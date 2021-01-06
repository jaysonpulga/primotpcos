@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	User Update
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">User update</li>
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
		<form  id="update_user_task_info">
			<div class="box-body margin">
				<div class="row">
					<div class="col-lg-7">
							<div class="form-group">
								<label>User Type</label>
								<select class="form-control" name="UserType" id="UserType">
									<option value="Admin">Admin</option>
									<option value="Operator">Operator</option>
									 <option value="QA">QA</option>
									<option value="Admin" selected="">Admin</option>								
								</select>
							</div>
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" required placeholder="Name" name="Name" value="<?php echo @$userinfo->Name ?>">
							</div>
							<div class="form-group">
								<label>User name</label>
								<input type="text" class="form-control" required placeholder="User Name" name="UserName" value="<?php echo @$userinfo->UserName ?>">
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" class="form-control" required placeholder="Password" name="Password" value="<?php echo @$userinfo->Password ?>">
							</div>
					</div>		
				</div>	
			</div>
			<!-- /.box-body -->
			<div class="box-body margin">
				<div class="row">
					<div class="col-lg-7">
						<strong style="display:block;margin-bottom:15px">User Task</strong>
						<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
								 <tr>
									<th width="5%"></th>
									<th>WorkFlow Name</th>
									<th>Process Code</th>
									<th>Process</th>
								 </tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>	
				</div>
			</div>
			<!-- /.box-body -->
		   <div class="box-footer">
			<button type="submit" class="btn btn-primary">Save</button>
			<button type="reset" class="btn btn-danger" onclick="location.href='UserList'" >Cancel</button>
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

$(document).ready(function(){
	
$("#UserType").val("<?php echo @$userinfo->UserType ?>");

});

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
			"url"   : "UserListController/get_process",
			"data"  : {"UserID":"<?php echo @$userinfo->id ?>"},
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
			{'data': 'id'},
			{'data':'WorkFlowName'},
			{'data':'ProcessCode'},
			{'data':'Description'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
		$(nRow).attr("id",aData['id']);
		return nRow;
		},

	});
	
});
</script>

<script>
$("#update_user_task_info").on("submit", SaveData); 
function SaveData(event){
	
	event.preventDefault();
	
	let form = $('#update_user_task_info');
	let formData = form.serialize();
	formData += '&UserID=<?php echo @$userinfo->id ?>';
		
  $.ajax({
                url:'<?php echo base_url(); ?>UserListController/update_user_task_and_info',
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
