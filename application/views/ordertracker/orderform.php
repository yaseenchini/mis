<style type="text/css">
 
input[type=text]{
	border-radius:10px;
   
}
input[type=time]{
	border-radius:10px;
   
}
#orderdetails{
	border-radius:10px;
   
}
.radio-inline{
	padding-left: 12px;
}
label{
	color:black;
}

.radiostyle:after {
    width: 18px;
    height: 18px;
    border-radius: 18px;
    top: -2px;
    left: -1px;
    position: relative;
    background-color:#DCDCDC;
    content: '';
    display: inline-block;
    visibility: visible;
    border: 2px solid white;
}

.radiostyle:checked:after {
    width: 15px;
    height: 15px;
    border-radius: 15px;
    top: -2px;
    left: -1px;
    position: relative;
    background-color:#00CED1;
    content: '';
    display: inline-block;
    visibility: visible;
    border: 2px solid white;
}
.orange{
  background-color: orange;
}

</style>
 <script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"> 
</script>



<script>

  setInterval(function(){
         $.ajax({
     url:'<?php echo base_url()?>order/food_order',
         method:'POST',
         data:{'addr_id': 'some data'},
         success:function(data){
           obj = JSON.parse(data);
          console.log(obj);
          var contents = '';
          $.each(obj, function(idx, obj) {
          contents += '<tr id="popup" style="cursor:pointer" value="'+obj.mo_id+'"><td>'+obj.mo_id+'</td><td>'+obj.mo_time+'</td><td>'+obj.mo_name+'</td><td>'+obj.mo_cellno+'</td><td>'+obj.mo_address+'</td><td>'+obj.resturent+'</td><td>'+obj.items+'</td><td><a class="btn btn-xs" value="" id="takeorder">take</a>&nbsp;<a class="btn btn-xs" id="discard">Discard</a><input type="hidden" name="general_id" id="general_id" value="'+obj.id+'"></td></tr>';
          });

          $( "#food_order" ).html(contents);
           

           // $( "#food_order" ).prepend('<tr id="popup" style="cursor:pointer" value="'+obj.mo_id+'"><td>'+obj.mo_id+'</td><td>'+obj.mo_time+'</td><td>'+obj.mo_name+'</td><td>'+obj.mo_cellno+'</td><td>'+obj.mo_address+'</td><td>'+obj.resturent+'</td><td>'+obj.items+'</td><td><a class="btn btn-xs" value="" id="takeorder">take</a>&nbsp;<a class="btn btn-xs" id="discard">Discard</a><input type="hidden" name="general_id" id="general_id" value="'+obj.id+'"></td></tr>');
         },
         error:function(){
           alert('error');
         }
         
  });
  },5000);
  $(document).ready(function(){
    $("#save").click(function(){
       var dataString = { 
              cellno : $("#cellno").val(),
              cust_name : $("#c_name").val(),
              comment : $("comment").val()
            };
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('order/response');?>",
            data: dataString,
            cache : false,
            success: function(data){
                var obj = JSON.parse(data);
                var socket = io.connect( 'http://'+window.location.hostname+':8080' );
                socket.emit('new_message', { 
                  email: "data.email",
                  subject: "data.subject"
                });
            } ,error: function(xhr, status, error) {
              alert(error);
            },

        });

      });

