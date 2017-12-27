<?php


//create roles
$role_list = "";
foreach($roles as $role){
    $role_list .= "<option value='".$role->role_id."' ".sel_attr($role->role_id, $user->role_id)."> ".$role->role_title."</option>";
}


//create depts
$dept_list = "";
foreach($departments as $dept){
    $dept_list .= "<option value='".$dept->dept_id."' ".sel_attr($dept->dept_id, $user->dept_id)."> ".$dept->dept_title."</option>";
}



?>

<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<!-- STYLER -->
			
			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>">Home</a>
				</li>
                <li>
					<!--<i class="fa fa-home"></i>-->
					<a href="<?php echo site_url("users/view"); ?>">Users</a>
				</li>
				<li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
            <div class='row'>
                        
                <div class='col-md-6'>
                    <div class='clearfix'>
					  <h3 class='content-title pull-left'><?php echo $title; ?></h3>
					</div>
					<div class='description'><?php echo $title; ?></div>
                </div>
                
                <div class='col-md-6'>
                    <div class='pull-right'>
                        <a class='btn btn-primary btn-sm' href='<?php echo site_url("users/add_user"); ?>'><i class='fa fa-plus'></i> New</a>
                        <a class='btn btn-danger btn-sm' href='<?php echo site_url("users/trashed_users"); ?>'><i class='fa fa-trash-o'></i> Trash</a>
                    </div>
                </div>
                
            </div>
            
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->



<!-- PAGE MAIN CONTENT -->
<div class="row">
		<!-- MESSENGER -->
	<div class="col-md-12">
	<div class="box border blue" id="messenger">
		<div class="box-title">
			<h4><i class="fa fa-bell"></i><?php echo $title; ?></h4>
			<div class="tools">
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="box-body">
            
            <?php echo validation_errors(); ?>
            
            <form class="form-horizontal" role="form" id="role_form" method="post" action="<?php echo site_url("users/edit_user/".$user->user_id); ?>">
			  
              <div class="form-group">
				<label for="user_title" class="col-sm-2 control-label">User Title</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_title" name="user_title" placeholder="User Title/Full Name" value="<?php echo set_value("user_title", $user->user_title); ?>" />
				</div>
			  </div>
              
              
              <div class="form-group">
				<label for="user_email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_email" name="user_email" placeholder="Email Address (will be used for login)" value="<?php echo set_value("user_email", $user->user_email); ?>" />
				</div>
			  </div>
              
              
              <div class="form-group">
				<label for="user_password" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_password" name="user_password" placeholder="Enter Password" value="<?php echo set_value("user_password", $user->user_password); ?>" />
				</div>
			  </div>
              
              
               
              
              
              
              
              
              
              <div class="form-group">
				<label class="col-sm-2 control-label">Role</label>
				<div class="col-sm-10">
				 <select class="form-control" name="role_id">
				  <?php echo $role_list; ?>
				</select>
				
				</div>
			  </div>
              
              
              
              
              
              
              <div class="form-group">
				<label class="col-sm-2 control-label">Department</label>
				<div class="col-sm-10">
				 <select class="form-control" name="dept_id">
				  <?php echo $dept_list; ?>
				</select>
				
				</div>
			  </div>
              
              
              
              
              <div class="form-group">
				 <label class="col-md-2 control-label">User Status </label> 
				 <div class="col-md-10"> 
					<label class="radio"> <input type="radio" class="uniform" name="user_status" value="1" <?php echo radio_checked($user->user_status, "1"); ?> /> Active </label> 
					<label class="radio"> <input type="radio" class="uniform" name="user_status" value="0" <?php echo radio_checked($user->user_status, "0"); ?> /> Inactive </label> 
					</div>
			  </div>
              
              
              
			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-primary">Save</button>
				</div>
			  </div>
			</form>



			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
