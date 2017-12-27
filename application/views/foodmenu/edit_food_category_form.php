<?php 
	$res_id = $this->uri->segment(4);
?>
<div class="container">
	<div class="row">
		<center><h2>Update Food Category</h2></center>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class=" col-md-offset-2 col-md-9   desc" id="order2"  style="padding-top:30px">
			<form method="post" action="<?php echo base_url();?>foodmenu/update_food_category">
				<input type="hidden" name="fm_id" value="<?php if(!empty($edit_food)){echo $edit_food->fc_id;};?>" />
				<input type="hidden" name="res_id" value="<?php echo $res_id;?>" />
				<input type="hidden" name="fc_name" value="<?php if(!empty($edit_food)){echo $edit_food->fc_name;};?>" />
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2>Update Food Category</h2>

					</div>
					<div class="panel-body">
						<div class="row">
						<div class="col-md-6">
							 
						<div class="form-group">
						   <label>Food Category Name</label>
						   <input type="text" name="food_category" class="form-control" value="<?php if(!empty($edit_food)){echo $edit_food->fc_name;};?>" placeholder="Food items"/>
						</div>
						<?php echo form_error('food_category');?>
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