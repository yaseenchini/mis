

<div class="container-fluid" style="margin-top:120px;">
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<form method="post" action="<?php echo base_url();?>addresses/update_address">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="text-center">Edit Address</h2>
					</div>
					<div class="panel-body">
						<div class="form-group">
						   <label>Sub Address</label>
						   <input type="hidden" name="s_addr_id" value="<?php echo $edit_address->s_addr_id;?>" />
						   <input type="text" name="sub_address" value="<?php if(!empty($edit_address))	echo $edit_address->s_addr_title;?>" class="form-control" placeholder="Enter Sub address"/>
						</div>
						<?php echo form_error('sub_address','<div class="text-danger">','</div>');?>
						<div class="form-group">
						   <label>Address</label>
						  <select name="a_id" class="form-control">
						  	<option value="-1">Please Category From The Following</option>
						  	<?php if(!empty($address)){?>
						  	<?php foreach($address as $addresss){?>
						  	<option value="<?php echo $addresss->addr_id;?>"<?php if($addresss->title==$edit_address->title) echo 'selected="selected"';?>><?php echo $addresss->title;?></option>
						    <?php }?>
						    <?php }?>
						  </select>
						</div>
						<?php echo form_error('address','<div class="text-danger">','</div>');?>
						<input type="submit" name="submit" class="btn btn-primary btn-block" value="Update"/>
				    </div>
				</div>
			</form>
		</div>
	</div>
</div>