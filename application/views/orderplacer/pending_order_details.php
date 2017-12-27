<?php

$list = "";

if(!empty($basic_details)){
foreach($basic_details as $obd){
	$orderid=$obd->o_id;
    $delivery_charges=$obd->delivery_charges;
    $list .= "<tr>";
    $list .= "<td style='color:red'><label>Customer Name</label></td><td>".$obd->cust_name."</td>";
    $list .= "<td style='color:red'><label>Cell No</label></td><td>".$obd->cellno."</td>";
    $list .= "</tr>";
    continue;
}
}
$this->load->model("ordertracker_m");
$order_address = $this->ordertracker_m->get_order_address($orderid);
if(!empty($food_details)){

$sn = 1;
$oder_items_data ="";
$order_food_items_total = 0;
foreach($food_details as $fd){
	$orderid=$fd->o_id;
    $oder_items_data .= "<tr>";
   // $list .= "<th><label>S#</label></th><td>".$sn."</td>";
    $oder_items_data .= "<td>".$sn."</td>";
    $oder_items_data .= "<td>".$fd->res_name."</td>";
    $oder_items_data .= "<td>".$fd->food_name."</td>";
    $oder_items_data .= "<td>".$fd->qty."</td>";
    $oder_items_data .= "<td>".$fd->desc."</td>";
    $oder_items_data .= "<td>".$fd->price."</td>";
    $oder_items_data .= "</tr>";
    $order_food_items_total += $fd->price*$fd->qty;
    $sn++;
}
}
if(!empty($cold_drinks)){

$sn = 1;
$oder_cd_data ="";
foreach($cold_drinks as $ocd){
    $oder_cd_data .= "<tr>";
   // $list .= "<th><label>S#</label></th><td>".$sn."</td>";
    $oder_cd_data .= "<td>".$sn."</td>";
    $oder_cd_data .= "<td>".$ocd->colddrink."</td>";
    $oder_cd_data .= "<td>".$ocd->liter."</td>";
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
                <a class="" id="print_order"><i class="fa fa-print"></i></a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>
		</div>
		<div class="box-body">
			
            <div class="table-responsive" id="printdiv">
                
                <table class="table table-striped">
                
						  <?php echo $list; ?>
						
					 

                    
                    
                </table>
                <table class="table table-striped">
                
                		  <tr>
						  		<th>S#</th>
						  		<th>Restaurant</th>
						  		<th>Food Item</th>
						  		<th>Qty</th>
						  		<th>Description</th>
						  		<th>Price</th>
						  </tr>
						  <?php echo $oder_items_data; ?>
						  
						  <tr><td colspan="5">Subtotal</td><td><?php echo $order_food_items_total;?></td><tr>
						  <tr><td colspan="5">Delivery Charges</td><td><?php echo $delivery_charges;?></td><tr>
						  <tr><td colspan="5">Total</td><td><?php echo $order_food_items_total+$delivery_charges;?></td><tr>
					 

                    
                    
                </table>
                <table class="table table-striped">
                
                		  <tr>
						  		<th>S#</th>
						  		<th>Cold Drink Name</th>
						  		<th>Size</th>
						  </tr>
						  <?php echo $oder_cd_data; ?>
						  
					 

                    
                    
                </table>
                <table class="table table-striped">
                
                		  <tr>
						  		<th>Order Address:</th>
						  		<th><?php echo $order_address;?></th>
						  </tr>	
                		  <tr>
						  		<th>Order Placed:</th>
						  		<th>________________</th>
						  </tr>						  
					 
                </table>                
                <label class="label label-success"> Order Details:</label>
                <textarea class="form-control">
                    <?php  echo $obd->order_details; ?>
                </textarea>
            </div>

            <div class="row">
            	<div class="col-md-4 col-md-offset-4">
		<form method="post" action="<?php echo base_url();?>order/order_process/<?php echo $orderid;?>">
			<div class="form-grou">
				<label>Order Placed on the Name of</label>
				<input type="text" name="comment" class="form-control" placeholder="" value="<?php echo $pendingorderdetails->cust_name;?>"/><br>
				<label>ReadyTime</label>&nbsp;&nbsp;
				 <label class="radio-inline">
                                 <input type="radio"  name="readytime" value="10" />10
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="readytime" value="20" />20
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="readytime" value="30" />30
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="readytime" value="50" />50
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="readytime" value="60" />60
                              </label>
				<input type="submit" name="submit" class="btn btn-primary" value="Process"style="margin-top:20px;"/>
			</div>
		</form>
	</div>
	</div>
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>

<script type="text/javascript">
$('#print_order').click(function(){
$('#printdiv').printThis();    
});

</script> 