// this method is updating data real time in table...
    var socket = io.connect( 'http://'+window.location.hostname+':8080' );
    socket.on( 'food_order', function( data ) {
          console.log(data);
                $.ajax({
              url:'<?php echo base_url()?>order/food_order',
                  method:'POST',
                  data:{'addr_id': data},
                  success:function(data){
                    obj = JSON.parse(data);
                    $( "#food_order" ).prepend('<tr id="popup" style="cursor:pointer" value="'+obj.mo_id+'"><td>'+obj.mo_id+'</td><td>'+obj.mo_time+'</td><td>'+obj.mo_name+'</td><td>'+obj.mo_cellno+'</td><td>'+obj.mo_address+'</td><td>'+obj.resturent+'</td><td>'+obj.items+'</td><td><a class="btn btn-xs" value="" id="takeorder">take</a>&nbsp;<a class="btn btn-xs" id="discard">Discard</a><input type="hidden" name="general_id" id="general_id" value="'+obj.id+'"></td></tr>');
                    console.log(data);
                  },
                  error:function(){
                    alert('error');
                  }
                  
           });
          });



});
</script>
<!--start of food order-->
<div class="container">
	
		<div class="  col-md-12   desc" id="order2"  style="padding-top:15px;">
			<form method="post" id="order_form" action="<?php echo base_url();?>order/add_order">
				<div class="panel panel-primary" style="padding-bottom: 20px;">
					<div class="panel-heading">
						<h4 style="text-align:left;margin-left:10px;">Food Order</h4>
						<?php echo validation_errors();?>
					</div>
					<div class="panel-body" id="formbackg" style="background-color:white">
						<div class="row">
						    
						    <div class="col-md-12">
								<div class="form-group" style="background-color:#ccc;border:1px dotted red;">
								    <button type="button" id="getcallerno" class="btn btn-xs btn-info"><span class="fa fa-phone">call</span></button>
                                  <h3 id="callqueu" style="margin-left:10px">Calling:</h3>
                                   
						        </div>
						
					        </div>
              <!-- mobile order table starts here  -->
						  <div class="row"> 
                <div class="col-md-12">
                  <?php 
                      $mob_food_order;
                      $list;
                      $counter = 1;
                      
                      foreach ($this->data['mob_food_order'] as $key => $value) {
                        $id = $value->mo_id;
                        $items = null;
                        $resturent = null;
                        $data = $this->ordertracker_m->food_items($id);
                          if($data){
                                foreach ($data as $key => $value1) {
                                  $name = $value1->food_name;
                                  $f_quantity = $value1->f_quantity;
                                  $quantity = $value1->quantity;
                                  $price = $value1->price;
                                  $items .= $name."<b>:</b>".$f_quantity." (".$price.") [".$quantity."], ";
                                  $resturent = $value1->res_name;
                                }
                            }else{
                              $items = null;
                              $resturent = null;
                            }
                        $list.="<tr>
                              <td>".$counter."</td><td id='mo_time' value='$fromaddress'>".$value->mo_time."</td>";
                        $list.="<td id='mo_name' value=''>".$value->mo_name."</td>";
                        $list.="<td id='mo_cellno' value=''>".$value->mo_cellno."</td>";
                        $list.="<td id='mo_address' value='' >".$value->mo_address."</td><td>".$resturent."</td><td>".rtrim($items, ', ')."</td>
                                <td><a class='btn btn-xs' value='' id='takeorder'>take</a>&nbsp;<a class='btn btn-xs' id='discard'>Discard</a><input type='hidden' name='general_id' id='general_id' value='".$id."'></td>
                              </tr>";
                        $counter++;
                      }
                  ?>
                  <div class="box border blue">
                    <div class="box-title">
                      <h4><i class="fa fa-table"></i>Mobiles order</h4>
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
                      <table class="table table-responsive table-condensed table-bordered">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>date</th>
                          <th>Customer Name</th>
                          <th>Number</th>
                          <th>Address</th>
                          <th>Resturent</th>
                          <th>Food</th>
                          <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="food_order">
                          <?= $list; ?>
                        </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- mobile table ends -->
							<div class="col-md-4">
								<div class="form-group">
						   <label>Cell No <span style="color: red;">*</span></label>
						   <input type="text" name="cellno" id="cellno" class="form-control" placeholder="Cell no" required="required"/>
						</div>
						
					</div>
					    <div class="col-md-4">
						<div class="form-group">
						   <label>Customer Name <span style="color: red;">*</span></label>
						   <input type="text" name="c_name" id="c_name" class="form-control" placeholder="Customer Name" required="required"/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						   <label>Comment</label>
						   <input type="text" name="comment" id="comment" class="form-control" placeholder="Comments" />
						</div>

					</div>
				
				 
					</div>
				   <div class="row">
                    <ul><li id="address1_selection" style="display:none" class="btn btn-primary start"></li><input type="hidden" id="address1_selection_id" name="address1_selection" /></ul>
                   <div class="col-md-3" style="border: 1px solid #ccc;padding: 10px 5px;margin: 0px 9px 5px 10px !important; overflow:scroll; height:400px;"> 
                   	
     		         
				 	 <input type="text" name="addressname" class="form-control" style="width: 70%; display: inline-block;" id="new_address" placeholder="Add Address"/>
				 	 <input type="hidden" value="" id="checked_modules" name="checked_modules" /> 
                      <button type="button" class="btn btn-primary btn-xs" id="save_address"><i class="fa fa-save"></i></button>
                      <button type="button" class="btn btn-primary btn-xs" id="delete_address"><i class="fa fa-trash-o"></i></button>
              
				 	<br/>

                     
				     <div id="roles_tree">           
                   <!-- <ul>
                    <?php
                      /*  foreach ($address as $value){
                           echo "<li id=".$value->addr_id.">";
                           echo $value->title;
                           
                                echo "<ul>";
                                foreach($this->ordertracker_m->get_child_address($value->addr_id) as $child)
                                {
                                    echo "<li id=".$child->addr_id.">";
                                    echo $child->title;
                                      echo"<ul>";
                                      foreach($this->ordertracker_m->get_child_address($child->addr_id) as $child1)
                                      {
                                          echo "<li id=".$child1->addr_id.">";
                                          echo $child1->title;
                                            echo "<ul>";
                                            foreach($this->ordertracker_m->get_child_address($child1->addr_id) as $child2)
                                            {
                                                echo "<li id=".$child2->addr_id.">";
                                                echo $child2->title;
                                            }
                                            echo "</ul>";
                                            echo "</li>";
                                      }
                                      echo "</ul>";
                                      echo "</li>";
                                }
                            
                                echo "</ul>";
                                
                                echo "</li>";
                           
                        }
                      
                    */  ?>
                  
                  </ul>-->

              </div>
 <a id="ref">refresh</a>             
