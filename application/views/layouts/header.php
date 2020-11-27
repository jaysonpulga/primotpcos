<header class="main-header">
    <!-- Logo -->	
	<a href="#" class="logo">     
      <!-- mini logo for sidebar mini 50x50 pixels -->
     <span class="logo-mini"><img src="assets/images/innodata.png" class="img-circle"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg pull-left"><img src="assets/images/innodata.png" class="img-circle" alt="User Image">&nbsp;<b>p</b>rimo</span>
    </a>
	
	
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="assets/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"> <?php echo @$_SESSION['EName'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="assets/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo @$_SESSION['EName'];?>
                  <small><?php echo @$_SESSION['UserType'];?></small>
                </p>
              </li>
  
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                 <div class="pull-right">
				   <a class="btn btn-default btn-flat" href="signout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
				   <form id="logout-form" action="signout" method="POST" style="display: none;"></form>
				</div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>