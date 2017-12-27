<?php
// print_r($search);

$list = "";
$sn=1;
if(!empty($search))
{
foreach($search as $value){
  
    //print_r($this->ordertracker_m->getgeneraltoaddress($value['o_id']));exit;
    $list .= "<tr>";
    $list .= "<td>".$sn."</td>";
    $list .= "<td>".$value['o_id']."</td>";
    $list .= "<td>".$this->ordertracker_m->get_order_address($value['o_id'])."</td>";
    $list.=  "<td>".$this->ordertracker_m->getgeneraltoaddress($value['o_id'])."</td>";
    $list .= "<td>".$value['order_details']."</td>";
    $list .= "<td>".$value['delivery_charges']."</td>";
    $list .= "<td>".$value['comment']."</td>";
    $list .= "<td>".$value['ordertime']."</td>";
    $list .= "<td class='text-center'>
                    <a href='".site_url("order/deleteorder/".$value['o_id'])."' class='trash_btn ml10' title='Delete User'><i class='fa fa-trash-o'></i><a>
                  </td>";
    $list .= "</tr>";
    $sn++;
    
    
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
            <table class="table table-responsive table-bordered table-striped">
					<thead>
					  <tr>
					  	<th>S#</th>
						<th>O_id</th>
						<th>From</th>
					    <th>To</th>
						<th>Order Details</th>
						<th>Delivery Charges</th>
						<th>comments</th>
						<th>Order Time</th>
						<th>Actions</th>
					  </tr>
					</thead>
					<tbody>
					  <?php echo $list; ?>
					</tbody>
			</table>			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>
