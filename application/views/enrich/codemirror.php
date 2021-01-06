@extends(layouts/site)
@section(content)

<link rel="stylesheet" href="assets/codemirror/codemirror.css">
<link rel="stylesheet" href="assets/addon/fold/foldgutter.css" />
<link rel="stylesheet" href="assets/addon/dialog/dialog.css">
<link rel="stylesheet" href="assets/addon/search/matchesonscrollbar.css">
 
<script src="assets/codemirror/codemirror.js"></script> 
<script src="assets/addon/fold/foldcode.js"></script>
<script src="assets/addon/fold/foldgutter.js"></script>
<script src="assets/addon/fold/brace-fold.js"></script>
<script src="assets/addon/fold/xml-fold.js"></script>
<script src="assets/addon/fold/markdown-fold.js"></script>
<script src="assets/addon/fold/comment-fold.js"></script>
<script src="assets/mode/javascript/javascript.js"></script>
<script src="assets/mode/xml/xml.js"></script>
<script src="assets/mode/markdown/markdown.js"></script>

<!-- CKEDITOR -->
<script src="<?php echo base_url(); ?>assets/ckeditor/4.14.0/ckeditor.js"></script>
  


  <style type="text/css">
    .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; height: 32vw;}
	.CodeMirror-selected  { background-color: skyblue !important; }
      .CodeMirror-selectedtext { color: white; }
      .styled-background { background-color: #ff7; }
	 
	  #col3.nav-tabs-custom>.nav-tabs>li { margin-right:0px !important; }
	  
  </style>

<section class="content-header">
  <h1>
	File: <?php echo @$dataresult->Filename ?></span>
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Document Editor</li>
	<li><a href="Splitview?RefId=<?php echo $_GET['RefId'] ?>&BatchID=<?php echo $_GET['BatchID']?>&Task=<?php echo $_GET['Task'] ?>"><i class="fa fa-copy"></i> Split View</a></li>
   </ol>
</section>


<!-- Main content -->
<section class="content">
<!-- Main row -->
<div class="row">

<!-- col 1-->
<div class="col-md-3">
	<div id='col3' class="nav-tabs-custom">
	
		<ul id='tabs' class="nav nav-tabs pull-right">
		  <li class="active"><a href="#allocationDetails" data-toggle="tab" aria-expanded="true"><span style='display:block'>Allocation</span> Details</a></li>
		  <li class=""><a href="#JobQueue" data-toggle="tab"  aria-expanded="false">Styles</a></li>
		  <li class="validate"><a id="click_validateresult" href="#validateresult" data-toggle="tab"  aria-expanded="true"> Validation<br>Logs</a></li>
		</ul>
		
		<!-- TAB CONTENT-->
		<div id="tab-content" class="tab-content">
		
				<!-- TAB 1 -->
				<div class="tab-pane" id="validateresult" style="overflow:auto; min-height:25vw;">
					<ul class="nav nav-pills nav-stacked">
						<div id="validate_result_return"><br><br></div>
					</ul>
				</div>
				<!--END TAB 1 --
				
				<!-- TAB 2 -->
				<div class="tab-pane" id="JobQueue" style="overflow-y: scroll; height:10vw;">
					<ul class="nav nav-pills nav-stacked">
						<div id="Joblist"><br></div>
					</ul>
				</div>
				<!--END TAB 2 -->
						
				<!-- TAB 3 -->
				<div class="tab-pane active" id="allocationDetails">
					<!-- BODY TAB2-->
					<div class="box-body no-padding">
						
						  <!-- Stacked 1-->
						  <ul class="nav nav-pills nav-stacked">
						  
								<li>
									<a href="#"><i class="fa fa-tasks"></i><b>TASK: <span id="Task1"><?php  echo @$dataresult->ProcessCode ?></span></b></a>
								</li>
								<li>
									<a href=""><i class="fa fa-file-o"></i>JobID: <u><span id="JobID"><?php echo @$dataresult->JobId ?></span></u></a>
								</li>
								<li>
									<a href=""><i class="fa fa-file-o"></i>RefId: <u><span id="JobID"><?php echo @$dataresult->RefId ?></span></u></a>
								</li>
								
								<li>
									<a href="" ><i class="fa fa-file-o"></i>FileName: <u><span id="filename"><?php echo @$dataresult->Filename ?></span></u></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-folder"></i>JobName: <u><?php echo @$dataresult->JobName ?></u></a>
								</li>
								
								<li>
									<a href="#"><i class="fa fa-fw fa-book"></i>Regulation Number: <u><?php echo @$dataresult->RegulationNumber ?></u></a>
								</li>
								
								<li>
									<a href="#"><i class="fa fa-line-chart"></i>Status: <u><span id="Status"><?php echo @$dataresult->StatusString ?></span></u></a>
								</li>
								
								
								<li>
									<a href="#"><i class="fa fa-clock-o"></i>Last Updated: <u><?php echo @$dataresult->LastUpdate ?></u></a>
								</li>
								
						
								<!-- TOOLS -->
								
								<?php
									if( @$dataresult->StatusString=='Allocated'){
										$Start="block";
										$Resume ="none";
										$Completed="none";
										$Pending="none";
										$Hold="none";
										$GetNextBatch="none";
										$btnvalidate="none";
										 
									}
									elseif(@$dataresult->StatusString=='Ongoing'){
										$Start="none";
										$Resume ="none";
										$Completed="block";
										$Pending="block";
										 $Hold="block";
										 $GetNextBatch="none";
										 $btnvalidate="block";
									}
									elseif(@$dataresult->StatusString=='Pending'){
										$Start="none";
										$Resume ="block";
										$Completed="none";
										$Pending="none";
										 $Hold="none";
										 $GetNextBatch="none";
										 $btnvalidate="none";
									}
									elseif(@$dataresult->StatusString=='Done'){
										$Start="none";
										$Resume ="none";
										$Completed="none";
										$Pending="none";
										 $Hold="none";
										 $GetNextBatch="block";
										 $btnvalidate="none";
									}
									else{
										$Start="none";
										$Resume ="none";
										$Completed="none";
										$Pending="none";
										$Hold="none";
										$GetNextBatch="none";
										$btnvalidate="none";
									}

									
									?>
								
								
								<u>
									<div class="box-footer with-border">
										  <div class="box-tools">
										  
												<li style='display: <?php echo $Start;?>' id="Start">
													<button type="button" class="btn btn-default  pull-right btnStart"  data-batchid="<?php echo @$dataresult->BatchId ?>" style='display: <?php echo $Start;?>'>
														<i class="fa fa-hourglass-start" ></i> Start
													</button>
												</li>
												 
												 <li style='display:  <?php echo $Completed;?>' id="Completed"  > 
													<button type="button" class="btn btn-default  pull-right btncompleted"   data-batchid="<?php echo @$dataresult->BatchId ?>"  style="width:150px"  >
														<i class="fa fa-check"></i> Set as completed
													</button>
												 </li>
												 
												 <li style='display: <?php echo $Hold;?>'  id="Hold" > 
													<button type="button" class="btn btn-default  pull-right btnBold" data-toggle="modal" data-target="#modal-Hold" style="width:150px" >
														<i class="fa  fa-hand-stop-o"></i> Hold
													</button>
												  </li>
												 
												  <li style='display:  <?php echo $Pending;?>'  id="Pending" >
														<button type="button" class="btn btn-default pull-right btnPending"  data-batchid="<?php echo @$dataresult->BatchId ?>"  style="width:150px"  >
															<i class="fa fa-hourglass-2" ></i> Pending
														</button>
												   </li>
												 
													<li style='display:  <?php echo $Resume;?>'  id="Resume" >
														<button type="button" class="btn btn-default  pull-right btnResume"  data-batchid="<?php echo @$dataresult->BatchId ?>" >
															<i class="fa fa-hourglass-start"></i> Resume
														</button>
													</li>
												 
													<li style='display: <?php echo $GetNextBatch;?>'  id="GetNext">
														<a class="btn btn-default  pull-right GetNextbatch"  href="javascript:void(0)"  data-ProcessCode="<?php echo @$dataresult->ProcessCode ?>" data-WorkFlowId="<?php echo @$dataresult->WorkflowId ?>"  ><i class="fa  fa-hand-grab-o"></i> Get Next Batch </a>
													</li>
													
												
												  
												  
											 </div>
									</div>
									
								</u><!--END TOOLS -->
								
						  </ul> <!-- END Stacked-->
						  
					</div>	<!-- END BODY TAB2-->
					
				</div><!-- END TAB 3 -->
				
				
			</div><!--END  TAB CONTENT-->	
	</div>
	
</div>
<!-- end col 1 -->





<!-- col-2 -->
<div class="col-md-9">
<div class="nav-tabs-custom">


            <ul id="nav-tab" class="nav nav-tabs pull-right">
			
			  <li><a href="#TAB_metadatainfo" data-toggle="tab">Metadata info.</a></li>
			  <li onclick="GenerateXML()"><a id="xmleditor" href="#TAB_xmleditor" data-toggle="tab">XML Editor</a></li>
			  <li><a href="#TAB_styling" data-toggle="tab">Styling</a></li>
			  <li class="active"><a href="#TAB_source_file" data-toggle="tab">Source</a></li>  
			  <li class="pull-left header"><i class="fa fa-th"></i> </li>
			  
            </ul>

		<div class="tab-content">
				
				<!-- /.tab-4-->
				<div class="tab-pane " id="TAB_metadatainfo">
					<div id="fieldedForm">
						<fieldset>
							<div class="col-md-12">
								<form id="mlform">
									<?php echo  @$dataEntryFormTemplate  ?>
								</form>
						   </div>
						</fieldset>
						<div class="box-footer"></div>
					</div>
              </div>
			  <!-- /.tab-4-->


              <!-- /.tab-3-->
              <div class="tab-pane " id="TAB_xmleditor">
			  <form id='xmlsubmit'>
				<fieldset>
					<div class="form-group" style="width:100%; height:35vw;">
					<textarea  rows="100"  name="xmltextarea" id="xmltextarea" ></textarea>
					
					<script id="script">
					/*
					 * Demonstration of code folding
					 */
				 
					 
					  var te_html = document.getElementById("xmltextarea");
					 
					 
					  var editor_html = CodeMirror.fromTextArea(te_html, {
						mode: "text/xml",
						lineNumbers: true,
						matchTags: {bothTags: true},
						lineWrapping: true,
						extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
						foldGutter: true,
						styleActiveLine: true,
						styleActiveSelected: true,
						styleSelectedText: true,
						gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
					  });
					   
					editor_html.refresh();
					 
					  </script>
					  
					   <script>
					  function jumpToLine(prLineNo,prCol){
						  
						editor_html.refresh();
						editor_html.setCursor(prLineNo);
						
						editor_html.markText({line: prLineNo, ch: prCol}, {line: prLineNo, ch: prCol+5}, {className: "styled-background"});
					  }
					  </script>
					  <br>
					 
					<div id="btnvalidate" style="display: <?php echo $btnvalidate;?>" >
						<button type="submit" for="xmlsubmit" class="btn btn-success .btn-sm"> Author's View </button>
					</div>	
			  
					<div class="pull-right">
						<input type="hidden" name="SGML_filename" value="<?php echo $dataresult->SGML_filename ?>">
						<input type="hidden" name="RefId" value="<?php echo $dataresult->RefId ?>">
			
							<div id="btnvalidate" style="display: <?php echo $btnvalidate;?>" >
								<button type="submit" for="xmlsubmit" class="btn btn-success .btn-sm"> Validate </button>
							</div>	
	
					</div>
					</div>
				</fieldset>
			</form>	
			</div>
            <!-- /.tab-3 -->
			
			
			
			<!-- tab-2 -->
            <div class="tab-pane" id="TAB_styling">
				<fieldset>
				 	<div id='editContainer'>
						<div id="editorForm"></div>
					</div>
				</fieldset>
				<div class="box-footer"></div>	
            </div> <!-- /.tab-2 -->
			  
	

			<!-- tab-1 -->
            <div class="tab-pane active" id="TAB_source_file">
				<fieldset>
				 	<div id='editContainerSource'>					
						<object data="<?php echo base_url().''.$file; ?>" width="100%" height="550vh" style="border:none;"></object>
					</div>
				</fieldset>
				<div class="box-footer"></div>	
            </div> <!-- /.tab-pane -->
			
			
	</div><!-- /.tab-content -->
	
</div><!-- /.nav-tabs-custom -->

</div>
<!-- end col-2 -->

</div>
<!-- /.row (main row) -->
</section>
<!-- /.content -->


<script>
function GenerateXML(){
	 editor_html.setValue("");	
	//var jTextArea = CKEDITOR.instances['editor1'].getData();
	//var data = 'data='+encodeURIComponent(jTextArea);
	let form = $('#xmlsubmit');
	let formData = form.serialize();
	
	  var xmlhttp = new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		  //response.innerHTML=xmlhttp.responseText;
		  
		  editor_html.setValue(xmlhttp.responseText);
		}
	  }
	  
	  
	  xmlhttp.open("POST","CodeMirrorController/submitxml",true);
	  //Must add this request header to XMLHttpRequest request for POST
	  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  xmlhttp.send(formData);
}
</script>