<script>

$(function() {
  $('#roles_tree').jstree({
    'core' : {
      'data' : {
        "url" : "<?php echo base_url()?>order/prepare_jstree_addresses",
        "dataType" : "json" // needed only if you do not supply JSON headers
      }
    }, 
    'checkbox': {
			three_state: false,
			cascade: 'none'
    },
    search : { show_only_matches : true, show_only_matches_children : true },
    "plugins": [ "themes", "html_data", "checkbox", "ui","search" ]
  }).on('search.jstree before_open.jstree', function (e, data) {
    if(data.instance.settings.search.show_only_matches) {
        data.instance._data.search.dom.find('.jstree-node')
            .show().filter('.jstree-last').filter(function() { return this.nextSibling; }).removeClass('jstree-last')
            .end().end().end().find(".jstree-children").each(function () { $(this).children(".jstree-node:visible").eq(-1).addClass("jstree-last"); });
    }
});
});




$('#roles_tree').on('changed.jstree', function (e, data) {
		
		if (!$("#multiselect").is(':checked') && data.selected.length > 1) {
			resetting = true; //ignore next changed event
			data.instance.uncheck_all(); //will invoke the changed event once
			data.instance.check_node(data.node/*currently selected node*/);
			return;
		}
	});

</script>

              </div>
              <div class="col-md-3" style="margin-top:20px">
              	<label>Custom Address</label>
              	 <input type="text" id="customeraddress" name="customaddress" class="form-control" placeholder="custom address"/>
                 <div id="mobile_order"></div>
              </div>

              <script>
                var max_in_child;
                 $("#order_form").submit(function(){
                          var max = $("#roles_tree").jstree().get_checked(true)[0].id;
                           $("#checked_modules").val(max);
                           
                            /*alert(ids);
                            return false;*/
                        });
              	$("#delete_address").on('click',function(){

              		
              		var max = $("#roles_tree").jstree().get_checked(true)[0].id;
                    var selected_name = $("#roles_tree").jstree().get_checked(true)[0].name;
                   if (confirm(selected_name)) {
                        $.ajax({
                  			url:'<?php echo base_url()?>order/delete_address',
                            method:'POST',
                            data:{'addr_id': max},
                           success:function(data){
                               alert("Deleted");
                               $('#roles_tree').jstree(true).refresh();
                           },
                           error:function(){
                           	alert('error');
                           }
                          
                  		});
                    }

              		$("#roles_tree").load();

              		

                   
                   
              	
              		
              	});                        
                        
                        
              	$("#save_address").on('click',function(){

              		
              		var max = $("#roles_tree").jstree().get_checked(true)[0].id;
                    
              		$("#checked_modules").val(max);
              		var addressname=$("#new_address").val();
              		$.ajax({
              			url:'<?php echo base_url()?>order/list_addresses',
                        method:'POST',
                        data:{'addressname': addressname,'max':max},
                       success:function(data){
                            var data_id = parseInt(data);
                            var generated_li_id = (data_id+1)
                      		var max_id = "#"+max;
                      		var next_id = "#"+(data_id+1);
                            
        
                      		var prepare_li = '<li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="'+(generated_li_id)+'_anchor" id="'+(generated_li_id)+'" class="jstree-node  jstree-leaf jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="'+(generated_li_id)+'_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>'+$("#new_address").val()+'</a></li>';
                      		
         
                      		$(max_id).append(prepare_li);   
                            $('#roles_tree').jstree(true).refresh();                   
                       },
                       error:function(){
                       	alert('error');
                       }


                      
              		});

              		for(var i=0;i<$("#roles_tree").jstree().get_checked(true).length;i++){
              			if($("#roles_tree").jstree().get_checked(true)[i].id>max){
              				max = $("#roles_tree").jstree().get_checked(true)[i].id;

              			}

              		}
              		$("#roles_tree").load();

              		

                   
                   
              	
              		
              	});

            $("#roles_tree").on('click', '.jstree-anchor', function (e) {
                var id = $("#roles_tree").jstree(true).get_node($(this)).id;
                //alert(id);
                var myKeyVals = { addr_id : id}
                $.ajax({
                      type: 'POST',
                      url: "<?php echo base_url();?>order/get_absolute_addr/", 
                      data: myKeyVals,
                      success: function(resultData) { 
                        
                        $('#address1_selection').show();
                        $('#address1_selection').text(resultData);
                        $('#address1_selection_id').val(id);
                        
                      
                       }
                })                
                
                $(this).jstree(true).toggle_node(e.target);
            });
                                //searchin in jstree-------
                                 var to = false;
                              $('#new_address').keyup(function () {
                                if(to) { clearTimeout(to); }
                                to = setTimeout(function () {
                                  var v = $('#new_address').val();
                                  $('#roles_tree').jstree(true).search(v);
                                }, 10);
                              });
                              //---------------------------------

                        $("#role_form").submit(function(){
                            var ids = $("#roles_tree").jstree().get_checked(false);
                            console.log(ids);
                            $("#checked_modules").val(ids);
                            /*alert(ids);
                            return false;*/
                        });
                    
                </script>
                    
                    <div class="col-md-4" id="addresssuggestion" style="margin-top:40px; margin-left:30px">
                      <div class="form-inline" id="addresssugg">
          
                      </div>
                      <br><br><br>
                      <div id="order_details"></div>
                    </div>
                    

                  </div>
				         
			
					<div class="row" id="resturent_tab">
						<div>
              <div class="col-md-3" >
  						  <label>Select Resturant</label>
  						    <select class="form-control chosen" style="width:200px" name="resturants[]" id="resturent" required="required">
  								<option>Select Resturent</option>
  								<?php foreach ($resturent1 as $values):?>
    									<option value="<?php echo $values['res_id'];?>">
                        <?php echo $values['res_name'];?>
                      </option>
  								  <?php endforeach;?>
  						   </select>
              </div>

					    <div class="col-md-offset-5 col-md-3">
                <table class="table table-striped" id="test_div">
                                 
                </table>
					    </div>
					</div>
					
				</div>
        <!-- this div will get all the data through ajax using getmenu() method in controller -->
        <div id="my_menuitem">
             
        </div>
        <br/>
                    
                    <!--<div class="row">
                      <div class="col-md-12" style="margin-top:20px;">
                          <div class="form-group">
                            <?php //if(!empty($colddrink)){?>
                            <?php //foreach($colddrink as $colddrinks){?>
                          <label><?php //echo $colddrinks->colddrink;?></label>
                          <input type="checkbox" name="cold[]" value="<?php //echo $colddrinks->colddrink_id;?>"/>
                          <?php //}?>
                          <?php //}?>
                        </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            //<?php //if(!empty($colddrink)){?>
                            //<?php //foreach($colddrink as $colddrinks){?>
                            <label class="radio-inline">
                            <input type="radio" name="liter" class="radiostyle" value="<?php //echo $colddrinks->liter;?>"/><?php //echo $colddrinks->liter."ltr";?>
                            </label>
                            <?php //}?>
                          <?php //}?>
                          </div>
                        </div> -->
                 
