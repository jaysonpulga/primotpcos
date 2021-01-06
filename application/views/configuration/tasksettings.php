@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	Task Settings
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Task Settings</li>
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
				<div class='row'>
					<div class="col-lg-12">
					</div>
				</div>
			</div>
			
			
		
            <!-- /.box-header -->
            <div class="box-body margin">
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
					<tr>
					  <th>WorkFLow Name</th>
					  <th>Process Code</th>
					  <th>Description</th>
					  <th>Previous Process1</th>
					  <th>Previous Process2</th>
					  <th>Previous Process3</th>
					  <th>Optional</th>
					  <th>Quota</th>
					  <th>AutoAllocate</th>
					  <th>Action</th>
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



<div id="modal_view" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Create New Item Group</h4>
		  </div>
		  
		
		  <div class="modal-body">
			<div class="box-body">
				<form id="fomrDetails">
						<input type="hidden" id="ColumnID" name="ColumnID">
						<div class="form-group">
						  <label>Field Name</label>
						  <input type="text" class="form-control" placeholder="Field Name" name="FieldName" id="FieldName" required >
						</div>
						
						<div class="form-group">
						  <label>Field Caption</label>
						  <input type="text" class="form-control" placeholder="Field Caption" name="FieldCaption" id="FieldCaption" required>
						</div>
						
						<div class="form-group">
							<label>Field Type</label><br>
							<Select name="FieldType" id="FieldType" class="form-control" required>
								<option value="text">text</option>
								<option value="date">date</option>
								<option value="number">number</option>
								<option value="textarea">textarea</option>
								<option value="dropdown">dropdown</option>
							</Select>
						</div>
						
						<div class="form-group">
						  <label>Field Option</label><br>
						  <textarea name="FieldOption" id="FieldOption"  class="form-control" cols="7" rows="5"></textarea>
						</div>
					
				</form>
              </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" form="fomrDetails"  class="btn btn-success btn-primary  btn-flat" id="saveData">Save</button>
			<input type="hidden"  id="action" name="action">
		  </div>
		 
		</div>
	  </div>
 </div>
<!-- /.content -->



<script type="text/javascript">

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
			"url"  : "TaskSettingsController/getData",
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1,2,3,4,5],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
		{'data': 'WorkFlowName'},
		{'data': 'ProcessCode'},
		{'data': 'Description'},
		
		{'data': 'Process1'},
		{'data': 'Process3'},
		{'data': 'Process3'},
		
		
		{'data': 'Optional'},
		{'data': 'Quota'},
		{'data': 'AutoAllocate'},
		
		
		{'data': 'Action'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
		$(nRow).attr("WorkFlowName",aData['WorkFlowName']);
		return nRow;
		},

	});
	
});

</script>

@endsection
