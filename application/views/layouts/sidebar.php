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
				 <li class="active">
					<a href="precoding">
						<i class="fa fa-circle-o"></i> Precoding 
						<small class="label pull-right bg-green">
							<span class="precoding_count">0</span>
						</small>
					</a>
				</li>
				 <li class="active">
					<a href="forApproval">
						<i class="fa fa-question"></i> For Approval 
						<small class="label pull-right bg-green">
							<span class="forApproval_count">0</span>
						</small>
					</a>
				</li>
				<li class="active">
					<a href="batching">
						<i class="fa fa-file"></i> Batching
							<small class="label pull-right bg-green">
								<span class="batching_count">0</span>
							</small>
					</a>
				</li>
				<li class="active">
					<a href="registered">
						<i class="fa fa-file"></i> Registered
							<small class="label pull-right bg-green">
								<span class="registered_count">0</span>
							</small>
					</a>
				</li>
				<li class="active">
					<a href="registration">
						<i class="fa fa-file"></i> Manual Registration
					</a>
				</li>
			  </ul>
       </li>
       <li id="Parent_Menu_EnrichMenu"  class="treeview">
          <a href="#">
            <i class="fa fa-spinner"></i> <span>ENRICH</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
		  
			<?php
				include(APPPATH.'controllers/SidebarMenuController.php'); 
				$GetData = SidebarMenuController::EnrichMenu();
				//print_r($GetData);
			?>

		  
		   <ul class="treeview-menu">
		   <?php if (!empty($GetData)): ?>
		   
				<?php foreach($GetData as $WorkflowName => $data): ?>
				
					<?php $WorkflowName_remove_space = preg_replace('/\s+/', '', $WorkflowName); ?>
					<li id="Child_Menu_<?php echo $WorkflowName_remove_space;?>"  class="treeview" >
						<a href="#"> 
							<i class="fa fa-book"></i> 
							
							
							<span> <?php echo $WorkflowName; ?> </span> 
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
						</a>
						<ul class="treeview-menu">
						
								<?php foreach($data as  $ProcessCode => $valData ): ?>
									<li id="Sub_Child_Menu_<?php echo @$ProcessCode;  ?>">
											 <a href="#">
												<i class="fa fa-book"></i> 
												<span> <?php echo @$ProcessCode;  ?> </span>								
												<span class="pull-right-container">
													<i class="fa fa-angle-left pull-right"></i>
													<span class="label label-primary pull-right"><?php echo $valData['countNum'];  ?></span>
												</span>
											  </a>
											  
											  <ul class="treeview-menu">
											  
													<?php if($valData['countNum'] > 0): ?>
													
															<?php foreach($valData['data_value'] as $value ): ?>
																
																<li class="" id="Second_Sub_Child_Menu_<?php echo $value['RefId'] ?>">
																	<a href='CodeMirror?RefId=<?php echo $value['RefId'] ?>&BatchID=<?php echo $value['BatchID'] ?>&Task=<?php echo $valData['ProcessCode'] ?>'  >
																		<i class="fa fa-file-pdf-o"></i>
																		<span><?php echo $value['JObname'] ?></span>
																	</a>
																</li>
													
														
															<?php endforeach; ?>
											  
													<?php else: ?>
													
														<li class="" id="Second_Sub_Child_Menu_">
															<a href="javascript:void(0)" class="GetNextbatch" data-ProcessCode="<?php echo $valData['ProcessCode']; ?>" data-WorkFlowId="<?php echo $valData['WorkFlowId'] ?>" >
																<i class="fa  fa-hand-grab-o"></i>
																<span>Get Next Batch</span>
															</a>
														</li>
														
													<?php endif; ?>
											  </ul>
	
											
									</li>
								<?php endforeach; ?>
						
						</ul>
					</li>
				<?php endforeach; ?>
			
			
			<?php endif; ?>
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
		
		<li class="treeview">
          <a href="#">
             <i class="fa f fa-tasks"></i>
            <span>Task Settings</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="TaskSettings"><i class="fa fa-cog"></i> Configure</a></li>
          </ul>
        </li>
		
		<li class="treeview">
          <a href="#">
             <i class="fa fa-user"></i>
            <span>User Maintenance</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="UserList"><i class="fa fa-user-plus"></i> User List</a></li>
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
  

  
 <script> 
