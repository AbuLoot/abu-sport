<<<<<<< HEAD
var request = require('request'),
	io = require('socket.io')(6001),
	Redis = require('ioredis'),
	redis = new Redis;

io.on('connection', function(socket) {
	socket.on('subscribe', function(channel) {
		console.log('Subscribe on:', channel);

		socket.join(channel, function(error) {
			socket.send('Join to ' + channel);
		});
	});

});
redis.psubscribe('*', function(error, count) {
	// 
});

redis.on('pmessage', function (subscribed, channel, message) {

	message = JSON.parse(message);	
    console.log(message);
	if(message.event=="LeftMatch"){
		io.emit('exitplayer', message.data);
	}
	if(message.event=="JoinedToMatch"){
		io.emit('newplayer', message.data);
	}
	if(message.event=="AddedNewMessage"){
		io.emit('mess', message.data);
	}
	if(message.event=="CreatedNewMatch"){
		io.emit('newmatch', message.data);
	}
	if(message.event=="StartedMatch"){
		io.emit('startedmatch', message.data);
	}
	io.to(channel)
		.emit(channel, message.data);
	// end
});
=======
var io=require('socket.io')(6002);
io.on('connection',function(socket){
    console.log('New connection');
});
>>>>>>> d17d7416b768cec8a25706a117cbf130d1c8f5ca
