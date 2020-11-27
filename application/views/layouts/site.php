<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="assets/adminlte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
	   folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="assets/adminlte/dist/css/skins/_all-skins.min.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
   <!-- jQuery 2.2.3 -->
   <script src="assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
   <!-- jQuery UI 1.11.4 -->
   <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
   <!-- Bootstrap 3.3.6 -->
   <script src="assets/adminlte/bootstrap/js/bootstrap.min.js"></script>
  
	
</head>
<body>
	
</body>
</html>


<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <!-- Main Header -->
  <div>
	<?php $this->load->view('layouts/header'); ?>
  </div>
  
  <!-- Left side column. contains the logo and sidebar -->
  <div>
    <!-- sidebar: style can be found in sidebar.less -->
   <?php $this->load->view('layouts/sidebar'); ?>
    <!-- /.sidebar -->
  </div>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <!-- Content Wrapper. Contains page content -->
		@yield(content)
	  <!-- /.content-wrapper -->
  </div>
  <!-- /.content-wrapper -->
   

  <footer class="main-footer">
     <?php $this->load->view('layouts/footer'); ?>
  </footer>

  
</div>
<!-- ./wrapper -->
</body>
</html>
<!-- JS content -->
<?php $this->load->view('layouts/javascript_container'); ?>
