<?php

$list = "";
if(!empty($data))
{
foreach($data as $object){
   
    $riderid=$object->r_id;
    $list .= "<tr>";
    $list .= "<td>".$object->r_id."</td>";
    $list .= "<td>".$object->name."</td>";
    $list .= "<td>".$object->office_no."</td>";
    $list .= "<td>".$object->personal_no."</td>";
    $list .= "<td>".$this->rider_m->riderstatus($object->status)."</td>";
    $list .= "<td>".$object->shift."</td>";
    $list .= "<td>".$object->comments."</td>";
    $list .= "<td><a href='".site_url("riders/approvedbyadmin/".$riderid)."'>".$this->rider_m->adminapproval($object->admin_approval)."</a></td>";
    $list .= "<td><a href='".site_url("riders/activerider/".$riderid)."'>".$this->rider_m->active($object->Active)."</a></td>";
    $list .= "<td class='text-center'>
                    <button type='button' class='btn-btn-primary btn-xs' value=".$riderid." id='ridercomment'><span class='fa fa-pencil'></span></button>
                    <a href='".site_url("riders/update_riders/".$object->r_id)."'
                    onclick='return confirm('Are You Sure To Delete This!')'; class='ml10' title='Edit User'><i class='fa fa-edit'></i><a>
                    <a href='".site_url("riders/delete_riders/".$object->r_id)."' class='trash_btn ml10' title='Delete User'><i class='fa fa-trash-o'></i><a>
                  </td>";
    $list .= "</tr>";
}
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
							<th>Office No</th>
							<th>Personal No</th>
							<th>Status</th>
							<th>Shift</th>
							<th>Comments</th>
							<th>Admin_approval</th>
							<th>Active</th>
							<th>Actions</th>
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

<div>
    <div id="myModal" class="modal fade" role="dialog" style="display:none">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Write Comment</h4>
      </div>
      <form method="post" action="<?php echo base_url();?>riders/ridercomments">
      <div class="modal-body">
        <label>Comment</label>
        <input type="text" name="comment" placeholder="Comment" class="form-control"/>
        <input type="hidden" name="riderid" id="riderid" value=""/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>

  </div>
</div>
    
    
</div>


<script>
    $("#ridercomment").on('click',function(){
       var riderid=$(this).attr('value');
       $("#riderid").val(riderid);
       $("#myModal").modal('show');
       
       
    });
    
    
</script>
