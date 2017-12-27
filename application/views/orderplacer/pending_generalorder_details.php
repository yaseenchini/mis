<?php
//print_r($generalpendingorderdetail);exit;
//print_r($generalorder_basic_details);die;
$list = "";
foreach($basic_details as $bd){
	$orderid=$bd->o_id;
    $list .= "<tr>";
    $list .= "<td style='color:red'><label>Customer Name</label></td><td>".$bd->cust_name."</td>";
    $list .= "<td style='color:red'><label>Cell No</label></td><td>".$bd->cellno."</td>";
    $list .= "</tr>";
      continue;
}
$sn = 1;
$oder_items_data ="";
foreach($generalorder_basic_details as $pbd){
         $orderid=$pbd->o_id;
        $billingstatus= $pbd->billing;
        if($billingstatus==1){
            $billing="Pay Bill";
        }
        else
        {
            $billing="not Pay";
        }
        $fromstatus=$pbd->from;
        if($fromstatus==1)
        {
            $from="From";
        }
        else
        {
            $from="To";
        }
         $oder_items_data .= "<tr>";
         $oder_items_data .= "<td>".$sn."</td>";
         $oder_items_data .= "<td>".$this->ordertracker_m->getaddress($pbd->addr_id). "</td>";
         $oder_items_data .= "<td>".$from."</td>";
         $oder_items_data .= "<td>".$billing."</td>";
         $oder_items_data .= "</tr>";
 $sn++;
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
			
            <div class="table-responsive" id="printdiv">
                <table class="table table-striped">
                
						  <?php echo $list; ?>
						
					 
                    
                </table>
                <table class="table table-striped">
                           <tr>
						  		<th>S#</th>
						  		<th>Address Title</th>
						  		<th>From status</th>
						  		<th>Billing Status</th>
						  		
						  </tr>
                        <?php echo $oder_items_data;?>
					
                    
                </table>
            </div>
            <div class="row">
            	<div class="col-md-4 col-md-offset-4">
		<form method="post" action="<?php echo base_url();?>order/generalorder_process/<?php echo $orderid;?>">
			<div class="form-grou">
				<label>Order Placed</label>
				<input type="text" name="gcomment" class="form-control" placeholder="comment" value="<?php echo $bd->cust_name;?>"/><br>
				<label>ReadyTime</label>&nbsp;&nbsp;
				 <label class="radio-inline">
                                 <input type="radio"  name="greadytime" value="10">10
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="greadytime" value="20">20
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="greadytime" value="30">30
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="greadytime" value="50">50
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="greadytime" value="60">60
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