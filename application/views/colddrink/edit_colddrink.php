<div class="container-fluid" style="margin-top:120px;">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form method="post" action="<?php echo base_url();?>colddrink/update_colddrink">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Add Rider</h2>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<input type="hidden" name="colddrink_id" value="<?php echo $edit_colddrink->colddrink_id;?>"/>
						   <label>ColdDrink</label>
						   <input type="text" name="colddrink" class="form-control" placeholder="Rider Name" value="<?php echo $edit_colddrink->colddrink;?>"/>
						</div>
						<?php echo form_error('colddrink','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Liter</label>
						   <input type="text" name="liter" class="form-control" placeholder="Office No" value="<?php echo $edit_colddrink->liter;?>"/>
						</div>
						<?php echo form_error('liter','<div class="text-danger">','</div>');?>
						<input type="submit" class="btn btn-primary btn-block" value="Update"/>
				    </div>
				</div>
			</form>
		</div>
	</div>
</div>