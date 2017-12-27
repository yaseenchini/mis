<?php

$list = "";
//print_r($allfooditems);exit;
if(!empty($items))
{
foreach($items as $object){
    
    $list .= "<tr>";
    $list .= "<td>".$object->fm_id."</td>";
    $list .= "<td>".$object->food_name."</td>";
    $list .= "<td>".$object->price."</td>";
    $list .= "<td>".$object->quantity."</td>";
    $list .= "<td>".$object->desc."</td>";
    $list .= "<td class='text-center'>
    			<a href='".site_url("foodmenu/update_food_items/".$object->fm_id)."'
    			  class='ml10' title='Edit User'><i class='fa fa-edit'></i><a> 
                <a onclick='return confirm('Are You Sure To Delete This!')'; href='".site_url("foodmenu/delete_food_items/".$object->fm_id)."' class='trash_btn ml10' title='Delete User'><i class='fa fa-trash-o'></i></a>
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
				<li><?php echo $category_name; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
            <div class='row'>
                        
                <div class='col-md-9'>
                    <div class='clearfix'>
					  <h3 class='content-title pull-left'><?php echo $category_name; ?></h3>
					</div>
					<div class='description'>In this page you can see all the items of <b><?= $category_name; ?></b>. you are able to add more items, edit items and delete items. and by clicking on <b>add new item</b> button you can add new items to explore resturent and category.</div>
                </div>
                
                <div class='col-md-3'>
                    <div class='pull-right'>
                        <a class='btn btn-primary btn-sm add_food_item'><i class='fa fa-plus'></i>Add New item</a>
                    </div>
                </div>
                
            </div>
            
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->


<div class="container">
	<div class="row add_food_item-container" style="display: none;">
		<div class=" col-md-offset-2 col-md-9   desc" id="order2"  style="padding-top:30px">
			<form method="post" action="<?php echo base_url();?>foodmenu/add_food_items">

				<input type="hidden" name="resturent" value="<?php echo $res_id; ?>" >
				<input type="hidden" name="food_category" value="<?php echo $category_id; ?>" >
				<input type="hidden" name="category_name" value="<?php echo $category_name; ?>" >
				
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h5>Add New Food item</h5>

					</div>
					<div class="panel-body">
						<div class="row">
						<div class="col-md-6">
							 
						<div class="form-group">
						   <label>Food Name</label>
						   <input type="text" name="foodname" class="form-control" placeholder="Food items"/>
						</div>
						<?php echo form_error('foodname');?>
					    </div>
					    <div class="col-md-6">
					    	<div class="form-group">
					    	   <label>Weight</label>
					    	   <input type="text" name="weight" class="form-control" placeholder="kilo, sizes, amount etc."/>
					    	</div>
					    	<?php echo form_error('price');?>
					    </div>
				        </div>
				       <div class="row">
				       
					<div class="col-md-6">
						<div class="form-group">
						   <label>Price</label>
						   <input type="text" name="price" class="form-control" placeholder="PKR"/>
						</div>
						<?php echo form_error('price');?>
					</div>
					    <div class="col-md-6">
						<div class="form-group">
						   <label>Description</label>
						   <input type="text" name="desc" class="form-control" placeholder="Description"/>
						</div>
						<?php echo form_error('desc');?>
					   </div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-offset-3 col-md-6 col-md-offset-3">
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-primary btn-block" value="submit"/>
							</div>
						</div>
					</div>
				</div>

				</div>
			</form>
		</div>
	</div>
</div>

<script>
	// $(document).ready(function(){
	// 	$(".add_food_item-container").hide();
	// });
	$(document).on('click','.add_food_item',function(){
		$(".add_food_item-container").slideToggle("slow");
	});
</script>













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
							<th>Food Name</th>
							<th>Price</th>
							<th>Weight</th>
							<th>Description</th>
							<th class="text-center">Action</th>
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
