
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<!-- STYLER -->
			
			<!-- /STYLER -->
			<!-- BREADCRUMBS -->
			<ul class="breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>">Home</a>
				</li>
				<li><?php echo $title; ?></li>
			</ul>
			<!-- /BREADCRUMBS -->
            <div class='row'>
                        
                <div class='col-md-6'>
                    <div class='clearfix'>
					  <h3 class='content-title pull-left'><?php echo $title; ?></h3>
					</div>
					<div class='description'><?php echo $title; ?></div>
                </div>
                
                <div class='col-md-6'>
                    <div class='pull-right'>
                        <a class='btn btn-primary btn-sm Add_new_restaurant'><i class='fa fa-plus'></i> New Resturent</a>
                    </div>
                </div>
                
            </div>
            
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->

<div class="row restaurant_form-container">
		<!-- MESSENGER -->
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
            
            <?php echo validation_errors(); ?>
            
            <form class="form-horizontal" role="form" id="role_form" method="post" enctype="multipart/form-data" action="<?php echo site_url("restaurant/add_restaurant"); ?>">
			  
              <div class="form-group">
				<label for="user_title" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_title" name="res_name" placeholder="Resturant Title/Full Name" />
				</div>
			  </div>
              
              <div class="form-group">
				<label for="res_desc" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="res_desc" name="res_desc" placeholder="Resturant Description" />
				</div>
			  </div>
              
              <div class="form-group">
				<label for="user_email" class="col-sm-2 control-label">Location</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_email" name="res_location" placeholder="Address" />
				</div>
			  </div>
              
              
              <div class="form-group">
				<label for="user_password" class="col-sm-2 control-label">Contact No</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="user_password" name="res_contactno" placeholder="Conact No" />
				</div>
			  </div>

			  <div class="form-group">
			    	<label for="seq" class="col-sm-2 control-label">Sequence</label>
			    	<div class="col-sm-10">
			    	  <input type="text" class="form-control" id="seq" name="res_seqeunce" value="<?php echo $max1+1; ?>" placeholder="Sequence" />
			    	</div>
			  </div>
              
              <div class="form-group">
				 <label class="col-md-2 control-label">File Upload</label> 
				 <div class="col-md-10">
					<input type="file" class="form-control" id="res_image" name="res_image" />
					<!-- <div class="fileupload fileupload-new">
					<div class="input-group">
						<div class="input-group-btn">
							<a class="btn btn-default btn-file">
								<input type="file" name="res_image" class="file-input">
							</a>
						</div>
					</div>
					</div> -->
				 </div>
			  </div>

			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-primary">Save</button>
				</div>
			  </div>
			</form>



			
			
		</div>
		
	</div>
	</div>
	<!-- /MESSENGER -->
</div>

<script>
	$(document).ready(function(){
		$(".restaurant_form-container").hide();
	});
	$(document).on('click','.Add_new_restaurant',function(){
		$(".restaurant_form-container").slideToggle("slow");
	});
	
</script>


<!-- PAGE MAIN CONTENT -->
<div class="row">
		<!-- MESSENGER -->
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
							<th>Seqeunce</th>
							<th>Resturant Name</th>
							<th>Resturant Description</th>
							<th>Resturant Location</th>
							<th>Contact No</th>
							<th>image</th>
							<th>Visibilty</th>
							<th>Actions</th>
						  </tr>
						</thead>
						<tbody>
						 <?php 
                           foreach ($record as $value):
                           	$resid=$value['res_id'];
                           	$res_name=$value['res_name'];

                           	?>
                           	<tr>
                               <td><?php echo $value['res_seqeunce'];?></td>
                               <td><?php echo $value['res_name'];?></td>
                               <td><?php echo $value['res_desc'];?></td>
                               <td><?php echo $value['res_location'];?></td>
                               <td><?php echo $value['res_contactno'];?></td>
                               <td><?php echo $value['res_image'];?></td>
                               <td><?php $vis = ($value['res_visibility'] == 1)? 'Hidden' : 'Visibile' ?><a class="any" data-id="<?php echo $value['res_id']; ?>"><?php echo $vis; ?></a></td>
                               <td>
                               <a href="<?php echo site_url('restaurant/explore/'.$resid.'/'.$res_name);?>" class='ml10' title='view restaurant'><i class='fa fa-eye'></i><a>

                               <a href="<?php echo site_url('restaurant/edit_restaurant/'.$resid);?>" class='ml10' title='Edit User'><i class='fa fa-edit'></i><a>
                                     <a onClick="return confirm('are you sure you want to delete it');" href='<?php echo site_url("restaurant/delete_restaurant/".$resid);?>' class='trash_btn ml10' title='Delete User'><i class='fa fa-trash-o'></i><a>
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


<script>
	
	$("a.any").click(function() {
	        // Assign the value of the data attribute
	        var id =   $(this).data('id');
	        var text = $(this).parent().text();
	        
	        $.ajax({
				url:"<?php echo base_url();?>restaurant/toggle_visiblity",
				type:"POST",
				data:{"id":id, "text":text},
				success:function(result){
				//	$("#menuitem").html(result).modal('show');
		        location.reload();
				},
				error:function(){
					alert("error");
				}

			});

	});

</script>