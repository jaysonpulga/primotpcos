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
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
					<tr>
					  <th>Select All<br><input type='checkbox' class='SelectAll' /></th>
					  <th>RefID</th>
					  <th>MetaData Info.</th>
					  <th>SGML Filename</th>
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


<!-- include  base url js file  -->
<script type="text/javascript">
	let baseUrl = "<?= base_url();?>";
</script>


<script>
var SGML_file_array = [];
</script>

<script>
Array.prototype.contains = function (val) 
{ 

	for(var i = 0; i < this.length; i++ )
	{
		if(JSON.stringify(this[i]) === JSON.stringify(val)) return true;
	}
	return false;
	
} 
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
			
				if(value['SGML_filename'] != ''){
				   return '<input type="checkbox" id="parent_checkbox" class="checkboxes" name="parent_checkbox"  data-SGML_filename="'+value['SGML_filename']+'"  value="'+value['RefId']+'"  >';
				}
				else{
					return '';
				}
			}
		
		},
		{'data': 'RefId'},
		{'data': 'meta_data'},
		{'data': 'SGML_filename'},
		{'data': 'Jurisdiction'},
		{'data': 'Status'},
		{'data': 'Title'},
		{'data': 'Filename'},
		{'data': 'DateRegistered'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
			
			
			if ( aData['SGML_filename'] == "" ){
				//$('td', nRow).css('background-color', '#dedddd');
				 $(nRow).css('background-color', '#ff9487');
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
$(".btnBatching").click(function() {
	
	let array_store = [];
		
		
	$('input[class=checkboxes]:checked').each(function() {	
		
		let SGML_filename = $(this).attr("data-SGML_filename");
		
		array_store.push(SGML_filename);
		
	}); 
	
	var uniqueNames = [];
	$.each(array_store, function(i, el){
		if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
	});
	
	
	alert("original fetch data = " + JSON.stringify(array_store));
	
	alert("remove all duplicate = " + JSON.stringify(uniqueNames));
	
});
</script>

@endsection
