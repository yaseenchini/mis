<div class="container-fluid" style="margin-top:120px;">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form method="post" action="<?php echo base_url();?>pricetime/update_pricetime">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Add Rider</h2>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<input type="hidden" name="time_price_id" value="<?php echo $edit_pricetime->time_price_id;?>"/>
						   <label>ColdDrink</label>
						   <input type="text" name="time" class="form-control" placeholder="Rider Name" value="<?php echo $edit_pricetime->time;?>"/>
						</div>
						<?php echo form_error('time','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Liter</label>
						   <input type="text" name="price" class="form-control" placeholder="Office No" value="<?php echo $edit_pricetime->price;?>"/>
						</div>
						<?php echo form_error('price','<div class="text-danger">','</div>');?>
						<input type="submit" class="btn btn-primary btn-block" value="Update"/>
				    </div>
				</div>
			</form>
		</div>
	</div>
</div>