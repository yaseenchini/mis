<div class="container">
	<div class="row">
		<center><h2>Add Fooditems</h2></center>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class=" col-md-offset-2 col-md-9   desc" id="order2"  style="padding-top:30px">
			<form method="post" action="<?php echo base_url();?>foodmenu/add_food_items">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2>Add Fooditem</h2>

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
						   <select name="food_category" id="food_category" class="form-control">
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
$(document).on('change','#resturent',function(){	
var id=$(this).val();
var selected_rest = $("option[value='"+id+"']").text();
	$.ajax({
		url:"<?php echo base_url();?>foodmenu/get_categories_by_id",
		type:"POST",
		data:{"id":id, "selected_rest":selected_rest},
		dataType: 'json',
		success:function(result){
					$.each(result, function(i, category){
		               $("#food_category").append("<option value='"+category.fc_id+"'>"+ category.fc_name +"</option>");
		            });
		},
		error:function(){
			alert("error");
		}

	});
			
});
	      
	// });
</script>