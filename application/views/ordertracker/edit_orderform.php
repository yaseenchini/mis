<?php

/*
echo"<pre>";
print_r($editorderformrecord);exit;*/
foreach($editorderformrecord as $value)
{
    $orderid=$value['o_id'];
    $cellno=$value['cellno'];
    $custname=$value['cust_name'];
    $comment=$value['comment'];
    $customaddress=$value['custom_addr'];
    $order_address_id=$value['order_address_id'];
    $orderdetails=$value['order_details'];   
    $deliverycharges=$value['delivery_charges'];
    $deliverytime=$value['deliverytime'];
    $orderreadytime=$value['orderreadytime'];
    $customer_id=$value['customer_id'];
   
 
   
   
   
}

foreach($editcolddrink as $value1)
{
     
}

?>

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



</style>
 

<!--start of food order-->
<div class="container">
	
		<div class="  col-md-12   desc" id="order2"  style="padding-top:30px">
			<form method="post" id="order_form" action="<?php echo base_url();?>order/edit_order/<?php echo $orderid;?>">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 style="text-align:left;margin-left:10px;">Food Order</h4>
						<?php echo validation_errors();?>
					</div>
					<div class="panel-body" id="formbackg" style="background-color:white">
						<div class="row">
						  
						    
							<div class="col-md-4">
								<div class="form-group">
						   <label>Cell No</label>
						   <input type="text" name="cellno" id="cellno" class="form-control" placeholder="Cell no" value="<?php if(!empty($cellno)) echo $cellno;  ?>"/>
						   <input type="hidden" name="orderid" value="<?php if(!empty($orderid)) echo $orderid;?>"/>
						   <input type="hidden" name="customerid" value="<?php if(!empty($customer_id)) echo $customer_id;?>"/>
						</div>
						
					</div>
					    <div class="col-md-4">
						<div class="form-group">
						   <label>Customer Name</label>
						   <input type="text" name="c_name" id="c_name" class="form-control" placeholder="Customer Name" value="<?php if(!empty($custname)) echo $custname;   ?>"/>
						</div>
					</div>
					   <div class="col-md-4">
						<div class="form-group">
						   <label>Comment</label>
						   <input type="text" name="comment" id="comment" class="form-control" placeholder="Comments" value="<?php if(!empty($comment)) echo $comment;   ?>"/>
						</div>
					</div>
				
				 
					</div>
				   <div class="row">
                    
                   <div class="col-md-3" style="border: 1px solid #ccc;padding: 3px;margin: 0px 9px 5px 10px !important;"> 
                   	
                   		
				 	 <input typ="text" name="addressname" id="new_address" placeholder="Add Address"/>
				 	 <input type="hidden" value="" id="checked_modules" name="checked_modules" /> 
                      <button type="button" class="btn btn-primary btn-xs" id="save_address"><i class="fa fa-save"></i></button>
              
				 	<br/>

                     
				      <div id="roles_tree">
				 
				                     
                    <ul>
                    <?php 
                        foreach ($address as $value){
                           echo "<li id=".$value->addr_id." class='jstree-open'>";
                           
                                if($order_address_id == $value->addr_id){
                                    echo '<a href="#"  class="jstree-checked">'.$value->title.'</a>';
                                }else{
                                    echo "<a href='#'>".$value->title."</a>";
                                }
                           
                                echo "<ul>";
                                foreach($this->ordertracker_m->get_child_address($value->addr_id) as $child)
                                {
                                    echo "<li id=".$child->addr_id." class='jstree-open'>";
                                    if($order_address_id == $child->addr_id){
                                        echo '<a href="#"  class="jstree-checked">'.$child->title.'</a>';
                                    }else{
                                        echo "<a href='#'>".$child->title."</a>";
                                    }
                                      echo"<ul>";
                                      foreach($this->ordertracker_m->get_child_address($child->addr_id) as $child1)
                                      {
                                          echo "<li id=".$child1->addr_id."   class='jstree-open'>";
                                          echo $child1->title;
                                            echo "<ul>";
                                            foreach($this->ordertracker_m->get_child_address($child1->addr_id) as $child2)
                                            {
                                                if($order_address_id == $child2->addr_id){
                                                    echo '<li id="'.$child2->addr_id.'"  class="jstree-open"><a href="#" class="jstree-checked">'.$child2->title.'</a></li>';
                                               }else{
                                                    echo '<li id="'.$child2->addr_id.'"   class="jstree-open" ><a href="#" >'.$child2->title.'</a></li>';
                                               }
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
                      ?>
                  
                  
              </div>
              </div>
              <div class="col-md-3" style="margin-top:20px">
              	<label>Custom Address</label>
              	 <input type="text" id="customeraddress" name="customaddress" class="form-control" placeholder="custom address" value="<?php if(!empty($customaddress)) echo $customaddress;   ?>"/>
              </div>

              <script>
                $("#roles_tree").jstree("_open_to",69);
                 $("#order_form").submit(function(){
                          var max = $("#roles_tree").jstree().get_checked(true)[0].id;
                           $("#checked_modules").val(max);
                           
                            /*alert(ids);
                            return false;*/
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
              		var max_id = "#"+max;
              		var next_id = "#"+(max+1);

              		var prepare_li = '<li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="'+(max+1)+'_anchor" id="'+(max+1)+'" class="jstree-node  jstree-leaf jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="'+(max+1)+'_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>'+$("#new_address").val()+'</a></li>';
              		

              		$(max_id).append(prepare_li);
              		

                   
                   
              	
              		
              	});
                  $(document).ready(function() {
                        $("#roles_tree").jstree({

                     checkbox: {       
                          three_state : false, 
					                whole_node : false,   
					               tie_selection : false 
					            },

                                     
                            "plugins" : [ "themes", "html_data", "checkbox", "ui","search" ]
                        
});
                                //searchin in jstree-------
                                 var to = false;
                              $('#new_address').keyup(function () {
                                if(to) { clearTimeout(to); }
                                to = setTimeout(function () {
                                  var v = $('#new_address').val();
                                  $('#roles_tree').jstree(true).search(v);
                                }, 250);
                              });
                              //---------------------------------

                        $("#role_form").submit(function(){
                            var ids = $("#roles_tree").jstree().get_checked(false);
                            console.log(ids);
                            $("#checked_modules").val(ids);
                            /*alert(ids);
                            return false;*/
                        });
                    });
                </script>
                    
                    <div class="col-md-4" id="addresssuggestion" style="margin-top:40px; margin-left:30px">
                      <div class="form-inline" id="addresssugg">
          
                      </div>
                    </div>

                  </div>
				         
			
					<div class="row" id="resturent_tab">
							<div>
						
						<div class="col-md-3" >
						
							<label>Select Resturant</label>
						    <select class="form-control chosen" style="width:200px" name="resturants[]" id="resturent">
								<option>Select Resturent</option>
								<?php  foreach ($resturent as $value1):?>
									<option value="<?php echo $value1['res_id'];?>"><?php echo $value1['res_name'];?></option>

								  <?php endforeach;?>
						   </select>
						
					    </div>

					    <div class="col-md-offset-5 col-md-3">
                              <table class="table table-striped" id="test_div">
                                 <?php if(!empty($itemrecord))
                                     foreach($itemrecord as $value):?>
                                    
                                     <tr value="<?php echo $value['o_id'];?>" id="<?php echo $value['menu_id'];?>">
                                         <td><?php echo $this->ordertracker_m->get_resturent_name($value['r_id']);?></td>
                                         <td><?php echo $this->ordertracker_m->getmenuname($value['menu_id']);?></td>
                                         <td><?php echo $value['qty'];?></td>
                                         <td><button type="button" id="deleteitem" class="btn btn-danger btn btn-xs" value="<?php echo $value['menu_id'];?>">X</button></td>
                                         
                                     </tr>
                                     <?php endforeach;?>
                                     
                              </table>
					    </div>
					</div>
					
				</div> <br>
                    
                    <div class="row">
                      <div class="col-md-12" style="margin-top:20px;">
                          <div class="form-group">
                            <?php if(!empty($colddrink)){?>
                            <?php foreach($colddrink as $colddrinks){?>
                          <label><?php echo $colddrinks->colddrink;?></label>
                          <input type="checkbox" name="cold[]" value="<?php echo $colddrinks->colddrink;?>"<?php foreach($editcolddrink as $value1) if($colddrinks->colddrink==$value1['colddrink_name']) echo 'checked="checked"' ?>/>
                          <?php  }?>
                          <?php }?>
                        </div>
                        </div>
                       <!-- <div class="col-md-6">
                          <div class="form-group">
                            <?php if(!empty($colddrink)){?>
                            <?php foreach($colddrink as $colddrinks){?>
                            <label class="radio-inline">
                            <input type="radio" name="liter" class="radiostyle" value="<?php //echo $colddrinks->liter;?>"<?php foreach($editcolddrink as $value1) if($colddrinks->liter==$value1['liter']) //echo'checked="checked"'?>/><?php //echo $colddrinks->liter."ltr";?>
                            </label>
                            <?php }?>
                          <?php }?>
                          </div>
                        </div>-->
                 

					         </div>
					<br>

				  <div class="row">
				  	<div class="col-md-12">
				  		<div class="form-group">
				  			<label>Order Details</label>
                            <textarea class="form-control" name="orrderdetails" id="orderdetails">
                                <?php if(!empty($orderdetails)) echo $orderdetails;?>
                            </textarea>
                    </div>
                   </div>
				  </div>

				       <div class="row">

					<div class="col-md-3">
					    <label>Prices:</label>
						<div class="form-group">
						    <?php if(!empty($pricetime)){?>
						    <?php foreach($pricetime as $pricetimes){?>
						      <label class="radio-inline">

                                 <input type="radio"  name="price" class="radiostyle" value="<?php echo $pricetimes->price;?>" <?php if($deliverycharges==$pricetimes->price) echo'checked="checked"'?> ><?php echo $pricetimes->price;?>
                              </label>
                              <?php } ?>
                              <?php } ?>
						     
							
                             
						</div>
					</div>		 
					<div class="col-md-3">
						<div class="form-group">
						<label>custom price</label>
                         <input  type="text" id="customeprice" name="customprice" class="form-control input-small" placeholder="Custom Price">
                         </div>
					</div>

					<div class="col-md-3">
					    <label>Time (Minutes):</label>
						<div class="form-group">
						    <?php if(!empty($pricetime)){?>
						    <?php foreach($pricetime as $pricetimes){?>
							  <label class="radio-inline">
                                 <input type="radio"  name="time" class="radiostyle" value="<?php echo $pricetimes->time;?>" <?php if($deliverytime==$pricetimes->time) echo'checked="checked"'?> ><?php echo $pricetimes->time;?>
                              </label>
                              <?php } ?>
                              <?php } ?>
                             
						</div>
					</div>		 

					<div class="col-md-3">
						<div class=" clockpicker1" data-placement="left" data-align="top" data-autoclose="true">
							<label>Delivery Time</label>
                        <input type="integer" class="form-control" name="deliverytime">
                         
                       </div>
					</div>
					
				</div> 
				  <div class="row">
						<div class=" col-md-4 ">
                          <label>Already Placed</label>&nbsp;<input type="checkbox" value="" id="alreadyplaced">
						</div>

						<div class="col-md-4" style="display:none" id="placedtime">
							<div class="form-group">
							  <label class="radio-inline">
                                 <input type="radio"  name="placetime" class="placetime" value="30"<?php if(!empty($orderreadytime)){if($orderreadytime==30){echo 'checked=="checked"';}}?>>30
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="placetime" class="placetime" value="50">50
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="placetime" class="placetime" value="60">60
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="placetime" class="placetime" value="70">70
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="placetime" class="placetime" value="90">90
                              </label>
						    </div>

						</div>

					</div>
					<br>
                        <button type="submit" name="save" id="save" class="btn btn-danger" style="background-color:#C0392B">Save</button>
				</div>
			</form>
		</div>

	</div>
</div>

<!-- Modal for MENU items-->
<div class="modal fade" role="dialog" id="menuitem">
	
</div>
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
                                $("#callqueu").after('<label style="margin-left:10px"><i class="fa fa-phone"></i>'+data[i].caller_id+'</label><input type="checkbox" value='+data[i].caller_id+' id="callerno" style="margin-right:10px">  ');
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
               url:"<?php echo base_url();?>order/insertcallno",
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
			$.ajax({
				url:"<?php echo base_url();?>order/getmenu",
				type:"POST",
				data:{"id":id},
				success:function(result){
					$("#menuitem").html(result).modal('show');

				},
				error:function(){
					alert("error");
				}

			});
			
});




</script>

<script type="text/javascript">
$('#60_anchor').toggleClass('jstree-checked');
//onblure function to get customer record if exitst---------------------------------------------
$("#cellno").blur(function(){
	var cellno=$(this).val();
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
           //getid(id);
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
          
});
//----------------------------------------------------------------------------------------------------------


//on double click create items -----------------------------------------------
 var id;
 $(document).on('dblclick','#getitemvalue',function(){
	
	
	 id=$(this).val();
	 var itemname=$(this).text();
	 var restid=$("#restid").val();
   var price1="price"+id;
   var price2="myprice"+id;
   var priceid="#price"+id;  
	var selecteditem="<tr id='remove' style='list-style-type:none'><td><h5 class='text text-success itemname' >"+  itemname  +"&nbsp;&nbsp;</h5> </td><td><input type='number' name='qty[]' id="+price2+" obi="+price1+" class='clearfields' value='' style='margin:0px;width:80px'/></td><td><input type='hidden' name='itemid[]' value="+id+" class='clearfields' class='itemid'/></td><td><input type='hidden' name='itemname[]' value="+itemname+" class='clearfields' class='itemname'/></td><td><input type='hidden' name='resturentid[]' id='resturentid' class='clearfields' value="+restid+"></td><td><label class='text text-success'>SubTotal &nbsp;&nbsp;</label><input type='text' name='price[]' id="+price1+" value='' class='sum' disabled style='width:40px'/>&nbsp;&nbsp;</td><td><button type='button' name='canel' id='canel' class='btn btn-danger btn-xs'>X</button></td></tr>";
	$("#appenditem").append(selecteditem);
  var price; 
		$.ajax
	    ({
        url:"<?php echo base_url();?>order/getprice",
        type:"POST",
        data:{"id":id},
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
        var obiprice=$(this).attr('obi');
         var itemprice=$("#"+obiprice).val();
         var subtotal=qty*price;
         $("#"+obiprice).val(subtotal);
          
          var values= $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();
              var total=0;
              $(".sum").each(function(){
                total+=parseFloat($(this).val());
              });
             $("#total").val(total);
               
      });
    



});
 //-------------------------------------------------------------------------------


//remove selected item ---------------------------------
 $(document).on('click','#canel',function(){
       //$("#remove").remove();
       $(this).parent().parent().remove();
 });
//------------------------------------------------------


//insertion of selected items in cart table with ajax------------------------------------
 $(document).on('click','#saveitem',function(){
     var formdata=$("#item-form").serialize();
   $.ajax({
       url:"<?php echo base_url();?>order/save_food_items",
       type:"POST",
       data:formdata,
       success:function(result){
         console.log(result);
       	$("#ordermodal").hide();
       		$('#resturent option[value=""]');
       		$("#test_div").load("<?php echo base_url();?>order/saveitems");
      
       },
       error:function(error){
       	alert(error);
       }
   });

 });
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
       }
       else{
       	$("#placedtime").hide();
       	$(".placetime").attr('checked',false);
       	$("#alreadyname").val('').hide();
       	
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
  


 
 

  $(document).on('keyup','#search',function(){
      var matches = $( 'ul#mymenu' ).find( 'li:contains('+ $( this ).val() +') ' );
        $( 'li', 'ul#mymenu' ).not( matches ).slideUp();
        matches.slideDown();  
  });
  
$(document).on('click','#deleteitem',function(){
    alert("hello");
    var id=$(this).attr('value');
    var orderid=$("#"+id).attr('value');
    $.ajax({
        url:"<?php echo site_url();?>order/itemdeletion",
        type:"POST",
        data:{"id":id,"orderid":orderid},
        success:function(result)
        {
            alert(result);
            $("#"+id).remove();
        }
    });
     
});
          

</script>



