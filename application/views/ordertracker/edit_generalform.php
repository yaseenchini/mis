<?php
echo"<pre>";
print_r($editgeneralorderformrecord);exit;

?>




<style type="text/css">
    input[type=radio] {
    width:100%;
	height: 1em;
	
}

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



</style>
<div class="container">
    <div class="row" style="margin-top:15px">
<div class="col-md-12 desc" id="order3" >
			<form method="post" id="order_form2" action="<?php echo base_url();?>order/add_genral_order">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 style="text-align:left">General Order</h4>
					</div>
					<div class="panel-body">
	    
					<div class="row">
					    
					    
							<div class="col-md-3">
								<div class="form-group">
						   <label>Cell No</label>
						   <input type="text" name="gcellno" id="gcellno" class="form-control" placeholder="Enter Cellno"/>
						</div>
						
					</div>
					  <div class="col-md-3">
						<div class="form-group">
						<label>Customer Name</label>
						<input type="text" name="gc_name" id="gc_name" class="form-control" placeholder="Enter Customer"/>
						</div>
					</div>
           <div class="col-md-3">
            <div class="form-group">
            <label>Comments</label>
            <input type="text" name="gcomment" id="gcomment" class="form-control" placeholder="Enter Customer"/>
            </div>
          </div>
					</div>
            <div class="row" style="border: 2px solid #00ffbf">
            <div class="col-md-3" style="border: 1px solid #ccc;padding: 3px;margin: 0px 9px 5px 10px !important;">           
           <input typ="text" name="addressname" id=".jstree({" placeholder="Add Address"/>
           <input type="hidden" value="" id="checked_modules2" name="gchecked_modules[]" /> 
          <button type="button" class="btn btn-primary btn-xs" id="save_address2"><i class="fa fa-save"></i></button>   
          <br/>

                     
              <div id="roles_tree2">           
                    <ul>
                    <?php
                        foreach ($address as $value){
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
                                //end of controller li
                                echo "</li>";  
                        }
                      ?>
                  </ul>
              </div>
              </div>
              <script>
                 $("#order_form2").submit(function(){
                          var max = $("#roles_tree2").jstree().get_checked(true)[0].id;
                           $("#checked_modules2").val(max);
                        });
                $("#save_address2").on('click',function(){                  
                  var max = $("#roles_tree2").jstree().get_checked(true)[0].id;
                  $("#checked_modules2").val(max);
                  var addressname=$("#.jstree({").val();
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

                  for(var i=0;i<$("#roles_tree2").jstree().get_checked(true).length;i++){
                    if($("#roles_tree2").jstree().get_checked(true)[i].id>max){
                      max = $("#roles_tree2").jstree().get_checked(true)[i].id;

                    }

                  }
                  $("#roles_tree2").load();
                  var max_id = "#"+max;
                  var next_id = "#"+(max+1);

                  var prepare_li = '<li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="'+(max+1)+'_anchor" id="'+(max+1)+'" class="jstree-node  jstree-leaf jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="'+(max+1)+'_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>'+$("#.jstree({").val()+'</a></li>';
                  $(max_id).append(prepare_li);
                });
                  $(document).ready(function() {
                        $("#roles_tree2").on('click', '.jstree-anchor', function (e) {
            $(this).jstree(true).toggle_node(e.target);
        }).jstree({

                          "checkbox": {       
                          "three_state":false, 
					                "whole_node" : false,   
					               "tie_selection" : false ,
					               
					            },

                                     
                            "plugins" : [ "themes", "html_data", "checkbox", "ui","search","wholerow" ]
                        
});
                                //searchin in jstree-------
                                 var to = false;
                              $('#new_address2').keyup(function () {
                                if(to) { clearTimeout(to); }
                                to = setTimeout(function () {
                                  var v = $('#new_address2').val();
                                  $('#roles_tree2').jstree(true).search(v);
                                }, 250);
                              });
                        $("#role_form2").submit(function(){
                            var ids = $("#roles_tree2").jstree().get_checked(false);
                            console.log(ids);
                            $("#checked_modules2").val(ids);
                            /*alert(ids);
                            return false;*/
                        });
                    });
                    
                    
   
                </script>
               <div class="col-md-2" style="margin-top:20px">
                   <label> custom address  </label>
                       <input type="text" name="gcustomaddress[]" placeholder="custom address"/>
                       
               </div>
               <br>
                 <div class="col-md-2" style="margin-top:20px;margin-left:10px">
                     
                          <label>From</label>
                          <input type="checkbox" name="from" id="from1" value=""/>
                        
                       
                </div>
                
                <div class="col-md-2" style="margin-top:20px;">
                    <label>To</label>
                    <input type="checkbox" name="to" id="to1" value=""/>
                </div>
                

                
                 <div class="col-md-2" style="margin-top:20px">
                     
                          <label>Billing</label>
                          <input type="checkbox" name="billing" id="billing1" value=""/>
                        
                        
                </div>
                 </div>

                   <div class="col-md-4" id="addresssuggestion" style="margin-top:40px; margin-left:30px">
                      <div class="form-inline" id="addresssugg1">
                      </div>
                    </div>
			<div class="row">
             <div class="col-md-12">
              <div class="form-group">
                <label>Order Details</label>
                  <textarea class="form-control" name="gorrderdetails" id="gorderdetails"></textarea>
                </div>
              </div>
          </div>
          
          
          		<div class="row">
					    
					    
							<div class="col-md-3">
								<div class="form-group">
						   <label>Cell No</label>
						   <input type="text" name="gaddcellno" id="gcellno" class="form-control" placeholder="Enter Cellno"/>
						</div>
						
					</div>
					  <div class="col-md-3">
						<div class="form-group">
						<label>Customer Name</label>
						<input type="text" name="gaddc_name" id="gc_name" class="form-control" placeholder="Enter Customer"/>
						</div>
					</div>
           <div class="col-md-3">
            <div class="form-group">
            <label>Comments</label>
            <input type="text" name="gaddcomment" id="gcomment" class="form-control" placeholder="Enter Customer"/>
            </div>
          </div>
					</div>
            <div class="row" style="border: 2px solid #00ffbf">
            <div class="col-md-3" style="border: 1px solid #ccc;padding: 3px;margin: 0px 9px 5px 10px !important;">           
           <input type="text" name="addressname" id="new_address1" placeholder="Add Address"/>
           <input type="hidden" value="" id="checked_modules1" name="gchecked_modules[]" /> 
          <button type="button" class="btn btn-primary btn-xs" id="save_address1"><i class="fa fa-save"></i></button>   
          <br/>

                     
              <div id="roles_tree1">           
                    <ul>
                    <?php
                        foreach ($address as $value){
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
                                //end of controller li
                                echo "</li>";  
                        }
                      ?>
                  </ul>
              </div>
              </div>
              <script>
              $("#roles_tree1").bind("select_node.jstree", function (e, data) {
    return data.instance.toggle_node(data.node);
});
                 $("#order_form2").submit(function(){
                          var max = $("#roles_tree1").jstree().get_checked(true)[0].id;
                           $("#checked_modules1").val(max);
                        });
                $("#save_address1").on('click',function(){                  
                  var max = $("#roles_tree1").jstree().get_checked(true)[0].id;
                  $("#checked_modules1").val(max);
                  var addressname=$("#new_address1").val();
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

                  for(var i=0;i<$("#roles_tree1").jstree().get_checked(true).length;i++){
                    if($("#roles_tree1").jstree().get_checked(true)[i].id>max){
                      max = $("#roles_tree1").jstree().get_checked(true)[i].id;

                    }

                  }
                  $("#roles_tree1").load();
                  var max_id = "#"+max;
                  var next_id = "#"+(max+1);

                  var prepare_li = '<li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="'+(max+1)+'_anchor" id="'+(max+1)+'" class="jstree-node  jstree-leaf jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="'+(max+1)+'_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>'+$("#new_address2").val()+'</a></li>';
                  $(max_id).append(prepare_li);
                });
                  $(document).ready(function() {
                        $("#roles_tree1").jstree({

                           checkbox: {       
                          three_state :false, 
					                whole_node : false,   
					               tie_selection : false 
					            },

                                     
                            "plugins" : [ "themes", "html_data", "checkbox", "ui","search","wholerow" ]
                        
});
                                //searchin in jstree-------
                                 var to = false;
                              $('#new_address1').keyup(function () {
                                if(to) { clearTimeout(to); }
                                to = setTimeout(function () {
                                  var v = $('#new_address1').val();
                                  $('#roles_tree1').jstree(true).search(v);
                                }, 250);
                              });
                        $("#role_form1").submit(function(){
                            var ids = $("#roles_tree1").jstree().get_checked(false);
                            console.log(ids);
                            $("#checked_modules1").val(ids);
                            /*alert(ids);
                            return false;*/
                        });
                    });
                </script>
                
                <div class="col-md-2" style="margin-top:20px">
                   <label> custom address  </label>
                       <input type="text" name="gcustomaddress[]" placeholder="custom address"/>
                       
               </div>
               <br/>
              
                <div class="col-md-2" style="margin-top:20px;margin-left:10px">
                  
                          <label>From</label>
                          <input type="checkbox" name="from" id="from2" value=""/>
                       
                </div>
                <div class="col-md-2" style="margin-top:20px;">
                    <label>To</label>
                    <input type="checkbox" name="to" id="to2" value=""/>
                </div>
                 <div class="col-md-2" style="margin-top:20px">
                    
                          <label>Billing</label>
                          <input type="checkbox" name="billing" id="billing2" value=""/>
                        
                       
                </div>
                

                 </div>
                 
                 <br/>
               <!-- <div class="row" style="border: 2px solid #00ffbf;display:none;" id="addaddress">
            <div class="col-md-3" style="border: 1px solid #ccc;padding: 3px;margin: 0px 9px 5px 10px !important;">           
           <input typ="text" name="addressname" id="new_address3" placeholder="Add Address"/>
           <input type="hidden" value="null" id="checked_modules3" name="gchecked_modules[]" /> 
          <button type="button" class="btn btn-primary btn-xs" id="save_address3"><i class="fa fa-save"></i></button>   
          <br/>

                     
              <div id="roles_tree3">           
                    <ul>
                    <?php
                        foreach ($address as $value){
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
                                //end of controller li
                                echo "</li>";  
                        }
                      ?>
                  </ul>
              </div>
              </div>
              <script>
                 $("#order_form2").submit(function(){
                          var max = $("#roles_tree3").jstree().get_checked(true)[0].id;
                           $("#checked_modules3").val(max);
                        });
                $("#save_address3").on('click',function(){                  
                  var max = $("#roles_tree3").jstree().get_checked(true)[0].id;
                  $("#checked_modules3").val(max);
                  var addressname=$("#new_address3").val();
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

                  for(var i=0;i<$("#roles_tree3").jstree().get_checked(true).length;i++){
                    if($("#roles_tree3").jstree().get_checked(true)[i].id>max){
                      max = $("#roles_tree3").jstree().get_checked(true)[i].id;

                    }

                  }
                  $("#roles_tree3").load();
                  var max_id = "#"+max;
                  var next_id = "#"+(max+1);

                  var prepare_li = '<li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="'+(max+1)+'_anchor" id="'+(max+1)+'" class="jstree-node  jstree-leaf jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="'+(max+1)+'_anchor"><i class="jstree-icon jstree-checkbox" role="presentation"></i><i class="jstree-icon jstree-themeicon" role="presentation"></i>'+$("#new_address2").val()+'</a></li>';
                  $(max_id).append(prepare_li);
                });
                  $(document).ready(function() {
                        $("#roles_tree3").on('click', '.jstree-anchor', function (e) {
            $(this).jstree(true).toggle_node(e.target);
        }).jstree({

                           checkbox: {       
                          three_state : false, 
					                whole_node : false,   
					               tie_selection : false 
					            },

                                     
                            "plugins" : [ "themes", "html_data", "checkbox", "ui","search","wholerow" ]
                        
});
                                //searchin in jstree-------
                                 var to = false;
                              $('#new_address3').keyup(function () {
                                if(to) { clearTimeout(to); }
                                to = setTimeout(function () {
                                  var v = $('#new_address3').val();
                                  $('#roles_tree3').jstree(true).search(v);
                                }, 250);
                              });
                        $("#role_form3").submit(function(){
                            var ids = $("#roles_tree3").jstree().get_checked(false);
                            console.log(ids);
                            $("#checked_modules3").val(ids);
                            /*alert(ids);
                            return false;*/
                        });
                    });
                </script>
                
                <div class="col-md-2" style="margin-top:20px">
                   <label> custom address  </label>
                       <input type="text" name="gcustomaddress[]" placeholder="custom address"/>
                       
               </div>
               <br>
                <div class="col-md-2" style="margin-top:20px;margin-left:10px;">
                  
                          <label>To</label>
                          <input type="checkbox" name="to" id="to3" value="null"/>
                       
                </div>
                 <div class="col-md-2" style="margin-top:20px">
                    
                          <label>Billing</label>
                          <input type="checkbox" name="billing" id="billing3" value="null"/>
                        
                       
                </div>
                

                 </div>
                 <br>
                 
                 <button type="button" id="add" class="btn btn-default">Add More</button>-->
              
                 <br><br>
			   <div class="row">
          <div class="col-md-3">
            <div class="form-group">
                <label class="radio-inline">
                                 <input type="radio"  name="gprice" value="100">100
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="gprice" value="150">150
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gprice" value="200">200
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gprice" value="250">250
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gprice" value="300">300
                              </label>
            </div>
          </div>     
          <div class="col-md-3">
            <div class="form-group">
            <label>custom price</label>
                         <input  type="text" id="gcustomeprice" name="gcustomprice" class="form-control input-small" placeholder="Custom Price">
                         </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
                <label class="radio-inline">
                                 <input type="radio"  name="gtime" value="30">30
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="gtime" value="50">50
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gtime" value="60">60
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gtime" value="70">70
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gtime" value="90">90
                              </label>
            </div>
          </div>     

          <div class="col-md-3">
            <div class=" clockpicker1" data-placement="left" data-align="top" data-autoclose="true">
              <label>Delivery Time</label>
                        <input type="integer" class="form-control" name="gdeliverytime">
                         
                       </div>
          </div>
          
        </div>
        <br>
        <br>
		<div class="row">
            <div class=" col-md-2 ">
            <label>Already Placed</label>&nbsp;<input type="checkbox" value="" id="galreadyplaced">
            </div>
             <div class="col-md-3">
                              <input type="text" name="galreadyname" id="galreadyname" class="form-control" style="display:none"/>
                          </div>
            <div class="col-md-4" style="display:none" id="gplacedtime">
              <div class="form-group">
                <label class="radio-inline">
                                 <input type="radio"  name="gplacetime" value="30">30
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="gplacetime" value="50">50
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gplacetime" value="60">60
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gplacetime" value="70">70
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gplacetime" value="90">90
                              </label>
                </div>
            </div>
          </div>
        <br>
          <button type="submit" name="save" id="save" class="btn btn-danger" style="background-color:#C0392B">Save</button>
				    </div>
				</div>
			</form>
		</div> 
		</div>
		</div>
 



