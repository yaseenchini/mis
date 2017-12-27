
<?php 
	// this code contain only order table data
	if(!empty($order)){

		$o_id 				 = $order[0]->o_id;
		$order_details 		 = $order[0]->order_details;
		$delivery_charges 	 = $order[0]->delivery_charges;
		$deliverytime 		 = $order[0]->deliverytime;
		$customer_id 		 = $order[0]->customer_id;
		$status;				//status has already value from controller
		$comment			 = $order[0]->comment;
		$ordertime 			 = $order[0]->ordertime;
		$placedtime 		 = $order[0]->placedtime;
		$orderreadytime 	 = $order[0]->orderreadytime;
		$orderpickingtime 	 = $order[0]->orderpickingtime;
		$reason				 = $order[0]->reason;
		$rider;					//rider has already value from controller
		$rider_acknowleg	 = $order[0]->rider_acknowleg;
		$riderpicking_time	 = $order[0]->riderpicking_time;
		$rider_acktime		 = $order[0]->rider_acktime;
		$rider_droptime		 = $order[0]->rider_droptime;
		$ordertype			 = $order[0]->ordertype;
		$cellno				 = $order[0]->cellno;
		$cust_name			 = strtoupper($order[0]->cust_name);

	}

	if(!empty($rider)){
		$rider_name = $rider[0]->name;
		$rider_office_no = $rider[0]->office_no;
	}

	// below code is for addressess & need loop later handle it...
	if(!empty($addresses)){
		$reciever_name = $addresses[0]->nameopt;
		$reciever_number = $addresses[0]->number;
		$reciever_custom_addr = $addresses[0]->custom_addr;
		$reciever_comment = $addresses[0]->commentopt;
		$reciever_from = $addresses[0]->from;
		$reciever_billing = $addresses[0]->billing;
		$reciever_to = $addresses[0]->to;
	}


	// below code is for food_items_list items showing purpose...

	if(!empty($food_items_list)){
		$oder_items_data = "";
		$sn = 1;
		$zipped = array_map(null, $food, $food_items_list);

		foreach($zipped as $tuple) {
		    // here you could do list($n, $t) = $tuple; to get pretty variable names
		   // print_r($tuple[0]->qty); // food
		   // echo "<br />";
		   // print_r($tuple[1]); // food_items_list
		   $oder_items_data .= "<tr>";
		   $oder_items_data .= "<td>".$sn."</td>";
		   $oder_items_data .= "<td>".$tuple[1]->food_name."</td>";
		   $oder_items_data .= "<td>".$tuple[1]->desc."</td>";
		   $oder_items_data .= "<td>".$tuple[1]->res_name."</td>";
		   $oder_items_data .= "<td>".$tuple[0]->qty."</td>";
		   $oder_items_data .= "<td>".$tuple[1]->price."</td>";
		   $oder_items_data .= "<td>".$tuple[1]->price*$tuple[0]->qty."</td>";
		   $oder_items_data .= "</tr>";
		   $total += $tuple[1]->price*$tuple[0]->qty;
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
                
               
                
            </div>
            
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->


<!-- PAGE MAIN CONTENT -->
<div class="row">
	<div class="col-md-12">
		<!-- BOX -->
		<div class="box border blue">
			<div class="box-title">
				<h4><i class="fa fa-list-ul"></i>Order Details</h4>
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


			<div class="row">
				<div class="col-sm-4 payment-info">
				  <div class="invoice-title text-muted">order Details</div>
				  <div class="well">
				  	  <strong>Order details </strong> <?= $order_details; ?><br>
					  <strong>Delivery charges: </strong> <?= $delivery_charges; ?>
					  <br>
					  <strong>Delivery time: </strong> <?= $deliverytime ?>mins
					  <br>
					  <strong>Order date: </strong><?= $ordertime?>
					  <br>
					  <strong>Order ready time: </strong><?= $orderreadytime; ?><br>
					  <strong>Order placed time:</strong><?= $placedtime; ?><br />
					  <strong>Order picking time:</strong> <?= $orderpickingtime; ?>

				  </div>
				</div>
				<div class="col-sm-4 buyer">
				  <div class="invoice-title">Caller Info</div>
				  <i class="fa fa-male"></i>
				  <address>
					<strong><?php echo $cust_name; ?></strong>
					<br>
					<small><?= $comment; ?></small>
					<br>
					<?php echo $address; ?>
					
					<i style="margin-left:-35px;" class="fa fa-phone"></i>
					<small><?= $cellno; ?></small>
				  </address>
				</div>
				<div class="col-sm-4 payment-info">
				  <div class="invoice-title text-muted">Rider detail</div>
				  <div class="well">
				  	  <strong>Rider </strong> <?= $rider_name; ?><br>
				  	  <strong>Cellno# </strong> <?= $rider_office_no; ?><br>
					  <strong>Rider acknowledge: </strong> <?= $rider_acknowleg; ?>
					  <br>
					  <strong>Pick time: </strong> <?= $riderpicking_time ?>
					  <br>
					  <strong>Rider ack time: </strong><?= $rider_acktime ?>
					  <br>
					  <strong>Order placed time:</strong><?= $placedtime; ?><br />
					  <strong>Order picking time:</strong> <?= $orderpickingtime; ?>
					  <br>
					  <strong>Drop time: </strong><?= $rider_droptime; ?><br>
					
				  </div>
				</div>
			  </div>



















				<!-- ORDERS -->
				<div class="row">
					<!-- ORDER DETAILS -->
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-body">
							
							<!-- TABLE -->
					<?php if($ordertype ==1){
					   echo'<table class="table table-hover table-responsive table-bordered">
							  <thead>
								<tr>
								  <th class="only-checkbox">
									#
								  </th>
								  <th>Item</th>
								  <th>Description</th>
								  <th>
									<div>From</div>
								  </th>
								  <th>
									<div>Quantity</div>
								  </th>
								  <th>
									<div>Price</div>
								  </th>
								  <th>
									<div>Sub total</div>
								  </th>
								</tr>
							  </thead>
							  <tbody>
								<tr>'; }?> 

								<?php echo $oder_items_data; ?>
								  <!-- <td class="only-checkbox">
									<input type="checkbox">
								  </td>
								  <td>Ray Ban</td>
								  <td>
									<div class="text-center">3</div>
								  </td>
								  <td>
									<div class="text-right">$224.00</div>
								  </td> -->
						<?php if($ordertype ==1){
							echo '</tr>
							  </tbody>
							</table>'; }?>
							<!-- /TABLE -->
							<div class="text-right">
								<h3><?php if($ordertype==1){ echo "Total Rs.". $total."/-";} ?></h3>
							</div>
							<hr>
							<!-- CUSTOMER DETAILS -->
							<div class="row">
								<div class="col-sm-4">
									<h4>
										<?php if($ordertype==2){
										 echo'
										<i class="fa fa-dollar"></i>
										Payment | Billing';
										} ?>
									</h4>
									<h5><strong><?php if($ordertype==2){
										 echo'<span class="label label-success"><i class="fa fa-check"></i>';}?> <?php if($ordertype==2 && $reciever_billing==1){
										$reciever_billing = 'Yes';
									 echo $reciever_billing;} ?><?php if($ordertype==2){
										 echo'</span>';}?></strong></h5><br>
									<h4>
										<?php if($ordertype==2){
										 echo'<i class="fa fa-map-marker"></i>';}?>
										<?php if($reciever_from==1){
										$reciever_from_label = 'From';
									 echo $reciever_from_label;} ?>
									 <?php if($reciever_to==1){
										$reciever_to_label = 'To';
									 echo $reciever_to_label;}?>
									</h4>
									<h5><strong><?php if($ordertype==2){
										 echo'<span class="label label-primary"><i class="fa fa-check"></i>';}?> <?php if($ordertype==2 && $reciever_from==1){
										$reciever_from = 'Yes';
									 echo $reciever_from;} ?>
										<?php if($ordertype==2 && $reciever_to==1){
										$reciever_to = 'Yes';
									 echo $reciever_to;} ?>
									 <?php if($ordertype==2){
										 echo'</span>';}?></strong></h5><br>
								</div>
								<div class="col-sm-7 col-sm-offset-1">
									<h4>
										<?php if($ordertype==2){
										 echo'<i class="fa fa-envelope"></i>
										Shipping address';}?>
									</h4>
									<div class="well">	
										<h4><strong><?php if($ordertype==2){ echo $reciever_name;} ?></strong></h4>
										<?php if($ordertype==2){
										 echo'<i class="fa fa-phone">';}?> <?php if($ordertype==2){ echo $reciever_number; } ?><?php if($ordertype==2){
										 echo'</i>';}?><br>
										 <?php if($ordertype==2){ echo $to_or_from."<br />";} ?>
										<?php if($ordertype==2){ echo $reciever_comment;} ?><br>
									</div>
								</div>
							</div>
							<!-- PAYMENT STATUS -->
<!-- 							<hr> -->
						  </div>
						  <!-- /PANEL BODY --> 
						  
						</div>
					</div>
					<!-- /ORDER DETAILS -->
				</div>
				<!-- ORDERS -->
			</div>
		</div>
		<!-- /BOX -->
	</div>
</div>