@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	Register File
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">register File</li>
  </ol>
</section>


<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border"></div>
				<!-- /.box-header -->
				
					<div class="box-body">
						<form role="form" id="uploadfile" enctype="multipart/form-data">
							<div class="col-lg-6">
								<div class="form-group">
									<label>File List <i>(Excel Template)</i></label>
									<input type="file" class="form-control" name="ExcelFile" required />
									<small>allowed type: xls,csv,xlxs</small>
								</div>
								<div class="form-group">
									<label>Source Files</label>
									<input type="file" class="form-control" name="Files[]" multiple="multiple" required>
									<small>allowed type: docs,docx,xlx,sxls,csv,pdf</small>
								</div>
								<br>
								
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Save</button>
								</div>
							</div>
							<div class="col-lg-6">
								<div style="float:right">
									<a   href="<?= base_url();?>assets/FileListTemplate.xlsx"  class="btn btn-primary" download>Download Excel template</a>
								</div>
							</div>
						</form>
					</div>
					<!-- /.box-body -->

					<div class="box-footer">
					
					</div>
					<!-- /.box-footer -->
			</div>
			<!-- /.box-primary -->
		</div>		
		<!-- /.box-body -->
	</div>
	<!-- /. box -->
</section>



<script>
$('#uploadfile').on('submit', function(event){
event.preventDefault();
	$.ajax({
		   url         : "RegistrationController/UploadFile",
		   method      : "POST",
		   data        : new FormData(this),
		   contentType : false,
		   cache       : false,
		   processData : false,
		   dataType    : 'json',
		   beforeSend  : function(){
						
			$("body").waitMe({
				effect: 'timer',
				text: 'Uploading  				........ ',
				bg: 'rgba(255,255,255,0.90)',
				color: '#555'
			});
						
		   },
		   success:function(data){
				
				$('body').waitMe('hide');
				$('#upload_file').val("");
				
				
				//console.log(data.resultStatus);
				
				
				if(data.resultStatus == 'success'){
					
					//console.log("sucess =" +data.res.success);
					//console.log("error = " +data.res.error);
					
					var resulttext = "";
					var successText = "";
					var errorText = "";
					
					
					if(data.res.success.length > 0){
						
						
							var messageSuccess = "";
							 successText += "<span style='color:green'>SUCCESS</span><br>";
						
							$.each(data.res.success, function(index) {
								
								console.log("success = " + data.res.success[index]);
								
								messageSuccess += 	data.res.success[index];
							
							});
							
							successText += messageSuccess;
							
							
					}
					
					if(data.res.error.length > 0){
						
						   var messageError= "";
							 errorText += "<span style='color:red'>Error</span><br>";
						
							$.each(data.res.error, function(index) {
								
								console.log("error =" +data.res.error[index]);
								
								messageError += 	data.res.error[index];
							
							});
							
							
							errorText += messageError;
					}
					
					
					resulttext = successText + '<br>' + errorText;
					
					
					swal({
						
						type:'info',
						html:resulttext
					}).then(function(){
							
					 
					});	
				}
				else if(data.resultStatus == "failed")
				{
						
	
						
						swal({
							type:'error',
							title:"Oops..",
							html:data.res
						})
					 
				}
		
			
			},
			error: function (jqXHR, textStatus, errorThrown){
				$('body').waitMe('hide');
					console.log("jqXHR = "+jqXHR);
					console.log("textStatus = "+textStatus);
					console.log("errorThrown = "+errorThrown);
				swal({
					type:'error',
					title:"Oops..",
					text:"Internal error "
				})

			}
		   
	})
});
</script>
 
 
@endsection
