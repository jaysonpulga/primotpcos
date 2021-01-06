@extends(layouts/site)
@section(content)

<section class="content-header">
  <h1>
	Task Configuration (<?php echo $_GET['Name'];?>)
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Task Configuration</li>
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
					<h3 class="box-title"><a type="button" href="TaskSettings" class="btn btn-block btn-primary" >Back</a></h3>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		
		<form method="post" id="taskconfiguration">
			<div class="box-body margin">
				 <strong style="display:block">Editor Setting</strong>
				 <input type="checkbox"  name="SOURCE"  <?php echo $setttings->Source == 1 ? 'checked' : '' ?>  > Source<BR>
				 <input type="checkbox"  name="Styling" <?php echo $setttings->Styling == 1 ? 'checked' : '' ?> > Styling<BR>
				 <input type="checkbox"  name="XML_Editor" <?php echo $setttings->XMLEditor == 1 ? 'checked' : '' ?> > XML Editor<BR>
				 <input type="checkbox"  name="SequenceLabeling"  <?php echo $setttings->SequenceLabeling == 1 ? 'checked' : '' ?>> Sequence Labeling<BR>
				 <input type="checkbox"  name="TextCat" <?php echo $setttings->TextCategorization == 1 ? 'checked' : '' ?> > Text Categorization<BR>
				 <input type="checkbox"  name="DataEntry"  <?php echo $setttings->DataEntry == 1 ? 'checked' : '' ?>> Data Entry<BR>
				 <input type="checkbox"  name="TreeView"  <?php echo $setttings->TreeView == 1 ? 'checked' : '' ?>> Tree View<BR>
				 <input type="hidden" name="TaskID" value="<?php echo $TaskID; ?>" >
				 <input type="hidden" name="Processcode" value="<?php echo $Processcode; ?>">
			</div>
			<!-- /.box-body -->
			
			<div class="box-body margin">
			   <strong style="display:block">Menu Group</strong>
				<select name="MenuGroup" id="MenuGroup" style="width: 300px;" class="form-control">
					<option value=""></option>
					<option value="ACQUIRE">ACQUIRE</option>
					<option value="ENRICH">ENRICH</option>		 
					<option value="DELIVER">DELIVER</option>
				</select>
			</div>
			<!-- /.box-body -->
			
			<div class="box-body margin">
				<table id="mainDatatables"  class="table table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						 <tr>
							  <th  width="20px"><input type="Checkbox" id="chk_new"  onclick="checkAll('chk');" ></th>
							  <th>Domain Name</th>
							  <th>Auto-load</th>
						 </tr>
					</thead>
					<tbody></tbody>
					<tfoot>
						<tr>
							<th><button type="submit" class="btn btn-block btn-primary">Save</button></th>
							<th colspan="2"></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- /.box-body -->
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
    
	loadTable();
	
	$("#MenuGroup").val("<?php echo $setttings->MenuGroup ?>");
	
});

	



function loadTable(){

   
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
			"url"   : "TaskSettingsController/getConfig",
			"data"  : {"UID":"<?php echo $TaskID ?>"},
			"type"  : "post",
		},
		
		"columnDefs": [ {
		"targets": [0,1,2],
		"orderable": false
		}],
			
		"bDestroy": true,
		"columns"    : [
			{'data': 'id'},
			{'data': 'MLName'},
			{'data': 'autoload'},
		],

		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
		$(nRow).attr("id",aData['id']);
		return nRow;
		},

	});
   
}


function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
}

</script>

<script>
$("#taskconfiguration").on("submit", SaveData); 
function SaveData(event){
	
	event.preventDefault();
	
	let form = $('#taskconfiguration');
	let formData = form.serialize();
		
  $.ajax({
                url:'<?php echo base_url(); ?>TaskSettingsController/UpdatetaskConfiguration',
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
