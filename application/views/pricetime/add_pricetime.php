<div class="container-fluid" style="margin-top:120px;">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form method="post" action="<?php echo base_url();?>pricetime/add_pricetime">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Add Time Price</h2>
					</div>
					<div class="panel-body">
						<div class="form-group">
						   <label>Time</label>
						   <input type="text" name="time" class="form-control" placeholder="Time" value="<?php echo set_value('time');?>"/>
						</div>
						<?php echo form_error('time','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Price</label>
						   <input type="text" name="price" class="form-control" placeholder="Price" value="<?php echo set_value('price');?>"/>
						</div>
						<?php echo form_error('price','<div class="text-danger">','</div>');?>
						<input type="submit" class="btn btn-primary btn-block" value="Save"/>
				    </div>
				</div>
			</form>
		</div>
	</div>
</div>