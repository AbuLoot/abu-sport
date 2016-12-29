
var request = require('request'),
	io = require('socket.io')(6001, {
		origins: 'localhost:8000:*'
	}),
	Redis = require('ioredis'),
	redis = new Redis;

// Middleware
// io.use(function(socket, next) {

// 	request.get({
// 		url : 'http://localhost:8000/ws/check-auth',
// 		headers : {cookie : socket.request.headers.cookie},
// 		json : true
// 	}, function(error, response, json) {
// 		console.log(json);
// 		return json.auth ? next() : next(new Error('Auth error'));
// 	});

// });

io.on('connection', function(socket) {
	socket.on('subscribe', function(channel) {
		console.log('Subscribe on:', channel);

		socket.join(channel, function(error) {
			socket.send('Join to ' + channel);
		});

		// request.get({
		// 	url : 'http://localhost:8000/ws/check-sub/' + channel,
		// 	headers : {cookie : socket.request.headers.cookie},
		// 	json : true
		// }, function(error, response, json) {
		// 	if (json.can) {
		// 		socket.join(channel, function(error) {
		// 			socket.send('Join to ' + channel);
		// 		});
		// 		return;
		// 	}
		// });
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