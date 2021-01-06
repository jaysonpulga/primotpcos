
	// initilize  ckeditor
	editor = CKEDITOR.replace( 'editorForm', {
			extraPlugins: 'stylesheetparser',
			height: 360,
			
			
			//removePlugins : 'image, exportpdf, save, print, newpage, templates, div, flash, horizontalline, about, showblocks, forms, bidi, emoji, smiley, horizontalrule , trackChanges, lite, table, pagebreak',
			
			
			
			//fullPage: true,
		    //allowedContent: true, 

				// Custom stylesheet for editor content.
				//contentsCss: [ 'bower_components/ckeditor/stylesheetparser.css' ],
				
				// Custom stylesheet for editor content.
				contentsCss: [ baseUrl+'/assets/ckeditor/stylesheetparser.css', baseUrl+'/assets/ckeditor/stylesheetparserToolTip.css'  ],


				// Do not load the default Styles configuration.
				stylesSet: [  ],
				on: {
				key: function( event ) {
					// Gather all styles
					var styles = [];
					this.getStylesSet( function( defs ) { styles = defs } );
					
					// CTRL+SHIFT+1
					//echo $key;
				
				}
			},
	});
	


	$(function(){
		if(filepath != ''){
			CKEDITOR.instances['editorForm'].setData('');
			$.ajax({
				url: baseUrl+''+filepath+'?t='+randomCode,
				type : 'GET',
				cache : false,
				beforeSend:function(){	
					$("#editContainer").waitMe({
						effect: 'timer',
						text: 'Loading File Please Wait ........ ',
						bg: 'rgba(255,255,255,0.90)',
						color: '#555'
					});
				},
				success:function(response){
					//console.log(response);
					$('#editContainer').waitMe('hide');
					CKEDITOR.instances['editorForm'].setData(response);
				},
				error:function(){}
			});
		}
	});	
	
	
	// Insert Comment button
	editor.ui.addButton('InsertComment', {
		label: "Insert Comment",
		command: 'insertlink',
		toolbar: 'insert',
		icon: baseUrl+'assets/images/comment_icon.png',

	});
	

	// Remove Comment button
	editor.ui.addButton('RemoveComment', {
		label: "Remove Comment",
		command: 'disabledComment',
		toolbar: 'insert',
		icon: baseUrl+'assets/images/remove_comment_icon.png',

	});
	
	
	
	
	editor.addCommand('insertlink', new CKEDITOR.dialogCommand('insertlink'));
	
    CKEDITOR.dialog.add('insertlink', function( editor )
    {
        return {
            title : 'Comment Tool',
            minWidth : 500,
            minHeight : 150,
            contents :
            [
                {
                    id : 'general',
                    label : 'Settings',
                    elements :
                    [
                        
                        {
                            type : 'textarea',
                            label : 'Input your comment:',
							rows : 5,
							cols : 20,
							validate: CKEDITOR.dialog.validate.notEmpty('Cannot be null'),
							required : true,
                            commit : function( data )
                            {
                                data.comment = this.getValue();
                            }
                        }
                    ]
                }
            ],
            onOk : function()
            {
                var dialog = this,
                data = {};
				this.commitContent(data);
                var commentText = data.comment;
				
				var editor = CKEDITOR.instances['editorForm'];
				var selectedHtml = "";
				var selection = editor.getSelection();
				
				var selection = editor.getSelection();
				var ranges = selection.getRanges();
				var el = new CKEDITOR.dom.element("div");
				for (var i = 0, len = ranges.length; i < len; ++i) {
					el.append(ranges[i].cloneContents());
				}
				
				 selectedHtml = el.getHtml();
				 
				 if(selectedHtml == "")
				 {
					 alert("select text first");
					 return false;
				 }
	
				var strHTML= '<span class="tooltip">' + selectedHtml + '<span class="tooltiptext"> <sup>'+ename+':</sup><text>'+commentText+'</text></span>';
				
				 
				editor.insertHtml(strHTML);
				


            }
        };
    });

		
	
	editor.addCommand("disabledComment", {
			exec: function(edt) {
				
			
				var editor = CKEDITOR.instances['editorForm'];
				var selectedHtml = "";
				var selection = editor.getSelection();
				
				var selection = editor.getSelection();
				var ranges = selection.getRanges();
				var el = new CKEDITOR.dom.element("div");
				for (var i = 0, len = ranges.length; i < len; ++i) {
					el.append(ranges[i].cloneContents());
				}
				
				 selectedHtml = el.getHtml();
				
	
				var strHTML= '<span>' + selectedHtml + '</span>';
				
				 
				editor.insertHtml(strHTML);
				
			}
		});
		
		

		

		


	