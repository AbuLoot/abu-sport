var io=require('socket.io')(6002);
io.on('connection',function(socket){
    console.log('New connection');
});