$(function(){
	loadMenubar();
});

function loadMenubar(){	
	 $.ajax({
			url 		: "SidebarMenuController/Countmenubar",
			type		: "POST",
			dataType	: "JSON",
			success		: function(data){
						
						$(".precoding_count").empty().html(data.countPrecoding);
						$(".forApproval_count").empty().html(data.countApproval);
						$(".batching_count").empty().html(data.countApproved);
						$(".registered_count").empty().html(data.countRegistered);
						
						
						
			},
			error: function (jqXHR, textStatus, errorThrown){
				console.log('Error get data from ajax');
			}
    });
	
}	
</script>

<script>
$(document).on('click','.GetNextbatch',function(){
	
	var ProcessCode = $(this).attr('data-ProcessCode');
	var WorkFlowId = $(this).attr('data-WorkFlowId');
	
	$.ajax({
		url:'<?php echo base_url(); ?>GetNextbatchController/AutoAllocate',
		type:'post',
		data:{ProcessCode:ProcessCode,WorkFlowId:WorkFlowId},
		dataType:'json',
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
			 
			 if(data.count > 0  && data.error == false)
			 {
				   swal({
						type:'success',
						title:"File Allocated"
					}).then(function(){
						
						window.location.href="CodeMirror?RefId="+data.RefId+"&BatchID="+data.BatchID+"&Task="+data.Task;
							
					})
			 }
			 else if(data.error == true){
				 
					swal({
						type:'error',
						title:"Oops..",
						text:data.message
					})
					
					return false;
			 }
			 else
			 {
				 
				 swal({
						type:'error',
						title:"No File Allocated"
					})
				 return false;
						
			 }
			 
		},
		 error: function(xhr, status, error){
			 $('body').waitMe('hide');
         var errorMessage = xhr.status + ': ' + xhr.statusText
         alert('Error - ' + errorMessage);
     }
		/*
		error: function(event, jqXHR, ajaxSettings, thrownError) {
			$('body').waitMe('hide');
			alert('[event:' + event + '], [jqXHR:' + jqXHR + '], [ajaxSettings:' + ajaxSettings + '], [thrownError:' + thrownError + '])');
		}
		/*
		error:function(){
			$('body').waitMe('hide');
			swal({
				type:'error',
				title:"Oops..",
				text:"Internal error "
			})
        }
		*/
		
	})


});
</script>


<script>
$(document).ready(function(){

	var Parent_Menu_ = "<?php echo @$Parent_Menu_ ?>";
	var Child_Menu_ =  "<?php echo @$Child_Menu_ ?>";
	var Sub_Child_Menu_ =  "<?php echo @$Sub_Child_Menu_ ?>";
	var Second_Sub_Child_Menu_ =  "<?php echo @$Second_Sub_Child_Menu_ ?>";
	
	
	if(Parent_Menu_ != "")
	{	
		$('.sidebar ul li').removeClass('active');
		$('.sidebar ul li#'+Parent_Menu_).addClass('active');
	}
	

	if(Child_Menu_ != "")
	{	
		$('.sidebar ul.treeview-menu li').removeClass('active');
		$('.sidebar ul.treeview-menu li#'+Child_Menu_).addClass('active');
	}
	
	
	if(Sub_Child_Menu_ != "")
	{		
		$('li#'+Child_Menu_+'  ul.treeview-menu li').removeClass('active');
		$('li#'+Child_Menu_+'  ul.treeview-menu li#'+Sub_Child_Menu_).addClass('active');
	}
	
	if(Second_Sub_Child_Menu_ != "")
	{		
		$('li#'+Sub_Child_Menu_+'  ul.treeview-menu li').removeClass('active');
		$('li#'+Sub_Child_Menu_+'  ul.treeview-menu li#'+Second_Sub_Child_Menu_).addClass('active');
	}
	
	
	
});
</script>