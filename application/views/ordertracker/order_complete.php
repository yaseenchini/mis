<?php
//print_r($obaid);exit;
$list = "";
$sn = 1;
if(!empty($completeorder)){
foreach($completeorder as $needle=>$haystack){
	    $order_id=$haystack['o_id'];

     //-----------------------------------------------------------------------//
    
    // -------------------------------------------------------------------------//
      $restid=$resturentid=$this->ordertracker_m->ger_order_resturentid($haystack['o_id']);

    $list .="<tr>"; 
    $list .= "<td>".$sn."</td>";
    $list .= "<td>".$haystack['o_id']."</td>";
    $list .= "<td>".$this->ordertracker_m->get_resturent_name($restid)."</td>";
    $list .= "<td>".$this->ordertracker_m->get_order_address($haystack['o_id'])."</td>";
    $list .= "<td>".$haystack['order_details']."</td>";
    $list .= "<td>".$haystack['delivery_charges']."</td>";
    $list .= "<td>".$haystack['deliverytime']."</td>";
    
   
    $list .= "<td class='text-success'>".$this->ordertracker_m->get_order_status($haystack['status'])."</td>";

    $list .= "<td >".$haystack['ordertime']."</td>";
    $list .= "<td >".$haystack['placedtime']."</td>";
    $list .= "<td>".$haystack['orderreadytime']."</td>";
    $list .= "<td>".$haystack['orderpickingtime']."</td>";
     $list .= "<td>".$haystack['rider']."</td>";
      $list .= "<td>".$haystack['rider_acknowleg']."</td>";
      $list .= "<td>".$haystack['riderpicking_time']."</td>";
    $list .= "<td >
                    <a href='".site_url("order/process_order_details/".$haystack['o_id'])."' class='btn btn-primary' title='Delete Role'><i class='fa fa-eye-slash'></i><a>
                  </td>";
    $list .= "</tr>";
    $sn++;

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
	        <table class="table table-responsive table-condensed table-striped table-bordered">
				<thead>
				  <tr>
					<th>S#</th>
					<th>Order ID</th>
					<th>From</th>
					<th>To</th>
					<th>order_details</th>
					<th>delivery_charges</th>
					<th>Delivery Time</th>
					<th>Status</th>
					<th>order time</th>
					<th>Placed Time</th>
					<th>Orderready Time</th>
					<th>order picktime</th>
					<th>Rider</th>
					<th>Rider Ack</th>
					<th>Rider Picktime</th>
					<th>&nbsp;</th>
				  </tr>
				</thead>
				<tbody>
				  <?php echo $list; ?>
				</tbody>
			</table>	
		</div> <!-- box-body ends... -->
	</div>
	</div>
	<!-- /MESSENGER -->
</div>