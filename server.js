var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 8080;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {

  socket.on( 'new_count_message', function( data ) {
    io.sockets.emit( 'new_count_message', { 
    	new_count_message: data.new_count_message

    });
  });

  socket.on( 'update_count_message', function( data ) {
    io.sockets.emit( 'update_count_message', {
    	update_count_message: data.update_count_message 
    });
  });

  socket.on( 'new_message', function( data ) {
    io.sockets.emit( 'new_message', {
    	name: data.name,
    	email: data.email,
    	subject: data.subject,
    	created_at: data.created_at,
    	id: data.id
    });
  });

   // mobile food order code goes here...
    socket.on( 'food_order', function( data ) {
    io.sockets.emit( 'food_order', {
      name: data.subject,
      email: data.email
    });
  });

       // mobile general order code goes here...
    socket.on( 'general_order', function( data ) {
    io.sockets.emit( 'general_order', {
      name: data.subject,
      email: data.email
    });
  });
});