<!-- 
					         </div>
					<br/> -->

				  <div class="row">
				  	<div class="col-md-12">
				  		<div class="form-group">
				  			<label>Order Details</label>
                            <textarea class="form-control" name="orrderdetails" id="orderdetails"></textarea>
                    </div>
                   </div>
				  </div>

                <div class="row">
					<div class="col-md-3">
                        <label>Delivery Charges (Rs)</label>
						<div class="form-group">
						    <?php if(!empty($pricetime)){?>
						    <?php foreach($pricetime as $pricetimes){?>
						      <label class="radio-inline">

                                 <input type="radio"  name="price" class="radiostyle" value="<?php echo $pricetimes->price;?>"><?php echo $pricetimes->price;?>
                              </label>
                              <?php } ?>
                              <?php } ?>						
						</div>
					</div>		 
					<div class="col-md-3">
						<div class="form-group">
						<label for="customeprice">Custom charges</label>
                         <input  type="text" id="customeprice" name="customprice" style="width: 50px !important;" class="form-control input-small" placeholder="" />
                         </div>
					</div>

					<div class="col-md-3">
                        <label>Delivery Time (Minutes):</label>
						<div class="form-group">
						    <?php if(!empty($pricetime)){?>
						    <?php foreach($pricetime as $pricetimes){?>
							  <label class="radio-inline">
                   <input type="radio"  name="time" class="radiostyle" value="<?php echo $pricetimes->time;?>" /><?php echo $pricetimes->time;?>
                </label>
                <?php } ?>
                <?php } ?>
                             
						</div>
					</div>		 

					<div class="col-md-3">
						<div class=" clockpicker1" data-placement="left" data-align="top" data-autoclose="true">
							<label for="deliverytime">Custom Time</label>
                        <input type="integer" id="deliverytime" class="form-control" name="deliverytime" style="width: 50px !important;" />
                         
                       </div>
					</div>
					
				</div> 
				<br/>
				  <div class="row">
						<div class=" col-md-2 ">
                          <label>Already Placed</label>&nbsp;<input type="checkbox" value="" id="alreadyplaced" />
						</div>
                          <div class="col-md-3">
                              <label style="display:none" id="o_name_of"> Order on Name of </label>
                              <input type="text" name="alreadyname" id="alreadyname" class="form-control" style="display:none" />
                          </div>
						<div class="col-md-3" style="display:none" id="placedtime">
                        <label>Ready in </label>
							<div class="form-group">
                            
							  <label class="radio-inline">
                                 <input type="radio"  name="placetime" class="placetime" value="0" />0
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="placetime" class="placetime" value="10" />10
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="placetime" class="placetime" value="20" />20
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="placetime" class="placetime" value="30" />30
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="placetime" class="placetime" value="75" />75
                              </label>
						    </div>
						</div>
						<div class="col-md-3" style="display:none" id="placed_custom_time">
                       
							<div class="form-group">
                            
                                <input type="integer" class="form-control" name="deliverytime" style="width: 50px !important;" />
						    </div>
						</div>
                                   

					</div>
					<br/>
                        <button type="submit" name="save" id="save" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>

	</div>
