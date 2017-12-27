<!-- PAGE HEADER-->

<style>
.blink_text {

    animation:1s blinker linear infinite;
    -webkit-animation:1s blinker linear infinite;
    -moz-animation:1s blinker linear infinite;

     color: red;
    }

    @-moz-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @-webkit-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }
     .orange_blink {

         animation:0.5s orange_blinker linear infinite;
         -webkit-animation:0.5s orange_blinker linear infinite;
         -moz-animation:0.5s orange_blinker linear infinite;
          background-color: orange !important;
          color: white !important;
         }

         @-moz-keyframes orange_blinker {  
          0% { opacity: 1.0; }
          50% { opacity: 0.0; }
          100% { opacity: 1.0; }
          }

         @-webkit-keyframes orange_blinker {  
          0% { opacity: 1.0; }
          50% { opacity: 0.0; }
          100% { opacity: 1.0; }
          }

         @keyframes orange_blinker {  
          0% { opacity: 1.0; }
          50% { opacity: 0.0; }
          100% { opacity: 1.0; }
          }
    .expired{
        background-color: red !important;
        color: white !important;
      }
 </style>

<script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
<script>
  var socket = io.connect( 'http://'+window.location.hostname+':8080' );
  socket.on( 'new_message', function( data ) {
        console.log(data);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('order/food_order_process');?>",
            data: 1,
            cache : false,
            success: function(data1){
                var obj = JSON.parse(data1);
                console.log(obj);
                $('#notif_audio')[0].play();
                $( "#message-tbody" ).prepend('<tr id="popup" style="cursor:pointer" value="'+obj.o_id+'"><td>'+"from"+'</td><td>'+obj.to+'</td><td>'+obj.order_details+'</td><td>'+obj.ordertype+'</td><td>'+obj.delivery_charges+'</td><td>'+obj.deliverytime+'</td><td>'+obj.status+'</td><td>order date</td><td>'+obj.ordertime+'</td><td>'+obj.placedtime+'</td><td>'+obj.orderreadytime+'</td><td></td><td>'+obj.rider+'</td><td>'+obj.rider_acknowleg+'</td><td></td><td></td><td><a href="<?php echo site_url('order/process_order_details'); ?>'+'/'+obj.o_id+'"'+'class="ml10"><i class="fa fa-eye"></i></a> <a href="<?php echo site_url('order/edit_order');?>'+'/'+obj.o_id+'"'+'class="ml10"><i class="fa fa-pencil"></i></a> </td></tr>');
            } ,error: function(xhr, status, error) {
              alert(error);
            }

        });

  });
</script>

<div class="row">
	<div class="col-sm-12">
    <audio id="notif_audio"><source src="<?php echo base_url('sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('sounds/notify.wav');?>" type="audio/wav"></audio>
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
            </div>
            
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->


