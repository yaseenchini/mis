<?php

$list = "";
$sn = 1;
if(!empty($pendingorder)){
foreach($pendingorder as $pendingorders){
	if($pendingorders->status==1)
	{
		$pending="Pending";
	}
	$ordertype=$pendingorders->ordertype;

$start = date('Y-m-d h:i:s');
$end = $pendingorders->ordertime;
$diff=date_diff(date_create($start),date_create($end));
$time_elapsed =  (($diff->h)*60)+$diff->i;
    
    $list .= "<td>".$pendingorders->o_id."</td>";
    $list .= "<td>".$pendingorders->order_details."</td>";
    $list .= "<td>".$pendingorders->delivery_charges."</td>";
    $list .= "<td>".$pendingorders->deliverytime."</td>";
    $list .= "<td>".$time_elapsed."</td>";
    $list .= "<td class='text-success'>".$pending."</td>";
    if($ordertype==1){
    $list .= "<td class='text-center'>
                
                    <a href='".site_url("order/pending_order_details/".$pendingorders->o_id)."' class='btn btn-primary' title='Delete Role'><i class='fa fa-eye-slash'></i><a>
                
              
                  </td>";
    }
    else
    {
        $list .= "<td class='text-center'>
                
                    <a href='".site_url("order/pending_generalorder_details/".$pendingorders->o_id)."' class='btn btn-primary' title='Delete Role'><i class='fa fa-eye-slash'></i><a>
                
              
                  </td>";
    }
    $list .= "</tr>";
}
}




?>


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
                        <a class='btn btn-primary btn-sm' href='<?php echo site_url("roles/add_role"); ?>'><i class='fa fa-plus'></i> New</a>
                        <a class='btn btn-danger btn-sm' href='<?php echo site_url("roles/trashed_roles"); ?>'><i class='fa fa-trash-o'></i> Trash</a>
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
                
                    <table class="table table-bordered">
						<thead>
						  <tr>
							<th>S#</th>
							<th>order_details</th>
							<th>delivery_charges</th>
							<th>time</th>
							<th>Time Elapsed</th>
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