</div>

<!-- Modal for MENU items-->
<!-- <div class="modal fade" role="dialog" id="menuitem">
	
</div> -->
<!--End of Modal-->


<script type="text/javascript">
                $(function() {
                    $(".chosen").chosen();
                });
                
                $(document).ready(function(){
                      // we call the function
                      
                      Api();
                    });
            function Api()
            {
             
        
                   
                    
                   $.ajax({
                            url: '<?php echo base_url();?>order/apicall',
                            type: "GET",
                            dataType:"JSON",
                            success: function(data){
                               // alert(data[0].caller_id);
                               var i=0;
                               for(i;i<data.length;i++){
                                $("#callqueu").after('<label class="callerno"  value='+data[i].caller_id+' style="margin-left:10px"><i class="fa fa-phone"></i>'+data[i].caller_id+'</label><input type="checkbox" value='+data[i].caller_id+' id="callerno" style="margin-right:10px">  ');
                               }
                                  
                                  
                            }
                        });
                     
                   
           }
           
           /* window.setInterval(function(){
             Api();
          }, 5000); */

   /*    function insertcallno(status)
       {
           $.ajax({
               url:"<?php //echo base_url();?>order/insertcallno",
               type:'POST',
               data:{"no":status},
               success:function(result){
                 var json=JSON.parse(result);
                 var callno=json['callno'];
                 alert(callno);
                 $("#cellno").val(callno);
               }
               
           });
       }*/

	    

         $(document).on('change','#callerno',function(){
             if(this.checked){
             var callerno=$(this).val();
             $("#cellno").val(callerno);
             }
             else{
                 $("#cellno").val('');
             }
         });
         $(document).on('click','.callerno',function(){
            $("#cellno").val($(this).text());
            $("#cellno").attr('color','red');
         });
         
         

         $("#getcallerno").on('click',function(){
             
             Api();
         });


        
		$("#order3").hide();

		$(".order").click(function(){
			if($(this).val()==2){
				$("#order2").show();
				 $("#order3").hide();
			}else{

				$("#order2").hide();
				$("#order3").show();
			}
			
		});


		//onchange function when resturant selected menu will be show ----------------------------

		$(document).on('change','#resturent',function(){
			
			var id=$(this).val();
      var selected_rest = $("option[value='"+id+"']").text();

			$.ajax({
				url:"<?php echo base_url();?>order/getmenu",
				type:"POST",
				data:{"id":id, "selected_rest":selected_rest},
				success:function(result){
				//	$("#menuitem").html(result).modal('show');
        console.log(result);
          $("#my_menuitem").html(result);

				},
				error:function(){
					alert("error");
				}

			});
			
});


    // my code delete the record and remove from page through jquery ajax
      $(document).on('click','#discard',function(){
        var id = $(this).siblings('input').val();
        console.log(id);
        var item = $(this).parent().parent();
        item.remove();
         $.ajax({
            url:'<?php echo base_url()?>order/delete_mob',
                method:'POST',
                data:{'id': id, 'tablename': 'mob_food_order'},
               success:function(data){
                  item.remove();
               },
               error:function(){
                alert('error with on click method id discard');
               }
        

          });
      });

        $(document).on('click','#takeorder',function(){
        var id = $(this).siblings('input').val();
        var itemclicked = $(this).parents('tr');

        var mo_name= itemclicked.children('td#mo_name').text();
        var mo_cellno= itemclicked.children('td#mo_cellno').text();
        var mo_address= itemclicked.children('td#mo_address').text();
        $("input#cellno").val(mo_cellno);
        $("input#c_name").val(mo_name);
        $("input#customeraddress").val(mo_address);
        itemclicked.addClass('orange');
        $("div#mobile_order").append('<input type="hidden" name="mobile_order" value="1" />');
        //$(this).parent().parent().remove();
      });

