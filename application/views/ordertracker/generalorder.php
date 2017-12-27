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
.orange{
  background-color: orange;
}
.rotate{
  align-content: center;
  vertical-align: middle;
  color: orange;
  font-weight: bold;
 /* -moz-transform: rotate(-90.0deg); 
   -o-transform: rotate(-90.0deg);
  -webkit-transform: rotate(-90.0deg);*/
}

</style>

 <script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"> 
</script>



<script>

  setInterval(function(){
        var contents = '';
       $.ajax({
       url:'<?php echo base_url()?>order/mobile_general_order',
         method:'POST',
         data:{'addr_id': ''},
         success:function(data){
          console.log(data);
           obj = JSON.parse(data);
           $.each(obj, function(idx, obj) {
           var bring_or_drop = (obj.bringme_or_dropit == 1) ? "Drop item" : "Bring item";
          contents += '<tr id="popup" style="cursor:pointer" value="'+obj.mo_id+'"><td>'+obj.mo_id+'</td><td>'+obj.mo_pick_name+'</td><td>'+obj.mo_pick_cellno+'</td><td>'+obj.mo_pick_address+'</td><td>'+obj.mo_details+'</td><td>'+obj.mo_time+'</td><td>'+obj.mo_drop_name+'</td><td>'+obj.mo_drop_cellno+'</td><td>'+obj.mo_drop_address+'</td><td>'+bring_or_drop+'</td><td><a class="btn btn-xs" value="" id="takeorder">take</a>&nbsp;<a class="btn btn-xs" id="discard">Discard</a><input type="hidden" name="general_id" id="general_id" value="'+obj.id+'"><input type="hidden" name="bringme_or_dropit" id="bringme_or_dropit" value="'+obj.bringme_or_dropit+'"></td></tr>';
            });
            $( "#general_order" ).html(contents);
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
        socket.on( 'general_order', function( data ) {
              console.log(data);
                    $.ajax({
                    url:'<?php echo base_url()?>order/general_order',
                      method:'POST',
                      data:{'addr_id': data},
                      success:function(data){
                        obj = JSON.parse(data);
                        var bring_or_drop = (obj.bringme_or_dropit == 1) ? "Drop item" : "Bring item";
                        $( "#general_order" ).prepend('<tr id="popup" style="cursor:pointer" value="'+obj.mo_id+'"><td class="rotate">new</td><td>'+obj.mo_pick_name+'</td><td>'+obj.mo_pick_cellno+'</td><td>'+obj.mo_pick_address+'</td><td>'+obj.mo_details+'</td><td>'+obj.mo_time+'</td><td>'+obj.mo_drop_name+'</td><td>'+obj.mo_drop_cellno+'</td><td>'+obj.mo_drop_address+'</td><td>'+bring_or_drop+'</td><td><a class="btn btn-xs" value="" id="takeorder">take</a>&nbsp;<a class="btn btn-xs" id="discard">Discard</a><input type="hidden" name="general_id" id="general_id" value="'+obj.id+'"><input type="hidden" name="bringme_or_dropit" id="bringme_or_dropit" value="'+obj.bringme_or_dropit+'"></td></tr>');
                      },
                      error:function(){
                        alert('error');
                      }
                      
               });
              });




});
</script>



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
				      <div class="col-md-12">
							<div class="form-group" style="background-color:#ccc;border:1px dotted red;">
							    <button type="button" id="getcallerno" class="btn btn-xs btn-info"><span class="fa fa-phone "> call</span></button>
                              <h4 id="callqueu" style="margin-left:10px">Calling:</h4>
                               
					        </div>
					
				      </div>
					    <!-- below i added table you may copy it as a whole -->
            <?php 
              $mob_general_order;
              $list;
              $counter = 1;
              $bringme_or_dropit;
              foreach ($mob_general_order as $key => $value) {
                $bringme_or_dropit = ($value->bringme_or_dropit ==1) ? 'Drop items' : 'Bring item';
                $list.="<tr>
                      <td>".$counter."</td>";
                $list.="<td id='mo_pick_name' value=''>".$value->mo_pick_name."</td>";
                $list.="<td id='mo_pick_cellno' value=''>".$value->mo_pick_cellno."</td>";
                $list.="<td id='mo_pick_address' value=''>".$value->mo_pick_address."</td>";
                $list.="<td id='mo_details' value=''>".$value->mo_details."</td>";
                $list.="<td id='mo_time' value=''>".$value->mo_time."</td>";
                $list.="<td id='mo_drop_name' value=''>".$value->mo_drop_name."</td>";
                $list.="<td id='mo_drop_cellno' value=''>".$value->mo_drop_cellno."</td>";
                $list.="<td id='mo_drop_address' value=''>".$value->mo_drop_address."</td>";
                $list.="<td id='bringme_or_dropit' value=''>".$bringme_or_dropit."</td>";
                $list.="<td> <a class='btn btn-xs' value='' id='takeorder'>take</a>&nbsp;<a class='btn btn-xs' id='discard'>Discard</a>
                <input type='hidden' name='general_id' id='general_id' value='".$value->mo_id."'>
                <input type='hidden' name='bringme_or_dropit' id='bringme_or_dropit' value='".$value->bringme_or_dropit."'>
                </td>
                </tr>";
                $counter++;
              }
            ?>
          <div class="box border blue">
            <div class="box-title">
              <h4><i class="fa fa-table"></i>Mobiles General order</h4>
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
                  <th>Pick name</th>
                  <th>Number</th>
                  <th>Address</th>
                  <th>Details</th>
                  <th>time</th>
                  <th>Drop name</th>
                  <th>Number</th>
                  <th>Address</th>
                  <th>label</th>
                  <th>Action</th>
                  </tr>
                </thead>
                <tbody id="general_order">
                  <?= $list; ?>
                </tbody>
                </table>
            </div>
          </div><!-- my code ends here table ends here... -->
					    
					   <div class="col-md-3">
    	                    <div class="form-group">
    						   <label>Cell No</label>
    						   <input type="text" name="gcellno" id="gcellno" required="" class="form-control" placeholder="Enter Cellno"/>
    						</div>
    						
					   </div>
					  <div class="col-md-3">
						<div class="form-group">
						<label>Customer Name</label>
						<input type="text" name="gc_name" id="gc_name"  required="" class="form-control" placeholder="Enter Customer"/>
						</div>
					</div>
           <div class="col-md-3">
            <div class="form-group">
            <label>Comments</label>
            <input type="text" name="gcomment" id="gcomment" class="form-control" placeholder="Enter Customer"/>
            </div>
          </div>
         </div>
         <div class="separator"></div>
            <div class="row">
            <!-- <div class="row" style="border: 2px solid #00ffbf"> -->
            <ul><li id="address1_selection" style="display:none" class="btn btn-primary start"></li><input type="hidden" id="address1_selection_id" name="address[]" /></ul>

            <div class="col-md-3" style="border: 1px solid #ccc;padding: 10px 5px;margin: 0px 9px 5px 10px !important; overflow:scroll; height:400px;">  
                   
           <input type="text" name="addressname" id="addressname1" />
           <input type="hidden" value="" id="checked_modules2" name="gchecked_modules[]" /> 
          <button type="button" class="btn btn-primary btn-xs" id="save_address"><i class="fa fa-save"></i></button>
          <button type="button" class="btn btn-primary btn-xs" id="delete_address"><i class="fa fa-trash-o"></i></button>   
          <br/>

                     
              <div id="roles_tree2">           
                    <!--<ul>
                    <?php
                       /* foreach ($address as $value){
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
                        }*/
                      ?>
                  </ul>-->
              </div>
              </div>
        
        <script>
        
      $(function() {
          $('#roles_tree2').jstree({
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
        
        $('#roles_tree2').on('changed.jstree', function (e, data) {
        		
        		if (!$("#multiselect").is(':checked') && data.selected.length > 1) {
        			resetting = true; //ignore next changed event
        			data.instance.uncheck_all(); //will invoke the changed event once
        			data.instance.check_node(data.node/*currently selected node*/);
        			return;
        		}
        	});
        
        </script>              
              <script>
                 $("#order_form2").submit(function(){
                          var max = $("#roles_tree2").jstree().get_checked(true)[0].id;
                          $("#checked_modules2").val(max);
                        });
                $("#save_address").on('click',function(){                  
                  var max = $("#roles_tree2").jstree().get_checked(true)[0].id;
                  $("#checked_modules2").val(max);
                  var addressname=$("#addressname1").val();
                  $.ajax({
                    url:'<?php echo base_url()?>order/list_addresses',
                        method:'POST',
                        data:{'addressname': addressname,'max':max},
                       success:function(data){
                           alert("Added"); 
                           $('#roles_tree2').jstree(true).refresh();                       
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
                        var id = $("#roles_tree2").jstree(true).get_node($(this)).id;
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
                       <input type="text" name="gcustomaddress[]" class="form-control" value="" id="calleraddress" placeholder="custom address"/>
                       
               </div>
               <br/>
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
                          <br><br>
                        
                        <div id="order_details"></div>
                </div>
                 </div>

                <!--    <div class="col-md-4" id="addresssuggestion" style="margin-top:40px; margin-left:30px"> -->
                      <div class="form-inline" id="addresssugg1">
                      </div>

                      
<!--                     </div> -->
			<div class="row">
             <div class="col-md-12">
              <div class="form-group">
                <label>Order Details</label>
                  <textarea class="form-control" name="gorrderdetails" id="gorderdetails"></textarea>
                </div>
              </div>
          </div>
            <div id="mobile_order"></div>
          <div class="separator"></div>
          		<div class="row">
					    
					    
                    <div class="col-md-3">
		      			<div class="form-group">
						   <label>Cell No</label>
						   <input type="text" name="gaddcellno" id="gcellno1" class="form-control" placeholder="Enter Cellno"/>
						</div>
						
					</div>
			        <div class="col-md-3">
						<div class="form-group">
						<label>Customer Name</label>
						<input type="text" name="gaddc_name" id="gc_name1" class="form-control" placeholder="Enter Customer"/>
						</div>
					</div>
                       <div class="col-md-3">
                        <div class="form-group">
                        <label>Comments</label>
                        <input type="text" name="gaddcomment" id="gcomment" class="form-control" placeholder="Enter Customer"/>
                        </div>
                      </div>
			    </div>
            <div class="row">
              <ul><li id="address2_selection" style="display:none" class="btn btn-primary start"></li><input type="hidden" id="address2_selection_id" name="address[]" /></ul> 
              <div class="col-md-3" style="border: 1px solid #ccc;padding: 10px 5px;margin: 0px 9px 5px 10px !important; overflow:scroll; height:400px;"> 
                     
           <input type="text" name="addressname" id="new_address1" placeholder="Add Address"/>
           <input type="hidden" value="" id="checked_modules1" name="gchecked_modules[]" /> 
          <button type="button" class="btn btn-primary btn-xs" id="save_address1"><i class="fa fa-save"></i></button>   
          <br/>

                     
              <div id="roles_tree1">           
                    <!--<ul>
                    <?php
                        /*foreach ($address as $value){
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
                        } */
                      ?>
                  </ul> -->
              </div>
              </div>
        <script>
        
        $(function() {
          $('#roles_tree1').jstree({
            'core' : {
              'data' : {
                "url" : "<?php echo base_url()?>order/prepare_jstree_addresses",
                "dataType" : "json" // needed only if you do not supply JSON headers
              }
            },
            search : { show_only_matches : true, show_only_matches_children : true },
            'checkbox': {
        			three_state: false,
        			cascade: 'none'
            }, 
            "plugins": [ "themes", "html_data", "checkbox", "ui","search" ]
          }).on('search.jstree before_open.jstree', function (e, data) {
                if(data.instance.settings.search.show_only_matches) {
                    data.instance._data.search.dom.find('.jstree-node')
                        .show().filter('.jstree-last').filter(function() { return this.nextSibling; }).removeClass('jstree-last')
                        .end().end().end().find(".jstree-children").each(function () { $(this).children(".jstree-node:visible").eq(-1).addClass("jstree-last"); });
                }
            });
        });
        
        $('#roles_tree1').on('changed.jstree', function (e, data) {
        		
        		if (!$("#multiselect").is(':checked') && data.selected.length > 1) {
        			resetting = true; //ignore next changed event
        			data.instance.uncheck_all(); //will invoke the changed event once
        			data.instance.check_node(data.node/*currently selected node*/);
        			return;
        		}
        	});
        
        </script>                 
              <script>
              $("#roles_tree1").on('click', '.jstree-anchor', function (e) {
                var id = $("#roles_tree1").jstree(true).get_node($(this)).id;
                var myKeyVals = { addr_id : id}
               
                $.ajax({
                      type: 'POST',
                      url: "<?php echo base_url();?>order/get_absolute_addr/", 
                      data: myKeyVals,
                      success: function(resultData) { 
                        $('#address2_selection').show();
                        $('#address2_selection').text(resultData);
                        $('#address2_selection_id').val(id);
                        
                      
                       }
                }) 
                $(this).jstree(true).toggle_node(e.target);
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
                          three_state :true, 
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
                              $('#addressname1').keyup(function () {
                                if(to) { clearTimeout(to); }
                                to = setTimeout(function () {
                                  var v = $('#addressname1').val();
                                  $('#roles_tree2').jstree(true).search(v);
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
                      <input type="text" name="gcustomaddress[]" class="form-control" id="calleraddress1" value="" placeholder="custom address"/>
                       
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
               <div class="row" style="border: 2px solid #00ffbf;display:none;" id="addaddress">
            <div class="col-md-3" style="border: 1px solid #ccc;padding: 3px;margin: 0px 9px 5px 10px !important;">           
           <input type="text" name="addressname" id="new_address3" placeholder="Add Address"/>
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
                       <input type="text" name="gcustomaddress[]" value="" placeholder="custom address"/>
                       
               </div>
               <br/>
                <div class="col-md-2" style="margin-top:20px;margin-left:10px;">
                  
                          <label>To</label>
                          <input type="checkbox" name="to" id="to3" value=""/>
                       
                </div>
                 <div class="col-md-2" style="margin-top:20px">
                    
                          <label>Billing</label>
                          <input type="checkbox" name="billing" id="billing3" value=""/>
                        
                       
                </div>
                

                 </div>
                 <br/>
                <button type="button" id="add" class="btn btn-default">Add More</button>                
              
                 <br/><br/>
			   <div class="row">
          <div class="col-md-3">
            <div class="form-group">
                <label class="radio-inline">
                                 <input type="radio"  name="gprice" value="100" />100
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="gprice" value="150" />150
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gprice" value="200" />200
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gprice" value="250" />250
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gprice" value="300" />300
                              </label>
            </div>
          </div>     
          <div class="col-md-3">
            <div class="form-group">
            <label>custom price</label>
                         <input  type="text" id="gcustomeprice" name="gcustomprice" class="form-control input-small" placeholder="Custom Price" />
                         </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
                <label class="radio-inline">
                                 <input type="radio"  name="gtime" value="30" />30
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="gtime" value="50" />50
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gtime" value="60" />60
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gtime" value="70" />70
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gtime" value="90" />90
                              </label>
            </div>
          </div>     

          <div class="col-md-3">
            <div class=" clockpicker1" data-placement="left" data-align="top" data-autoclose="true">
              <label>Delivery Time</label>
                        <input type="integer" class="form-control" name="gdeliverytime" />
                         
                       </div>
          </div>
          
        </div>
        <br />
        <br />
		<div class="row">
            <div class=" col-md-2 ">
            <label>Already Placed</label>&nbsp;<input type="checkbox" value="" id="galreadyplaced" />
            </div>
             <div class="col-md-3">
                              <input type="text" name="galreadyname" id="galreadyname" class="form-control" style="display:none"/>
                          </div>
            <div class="col-md-3" style="display:none" id="gplacedtime">
              <div class="form-group">
                <label class="radio-inline">
                                 <input type="radio"  name="gplacetime" value="0" />0
                              </label>
                              <label class="radio-inline">
                                 <input type="radio"  name="gplacetime" value="10" />10
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gplacetime" value="20" />20
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gplacetime" value="30" />30
                              </label>
                              <label class="radio-inline">
                                  <input type="radio"  name="gplacetime" value="75" />75
                              </label>
                </div>
                
            </div>
           <div class="col-md-3" style="display:none" id="placed_custom_time">
           
				<div class="form-group">
                
                    <input type="integer" class="form-control" name="gplacetime" style="width: 50px !important;" />
			    </div>
			</div>
          </div>
        <br/>
          <button type="submit" name="save" id="save" class="btn btn-primary">Save</button>
				    </div>
				</div>
			</form>
		</div> 
		</div>
		</div>
 







<script type="text/javascript">
$("#delete_address").on('click',function(){
	var max = $("#roles_tree2").jstree().get_checked(true)[0].id;
    var selected_name = $("#roles_tree2").jstree().get_checked(true)[0].name;
      if (confirm(selected_name)) {
        $.ajax({
  			url:'<?php echo base_url()?>order/delete_address',
            method:'POST',
            data:{'addr_id': max},
           success:function(data){
               alert("Deleted");
               $('#roles_tree2').jstree(true).refresh();
               $('#roles_tree1').jstree(true).refresh();
           },
           error:function(){
           	alert('error');
           }
          
  		});
     }
	$("#roles_tree").load();	
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
           
           
             $(document).on('change','#callerno',function(){
             if(this.checked){
             var callerno=$(this).val();
             $("#gcellno").val(callerno);
             }
             else{
                 $("#gcellno").val('');
             }
         });

         $("#getcallerno").on('click',function(){
             
             Api();
         });





   $("#gcellno").blur(function(){
  var cellno=$(this).val();
  $.ajax({
    url:"<?php echo base_url();?>order/generalcustomerrecord",
    type:"POST",
    data:{'gcellno':cellno},
    success:function(data){
           var json = JSON.parse(data);
           var title=json['title'];
           var order_id = json['o_id'];
           var custname=json["cust_name"];
           var comment=json["comment"];
           var id=json["order_address_id"];
           var status=json["status"];
           var description = json['order_details'];
           orderInfo(order_id, status, description);
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
    function orderInfo(cellno, status, description){
      // this is switch is hardcoded on jquery...
      switch (status) {
          case '1':
            status = "Pending";
              break;
          case '2':
            status = "Placed";
              break;
          case '3':
            status = "Processed";
              break;
          case '4':
            status = "Complete";
            break;
          case '5':
            status = "Canceled";
            break;
          case '6':
            status = "Ack";
              break;
          case '7':
            status = "Picked";
              break;
          case '8':
            status = "Droped";
              break;
          case '9':
            status = "expectin in 5 minute";
              break;
          default:
              //# code...
              break;
      }
     $("#order_details").append('<table class="table table-condensed table-bordered table-responsive"><thead><tr><th>Status</th><th>Details</th><th>Link</th></tr></thead><tbody><tr><td>'+status+'</td><td>'+description+'</td><td><a href="" id="order_details_link">View</a></td></tr></tbody></table>');
     var link = "<?php base_url();?>/mis/order/process_order_details/"+cellno;
     $("#order_details_link").attr("href", link);
         
   }



//if order already placed by customer then--------------------------------------------
  $("#galreadyplaced").change(function(){
       if(this.checked){
        $("#gplacedtime").show();
        var cname=$("#gc_name").val();
       	$("#galreadyname").val(cname).show();
        $("#placed_custom_time").show();
       }
       else{
        $("#gplacedtime").hide();
        $("#galreadyname").val('').hide();
        $("#placed_custom_time").hide();
        
       }
  });
  //end of ---------------------------------------------------------------------------------
  
  
  //delete suggested address---------------------------------------
  $(document).on('click','#gdeleteaddress',function(){
    $(this).parent().parent().parent().remove();
  });
//end of dletion----------------------------------------------------  

// my code delete the record and remove from page through jquery ajax
  $(document).on('click','#discard',function(){
    var id = $(this).siblings('input').val();
    console.log(id);
    var item = $(this).parent().parent();
     $.ajax({
        url:'<?php echo base_url()?>order/delete_mob',
            method:'POST',
            data:{'id': id, 'tablename': 'mob_general_order'},
           success:function(data){
              item.remove();
           },
           error:function(){
            alert('error with on click method id discard');
           }
    

      });
  });

    $(document).on('click','#takeorder',function(){
    var id = $(this).siblings('input#general_id').val();
    var itemclicked = $(this).parents('tr');
    var mo_pick_name= itemclicked.children('td#mo_pick_name').text();
    var mo_pick_cellno= itemclicked.children('td#mo_pick_cellno').text();
    var mo_pick_address= itemclicked.children('td#mo_pick_address').text();
    var mo_details= itemclicked.children('td#mo_details').text();
    var mo_time= itemclicked.children('td#mo_time').text();
    var mo_drop_name= itemclicked.children('td#mo_drop_name').text();
    var mo_drop_cellno= itemclicked.children('td#mo_drop_cellno').text();
    var mo_drop_address= itemclicked.children('td#mo_drop_address').text();
    var mo_address= itemclicked.children('td#mo_address').text();
    var bringme_or_dropit = $(this).siblings('input#bringme_or_dropit').val();
    if(bringme_or_dropit == 1){
      console.log("one");
          $("input#gc_name").val(mo_pick_name);
          $("input#gcellno").val(mo_pick_cellno);
          $("input#calleraddress").val(mo_pick_address);
          $("input#gc_name1").val(mo_drop_name);
          $("input#gcellno1").val(mo_drop_cellno);
          $("input#calleraddress1").val(mo_drop_address);

    }else{
          $("input#gc_name").val(mo_drop_name);
          $("input#gcellno").val(mo_drop_cellno);
          $("input#calleraddress").val(mo_drop_address);
          $("input#gc_name1").val(mo_pick_name);
          $("input#gcellno1").val(mo_pick_cellno);
          $("input#calleraddress1").val(mo_pick_address);
    }
    $("#gorderdetails").val($.trim(mo_details));
    itemclicked.addClass('orange');
    $("div#mobile_order").append('<input type="hidden" name="mobile_order" value="1" />');

    // $(this).parent().parent().remove();
     // $.ajax({
     //    url:'<?php //echo base_url()?>order/delete_mob',
     //        method:'POST',
     //        data:{'id': id, 'tablename': 'mob_general_order'},
     //       success:function(data){
     //          item.remove();
     //       },
     //       error:function(){
     //        alert('error with on click method id discard');
     //       }
    

     //  });
  });

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
        elems.push(0);
        $('#billing2').val(JSON.stringify(elems));
     
        
    }
    else
    {
        $("#billing2").val('');
    }
    
});

$(document).on('change','#billing3',function(){
    if(this.checked)
    {
      var elems = [];
        elems.push(0);
        elems.push(0);
         elems.push(1);
        $('#billing3').val(JSON.stringify(elems));
     
        
    }
    else
    {
        $("#billing3").val('');
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
        elems.push(0);
        $('#from1').val(JSON.stringify(elems));
        
        var elems1=[];
        elems1.push(0);
        elems1.push(1);
        elems1.push(0);
        $("#to2").val(JSON.stringify(elems1));
        
}
    
});
$(document).on('change','#from2',function(){
    $("#to2").prop('checked',false);
    $("#to1").prop('checked',true);
    $("#from1").prop('checked',false);
   if(this.checked){
      var elems = [];
        elems.push(1);
        elems.push(0);
        elems.push(0);
        $('#from2').val(JSON.stringify(elems));
        
        var elems1=[];
        elems1.push(0);
        elems1.push(1);
        elems1.push(0);
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
        elems.push(0);
        $('#to1').val(JSON.stringify(elems));
      
      var elems1=[];
      elems1.push(0);
      elems1.push(1);
      elems1.push(0);
      $("#from2").val(JSON.stringify(elems1));
        
   }
   
  
});
// i write this code...
$(document).on('change','#to2',function(){
    $("#from2").prop('checked',false);
    $("#to1").prop('checked',false);
    $("#from1").prop('checked',true);
   if(this.checked){
      var elems = [];
        elems.push(1);
        elems.push(0);
        elems.push(0);
        $('#to1').val(JSON.stringify(elems));
      
      var elems1=[];
      elems1.push(0);
      elems1.push(1);
      elems1.push(0);
      $("#from1").val(JSON.stringify(elems1));
        
   }
   
  
});

// i commented this code.....

// $(document).on('change','#to3',function(){    
//     if($("#to2").prop('checked',true))
//     {
//          var elems = [];
//         elems.push(0);
//         elems.push(1);
//         elems.push(1);
//         $('#to3').val(JSON.stringify(elems));
//     }
//     else
//     {
//         var elems = [];
//         elems.push(1);
//         elems.push(0);
//         elems.push(1);
//         $('#to3').val(JSON.stringify(elems));
//     }
    
// });







</script>
