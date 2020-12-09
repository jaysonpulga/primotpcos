@extends(layouts/site)
@section(content)


<section class="content-header">
  <h1>
	For Approval
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">for approval</li>
  </ol>
</section>

<div style="margin-top:20px;margin-bottom:20px"></div>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
<div class="col-lg-12">
<!-- Main Box-->
<div class="box">

			<div class="box-header with-border margin">
				<div class="row">
					<div class="col-lg-12">
						<span class="pull-right">
								<a href="javascript:void(0)" type="button" class="btn btn-success  btn-flat btnupdateStatus disabled">
									<i class="fa fa-fw fa-pencil"></i> Update
								</a>	
								
								<a href="javascript:void(0)" type="button" class="btn btn-success  btn-flat btnexportexcel disabled">
									<span class="glyphicon glyphicon-export"></span> Export to Excel
								</a>	
								
								<a href="javascript:void(0)" type="button" class="btn btn-success  btn-flat btnimportexcel">
									<span class="glyphicon glyphicon-import"></span> Import from Excel
								</a>	
						</span>
					</div>
				</div>
			</div>
			
		
            <!-- /.box-header -->
            <div class="box-body margin table-responsive">
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
					<tr>
					  <th></th>
					  <th>RefID</th>
					  <th>Update Status?</th>
					  <th>MetaData Info.</th>
					  <th>Configname</th>
					  <th>Jurisdiction</th>
					  <th>Status</th>
					  <th>Title</th>
					  <th>Filename</th>
					  <th>Date Registered</th>
					</tr>
					</thead>
					<tbody></tbody>
				</table>
            </div>
            <!-- /.box-body -->




</div>
<!--box-->	
</div>	  
</div>
<!-- /.row (main row) -->
</section>
<!-- /.content -->



<div id="modal_view_import" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"></h4>
		  </div>
		  
		
		  <div class="modal-body">
			<div class="box-body">
				  <form method="post" id="import_form" enctype="multipart/form-data">
					   <p><label>Select Excel File</label>
					   <input type="file" class="form-control" name="upload_file" id="upload_file" required accept=".xls, .xlsx" /></p>
					</form>
					<small>allowed type: xls,csv,xlxs</small>
              </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" form="import_form"  class="btn btn-success btn-primary  btn-flat" id="import">Start Import</button>
		  </div>
		 
		</div>
	  </div>
 </div>
<!-- /.content -->


<!-- include  base url js file  -->
<script type="text/javascript">
	let baseUrl = "<?= base_url();?>";
</script>


<script type="text/javascript">

let table;

//load table
$(document).ready(function(){
    
	loadTable();
	
});

	
$(".btnsearch").click(function(e){	
	e.preventDefault();
	loadTable();
});




function loadTable(){

   
	 table =  $('#mainDatatables').DataTable({
		 
		'paging'      : true,
		'lengthChange': false,
		'searching'   : false,
		'info'        : true,
		"processing": true, //Feature control the processing indicator.
		// Load data for the table's content from an Ajax source
		/*
		'language': {
				'loadingRecords': '&nbsp;',
			   'processing': '<div class="spinner"></div>'
		},
		*/
		"ajax": {
			"url"   : baseUrl+"ForApprovalController/GetDataforApproval",
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1,2,3,4,5],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
		{
		   "data": null,
		   "bSortable": false,
		   "mRender": function(data, type, value) {
			   return '<input type="checkbox" id="parent_checkbox" name="parent_checkbox"  data-RefId="'+value['RefId']+'"  value="'+value['RefId']+'"  >';
    		}
		
		},
		{'data': 'RefId'},
		{
		   "data": null,
		   "bSortable": false,
		   "mRender": function(data, type, value) {
			   return `<select class="form-control seleclValue"  disabled  id="refIDStatus${value.RefId}" >
						<option value="">-- Select Status --</option>
						<option value="Approved">Approved</option>
						<option value="Discarded/Others">Discarded/Others</option>
						</select>`;
    		}
		
		},
		
		{'data': 'meta_data'},
		{'data': 'ConfigName'},
		{'data': 'Jurisdiction'},
		{'data': 'Status'},
		{'data': 'Title'},
		{'data': 'Filename'},
		{'data': 'DateRegistered'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
		$(nRow).attr("RefId",aData['RefId']);
		return nRow;
		},

	});
   
}
</script>


