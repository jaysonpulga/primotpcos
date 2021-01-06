@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	Data Entry Settings
	
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Data Entry Settings</li>
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
						 <h3 class="box-title"><button type="button" class="btn btn-block btn-primary addnew" >Add New</button></h3>
					</div>
				</div>
			</div>
			
			
		
            <!-- /.box-header -->
            <div class="box-body margin">
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
					<tr>
					  <th>ID</th>
					  <th>FieldName</th>
					  <th>Field Caption</th>
					  <th>Field Type</th>
					  <th>Field Option</th>
					  <th>Actions</th>
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
		'lengthChange': true,
		'searching'   : true,
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
			"url"  : "DataEntrySettingsController/entryData",
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1,2,3,4,5],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
		{'data': 'ColumnID'},
		{'data': 'FieldName'},
		{'data': 'FieldCaption'},
		{'data': 'FieldType'},
		{'data': 'FieldOption'},
		{'data': 'Action'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
		$(nRow).attr("ColumnID",aData['ColumnID']);
		return nRow;
		},

	});
   
}


function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
 
 
$(document).on('click', '.addnew', function(e){
e.preventDefault(); 
	
	$('#action').val("create_new");
	$('.modal-title').html("Data Entry");
	var options = { backdrop : 'static'}
	$('#modal_view').modal(options);     

}); 



$("#fomrDetails").on("submit", SaveData); 

function SaveData(event){
	
event.preventDefault();
 
let form = $('#fomrDetails');
let formData = form.serialize();

if($('#action').val() == "create_new")
{
	action_url = '<?php echo base_url(); ?>DataEntrySettingsController/addnewEntry';
}
else if($('#action').val() == "update_details")
{
	action_url = '<?php echo base_url(); ?>DataEntrySettingsController/updateEntry';
}


  $.ajax({
                url:action_url,
                type:"POST",
                data:formData,
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
					
                    if(data == "save")
                    {	
						$('#modal_view').modal('hide'); 
						reload_table();
						
						
                    }
					else
					{
						swal({
							type:'error',
							title:"Oops..",
							text:"data not save"
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




}
</script>


<script>
$(document).on('click','.edit',function(){


$('#action').val("update_details");
$('.modal-title').html("Edit Entry");

var id = $(this).attr('data-id');

	$.ajax({
		url:'<?php echo base_url(); ?>DataEntrySettingsController/geEntrybyID',
		type:'post',
		data:{id,id},
		dataType: "JSON",
		success:function(data){
				
			
             $('#FieldName').val(data.FieldName);
			 $('#FieldType').val(data.FieldType);
			 $('#FieldOption').val(data.FieldOption);
			 $('#FieldCaption').val(data.FieldCaption);
			 $('#ColumnID ').val(data.ColumnID );
			
			var options = { backdrop : 'static'}
			$('#modal_view').modal(options);   
		
		}
	})

});	
</script>



<script>
$(document).on('click','.delete',function(){


	var id = $(this).attr('data-id');

	
    swal({
        type:'warning',
        title:'Are you sure?',
        text:'Do you want to delete this entry',
        showCancelButton: true,
        confirmButtonText: 'Yes',
		confirmButtonColor: '#d33',
        cancelButtonText: 'No'
    }).then(function(isConfirm){
		
			
	
			$.ajax({
				url:'<?php echo base_url(); ?>DataEntrySettingsController/deleteEntry',
				type:'post',
				data:{id,id},
				success:function(data){
					reload_table();
				}
			})
			
			
		
    })
});
</script>

@endsection
