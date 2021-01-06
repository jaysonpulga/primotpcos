

	// create global var for layout so we can call myLayout.resize() after changing a theme
	var myLayout;

	$(document).ready(function(){

		// create tabs FIRST so elems are correct size BEFORE Layout measures them
		$(".ui-layout-center").tabs();

		// create a layout with default settings
		myLayout = $('body').layout({
			
			east: { size: 210},
			center: { size: 110},
			west: { size: 580},
		
		});
		
		// ACCORDION - in the West pane
		$("#accordion1").accordion({
			heightStyle:	"fill"
		});
		
		// ACCORDION - in the East pane - in a 'content-div'
		$("#accordion2").accordion({
			heightStyle:	"fill"
		,	active:			2
		});


		// THEME SWITCHER
		// if a new theme is applied, it could change the height of some content,
		// so call resizeAll to 'correct' any header/footer heights affected
		// NOTE: this is only necessary because we are changing CSS *AFTER LOADING* using themeSwitcher
		setTimeout( myLayout.resizeAll, 1000 ); /* allow time for browser to re-render with new theme */
		
		
		//Get Data Form Answer
		GetAnswerDataForm();
		
		// Get XMl Data
		GenerateXML();
		
	});
	
	
	// submit form
	$(document).on('click', '.saveXmlFormDatawithHtml', function(event){
	 event.preventDefault();
	
	var htmlsource = CKEDITOR.instances['editorForm'].getData();
	var Filename = $('#Filename').val();
	

			$.ajax({
					url: baseUrl+'CodeMirrorController/saveXmlFormDatawithHtml',
					//data : formData,
					data : {RefId:RefId,htmlsource:htmlsource,Filename:Filename,SGML_filename:SGML_filename,xmltextarea:editor_html.getValue()},
					type : 'POST',
					beforeSend:function(){
						
						$("body").waitMe({
							effect: 'timer',
							text: 'Saving  ........ ',
							bg: 'rgba(255,255,255,0.90)',
							color: '#555'
						});
						
					},
					success:function(data){
						
						$('body').waitMe('hide');
						
						
						$("#validate_result_return").empty().html(data);
						
						$('li#xmleditor a.class_xmleditor').trigger( "click" );
						
						$("#accordion2").accordion({
							heightStyle:	"fill"
						,	active:			1
						});
						
						
						if(data == 'done'){
							swal({
								type:'success',
								title:"Saved!",
								text:""
							}).then(function(){
								

							});
						}
					},
					error:function(){
						
						$('body').waitMe('hide');
							
						swal({
							type:'error',
							title:"Oops..",
							text:"Internal error "
						})

					}
					
			});

	})
	
	
		

		 
		
	// load Styling
	$(document).on('click', '#LoadStyles', function(){
		
			var response=document.getElementById("Joblist");
		  //var jTextArea=document.getElementById("jTextArea").value;
		  var jTextArea = "index";
		  var data = 'data='+encodeURIComponent(jTextArea);
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
			  response.innerHTML=xmlhttp.responseText;
				 
			}
		  }
		  xmlhttp.open("POST",baseUrl+'ListStyleSettingsController/loadStyleData',true);
		  //Must add this request header to XMLHttpRequest request for POST
		  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		  xmlhttp.send(data);
	})
		
   	
	function StyleDoc (prStyle,prType) {
		var editor = CKEDITOR.instances['editorForm'];
		var selectedHtml = "";
		var selection = editor.getSelection();
			
		if (selection) {
			selectedHtml = getSelectionHtml(selection);
		}
		
		var strHTML;
		if (prType==1){
			strHTML='<span class="'+ prStyle +'">' + selectedHtml + '</span>';
		}
		else{
			strHTML='<div class="'+ prStyle +'">' + selectedHtml + '</div>'; 
		}
		editor.insertHtml(strHTML);	 
	}
		
	function getSelectionHtml(selection) {
		var ranges = selection.getRanges();
		var html = '';
		for (var i = 0; i < ranges.length; i++) {
			html += getRangeHtml(ranges[i]);
		}
		return html;
	}
		
		
	function getRangeHtml(range) {
		var content = range.extractContents();
		// `content.$` is an actual DocumentFragment object (not a CKEDitor abstract)
		var children = content.$.childNodes;
		var html = '';
		for (var i = 0; i < children.length; i++) {
			var child = children[i];
			if (typeof child.outerHTML === 'string') {
				html += child.outerHTML;
			} else {
				html += child.textContent;
			}
		}
		return html;
	}

	function GenerateXML(){
		
		 editor_html.setValue("");
		//$("#modal-progress").modal();
		
		//var jTextArea = CKEDITOR.instances['editor1'].getData();
		//var data = 'data='+encodeURIComponent(jTextArea);
		let form = $('#xmlsubmit');
		let formData = form.serialize();
		
		  var xmlhttp = new XMLHttpRequest();
		  xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
			  //response.innerHTML=xmlhttp.responseText;
			  
			  editor_html.setValue(xmlhttp.responseText);
			  // $('#modal-progress').modal('hide');
			}
		  }
		  
		  
		  xmlhttp.open("POST","CodeMirrorController/submitxml",true);
		  //Must add this request header to XMLHttpRequest request for POST
		  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		  xmlhttp.send(formData);
	}
		
		
	function GetAnswerDataForm(){
		$.ajax({
			url: baseUrl+'PrecodingController/GetAnswerDataForm',
			data : {RefId:RefId},
			type : 'POST',
			dataType: 'json',
			success:function(data){
				//console.log(data);
				if(data.length > 0){
					$.each(data, function(index) {
						//console.log(data[index].FieldType);
						//console.log(data[index].Answer);
						if(data[index].FieldType == "textarea"){
							$("#"+data[index].FieldName).val(data[index].Answer).attr('readonly','readonly');
						}
						else{
							$("input#"+data[index].FieldName).val(data[index].Answer).attr('readonly','readonly');
						}
					});
				}
				
			},
			error: function(error){ 
				console.log(error);
			}
		})
	}
	
	
	function jumpToLine(prLineNo,prCol,prLength){
		
		var active = $('ul#nav-tab').find('li.ui-state-active a').attr('href');
		
		var timeout = 0;

		if(active != "#TAB_xmleditor"){
		
			$('li#xmleditor a.class_xmleditor').trigger( "click" );
			var timeout = 200;

		}

		setTimeout(function(){ 
			editor_html.refresh();
			editor_html.setCursor(prLineNo);
			// alert(prLength);
			editor_html.setSelection({line: prLineNo-1, ch: prCol-prLength}, {line: prLineNo-1, ch:prCol+prLength});
		}, timeout);
		
	}
		