</script>

<script type="text/javascript">
//onblure function to get customer record if exitst---------------------------------------------
$("#cellno").blur(function(){
	var cellno=$(this).val();
	$.ajax({
		url:"<?php echo base_url();?>order/getcustomerrecord",
		type:"POST",
		data:{'cellno':cellno},
		success:function(data){
        var json = JSON.parse(data);
        console.log(json);
        if(json.length != 0 ){
            var title=json['title'];
            var order_id = json['o_id'];
            var customerId = json['customer_id'];
            var custname=json["cust_name"];
            var comment=json["comment"];
            var id=json["order_address_id"];
            orderInfo(order_id); //this method will retrieve order id...
              // getid(id);
    	       $("#c_name").val(custname); 
    	       $("#comment").val(comment);
        }
	       if(json.length==0){
	       	$("#addresssugg").append('<table><tr><td class="badge badge-success">No Avaliable Address</td><td><button type="button" class="btn btn-info btn-xs" id="deleteaddress">X</button></td></tr></table>');
	           
	       }
	       else
	       {
	           $("#addresssugg").append('<table ><tr><td><input type="checkbox" name="addressid"  value="'+id+'"/></td><td class="badge badge-info">'+ title +'</td><td><button type="button" class="btn btn-info btn-xs" id="deleteaddress">X</button></td></tr></table>');
	       }

		},
		error:function(error){
			alert(error);
		}

	});
          
});
 function orderInfo(cellno){
  if(cellno != null){
  $("#order_details").append('<table class="table table-condensed table-bordered table-responsive"><th>link</th><tr><td><a href="" id="order_details_link">click for order details</td></tr></table>');
  var link = "<?php base_url();?>/mis/order/process_order_details/"+cellno;
  $("#order_details_link").attr("href", link);
  }
}
//----------------------------------------------------------------------------------------------------------