<!-- PAGE MAIN CONTENT -->
<div class="row">
		<!-- MESSENGER -->
	<div class="col-md-12">
	     <div class="box border blue" id="messenger">
		      <div class="box-title">
              <h4>
                <i class="fa fa-bell"></i><?php echo $title; ?>
              </h4>
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
          <div>
            <table class="table table-responsive table-striped table-condensed table-bordered">
              <thead>
    					  <tr>
    						<!-- <th>OrderId</th> -->
                <th>From</th>
                <th>To</th>
               
    						<th>order_details</th>
                <th class="text-center">
                  order type
                </th>
    						<th class="text-center">
                  <i class="fa fa-dollar fa-lg" aria-hidden="true">
                </th>
    						<th class="text-center"><!-- delivery time -->
                  deliver <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                </th>
    						<th>Status</th>
    						<th class="text-center">Order <i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
                </th>
                <th class="text-center">Order <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                </th>
                <th class="text-center">Placed <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                </th>
    						<th class="text-center">Ready <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                </th>
                <th class="text-center">Remain <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                </th>
    						<th class="text-center">
                  Rider
                </th>
                <th>Rider Ack</th>
                <th class="text-center">Picking<i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                </th>
                <th class="text-center">Droping <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                </th>
    						<th>Actions</th>
    					  </tr>
    				  </thead>
    					  <tbody id="message-tbody">
    					  <?php //echo $list; ?>
    					  <?php
                  $list1="";
                    foreach($gprocessorder as $key=>$value){
                          $fromaddress="";
                          $toaddress="";                      
                        // this below code is for order type label
                          $ordertype1=$value['od']['ordertype'];
                          if($ordertype1==1){
                            $ordertype_lebel="Food";
                            $toaddress = $this->ordertracker_m->get_order_address($value['od']['o_id']);
                            $restid = $this->ordertracker_m->ger_order_resturentid($value['od']['o_id']);
                            $fromaddress = $this->ordertracker_m->get_resturent_name($restid);
                          }else{ $ordertype_lebel="general";}
                        //ends here...
    					        $ordertype=$orderid=$value['od']['ordertype'];
                      $orderid=$value['od']['o_id'];
            					$list1.="<tr id='popup' style='cursor:pointer' ordertype=".$ordertype." value=".$orderid.">";
    						      // $list1.="<td>".$value['od']['o_id']."</td>"; no need to show in table...
                      if($ordertype1!=1){
      						      foreach($value['otf'] as $value1){

              						  if($value1['from']==1 and $value1['to']==0){
        						           $fromaddress.=$this->ordertracker_m->getaddress($value1['order_address_id'])." ".$value1['custom_addr'];
        						          }elseif($value1['from']==0 and $value1['to']==1){
              						          $toaddress.=$this->ordertracker_m->getaddress($value1['order_address_id']).$value1['custom_addr'];
              						    }
                        }
                      }

                      $list1.="<td id='$orderid' value='$fromaddress'>".$fromaddress."</td>";
                      $list1.="<td id='1$orderid' value='$toaddress'>".$toaddress."</td>";
                      $list1.="<td>".$value['od']['order_details']."</td>";
                      //$list1.="<td>".$value['od']['ordertype']."</td>";
                      $list1.="<td>".$ordertype_lebel."</td>";
                      $list1.="<td>".$value['od']['delivery_charges']."</td>";
                      $list1.="<td>".$value['od']['deliverytime']."</td>";
                      $list1.="<td>".$this->ordertracker_m->get_order_status($value['od']['status'])."</td>";
                      $list1.="<td>".$value['od']['orderdate']."</td>";
                      $list1.="<td>".$value['od']['ordertime']."</td>";
                      $list1.="<td>".$value['od']['placedtime']."</td>";
                      $list1.="<td>".$value['od']['orderreadytime']."</td>";
                      $list1.="<td id='time_$orderid'></td>";
                      $list1.="<td> <input type='hidden'  id='riderstatus' value='".$value['od']['rider']."'>".$this->ordertracker_m->getrider($value['od']['rider'])."</td>";
                      $list1.="<td>".$value['od']['rider_acknowleg']."</td>";
                      $list1.="<td>".$value['od']['riderpicking_time']."</td>";
                      $list1.="<td>".$value['od']['rider_droptime']."</td>";
                      // $list1.="<td></td>";
                      $list1 .= "<td class='text-center'>
                                  <a href='".site_url("order/process_order_details/".$value['od']['o_id'])."' class='ml10' title='click to view order detials'><i class='fa fa-eye'></i></a><a href='".site_url("order/edit_order/".$value['od']['o_id'])."' class='ml10' title='click to view order detials'><i class='fa fa-edit'></i></a>
                                </td>";
                      $list1 .= "</tr>";
                            if($value['od']['orderreadytime'] !='00:00:00'){
                                date_default_timezone_set('Asia/Karachi');
                                $timeValue = $value['od']['timer'];
                                $date = $value['od']['orderdate'];
                                $time = $date." ".$timeValue;
                                $time = date('Y-m-d H:i:s', strtotime($time));



                                $time = strtotime($time);

                                // date_default_timezone_set('Pacific/Marquesas');
                                //$timeValue = strtotime($timeValue);
                                  echo '<script>
                                        var timer = "timer_'.$orderid.'";
                                        var x = setInterval(function() {
                                          var tdId = "time_'.$orderid.'";
                                          var readytime = "'.$time.'";


                                          readytime = (parseInt(readytime))*1000;
                                          
                                              // thes two method getting current time
                                              var now = new Date().getTime();
                                              var currentTime = +new Date();

                                              // the now time value is showing should be in 12 hours format that is bug remove it.
                                              var distance = readytime - now;

                                                  // Time calculations for days, hours, minutes and seconds
                                                  //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                  
                                                  document.getElementById(tdId).innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
                                                  // If the count down is over, write some text 
                                                  // the distance value is showing negtive and thats the bug remove it.
                                                  if (distance < 0) {
                                                          clearInterval(timer);
                                                          document.getElementById(tdId).innerHTML = "EXPIRED";
                                                          document.getElementById(tdId).className = "expired";
                                                          
                                                  }
                                                  if( minutes < 5 && hours == 0){
                                                      document.getElementById(tdId).className = "orange_blink";
                                                    }

                                        }, 1000);
                                        </script>'; 
                                        //die(); 
                            }//checking wheater we have rider assign or not...




            				}
                    echo $list1; ?>

                    <?php //if(!empty($list1)) echo $list1; i commented this line for a while no need to desply these record already displayed..?>
            						     
            		</tbody>
    				</table>
            <?= $this->pagination->create_links(); ?>
          </div>	
    		</div>
      </div>
  </div>
