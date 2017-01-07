
var request = require('request'),
	io = require('socket.io')(6001, {
		origins: 'abusport.kz:*'
	}),
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

	io.to(channel)
		.emit(channel, message.data);
});
