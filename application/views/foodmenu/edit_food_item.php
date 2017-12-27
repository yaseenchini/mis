<div class="container">
	<div class="row">
		<center><h2>Update Food Items</h2></center>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class=" col-md-offset-2 col-md-9   desc" id="order2"  style="padding-top:30px">
			<form method="post" action="<?php echo base_url();?>foodmenu/update_food_items">
				<input type="hidden" name="fm_id" value="<?php if(!empty($edit_food)){echo $edit_food->fm_id;};?>" />
				<input type="hidden" name="resturent" value="<?php if(!empty($edit_food)){echo $edit_food->res_id;};?>" />
				<input type="hidden" name="food_category" value="<?php if(!empty($edit_food)){echo $edit_food->food_type;};?>" />
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2>Update Food item</h2>

					</div>
					<div class="panel-body">
						<div class="row">
						<div class="col-md-6">
							 
						<div class="form-group">
						   <label>Food Name</label>
						   <input type="text" name="foodname" class="form-control" value="<?php if(!empty($edit_food)){echo $edit_food->food_name;};?>"placeholder="Food items"/>
						</div>
						<?php echo form_error('foodname');?>
					    </div>

					    <div class="col-md-6">
					    	<div class="form-group">
					    	   <label>Weight</label>
					    	   <input type="text" name="weight" class="form-control" value="<?php if(!empty($edit_food)) echo $edit_food->quantity; ?>" placeholder="kilo, sizes, amount etc."/>
					    	</div>
					    	<?php echo form_error('price');?>
					    </div>
					    
				        </div>
				       <div class="row">
				        <div class="col-md-6">
				       	<div class="form-group">
				       	   <label>Price</label>
				       	   <input type="text" name="price" class="form-control" value="<?php if(!empty($edit_food)) echo $edit_food->price;?>"placeholder="PKR"/>
				       	</div>
				       	<?php echo form_error('price');?>
				       </div>

				        <div class="col-md-6">
					       	<div class="form-group">
					       	   <label>Description</label>
					       	   <input type="text" name="desc" class="form-control" value="<?php if(!empty($edit_food)){echo $edit_food->desc;};?>"placeholder="Description"/>
					       	</div>
					       	<?php echo form_error('desc');?>
				        </div>
				</div>

				<div class="panel-footer">
					<div class="row">
						<div class="col-md-offset-3 col-md-6 col-md-offset-3">
							<div class="form-group">
								<input type="submit" name="submit" class="btn btn-primary btn-block" value="Update"/>
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
$(document).ready(function(){
	var resturent_id = $("#resturent").val();
	var resturent_name = $("option[value='"+resturent_id+"']").text();
	if(resturent_id>0){
		$.ajax({
			url:"<?php echo base_url();?>foodmenu/get_categories_by_id",
			type:"POST",
			data:{"id": resturent_id, "selected_rest":resturent_name},
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
	}
	
	$(document).on('change','#resturent',function(){	
	var id=$(this).val();
	var selected_rest = $("option[value='"+id+"']").text();
		$.ajax({
			url:"<?php echo base_url();?>foodmenu/get_categories_by_id",
			type:"POST",
			data:{"id":id, "selected_rest":selected_rest},
			dataType: 'json',
			success:function(result){
					$("#food_category").html("<option value=''>Select Food category</option>");
				$.each(result, function(i, category){
	                $("#food_category").append("<option value='"+ category.fc_id+"'>"+ category.fc_name +"</option>");
	            });
			},
			error:function(){
				alert("error");
			}

		});
				
	});
});
</script>