<!-- define RefID  -->
<script type="text/javascript">
	let baseUrl = "<?= base_url();?>";
	let RefId = "<?php echo @$_GET['RefId']; ?>";
	let SGML_filename = "<?php echo $dataresult->SGML_filename ?>";
	let filepath = "<?php echo @$filepath ?>";
	let randomCode = '<?php echo rand(1,9999999999999);?>';
	let ename = '<?php echo $this->session->userdata("EName"); ?>'
</script>


<script src="<?php echo base_url(); ?>customize_file/acquire/ckeditor_custom.js?rand=randomCode"></script>



<script>
//Get Data Form Answer
GetAnswerDataForm();
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
</script>


<script>
// submit form
$("#xmlsubmit").on("submit", submitAnswer); 
function submitAnswer(event){
event.preventDefault();

let form = $('#xmlsubmit');
let formData = form.serialize();

		$.ajax({
				url: baseUrl+'CodeMirrorController/saveXmlFormData',
				data : formData,
				type : 'POST',
				beforeSend:function(){
					
					$("body").waitMe({
						effect: 'timer',
						text: 'Saving XML Details ........ ',
						bg: 'rgba(255,255,255,0.90)',
						color: '#555'
					});
					
				},
				success:function(data){
					
					$('body').waitMe('hide');
					
					if(data == "xsd_file_not_exist"){
						
						swal({
							type:'error',
							title:"Oops..",
							text:"XSD File not found!"
						})
						
						return false;
					}
					
					
					$('li a#click_validateresult').trigger( "click" );
					
					
					if(data == 'done'){
						swal({
							type:'success',
							title:"XML Saved!",
							text:""
						}).then(function(){
							

						});
						var resData = "<span style='color:green'>XML VALIDATION SUCESSFUL</span>"
						$("#validate_result_return").empty().html(resData);
						
					}else{
						
						$("#validate_result_return").empty().html(data);
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



//complete this job
$(document).on('click','.btncompleted',function(){

var batchid = $(this).attr('data-batchid');
 swal({
        type:'question',
        title:'',
        text:'Are you sure you want to set this batch as completed?',
        showCancelButton: true,
        confirmButtonText: 'Complete',
		confirmButtonColor: '#d33',
        cancelButtonText: 'No'
    }).then(function(isConfirm){
		
		
			$.ajax({
				url:'<?php echo base_url(); ?>CodeMirrorController/SetasCompleted',
				type:'post',
				data:{batch_id:batchid,SGML_filename:SGML_filename,RefId:RefId},
				success:function(data){
					
					if(data == "exist_xml"){
						
						$("li#Start").css('display','none');
						$("li#Completed").css('display','none');
						$("li#Pending").css('display','none');
						$("li#Resume").css('display','none');
						$("li#SaveButton").css('display','none');
						$("li#Hold").css('display','none');
						$("li#GetNext").css('display','block');		
						$("#btnvalidate").css('display','none');								
						
						$("span#Status").empty().html("Completed");
						
						swal({
							type:'success',
							title:"",
							text:"Batch is successfully completed"
						}).then(function(){
							
							location.reload();
						});
						
						
						
						return false
						
						
					}
					else if(data == "no_xml_exist"){
						
						swal({
							type:'error',
							title:"Oops..",
							text:"Please submit xml file before set as completed"
						})
						
						$('li a#xmleditor').trigger( "click" );
						return false;
						
					}
					else
					{
						
						$('li a#click_validateresult').trigger( "click" );
						$('li a#xmleditor').trigger( "click" );
						
						$("#validate_result_return").empty().html(data);
						
					}
				   
					
					

				}
			})
					
    }).catch();


});



//Start this job
$(document).on('click','.btnStart',function(){
var batchid = $(this).attr('data-batchid');

 swal({
        type:'question',
        title:'',
        text:'Are you sure you want to start this batch?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
		confirmButtonColor: '#d33',
        cancelButtonText: 'No'
    }).then(function(isConfirm){
		
			$.ajax({
				url:'<?php echo base_url(); ?>CodeMirrorController/StartJob',
				type:'post',
				data:{batch_id:batchid},
				success:function(data){
					
				    $("li#Start").css('display','none');
				    $("li#Completed").css('display','block');
					$("li#Pending").css('display','block');
				    $("li#Resume").css('display','none');
				    $("li#SaveButton").css('display','none');
					$("li#Hold").css('display','block');	
					$("#btnvalidate").css('display','block');					
				    $("span#Status").empty().html("Ongoing");

				}
			})
					
    }).catch(swal.noop);
	
});


//Pending this job
$(document).on('click','.btnPending',function(){
var batchid = $(this).attr('data-batchid');

 swal({
        type:'question',
        title:'',
        text:'Are you sure you want to set this batch as Pending?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
		confirmButtonColor: '#d33',
        cancelButtonText: 'No'
    }).then(function(isConfirm){
		
			$.ajax({
				url:'<?php echo base_url(); ?>CodeMirrorController/PendingJob',
				type:'post',
				data:{batch_id:batchid},
				success:function(data){
				   
				    $("li#Start").css('display','none');
				    $("li#Completed").css('display','none');
					$("li#Pending").css('display','none');
				    $("li#Resume").css('display','block');
				    $("li#SaveButton").css('display','none');
					$("li#Hold").css('display','none');
					$("#btnvalidate").css('display','none');
					$("span#Status").empty().html("Pending");

				}
			})
					
    }).catch(swal.noop);
	
});


//Resume this job
$(document).on('click','.btnResume',function(){
var batchid = $(this).attr('data-batchid');

 swal({
        type:'question',
        title:'',
        text:'Are you sure you want to set this batch as Resume?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
		confirmButtonColor: '#d33',
        cancelButtonText: 'No'
    }).then(function(isConfirm){
		
			$.ajax({
				url:'<?php echo base_url(); ?>CodeMirrorController/StartJob',
				type:'post',
				data:{batch_id:batchid},
				success:function(data){
					
			
					
					$("li#Start").css('display','none');
				    $("li#Completed").css('display','block');
					$("li#Pending").css('display','block');
				    $("li#Resume").css('display','none');
				    $("li#SaveButton").css('display','none');
					$("li#Hold").css('display','block');
					$("#btnvalidate").css('display','block');					
				    $("span#Status").empty().html("Ongoing");

				}
			})
					
    }).catch(swal.noop);
	
});


//Hold this job
$(document).on('click','.btnHold',function(event){
event.preventDefault();

let form = $('#holdform');
let formData = form.serialize();
		
		$.ajax({
			url:'<?php echo base_url(); ?>CodeMirrorController/HoldJob',
			type:'post',
			data:formData,
			success:function(data){
				
				$("li#Start").css('display','none');
				$("li#Completed").css('display','none');
				$("li#Pending").css('display','none');
				$("li#Resume").css('display','none');
				$("li#SaveButton").css('display','none');
				$("li#Hold").css('display','none');
				$("#btnvalidate").css('display','none');				
				$("span#Status").empty().html("Hold");
				
				$('#modal-Hold').modal('hide'); 
				
				swal({
					type:'success',
					title:"",
					text:"Hold this task succesfully"
				})
				
				
				
				return false
				
			}
		})

	
});



</script>


<script>
function jumpToLine(prLineNo,prCol,prLength){



var active = $('ul#nav-tab').find('li.active a').attr('href');
var timeout = 0;

if(active != "#TAB_xmleditor"){
	
	$('li a#xmleditor').trigger( "click" );
	var timeout = 200;

}

setTimeout(function(){ 

	var activeId = $(".visited").attr("id");
	$("#"+activeId).removeClass('visited');
	$("#"+activeId).css('color','blue');
	$("#"+activeId).addClass('checked');
	
	


	editor_html.refresh();
	editor_html.setCursor(prLineNo);
	// alert(prLength);
	editor_html.setSelection({line: prLineNo-1, ch: prCol-prLength}, {line: prLineNo-1, ch:prCol+prLength});
	
	if($("#myclass"+prLineNo).hasClass('checked') == false)
	{
		$("#myclass"+prLineNo).css('color','green');
		$("#myclass"+prLineNo).addClass('visited');
		
	}	
	
	
	
	
}, timeout);


/*
editor_html.markText({line: prLineNo-1, ch: prCol}, {line: prLineNo, ch:1}, {className: "styled-background"});
var line = editor_html.getLineHandle(prLineNo);
editor_html.setLineClass(line,'background','red');
*/

}




 </script>


<div class="modal modal-danger fade" id="modal-Hold" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>
		  <h4 class="modal-title">Hold Batch</h4>
      </div>
	  <form id="holdform">
      <div class="modal-body">
			   <input type="hidden" name="BatchIDHold" value="<?php echo @$dataresult->BatchId ?>" />
			   <input type="hidden" name="JobIDHold" value="<?php echo @$dataresult->JobId ?>" />
			  <p>Are you sure you want to put this batch on hold?</p>
			  <p>Remarks: <textarea rows="10" cols="80" class="form-control" name="Remarks"></textarea></p>
      </div>
	  </form>
      <div class="modal-footer">
			<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-outline btnHold">Hold</button>
      </div>
    </div>
  </div>
</div>



@endsection
