@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	User Access (<?php echo $_GET['Name'];?>)
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">User Access</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">
<!-- Main row -->
<div class="row">
<div class="col-lg-12">
<!-- Main Box-->
<div class="box">

	   <div class="box-header with-border">
			<div class='row'>
				<div class="col-lg-12">
					<h3 class="box-title"><a type="button" href="UserList" class="btn btn-block btn-primary" >Back</a></h3>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		<form method="post" id="user_access">
			<div class="box-body margin">
			
				 <strong style="display:block;margin-bottom:10px">User Settings</strong>
				 <input type="checkbox"  name="ACQUIRE" <?php echo $user_access->ACQUIRE == 1 ? 'checked' : '' ?> > ACQUIRE<BR>
				 <input type="checkbox"  name="ENRICH" <?php echo $user_access->ENRICH == 1 ? 'checked' : '' ?> > ENRICH<BR>
				 <input type="checkbox"  name="DELIVER" <?php echo $user_access->DELIVER == 1 ? 'checked' : '' ?> > DELIVER<BR>
				 <input type="checkbox"  name="USER_MAINTENANCE" <?php echo $user_access->USER_MAINTENANCE == 1 ? 'checked' : '' ?> > USER MAINTENANCE<BR>
				 <input type="checkbox"  name="EDITOR_SETTINGS" <?php echo $user_access->EDITOR_SETTINGS == 1 ? 'checked' : '' ?> > EDITOR SETTINGS<BR>
				 <input type="checkbox"  name="ML_SETTINGS" <?php echo $user_access->ML_SETTINGS == 1 ? 'checked' : '' ?> > ML SETTINGS<BR>
				 <input type="checkbox"  name="TRANSFORMATION_SETTINGS" <?php echo $user_access->TRANSFORMATION == 1 ? 'checked' : '' ?> > TRANSFORMATION SETTINGS<BR>
				 <input type="checkbox"  name="TRANSMISSION_SETTINGS" <?php echo $user_access->TRANSMISSION == 1 ? 'checked' : '' ?> > TRANSMISSION  SETTINGS<BR>
				 <input type="checkbox"  name="ACQUISITION_REPORT" <?php echo $user_access->AQUISITIONREPORT == 1 ? 'checked' : '' ?> > ACQUISITION REPORT<BR>
				 <input type="checkbox"  name="CONFIDENCE_LEVEL_REPORT" <?php echo $user_access->ConfidenceLevelReport == 1 ? 'checked' : '' ?> > CONFIDENCE LEVEL REPORT<BR>
				 <input type="checkbox"  name="TASK_SETTINGS" <?php echo $user_access->TaskSetting == 1 ? 'checked' : '' ?>> TASK  SETTINGS<BR>
				 <input type="checkbox"  name="DATAENTRY_SETTINGS" <?php echo $user_access->DataEntrySetting == 1 ? 'checked' : '' ?> > DATAENTRY SETTINGS<BR>
				 <input type="checkbox"  name="REPORT_MANAGEMENT" <?php echo $user_access->REPORTMANAGEMENT == 1 ? 'checked' : '' ?> > REPORT MANAGEMENT<BR>
			</div>
			<!-- /.box-body -->
			<div class="box-body margin">
				<strong style="display:block;margin-bottom:15px">User Report</strong>
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						 <tr>
							<th width="5%"></th>
							<th>Report Name</th>
						 </tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<!-- /.box-body -->
	  <div class="box-footer">
		<button type="submit" class="btn btn-primary">Save</button>
		<button type="reset" class="btn btn-danger" onclick="location.href='UserList'">Cancel</button>
	  </div>
	  </form>
	
</div>
<!--box-->	
</div>	  
</div>
<!-- /.row (main row) -->
</section>
<!-- /.content -->


<script type="text/javascript">
let table;

//load table
$(document).ready(function(){
    
		 table =  $('#mainDatatables').DataTable({
		 
		'paging'      : true,
		'lengthChange': true,
		'searching'   : true,
		'info'        : true,
		'ordering'    : false,
		'processing'  : true, //Feature control the processing indicator.
		// Load data for the table's content from an Ajax source
		/*
		'language': {
				'loadingRecords': '&nbsp;',
			   'processing': '<div class="spinner"></div>'
		},
		*/
		"ajax": {
			"url"   : "UserListController/get_tbluserreport",
			"data"  : {"UserID":"<?php echo $UID ?>"},
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
			{'data': 'id'},
			{'data': 'ReportName'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
		$(nRow).attr("id",aData['id']);
		return nRow;
		},

	});
   
	
});

	

</script>


<script>
$("#user_access").on("submit", SaveData); 
function SaveData(event){
	
	event.preventDefault();
	
	let form = $('#user_access');
	let formData = form.serialize();
	formData += '&UserID=<?php echo $UID ?>';
		
  $.ajax({
                url:'<?php echo base_url(); ?>UserListController/update_user_access',
                type:"POST",
                data:formData,
                beforeSend:function(){
                     $("body").waitMe({
                        effect: 'timer',
                        text: 'Updating  ........ ',
                        bg: 'rgba(255,255,255,0.90)',
                        color: '#555'
                    }); 
                },
                success:function(data){
                    $('body').waitMe('hide');
					
					 swal({
                        type:'success',
                        title:"Updated!"
                    }).then(function(){
							location.reload();
					})
					
                   
                },
                error:function(){
                    $('body').waitMe('hide');
                    swal({
                        type:'error',
                        title:"Oops..",
                        text:"Internal error "
                    })
                }
            })


}
</script>
 
 

@endsection
