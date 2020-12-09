<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo @base_url(); ?>assets/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo @$_SESSION['EName'];?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
       <li class="header">STAGE</li>
	   <li class="active treeview menu-open">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>ACQUIRE</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="">
             <li class="active"><a href="precoding"><i class="fa fa-circle-o"></i>Precoding <small class="label pull-right bg-green"><span class="precoding">0</span></small></a></li>
			 <li class="active"><a href="forApproval"><i class="fa fa-question"></i>For Approval <small class="label pull-right bg-green"><span class="precoding">0</span></small></a></li>
              <li class="active"><a href="batching"><i class="fa fa-file"></i>Batching<small class="label pull-right bg-green"><span class="batching">0</span></small></a></li>
              <li class="active"><a href="registration"><i class="fa fa-file"></i>Registration</a></li>
          </ul>
        </li>
       <li class="treeview">
          <a href="#" 1="">
            <i class="fa fa-spinner"></i> <span>ENRICH</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">			 
			<li class="treeview">
              <a href="#"><i class="fa fa-book"></i> CONTENTREVIEW <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
				  <span class="label label-primary pull-right">0</span>
                </span>
              </a>
              <ul class="treeview-menu">
				 <li class=""><a href="GetNextBatch.php?page=Enrich&amp;Task=CONTENTREVIEW"><i class="fa  fa-hand-grab-o"></i>Get Next Batch</a></li>
			  </ul>
            </li>				 
			<li class="treeview">
              <a href="#"><i class="fa fa-book"></i> DATAEXTRACTION <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
				  <span class="label label-primary pull-right">0</span>
                </span>
              </a>
              <ul class="treeview-menu">
				 <li class=""><a href="GetNextBatch.php?page=Enrich&amp;Task=DATAEXTRACTION"><i class="fa  fa-hand-grab-o"></i>Get Next Batch</a></li>
			  </ul>
            </li>				 
			<li class="treeview">
              <a href="#"><i class="fa fa-book"></i> QC <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
				  <span class="label label-primary pull-right">0</span>
                </span>
              </a>
              <ul class="treeview-menu">
				 <li class=""><a href="GetNextBatch.php?page=Enrich&amp;Task=QC"><i class="fa  fa-hand-grab-o"></i>Get Next Batch</a></li>
			  </ul>
            </li>				 
			<li class="treeview">
              <a href="#"><i class="fa fa-book"></i> WRITING <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
				  <span class="label label-primary pull-right">0</span>
                </span>
              </a>
              <ul class="treeview-menu">
				 <li class=""><a href="GetNextBatch.php?page=Enrich&amp;Task=WRITING"><i class="fa  fa-hand-grab-o"></i>Get Next Batch</a></li>
			   </ul>
            </li>				 
			<li class="treeview">
              <a href="#"><i class="fa fa-book"></i> WRITINGQC <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
				  <span class="label label-primary pull-right">0</span>
                </span>
              </a>
              <ul class="treeview-menu">
				 <li class=""><a href="GetNextBatch.php?page=Enrich&amp;Task=WRITINGQC"><i class="fa  fa-hand-grab-o"></i>Get Next Batch</a></li>
			  </ul>
            </li> 
			<li class="treeview">
              <a href="#"><i class="fa fa-book"></i> FINALREVIEW <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
				  <span class="label label-primary pull-right">0</span>
                </span>
              </a>
              <ul class="treeview-menu">
				
				 <li class=""><a href="GetNextBatch.php?page=Enrich&amp;Task=FINALREVIEW"><i class="fa  fa-hand-grab-o"></i>Get Next Batch</a></li>
			  </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-book"></i> Completed
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
				  
                </span>
              </a>
              <ul class="treeview-menu">
				  <li><a href="ListofCompleted.php?page=FINALREVIEW"><i class="fa fa-list-alt"></i>QC Completed <span class="label label-primary pull-right bg-green">0</span></a> </li>
				  <li><a href="WritingCompleted.php?page=FINALREVIEW"><i class="fa fa-list-alt"></i>Writing Completed <span class="label label-primary pull-right bg-green">0</span></a> </li>
				</ul>
            </li>
          </ul>
        </li>
		<li class="header">SETTINGS</li>
		
		<li class="treeview">
          <a href="#">
             <i class="fa f fa-table"></i><span>Data Entry Settings</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="DataEntrySettings"><i class="fa fa-cog"></i> Configure</a></li>
          </ul>
		</li>
		
		<li class="treeview menu-open">
          <a href="#">
             <i class="fa fa-edit"></i>
            <span>Editor Settings</span>
            
          </a>
          <ul class="treeview-menu">
            <li><a href="EditorSettings"><i class="fa fa-cog"></i> Configure</a></li>
          </ul>
        </li>
		
		
		<li class="header">REPORTS</li>
		<li class="treeview">
          <a href="#">
             <i class="fa  fa-dashboard"></i>
            <span>Reports</span>
          </a>
          <ul class="treeview-menu">
			<li><a href="TrackingReport.php"><i class="fa  fa-bar-chart"></i> Tracking Report</a></li>
			<li><a href="StateMonitoring.php"><i class="fa  fa-bar-chart"></i> State Monitoring</a></li>
			<li><a href="Dashboard.php"><i class="fa  fa-bar-chart"></i> Dashboard</a></li>
		  </ul>
        </li>
		<li class="header">REFERENCES</li>
		<li class="treeview">
          <a href="#">
             <i class="fa  fa-dashboard"></i>
            <span>LEGISLATION MONITORING</span>
          </a>
          <ul class="treeview-menu">
				<li><a href="Legislation Monitoring/Evaluating Relevance of Legislation.htm" target="_blank"><i class="fa  fa-book"></i> Relevance of Legislation</a></li>
				<li><a href="Legislation Monitoring/Jurisdiction Sources 10.03.2020_final.htm" target="_blank"><i class="fa  fa-book"></i> Jurisdiction Source</a></li>
				<li><a href="Legislation Monitoring/Copy of Legislation up to V60.htm" target="_blank"><i class="fa  fa-book"></i> Copy of Legislation up to V60</a></li>	
				<li><a href="Legislation Monitoring/List of jurisdictions - Pilot revised.htm" target="_blank"><i class="fa  fa-book"></i> List of jurisdictions</a></li>	
				<li><a href="Legislation Monitoring/Topics and Sub-Topics.htm" target="_blank"><i class="fa  fa-book"></i> Topics and Sub-Topics</a></li>		 
          </ul>
        </li>
		<li class="treeview">
          <a href="#">
             <i class="fa  fa-dashboard"></i>
            <span>SUMMARY WRITING</span>
          </a>
          <ul class="treeview-menu">
				<li><a href="Summary Writing/Ideagen Summary Writing - Innodata Queries_080320203-MA response (1).pdf" target="_blank"><i class="fa  fa-bar-chart"></i> Ideagen Summary Writing Queries</a></li>
				<li><a href="Summary Writing/Innodata-Legal Summary Examples 19.06.2020 (5).htm" target="_blank"><i class="fa  fa-bar-chart"></i> Inno Legal Summary Example</a></li>
				<li><a href="Summary Writing/QPulse Law Writing Principles.htm" target="_blank"><i class="fa  fa-bar-chart"></i> QPulse Law Writing</a></li>	
				<li><a href="Summary Writing/Legal Summary Examples.pdf" target="_blank"><i class="fa  fa-bar-chart"></i> Legal Summary</a></li>
				<li><a href="Summary Writing/Ideagen Summary Writing Innodata Queries_03.09.2020.pdf" target="_blank"><i class="fa  fa-bar-chart"></i> Innodata Queries_03.09.2020</a></li>	
					 
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>