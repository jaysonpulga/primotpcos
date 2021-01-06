@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	Batching
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">ACQUIRE</li>
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
					<div class="col-lg-6">
							<a href="javascript:void(0)" type="button" class="btn btn-success  btn-flat btnBatching">
								 Batch
							</a>	
					</div>
				</div>
			</div>
			
			
		
            <!-- /.box-header -->
            <div class="box-body margin table-responsive">
				<table id="mainDatatables"  class="table table-bordered table-hover " cellspacing="0" width="100%">
					<thead>
					<tr>
					  <th>Select All<br><input type='checkbox' class='SelectAll' /></th>
					  <th>RefID</th>
					  <th>MetaData Info.</th>
					  <th>SGML Filename</th>
					  <th>Jurisdiction</th>
					  <th>Status</th>
					  <th>Regulation Number</th>
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




<div id="modal_view_batching" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"></h4>
		  </div>
		  <div class="modal-body">
			<div class="box-body">
				<div class="col-lg-12">
					<center><span id="workflow"></span></center> 
				</div>
              </div>
		  </div>
		  <div class="modal-footer"></div>
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
			"url"   : baseUrl+"BatchingController/GetDataBatching",
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1,2,3,4,5],
		
		}],
		
		order:[[2,"asc"]],
		
		"bDestroy": true,
		"columns"    : [
		{
		   "data": null,
		   "bSortable": false,
		   "mRender": function(data, type, value) {
			   
			   
				if(value['SGML_filename']  == "" || value['SGML_filename'] == null )
				{
					
					return  '<a title="edit" href="fullscreen/'+value["RefId"]+'" target="_blank" ><i class="fa fa-fw fa-pencil"></i></a>';
				}
				else
				{
						
						let button = '<input type="checkbox" id="parent_checkbox" class="checkboxes" name="parent_checkbox"  data-SGML_filename="'+value['SGML_filename']+'"  value="'+value['RefId']+'">&nbsp;&nbsp;';
				   
						button += '<a  title="edit" href="fullscreen/'+value["RefId"]+'" target="_blank" ><i class="fa fa-fw fa-pencil"></i></a>';
				   
				   return button;
					
				}
			
				
			}
		
		},
		{'data': 'RefId'},
		{'data': 'meta_data'},
		{'data': 'SGML_filename'},
		{'data': 'Jurisdiction'},
		{'data': 'Status'},
		{'data': 'RegulationNumber'},
		{'data': 'Filename'},
		{'data': 'DateRegistered'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
			
			
			if ( aData['SGML_filename'] == "" || aData['SGML_filename'] == null ){
				//$('td', nRow).css('background-color', '#dedddd');
				 $(nRow).css('background-color', '#ffc7c7bd');
			}
			
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


<script>
$('.SelectAll').on('click', function() 
{

    var check = $(this).is(':checked');
	 
    if(check == true){
		
	
		$('.checkboxes').each(function() {
			this.checked = true;  
			$(this).closest("tr").css('background-color', '#fcff95');			
		}); 
				
	}
	else{
		
		$(':checkbox').each(function() {
            this.checked = false; 
			$(this).closest("tr").css('background-color', '');
        });
		
	}

}); 

</script>


<script type="text/javascript">
$('#mainDatatables').on('change', 'input[name="parent_checkbox"]', function() {
		
	let SGML_filename = $(this).attr("data-SGML_filename");

	
	if ($(this).is(":checked")) 
	{
		
      $(this).prop("checked", true);
	  $(this).closest("tr").css('background-color', '#fcff95');	

    }
	else
	{
		
		$(this).closest("tr").css('background-color', '');

	}
	
});  
</script>

<script>
let collect_data = [];
</script>

<script>
$(".btnBatching").click(function() {
	
	let array_store = [];
	
	$('input[class=checkboxes]:checked').each(function() {	
		
		let SGML_filename = $(this).attr("data-SGML_filename");
		array_store.push(SGML_filename);
		
	}); 
	
	
	if( array_store.length == 0){
		
		swal({
			type:'warning',
			text:"Please select data"
		})
		return false;
		
	}
	collect_data = [];
	collect_data = array_store;
	$.ajax({	
		url: baseUrl+'BatchingController/call_wms_WorkFlows_table',
		dataType: "json",
		success:function(data){
			
			var button ="";
			if(data.length > 0){
				
				$.each(data, function(index) {

					 button += "<a class='btn btn-app workflow' data-WorkFlowId="+data[index].WorkFlowId+"  >"+data[index].Description+"</a>";
	
				
				});
				
				$("#workflow").empty().html(button);
				$('.modal-title').html("Choose WorkFlow");
				var options = { backdrop : 'static'}
				$('#modal_view_batching').modal(options);
				
			}
			else{
				alert('error loading data');
			}
				
		}
		
	});
		
});
</script>

<script>
$(document).on('click','.workflow',function(){
	
	
	var WorkFlowId = $(this).attr('data-WorkFlowId');
	
	var uniqueFileNames = [];
	$.each(collect_data, function(i, el){
		if($.inArray(el, uniqueFileNames) === -1) uniqueFileNames.push(el);
	});
	
	
	$.ajax({
			url: baseUrl+'BatchingController/UpdateWorkflow',
			data : {WorkFlowId:WorkFlowId,uniqueFileNames:uniqueFileNames},
			type : 'POST',
			beforeSend:function(){
				
				$("body").waitMe({
					effect: 'timer',
					text: 'UPDATING ........ ',
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
						
						reload_table();
						$('#modal_view_batching').modal("hide");
						loadMenubar();
						
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
	
	
	
	//alert(WorkFlowId);
	//alert("original fetch data = " + JSON.stringify(collect_data));
	//alert("remove all duplicate = " + JSON.stringify(uniqueNames));
	
	
	
});
</script>

<style>

.btn-app {
    min-width: 210px !important;
    height: 70px;
    font-size: 18px !important;
}
</style>
@endsection
