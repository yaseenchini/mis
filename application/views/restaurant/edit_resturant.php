
<?php
    foreach ($record as $value) {
    	$id=$value['res_id'];
    	$name=$value['res_name'];
    	$location=$value['res_location'];
    	$contactno=$value['res_contactno'];
    	$res_seqeunce=$value['res_seqeunce'];
    	$res_desc=$value['res_desc'];
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
					<!--<i class="fa fa-home"></i>
					<a href="<?php// echo site_url("users/view"); ?>">Users</a>-->
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
            
            <form class="form-horizontal" role="form" id="role_form" method="post" action="<?php echo site_url("restaurant/edit_restaurant");?>">
			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
              <div class="form-group">
				<label for="user_title" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_title" name="res_name" placeholder="User Title/Full Name" value="<?php echo $name; ?>" />
				</div>
			  </div>
              
              
              <div class="form-group">
  				<label for="user_email" class="col-sm-2 control-label">Description</label>
  				<div class="col-sm-10">
  				  <input type="text" class="form-control" id="user_email" name="res_desc" placeholder="Description of restaurent" value="<?php echo $res_desc; ?>" />
  				</div>
  			  </div>

              <div class="form-group">
				<label for="user_email" class="col-sm-2 control-label">Location</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_email" name="res_location" placeholder="Email Address (will be used for login)" value="<?php echo $location; ?>" />
				</div>
			  </div>
              
              
              <div class="form-group">
				<label for="user_password" class="col-sm-2 control-label">Contact no</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_password" name="res_contactno" placeholder="Enter Password" value="<?php echo $contactno; ?>" />
				</div>
			  </div>

			  <div class="form-group">
			    	<label for="seq" class="col-sm-2 control-label">Sequence</label>
			    	<div class="col-sm-10">
			    	  <input type="text" class="form-control" id="seq" name="res_seqeunce" value="<?php echo $res_seqeunce; ?>" placeholder="Sequence" />
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