//on double click create items -----------------------------------------------
 var id;
 $(document).on('click','#addtocart',function(){
	var itemclicked = $(this).parents('tr');
  var itemname= itemclicked.children('td#getitemname').text();
  var price1= itemclicked.children('td#price').text();
	id= itemclicked.children('#getitemvalue').val();
	var restid=$("#restid").val();
  // alert("item name:"+itemname+"<br />price1:"+price1+"<br />food id:"+id);
  var price1="price"+id;
  var price2="myprice"+id;
  var priceid="#price"+id;  
	var selecteditem="<tr id='remove' style='list-style-type:none'><td>"+  itemname  +"</td><td><input type='number' name='qty[]' min='1' id="+price2+" obi="+price1+" class='clearfields' value='1' style='margin:0px;width:50px'/></td><input type='hidden' id='food_id' name='itemid[]' value="+id+" class='clearfields' class='itemid'/><input type='hidden' name='itemname[]' value="+itemname+" class='clearfields' class='itemname'/><input type='hidden' name='resturentid[]' id='resturentid' class='clearfields' value="+restid+"><td><input type='text' name='price[]' id="+price1+" value='' class='sum' disabled style='width:40px'/>&nbsp;&nbsp;</td><td><button type='button' name='canel' id='canel' class='btn btn-danger btn-xs'>Remove</button></td></tr>";
	$("#appenditem").append(selecteditem);
  var price; 
		$.ajax
	    ({
        url:"<?php echo base_url();?>order/getprice",
        type:"POST",
        data:{"id":id, "restid": restid, "itemname":itemname.trim(), "price":price1},
        success:function(data)
        {     
        	var json = JSON.parse(data);
        	price= json['price'];
        	var price_prepare = "#price"+id;
          $(price_prepare).val(price);
          

        },
        

	});
     
      $('#myprice'+id).blur(function(){
        var qty=$(this).val();
        var food_id = $(this).parents("tr").find("#food_id").val();
        var obiprice=$(this).attr('obi');
         var itemprice=$("#"+obiprice).val();
         var subtotal=qty*price;
         $("#"+obiprice).val(subtotal);
         // alert(qty+"<br />"+obiprice+"<br />"+itemprice);
          var values= $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();
              var total=0;
              $(".sum").each(function(){
                total+=parseFloat($(this).val());
              });
             $("#total").val(total);
               
      // my code... this code will update the food record in cart...
          $.ajax
            ({
              url:"<?php echo base_url();?>order/cart_update",
              type:"POST",
              data:{"food_id":food_id, "qty":qty},
              success:function(data)
              {     
                
              },
              

        });


      });
    



});
 //-------------------------------------------------------------------------------


