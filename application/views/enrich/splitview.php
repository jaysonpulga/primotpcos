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

	<!--<script src="js/jquery-3.4.1.min.js"></script>-->
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
	
	<!-- Bootstrap 3.3.6 -->
    <script  src="<?php echo base_url(); ?>assets/adminlte/bootstrap/js/bootstrap.min.js" ></script>
	
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
	
	<link rel="stylesheet" href="assets/codemirror/codemirror.css">
	<link rel="stylesheet" href="assets/addon/fold/foldgutter.css" />
	<link rel="stylesheet" href="assets/addon/dialog/dialog.css">
	<link rel="stylesheet" href="assets/addon/search/matchesonscrollbar.css">
	 
	<script src="assets/codemirror/codemirror.js"></script> 
	<script src="assets/addon/fold/foldcode.js"></script>
	<script src="assets/addon/fold/foldgutter.js"></script>
	<script src="assets/addon/fold/brace-fold.js"></script>
	<script src="assets/addon/fold/xml-fold.js"></script>
	<script src="assets/addon/fold/markdown-fold.js"></script>
	<script src="assets/addon/fold/comment-fold.js"></script>
	<script src="assets/mode/javascript/javascript.js"></script>
	<script src="assets/mode/xml/xml.js"></script>
	<script src="assets/mode/markdown/markdown.js"></script>
	
	<style type="text/css">
    .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; height: 32vw;}
	.CodeMirror-selected  { background-color: skyblue !important; }
      .CodeMirror-selectedtext { color: white; }
      .styled-background { background-color: #ff7; }
  </style>


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

 <a href="CodeMirror?RefId=<?php echo $_GET['RefId'] ?>&BatchID=<?php echo $_GET['BatchID']?>&Task=<?php echo $_GET['Task'] ?>" class="btn btn-danger">Exit Splitview</a> 
 
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
				
				<h3 id="LoadStyles"><a href="#" >Validation Logs</a></h3>
				<div>
					<ul class="nav nav-pills nav-stacked">
						<div id="validate_result_return"><br><br></div>
					</ul>
				</div>

				<h3><a href="#">Allocation Details</a></h3>
				<div>
					<ul class="nav nav-pills nav-stacked">
						<li><b>TASK: <span id="Task1"><?php  echo @$dataresult->ProcessCode ?></span></b></li>
						<li> RefID:  <u><span id='JobID'><?php  echo @$dataresult->RefId ?></span></u> </li>
						<li> JobName: <u><span id='JobID'><?php echo @$dataresult->JobName ?></span></u> </li>
						<li> JobID: <u><span id='JobID'><?php echo @$dataresult->JobId ?></span></u> </li>
						<li> Regulation Number: <u><span id='JobID'><?php echo @$dataresult->RegulationNumber ?></span></u></li>
						<li> 
							File name:  <u><span id='filename'><?php echo @$dataresult->Filename ?></span></u> 
							<input type="hidden" name="Filename" id="Filename" value="<?php echo pathinfo($dataresult->Filename, PATHINFO_FILENAME); ?>">
						</li>		
						<li>Last Update:  <u><?php echo @$dataresult->LastUpdate ?></u></li>
						<li>Status:  <u><?php echo @$dataresult->StatusString ?></u></li>
					</ul>
					<br>
					<div class="box-tools">
						 <br>
						 <?php if(@$dataresult->StatusString == "Ongoing" ) : ?>
						 
							<li id="SaveButton"> 
								<button   class="btn btn-success  pull-right saveXmlFormDatawithHtml" style="width:150px"> Validate</button>
							</li>
							
						<?php endif; ?>
					</div>
				</div>
		</div>
	<!-- /.box-body content -->
	</div>
</div>
<!--/East -->	

<!-- Center -->
<div class="ui-layout-center">
	<ul id="nav-tab" class="nav-tabs-custom">
	
		<li id="xmleditor" class="active"><a href="#TAB_xmleditor" class="class_xmleditor"  onclick="GenerateXML()"><SPAN>XML Editor</SPAN></a></li>
		<li ><a href="#tab_3"><SPAN>Metadata Info.</SPAN></a></li>
		
	</ul>	
	<div class="ui-layout-content"><!--  ui-widget-content -->
		<div id="tab_3">
			<fieldset>
				<form id="mlform">
					 <?php echo  @$dataEntryFormTemplate  ?>
				 </form>
			</fieldset> 
		</div>

		<div id="TAB_xmleditor">
			<form id='xmlsubmit'>
				<fieldset>
					<div class="form-group" style="width:100%; height:35vw;">
					<textarea rows="100"  name="xmltextarea" id="xmltextarea"></textarea>
					<script id="script">
					/*
					 * Demonstration of code folding
					 */
					  var te_html = document.getElementById("xmltextarea");
					  var editor_html = CodeMirror.fromTextArea(te_html, {
						mode: "text/xml",
						lineNumbers: true,
						matchTags: {bothTags: true},
						lineWrapping: true,
						extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); }},
						foldGutter: true,
						styleActiveLine: true,
						styleActiveSelected: true,
						styleSelectedText: true,
						gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
					  });
					   
					editor_html.refresh();
					 
					  </script>
					  
					   <script>
					  function jumpToLine(prLineNo,prCol){
						  
						editor_html.refresh();
						editor_html.setCursor(prLineNo);
						
						editor_html.markText({line: prLineNo, ch: prCol}, {line: prLineNo, ch: prCol+5}, {className: "styled-background"});
					  }
					  </script>
					  <br>
					<div class="pull-right">
						<input type="hidden" name="SGML_filename" value="<?php echo $dataresult->SGML_filename ?>">
						<input type="hidden" name="RefId" value="<?php echo $dataresult->RefId ?>">
					</div>
					</div>
				</fieldset>
				</form>	
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
	let filepath = '<?php echo @$filepath ?>';
	let randomCode = '<?php echo rand(1,9999999999999);?>';
	let SGML_filename = '<?php echo @$dataresult->SGML_filename ?>';
	let ename = '<?php echo $this->session->userdata("EName"); ?>'
</script>



<script src="<?php echo base_url(); ?>customize_file/enrich/splitview.js?rand=randomCode"></script>
<script src="<?php echo base_url(); ?>customize_file/acquire/ckeditor_custom.js?rand=randomCode"></script>