<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="innodata.png">
  <title>Log in</title>
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
  <!-- iCheck -->
  <link rel="stylesheet"  href="assets/adminlte/plugins/iCheck/square/blue.css">
 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
<style>

#msform fieldset, .login-box-body {
    border-radius: 23px !important;
}

#msform fieldset, .login-box-body {
    box-shadow: 0px 20px 20px 0px rgba(0, 0, 0, 0.4) !important;
}
.login-box-body, .register-box-body {
    background: #fff;
    padding: 20px;
    border-top: 0;
    color: #666;
}

#accoun_settings .fs-title, .login-box-msg {
    font-size:21px;
    font-weight: 300;
    margin-bottom: 0px !important;
}

.login-box-msg, .register-box-msg {
    margin: 0;
    text-align: center;
    padding: 0 20px 20px 20px;
}

.login-page, .register-page {
    background: #10416a !important;
}

.login-nav-logo {
    margin: auto;
    display: grid;
    margin-top: 10px;
	margin-bottom :20px;
}
</style>

</head>
<body class="hold-transition login-page">

<div class="login-box">
 
 <div class="login-nav-logo"><a href="#">
	<img src="assets/images/logo-innodata-white.png" style="width:97%"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
  
    <p class="login-box-msg">Sign in to start your session</p>
	
	 <?php  echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  ?> 
   
   <form  method="POST" action="signin">

		  <div class="form-group has-feedback">
			  <input id="username" type="text" class="form-control" name="username" placeholder="username" required autofocus>
			  <span class="glyphicon glyphicon-user form-control-feedback"></span>
		  </div>
		  
		  <div class="form-group has-feedback">      
			  <input id="password" type="password" class="form-control" name="password" placeholder="password" required>
			  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		  
		  
	
		<div class="form-group has-feedback">      
			  <button class="btn btn-primary btn-lg btn-block mb-2 mb-lg-5" type="submit"> Sign in </button>
		</div>
	
    </form>


 

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script  src="assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js" ></script>
<!-- Bootstrap 3.3.6 -->
<script  src="assets/adminlte/bootstrap/js/bootstrap.min.js" ></script>
<!-- iCheck -->
<script  src="assets/adminlte/plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

</body>
</html>