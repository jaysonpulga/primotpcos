

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
		,	active:			1
		});


		// THEME SWITCHER
		// if a new theme is applied, it could change the height of some content,
		// so call resizeAll to 'correct' any header/footer heights affected
		// NOTE: this is only necessary because we are changing CSS *AFTER LOADING* using themeSwitcher
		setTimeout( myLayout.resizeAll, 1000 ); /* allow time for browser to re-render with new theme */
		
		
		//Get Data Form Answer
		GetAnswerDataForm();
		
	});
	
	// submit form
	$("#mlform").on("submit", submitAnswer); 
	function submitAnswer(event){
		
		event.preventDefault();
		var RefIdStatus = $("#RefIdStatus").val();
		var answerlist = [];
		
		 $(".form_answer").each(function() {
		 
			if($(this).data('fieldtype') == "dropdown" ) 
			{

		
			}
			else
			{

				answerlist.push({
						  'answer': $(this).val(),
						  'fieldname':$(this).attr('name'),
						  'fieldtype':$(this).data('fieldtype'),
						  'fieldcaption':$(this).data('fieldcaption'),
				});

			}

		 });
		 
		
		var htmlsource = CKEDITOR.instances['editorForm'].getData();
		var Filename = $('#Filename').val();
		
		$.ajax({
				url: baseUrl+'PrecodingController/saveFormData',
				data : {answerlist:answerlist,RefId:RefId,RefIdStatus:RefIdStatus,htmlsource:htmlsource,Filename:Filename},
				type : 'POST',
				beforeSend:function(){
					
					$("body").waitMe({
						effect: 'timer',
						text: 'Saving  Details ........ ',
						bg: 'rgba(255,255,255,0.90)',
						color: '#555'
					});
					
				},
				success:function(data){
					
					$('body').waitMe('hide');
					
					if(data == 'done'){
						swal({
							type:'success',
							title:"Data Saved!",
							text:""
						}).then(function(){
							
							window.location.replace(baseUrl+"precoding");
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
	}
		
	// load Styling
	$(document).on('click', '.exitpreview', function(){
		setTimeout("window.close()", 100);
		
	});
	
		 
		
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
						console.log(data[index].FieldType);
						console.log(data[index].Answer);
						if(data[index].FieldType == "textarea"){
							$("#"+data[index].FieldName).val(data[index].Answer);
						}
						else{
							$("input#"+data[index].FieldName).val(data[index].Answer);
						}
					});
				}
				
			},
			error: function(error){ 
				console.log(error);
			}
		})
	}
		