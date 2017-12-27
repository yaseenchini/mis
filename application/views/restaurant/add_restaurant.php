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
            
            <form class="form-horizontal" role="form" id="role_form" method="post" enctype="multipart/form-data" action="<?php echo site_url("restaurant/add_restaurant"); ?>">
			  
              <div class="form-group">
				<label for="user_title" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_title" name="res_name" placeholder="Resturant Title/Full Name" />
				</div>
			  </div>
              
              
              <div class="form-group">
				<label for="user_email" class="col-sm-2 control-label">Location</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_email" name="res_location" placeholder="Address" />
				</div>
			  </div>
              
              
              <div class="form-group">
				<label for="user_password" class="col-sm-2 control-label">Contact No</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_password" name="res_contactno" placeholder="Conact No" />
				</div>
			  </div>
              
              <div class="form-group">
				 <label class="col-md-2 control-label">File Upload</label> 
				 <div class="col-md-10">
					<input type="file" class="form-control" id="res_image" name="res_image" />
					<!-- <div class="fileupload fileupload-new">
					<div class="input-group">
						<div class="input-group-btn">
							<a class="btn btn-default btn-file">
								<input type="file" name="res_image" class="file-input">
							</a>
						</div>
					</div>
					</div> -->
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