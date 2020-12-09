@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	Precoding
	
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">ML Configuration</li>
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
					<div class="col-lg-5">
						<table width="100%" id='table' border=0 >
							<tr>
								<td width="1%"><label for="jurisdiction" class="control-label" >Jurisdiction</label></td>
								<td width="16%" >			
									<select class="form-control" id="jurisdiction_value" name="jurisdiction_value">
										 <option value="NEW">NEW</option>
										 <option value="for Approval">for Approval</option>
										 <option value="Approved">Approved</option>
										 <option value="Discarded/Others">Discarded/Others</option>
								  </select>
								</td>
								<td width="1%"><button  class="btn btn-primary x-small pull-right btnsearch"><i class="fa  fa-search"></i> Search</button></td>
							</tr>	
						</table>					
					</div>
				</div>
			</div>
			
			
		
            <!-- /.box-header -->
            <div class="box-body margin table-responsive">
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
					<tr>
					  <th>RefID</th>
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


<script type="text/javascript">

//load table
$(document).ready(function(){
    
	loadTable();
	
});

	
$(".btnsearch").click(function(e){	
	e.preventDefault();
	loadTable();
});




function loadTable(){

	var search =  $( "#jurisdiction_value option:selected" ).val();
   
	 table =  $('#mainDatatables').DataTable({
		 
		'paging'      : true,
		'lengthChange': false,
		'searching'   : false,
		'info'        : true,
		"processing": true, //Feature control the processing indicator.
		//"serverSide": true,
		// Load data for the table's content from an Ajax source
		/*
		'language': {
				'loadingRecords': '&nbsp;',
			   'processing': '<div class="spinner"></div>'
		},
		*/
		"ajax": {
			"url"  : "PrecodingController/GetData",
			"data" : {search_val:search},
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1,2,3,4,5],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
		{'data': 'RefId'},
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


@endsection