<!-- breakkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk-->




<script type="text/javascript">
      

   $("#gcellno").blur(function(){
  var cellno=$(this).val();
  $.ajax({
    url:"<?php echo base_url();?>order/generalcustomerrecord",
    type:"POST",
    data:{'gcellno':cellno},
    success:function(data){
           var json = JSON.parse(data);
           var title=json['title'];
           
           
           var custname=json["cust_name"];
           var comment=json["comment"];
           var id=json["order_address_id"];
           $("#gc_name").val(custname);
           $("#gcomment").val(comment);
            if(json.length==0)
            {
              $("#addresssugg1").append('<table><tr><td class="badge badge-success">No Avaliable Address</td><td><button type="button" class="btn btn-info btn-xs" id="gdeleteaddress">X</button></td></tr></table>');
             
           }
         else
          {
                $("#addresssugg1").append('<table ><tr><td><input type="checkbox" name="gaddressid"  value="'+id+'"/></td><td class="badge badge-info">'+ title +'</td><td><button type="button" class="btn btn-info btn-xs" id="gdeleteaddress">X</button></td></tr></table>');
          }

    },
    error:function(error){
      alert(error);
    }

  });
          
});



//if order already placed by customer then--------------------------------------------
  $("#galreadyplaced").change(function(){
       if(this.checked){
        $("#gplacedtime").show();
        var cname=$("#gc_name").val();
       	$("#galreadyname").val(cname).show();
       }
       else{
        $("#gplacedtime").hide();
        $("#galreadyname").val('').hide();
        
       }
  });
  //end of ---------------------------------------------------------------------------------
  
  
  //delete suggested address---------------------------------------
  $(document).on('click','#gdeleteaddress',function(){
    $(this).parent().parent().parent().remove();
  });
