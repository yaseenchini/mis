<div class="container-fluid" style="margin-top:120px;">
	<div class="row">
		<div class="col-md-4 col">
			<form method="post" action="<?php echo base_url();?>addresses/add_address">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Add Main Address</h2>
					</div>
					<div class="panel-body">
						<div class="form-group">
						   <label>Address</label>
						   <input type="text" name="address" class="form-control" placeholder="Address" value="<?php echo set_value('address');?>"/>
						</div>
						<?php echo form_error('address','<div class="text-danger">','</div>');?>
						<input type="submit" class="btn btn-primary btn-block" value="Save"/>
				    </div>
				</div>
			</form>
		</div>



		<div class="col-md-4 col-md-offset-2">
			<form method="post" action="<?php echo base_url();?>addresses/add_sub_address">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Add Sub Address</h2>
					</div>
					<div class="panel-body">					
                    	<?php echo form_error('sub_address','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Main Address Category</label>
						  <select name="a_id" class="form-control">
						  	<option value="-1">Please Category From The Following</option>
						  	<?php if(!empty($address)){?>
						  	<?php foreach($address as $addresss){?>
						  	<option value="<?php echo $addresss->addr_id;?>"><?php echo $addresss->title; ?></option>
						    <?php }?>
						    <?php }?>
						  </select>
						</div>
						<div class="form-group">
						   <label>Sub Address</label>
						   <input type="text" name="sub_address" class="form-control" placeholder="Address" value="<?php echo set_value('address');?>"/>
						</div>

						<?php echo form_error('address','<div class="text-danger">','</div>');?>
						<input type="submit" class="btn btn-primary btn-block" value="Save"/>
				    </div>
				</div>
			</form>
		</div>
	</div>
</div>