</div>

<!-- EDIT ORDER DIV FOR UPDATING THE ORDER-->
  <!-- for popup window when click on order-->
      <nav style="display:none" id="showpopup">
        <ul>
          <li>
            <div class="dialog">
            <div class="title">Order Options</div>
              <form  method="post" action="<?php echo base_url();?>order/rider_assign">
                  <select class="form-control" name="rider" id="rider">
                      <option value="">^^^^ Select Rider ^^^</option>
                      <?php foreach ($rider as $rider):?>
                      <option value="<?php echo $rider->r_id;?>"><?php echo $rider->name;?><span> (<?php echo $rider->last_delivery; ?>)</span> </option>
                      <?php endforeach;?>
                  </select>
                <input type="text" name="reason" id="reason" placeholder="Reson for canceling order"/>
                <li id="cancelorder"  style="text-align:center;color:black;width:225px;height:30px;line-height:15px;padding-top:10px;margin-top:10px;padding-bottom:10px;background-color:white;cursor:pointer">Cancel Order</li><br>
                <input type="hidden" name="oid" value="" id="oid"/>
                <input type="hidden" name="cellno" value="" id="cellno"/>
                <input type="hidden" name="ridercellno" value="" id="ridercellno"/>
                <input type="hidden" name="customername" id="custname" value=""/>
                <input type="hidden" name="charges" id="charges" value=""/>
                <input type="hidden" name="order_details" id="order_details" value=""/>
                <input type="hidden" name="to" id="to" value=""/>
                <input type="hidden" name="from" id="from" value=""/>
                <input type="submit"  value="Ok"/>

                <!-- my code... below code is for status of order... -->
                <select class="form-control" id="changeStatus">
                  <option value="">Change order status</option>
                  <!-- <option value="1">Status 1</option> -->
                  <option value="2">Placed</option>
                  <!-- <option value="3">Processed</option> -->
                  <!-- <option value="4">Complete</option> -->
                  <!-- <option value="5">Status 5</option> bcoz 5 is canceled already exists--> 
                  <!-- <option value="6">Acknowledge</option> -->
                  <option value="7">Picked</option>
                  <option value="8">Droped</option>
                  <option value="9">Almost complete</option>
                  <!-- <option value="10">Ready In</option> -->
                </select>

              </form>
            </div>
          </li>
        </ul>
      <!-- </div>         -->
      </nav>


  <!-- styles and scripts-->
  <script type="text/javascript">
    var id;
    var fromaddress;
    var toaddress;
    $(document).on('click','#popup',function(){

    $("#showpopup").css( {position:"absolute", top:event.pageY-24, left: event.pageX-250}).slideToggle('slow');
    
    var id = $(this).attr('value');
    var ordertype=$(this).attr('ordertype');
    var fromaddress=$("#"+id).attr('value');
    var toaddress=$("#1"+id).attr('value');
    //alert(fromaddress);alert(toaddress);
  

       if(ordertype==1)
       {

    $.ajax
    ({
      url:"<?php echo base_url();?>order/getcellno",
      type:"POST",
      data:{"id":id},
      success:function(result){
          
          //alert(result);
        var json=JSON.parse(result);
        var result1=json[0];
        var cellno=result1['cellno'];
        var customername=result1['cust_name'];
        var charges=result1['delivery_charges'];
        var order_details=result1['order_details'];
        
        
        $("#cellno").val(cellno);
        $("#custname").val(customername);
        $("#charges").val(charges);
        $("#order_details").val(order_details);
     

        var result3=json[2];
        var from=result3['res_name'];
        $("#from").val(from);
        var result2=json[3];
        $("#to").val(result2);

       
       
       
      }

    });
     $("#oid").val(id);
     
       }
       
       else
       {
        
          // alert(id);
             $.ajax({
                  url:"<?php echo base_url();?>order/getgcellno",
                  type:"POST",
                  data:{"id":id},
                  success:function(result){
                    
                    var json=JSON.parse(result);
                   //alert(json);
                    var cust_name=json['cust_name'];
                    //alert(cust_name)
                    var cellno=json['cellno'];

                    var charges=json['delivery_charges'];
                    var order_details=json['order_details'];
                                        
                    //alert(cellno);
                    $("#cellno").val(cellno);
                    $("#custname").val(cust_name);
                    $("#from").val(fromaddress);
                    $("#to").val(toaddress);
                    $("#charges").val(charges);
                    $("#order_details").val(order_details);
       
        
                   
     
       
      }

    });
     $("#oid").val(id);
     
           
       }


}); 

    $(document).on('click','#cancelorder',function(){
    var id=$("#oid").val();
    var reason=$("#reason").val();
     $.ajax({
         url:"<?php echo base_url();?>order/cancelorder",
         type:"POST",
         data:{"id":id,"reason":reason},
         success:function(result){
          location.reload();
            /*setTimeout(function()
            {
           location.reload(); 
            }, )*/
         }
      });
       
    });

   // my code below code is for change the status of an order...
   $(document).on('change', '#changeStatus', function(){
    var statusId = $(this).val();
    var orderId = $("#oid").val();
    var text = $("#changeStatus option:selected").text();
    //var text = $("option[value='"+statusId+"']").text();
    // this below code for placed and ready time
    if(statusId == 2){
      var timeValue = prompt('Enter Ready time in minutes i-e 120,20,10 etc. :');
          if(timeValue){
            $.ajax({
                url: "<?php echo base_url();?>order/changeStatus",
                type: "POST",
                data: { "statusId": statusId, "orderId": orderId, "text":text, "timeValue": timeValue},
                success:function(result){
                        location.reload();
                },
                error: function(error){
                  console.log(error);
                }
            });
          }

    }else{  
        var descision = confirm("Do you really want to change the status to " + '"'+text+'".');
          if (descision===true) {
              $.ajax({
                  url: "<?php echo base_url();?>order/changeStatus",
                  type: "POST",
                  data: { "statusId": statusId, "orderId": orderId, "text":text},
                  success:function(result){
                          location.reload();
                  },
                  error: function(error){
                    console.log(error);
                  }
              });
          }
    }
    
   });



  /* setTimeout(function(){
      location.reload();
   },6000);*/
   
   
   $("#rider").change(function(){
       var riderid=$(this).val();
       $.ajax({
          url:"<?php echo base_url();?>order/getridercontactno",
          type:"POST",
          data:{"riderid":riderid},
          success:function(result){
              var json=JSON.parse(result);
              var ridercellno=json['personal_no'];
              $("#ridercellno").val(ridercellno);
          }
       });
   });

