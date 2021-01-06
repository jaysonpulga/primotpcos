<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="<?php echo base_url(); ?>assets/innodata.png">
  <title>Precoding Fullscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->  
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet"  href="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/square/blue.css">
 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
	
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
   <!-- source stable -->
   <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/source/stable/layout-default.css"/>
   
   <!-- Google Font -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 
   
   
	<!-- jQuery 2.2.3 -->
	<script  src="<?php echo base_url(); ?>assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js" ></script>
	<!-- Bootstrap 3.3.6 -->
    <script  src="<?php echo base_url(); ?>assets/adminlte/bootstrap/js/bootstrap.min.js" ></script>
	<!--<script src="js/jquery-3.4.1.min.js"></script>-->
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
	
	<!--<script src="js/jquery-2.js"></script>-->
	<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
	
	<!-- jquery layout -->
	<script src="<?php echo base_url(); ?>assets/source/stable/jquery.layout.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/themeswitchertool.js"></script> 
	
	
	<!-- Waitme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/waitme/waitMe.css">
	<script src="<?php echo base_url(); ?>assets/waitme/waitMe.min.js" ></script>
	
	<!-- sweet Alert -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.js"></script>
	

	<!-- CKEDITOR -->
	<script src="<?php echo base_url(); ?>assets/ckeditor/4.14.0/ckeditor.js"></script>
	<script src="<?php echo base_url(); ?>assets/ckeditor/4.14.0/samples/js/sample.js"></script>


<style type="text/css">

	/* remove padding and scrolling from elements that contain an Accordion OR a content-div */
	.ui-layout-center ,	/* has content-div */
	.ui-layout-west ,	/* has Accordion */
	.ui-layout-east ,	/* has content-div ... */
	.ui-layout-east .ui-layout-content { /* content-div has Accordion */
		padding: 0;
		overflow: hidden;
	}
	.ui-layout-center P.ui-layout-content {
		line-height:	1.4em;
		margin:			0; /* remove top/bottom margins from <P> used as content-div */
	}
	h3, h4 { /* Headers & Footer in Center & East panes */
		font-size:		1.1em;
		background:		#EEF;
		border:			1px solid #BBB;
		border-width:	0 0 1px;
		padding:		7px 10px;
		margin:			0;
	}
	.ui-layout-east h4 { /* Footer in East-pane */
		font-size:		0.9em;
		font-weight:	normal;
		border-width:	1px 0 0;
		background-color: #FFA07A;
	}
	</style>
	
		<style>
	/* Dropdown Button */
		.dropbtn {
		  background-color: #4CAF50;
		  color: white;
		  padding: 16px;
		  font-size: 16px;
		  border: none;
		}

		/* The container <div> - needed to position the dropdown content */
		.dropdown {
		  position: relative;
		  display: inline-block;
		}

		/* Dropdown Content (Hidden by Default) */
		.dropdown-content {
		  display: none;
		  position: absolute;
		  background-color: #f1f1f1;
		  min-width: 160px;
		  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		  z-index: 1;
		}

		/* Links inside the dropdown */
		.dropdown-content a {
		  color: black;
		  padding: 12px 16px;
		  text-decoration: none;
		  display: block;
		}

		/* Change color of dropdown links on hover */
		.dropdown-content a:hover {background-color: #ddd;}

		/* Show the dropdown menu on hover */
		.dropdown:hover .dropdown-content {display: block;}

		/* Change the background color of the dropdown button when the dropdown content is shown */
		.dropdown:hover .dropbtn {background-color: #3e8e41;}
	</style>
	

</head>
<body>
	
<!-- Main Header  North -->
<div class="ui-layout-north" align="left" style="background-color:#21618C">
 <a href="jqavascript:void(0)" class="btn btn-danger exitpreview">Exit Splitview</a>  
	<div class="pull-right">
		<img src="<?php echo base_url(); ?>assets/innodata.png"/>
	 </div>
	
</div>

<!-- Main Header  West -->
<div class="ui-layout-west"> 
	<div class="ui-layout-content">
		<div id='editContainer'>
			<div id="editorForm"></div>
		</div>
	</div>	
</div>


<!-- East -->
<div class="ui-layout-east">
	<div class="ui-layout-content">
		<div id="accordion2" class="basic">
			
				<h3 id="LoadStyles"><a href="#" >Styles</a></h3>
				<div>
					 <ul class="nav nav-pills nav-stacked">
						<div id="Joblist"></div>
					</ul>
				</div>
		
		
				<h3><a href="#">Allocation Details</a></h3>
				<div>
					<ul class="nav nav-pills nav-stacked">
						<li><b>TASK: <span id="Task1"></span></b></li>
						<li> RefID:  <u><span id='JobID'><?php  echo @$dataresult->RefId ?></span></u> </li>
						<li> ConfigName: <u><span id='JobID'><?php echo @$dataresult->ConfigName ?></span></u> </li>
						<li> Jurisdiction:  <u><span id='JobID'><?php echo @$dataresult->Jurisdiction ?></span></u> </li>
						<li> Regulation Number : <u><span id='JobID'><?php echo @$dataresult->RegulationNumber ?></span></u></li>
						<li> 
							File name:  <u><span id='filename'><?php echo @$dataresult->Filename ?></span></u> 
							<input type="hidden" name="Filename" id="Filename" value="<?php echo pathinfo($dataresult->Filename, PATHINFO_FILENAME); ?>">
						</li>		
						<li>Date Registered:  <u><?php echo @$dataresult->DateRegistered ?></u></li>
						<li>Status:  <u><?php echo @$dataresult->Status ?></u></li>
					</ul>
					<br>
					<div class="box-tools">
						 <br>
						  <?php  if(@$dataresult->Status != "for Approval"){ ?>
						 
							<li id="SaveButton"> 
								<button  type="submit" form="mlform"  class="btn btn-primary  pull-right saveHTMLFormData" style="width:150px"><i class="fa fa-save"></i> Save</button>
							</li>
							
						<?php } ?>
					</div>
				</div>
		</div>
	<!-- /.box-body content -->
	</div>
</div>
<!--/East -->	

<!-- Center -->
<div class="ui-layout-center">
	<ul  class="nav-tabs-custom">
		<li><a href="#tab_3"><SPAN>Metadata Info.</SPAN></a></li>
	</ul>	
	<div class="ui-layout-content"><!--  ui-widget-content -->
		<div id="tab_3">
			<fieldset>
				<form id="mlform">
					<input type="hidden" value="<?php echo @$dataresult->Status ?>"  name="RefIdStatus" id="RefIdStatus"/>
					 <?php echo  @$dataEntryFormTemplate  ?>
				 </form>
			</fieldset> 
		</div>				
	</div>
</div>
<!-- /Center --> 	 

</body>
</html>


<!-- define RefID  -->
<script type="text/javascript">
	let baseUrl = "<?= base_url();?>";
	let RefId = '<?php echo @$RefId?>';
	let Filename = '<?php echo @$dataresult->Filename ?>';
	let filepath = '<?php echo @$ckeditorloadfile ?>';
	let randomCode = '<?php echo rand(1,9999999999999);?>';
	let ename = '<?php echo $this->session->userdata("EName"); ?>'
</script>


<script src="<?php echo base_url(); ?>customize_file/acquire/fullscreen.js?rand=randomCode"></script>
<script src="<?php echo base_url(); ?>customize_file/acquire/ckeditor_custom.js?rand=randomCode"></script>