//remove selected item ---------------------------------
 $(document).on('click','#canel',function(){
       //$("#remove").remove();
    $(this).parent().parent().remove();
    var food_id = $(this).parents("tr").find("#food_id").val();

    $.ajax
          ({
            url:"<?php echo base_url();?>order/deletecartitem",
            type:"POST",
            data:{"itemid":food_id},
            success:function(data)
            {    
              

              // var json = JSON.parse(data);
              // price= json['price'];
              // var price_prepare = "#price"+id;
              // $(price_prepare).val(price);
              

            },
            

      });

 });
//------------------------------------------------------


//insertion of selected items in cart table with ajax------------------------------------

    // i commented this code becouse i commented save button whith id i-e saveitem & this code is trigering through that button next i will comment containing methods in this code in controller and models 
 // $(document).on('click','#saveitem',function(){
 //     var formdata = $("#item-form").serialize();
 //   $.ajax({
 //       url:"<?php //echo base_url();?>order/save_food_items",
 //       type:"POST",
 //       data:formdata,
 //       success:function(result){
 //           alert(result);
 //       	//$("#ordermodal").hide();
 //       		$('#resturent option[value=""]');
 //       		$("#test_div").load("<?php // echo base_url();?>order/saveitems");
      
 //       },
 //       error:function(error){
 //       	alert(error);
 //       }
 //   });

 // });
//end of insertion-------------------------------------------------------------------------



//delete suggested address---------------------------------------
  $(document).on('click','#deleteaddress',function(){
    $(this).parent().parent().parent().remove();
  });
//end of dletion----------------------------------------------------  


//if order already placed by customer then--------------------------------------------
  $("#alreadyplaced").change(function(){
       if(this.checked){
       	$("#placedtime").show();
       	var cname=$("#c_name").val();
        
       	$("#alreadyname").val(cname).show();
      	$("#o_name_of").show();
        $("#placed_custom_time").show();
       } 
       else{
       	$("#placedtime").hide();
       	$(".placetime").attr('checked',false);
       	$("#alreadyname").val('').hide();
      	$("#o_name_of").hide();
        $("#placed_custom_time").hide();
       	
       }
  });
  //end of ---------------------------------------------------------------------------------
  
  $(document).on('click','#deletecartitem',function(){
     // var value=$(this).parent().attr('value');
     value=$(this).attr('value');
     $.ajax({
         url:"<?php echo base_url();?>order/deletecartitem",
         type:"POST",
         data:{"itemid":value},
         success:function(result){
             $("#test_div").load("<?php echo base_url();?>order/saveitems");
         }
     });
      
     
  });
  
  $("#c_name").on('click',function()
  {
      var cellno=$("#cellno").val();
      if(cellno.length>0){
          	$.ajax({
		url:"<?php echo base_url();?>order/getcustomerrecord",
		type:"POST",
		data:{'cellno':cellno},
		success:function(data){
		
           var json = JSON.parse(data);
           var title=json['title'];
           
           
           var custname=json["cust_name"];
           var comment=json["comment"];
           var id=json["order_address_id"];
           getid(id);
	       $("#c_name").val(custname);
	       $("#comment").val(comment);
	       if(json.length==0){
	       	$("#addresssugg").append('<table><tr><td class="badge badge-success">No Avaliable Address</td><td><button type="button" class="btn btn-info btn-xs" id="deleteaddress">X</button></td></tr></table>');
	           
	       }
	       else
	       {
                $("#addresssugg").append('<table ><tr><td><input type="checkbox" name="addressid"  value="'+id+'"/></td><td class="badge badge-info">'+ title +'</td><td><button type="button" class="btn btn-info btn-xs" id="deleteaddress">X</button></td></tr></table>');
	       }

		},
		error:function(error){
			alert(error);
		}
          	});

      }
      else
      {
          alert("no");
      }
  });
/* function getid(id){
     $.ajax({
         url:"<?php echo base_url();?>order/getcompleteaddress",
         type:"POST",
         data:{"id":id},
         success:function(result)
         {
             alert(result);
         }
     });
 }*/
 
 

  $(document).on('keyup','#search',function(){
      var matches = $( 'ul#mymenu' ).find( 'li:contains('+ $( this ).val() +') ' );
        $( 'li', 'ul#mymenu' ).not( matches ).slideUp();
        matches.slideDown();  
  });
  

          

</script>