<script type="text/javascript">
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
</script>


<script type="text/javascript">
$('#mainDatatables').on('change', 'input[name="parent_checkbox"]', function() {
		
	let RefId = $(this).attr("data-RefId");

		
	if ($(this).is(":checked")) 
	{
		
		 
		
      $('input[name="parent_checkbox"]').prop("checked", false);
	  $('#mainDatatables tbody tr').removeClass('addcolor');
      $(this).prop("checked", true);
	  $(this).closest("tr").addClass('addcolor').removeAttr('disabled');	  
	  $('#mainDatatables tbody tr td select').attr("disabled", true);	  
	  $(this).closest('tr').find('td select.seleclValue').removeAttr('disabled');
	  
	   $(".btnupdateStatus").removeClass('disabled');
	   $(".btnexportexcel").removeClass('disabled');
	  
    }
	else
	{
		
		$(this).closest("tr").removeClass('addcolor');
		$(this).closest('tr').find('td select.seleclValue').attr("disabled", true);	

		$(".btnupdateStatus").addClass('disabled');
	    $(".btnexportexcel").addClass('disabled');		
		
		
	}
	
});  
</script>


 <script type="text/javascript">
$(document).on('click', '.btnupdateStatus', function(e){
e.preventDefault(); 

	 $.each($("input[name='parent_checkbox']:checked"), function(){
			RefId = $(this).val();
	 });
	 
	var selected_value = $("#refIDStatus"+RefId+" option:selected").val();
	
	if(selected_value == "")
	{
		swal({
			type:'warning',
			title:"",
			text:"Please Select update status"
		})
		
		return false;
	}


	$.ajax({
		
			url: baseUrl+"ForApprovalController/UpdateStatus",
			data : {status_selcted:selected_value,RefId:RefId},
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
				
				if(data == 'updated'){
					swal({
						type:'success',
						title:"Updated!",
						text:""
					}).then(function(){
							
							reload_table();
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
			
	})




}); 
</script>


<!--- ////   EXPORT EXCEL  /////////// -->
 <script type="text/javascript">
$(document).on('click', '.btnexportexcel', function(e){
e.preventDefault();

 $.each($("input[name='parent_checkbox']:checked"), function(){
		RefId = $(this).val();
});
		
$("#RefId_value").val(RefId);

$( "#target" ).submit();


});
</script>

<form id="target" target="_blank" action="<?= base_url();?>ForApprovalController/ExportToExcel" method="POST">
	<input type="hidden"  id="RefId_value" name="RefId_value" />
</form>


<!--- ////   IMPORT EXCEL  /////////// -->
 <script type="text/javascript">
$(document).on('click', '.btnimportexcel', function(e){
e.preventDefault();


	$('.modal-title').html("Import Excel");
	var options = { backdrop : 'static'}
	$('#modal_view_import').modal(options);     

});
</script>


<script>
$('#import_form').on('submit', function(event){
event.preventDefault();
	$.ajax({
		  "url"   : baseUrl+"ForApprovalController/importExcel",
		   method:"POST",
		   data:new FormData(this),
		   contentType:false,
		   cache:false,
		   processData:false,
		   beforeSend:function(){
						
			$("body").waitMe({
				effect: 'timer',
				text: 'updating  Details ........ ',
				bg: 'rgba(255,255,255,0.90)',
				color: '#555'
			});
						
		   },
		   success:function(data){
				
				$('body').waitMe('hide');
				$('#upload_file').val("");
				
				if(data == 'updated'){
					swal({
						type:'success',
						title:"Updated!",
						text:""
					}).then(function(){
							
							$('#modal_view_import').modal("hide");   
							reload_table();
					});	
				}
				else
				{
						
						$('#modal_view_import').modal("hide"); 
						
						swal({
							type:'error',
							title:"Oops..",
							html:data
						})
					 
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
		   
	})
});
</script>

<style>
.addcolor {
    background-color: #f8fb4699 !important;
}
</style>


@endsection
