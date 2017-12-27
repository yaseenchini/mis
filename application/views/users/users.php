<?php

$list = "";
$sn = 1;
foreach($data as $object){
    
    $list .= "<tr>";
    $list .= "<td>".$sn++."</td>";
    $list .= "<td>".$object->user_title."</td>";
    $list .= "<td>".$object->role_title."</td>";
    $list .= "<td>".$object->dept_title."</td>";
    $list .= "<td>".$object->user_email."</td>";
    $list .= "<td>".$object->user_name."</td>";
    $list .= "<td>".status($object->user_status)."</td>";
    $list .= "<td class='text-center'>
                    <a href='".site_url("users/edit_user/".$object->user_id)."' class='ml10' title='Edit User'><i class='fa fa-edit'></i><a>
                    <a href='".site_url("users/trash_user/".$object->user_id)."' class='trash_btn ml10' title='Delete User'><i class='fa fa-trash-o'></i><a>
                  </td>";
    $list .= "</tr>";
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
			
            <div class="table-responsive">
                <table class="table table-striped">
                
                    <table class="table table-bordered table-striped">
						<thead>
						  <tr>
							<th>S#</th>
							<th>Name</th>
							<th>Role</th>
							<th>Dept/Sec</th>
							<th>Email</th>
							<th>Username</th>
							<th>Status</th>
							<th>&nbsp;</th>
						  </tr>
						</thead>
						<tbody>
						  <?php echo $list; ?>
						</tbody>
					  </table>

                    
                    
                </table>
            </div>
			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
