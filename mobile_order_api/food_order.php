<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body onload="myemit();">
	
</body>
 <script src="../node_modules/socket.io/node_modules/socket.io-client/socket.io.js"> 
</script>
<script>
	function myemit(){
		var socket = io.connect( 'http://'+window.location.hostname+':8080' );
            socket.emit('food_order', { 
              email: "data.email",
              subject: "data.subject"
            });

            // copy this below code with socket links for general order...
            socket.emit('general_order', { 
              email: "data.email",
              subject: "data.subject"
            });
	}
</script>
</html>