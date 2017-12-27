<div class="container-fluid" style="margin-top:120px;">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form method="post" action="<?php echo base_url();?>riders/add_riders">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Add Rider</h2>
					</div>
					<div class="panel-body">
						<div class="form-group">
						   <label>Name</label>
						   <input type="text" name="rider_name" class="form-control" placeholder="Rider Name" value="<?php echo set_value('rider_name');?>"/>
						</div>
						<?php echo form_error('rider_name','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Office No</label>
						   <input type="text" name="office_no" class="form-control" placeholder="Office No" value="<?php echo set_value('office_no');?>"/>
						</div>
						<?php echo form_error('office_no','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Personal No</label>
						   <input type="text" name="personal_no" class="form-control" placeholder="Personal No" value="<?php echo set_value('personal_no');?>"/>
						</div>
						<?php echo form_error('personal_no','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Shift</label>
						   <input type="text" name="shift" class="form-control" placeholder="Shift" value="<?php echo set_value('shift');?>"/>
						</div>
						<?php echo form_error('shift','<div class="text-danger">','</div>');?>
						<input type="submit" class="btn btn-primary btn-block" value="Save"/>
				    </div>
				</div>
			</form>
		</div>
	</div>
</div>