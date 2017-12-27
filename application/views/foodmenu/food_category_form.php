<div class="container">
	<div class="row">
		<center><h2>Food Categories</h2></center>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class=" col-md-offset-2 col-md-9   desc" id="order2"  style="padding-top:30px">
			<form method="post" action="<?php echo base_url();?>foodmenu/add_food_category">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2>Add Food Category</h2>

					</div>
					<div class="panel-body">
						<div class="row">
					       	<div class="col-md-6">
							<div class="form-group">
							   <label>Resturent</label>
							   <select name="resturent" id="resturent" class="form-control">
							   	<option value="">Select Resturent</option>
							   	<?php if($res){?>
							   	<?php foreach($res as $rest){?>
							   	<option value="<?php echo $rest->res_id;?>"><?php echo $rest->res_name;?></option>
							    <?php }?>
							    <?php }?>
							   </select>
							</div>
							<?php echo form_error('resturent');?>
						    </div>
							<div class="col-md-6">
								<div class="form-group">
								   <label>Food Type</label>
								   <select name="filter_food_category" id="filter_food_category" class="form-control">
								   	<option value="">Select Food</option>
								   	<!-- below code is just comment for the sake of getting only those categories of selected resturant. -->
								   	<!-- <?php if($food_category){?>
								   	<?php foreach($food_category as $category){?>
								   	<option value="<?php echo $category->fc_id;?>"><?php echo $category->fc_name;?></option>
								    <?php }?>
								    <?php }?> -->
								   </select>
								</div>
								<?php echo form_error('food_category');?>
							</div>
							
				    	</div><!-- row ends -->
				    	<hr>
				    	<h3 class="text-center">OR</h3>
				    	<div class="row">
			    			<div class="col-md-6">
			    				 
			    			<div class="form-group">
			    			   <label>Food Category Name</label>
			    			   <input type="text" name="food_category" id="food_category" class="form-control" placeholder="Food Category Name"/>
			    			</div>
			    			<?php echo form_error('food_category');?>
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

<div class="container">
	<div class="row">
		<div class="col-md-12">
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
										<th>Food Category Name</th>
										<th>Actions</th>
									  </tr>
									</thead>
									<tbody>
									 <?php 
			                           foreach ($food_category as $key => $value1):
			                           	$resid=$value1->fc_id;

			                           	?>
			                           	<tr>
			                           	   <td><?php echo $value1->fc_id; ?></td>
			                               <td><?php echo $value1->fc_name; ?></td>
			                               <td>
			                               <a href="<?php echo site_url('foodmenu/update_food_category/'.$resid);?>" class='ml10' title='Edit Food Category'><i class='fa fa-edit'></i><a>
			                                     <a onClick="return confirm('are you sure you want to delete it');" href='<?php echo site_url("foodmenu/delete_food_category/".$resid);?>' class='trash_btn ml10' title='Delete Food Category'><i class='fa fa-trash-o'></i><a>
			                               </td>
			                           	</tr>
			                          <?php endforeach;?>
									</tbody>
								  </table>

			                    
			                    
			                </table>
			            </div>
						
						
					</div>
					
				</div>
				</div>
				<!-- /MESSENGER -->
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$(document).on('change','#resturent',function(){	
	var id=$(this).val();
	var selected_rest = $("option[value='"+id+"']").text();
		$.ajax({
			url:"<?php echo base_url();?>foodmenu/get_categories_which_are_not_assigned_to_this_id",
			type:"POST",
			data:{"id":id, "selected_rest":selected_rest},
			dataType: 'json',
			success:function(result){
					console.log(result.length);
					$("#filter_food_category").html("<option value=''>Select Food category</option>");
				$.each(result, function(i, category){
	                $("#filter_food_category").append("<option value='"+ category.fc_id+"'>"+ category.fc_name +"</option>");
	            });
			},
			error:function(result){
				alert("error");
				console.log(result);
			}

		});
	});

	// this method is used to disable input for category
	$(document).on('change','#filter_food_category',function(){
		$('#food_category').val('');
		$('#food_category').prop('disabled', true);
		var id=$(this).val();
		var selected_rest = $("option[value='"+id+"']").text();
	});
});
</script>