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
					<div class="col-lg-12">					
					</div>
				</div>
			</div>
			
			
		
            <!-- /.box-header -->
            <div class="box-body margin table-responsive">
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
					<tr>
					  <th>RefID</th>
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
			"url"   : baseUrl+"BatchingController/GetDataBatching",
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1,2,3,4,5],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
		{'data': 'RefId'},
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



@endsection