</script>

<style type="text/css">

nav ul {
  margin: 0px;
  padding: 0px;
}
.button {
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  margin: 0 8px;
  padding: 0px 32px;
  display: block;
  height: 100%;
  min-width:9px;
  line-height: 64px;
  border: 1px solid #C24032;
  border-width: 0px 1px;
  box-shadow: 0px 0px 4px #C24032;
  transition: box-shadow .2s linear;
}
nav ul li, .radio > .button {
  display: inline-block;
  vertical-align:top;
}

.add
{
  transition: box-shadow .2s linear, margin .3s linear .5s;
}
.add.active
{
  margin:0 98px;
  transition: box-shadow .2s linear, margin .3s linear;
}
.button:link
{
  color: #eee;
  text-decoration: none;
}
.button:visited
{
  color: #eee;
}
.button:hover
{
  box-shadow:none;
}
.button:active,
.button.active {
  color: #eee;
  border-color: #C24032;
  box-shadow: 0px 0px 4px #C24032 inset;
}
nav ul li a:active {
  color: #eee;
}
nav ul li a.active {
  color: #eee;
}
.dialog {
  position: relative;
  text-align: center;
  background: #4478a0;
  margin: 13px 0 4px 4px;
  display: inline-block;
  width: 256px;
  box-shadow: 0px 0px 8px rgba(68, 140, 160, 0.5);
}
.dialog:after,
.dialog:before {
  bottom: 100%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
}
.dialog:after {
  border-color: rgba(255, 255, 255, 0);
  border-bottom-color: #5C9CCE;
  border-width: 15px;
  left: 50%;
  margin-left: -15px;
}
.dialog:before {
  border-color: rgba(170, 170, 170, 0);
  border-width: 16px;
  left: 50%;
  margin-left: -16px;
}
.dialog .title {
  color: #fff;
  font-weight: bold;
  text-align: center;
  border: 1px solid #5189B5;
  border-width: 0px 0px 1px 0px;
  margin-left: 0;
  margin-right: 0;
  margin-bottom: 4px;
  margin-top: 8px;
  padding: 8px 16px;
  background: #5C9CCE;
  box-shadow: 0px 1px 4px rgba(68, 120, 160, 0.1);
  font-size: 16px;
  line-height:2em;
}
.dialog .title:first-child {
  margin-top: -4px;
}
form
{
  padding:16px;
  padding-top: 0;
}
select[name=type]
{
appearance:none;
  border-radius: 0;
}
textarea,input[type=text],input[type=datetime-local],input[type=time],select
{
  color: #fff;
  border: 0;
  outline: 0;
  resize: none;
  margin: 0;
  margin-top: 1em;
  padding: .5em;
  width:100%;
  border-bottom: 1px dotted rgba(250, 250, 250, 0.4);
  background:#5d92ba;
}
input[type=text]:focus,input[type=datetime-local]:focus,input[type=time]:focus {
  background-color: #4478a0;
}
input[type=submit]
{
  border:none;
  background: #FAFEFF;
  padding: .5em 1em;
  margin-top: 1em;
  color:#4478a0;
}
input[type=submit]:active
{
  background: #E1E5E5;
}
input:-moz-placeholder, textarea:-moz-placeholder {
  color: #FAFEFF;
}
input:-ms-input-placeholder, textarea:-ms-input-placeholder {
  color: #FAFEFF;
}
input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
    color:#FAFEFF;
}

</style>