//end of dletion----------------------------------------------------  



</script>

<script type="text/javascript">


$("#add").on('click',function(){
    $("#addaddress").show();
});
$(document).on('change','#billing1',function(){
    if(this.checked)
    {
      var elems = [];
        elems.push(1);
        elems.push(0);
        $('#billing1').val(JSON.stringify(elems));
        
    }
    else
    {
        $("#billing1").val('');
    }
    
});
$(document).on('change','#billing2',function(){
    if(this.checked)
    {
      var elems = [];
        elems.push(0);
        elems.push(1);
        $('#billing2').val(JSON.stringify(elems));
     
        
    }
    else
    {
        $("#billing2").val('');
    }
    
});

$(document).on('change','#from1',function(){
    $("#to2").prop('checked',true);
    $("#to1").prop('checked',false);
    $("#from2").prop('checked',false);
   if(this.checked){
      var elems = [];
        elems.push(1);
        elems.push(0);
        $('#from1').val(JSON.stringify(elems));
        
        var elems1=[];
        elems1.push(0);
        elems1.push(1);
        $("#to2").val(JSON.stringify(elems1));
        
}
    
});
$(document).on('change','#to1',function(){
    $("#from1").prop('checked',false);
    $("#to2").prop('checked',false);
    $("#from2").prop('checked',true);
   if(this.checked){
      var elems = [];
        elems.push(1);
        elems.push(0);
        $('#to1').val(JSON.stringify(elems));
      
      var elems1=[];
      elems1.push(0);
      elems1.push(1);
      $("#from2").val(JSON.stringify(elems1));
        
   }
   
  
});







</script>
