var io = require('socket.io')(6001);

io.on('connection', function(socket) {

	// console.log('Id: ', socket.id);

	// Send message
	// socket.send('Message from server. This id ' + socket.id);

	// Fire event
	// socket.emit('server-info', {version: .1});

	// socket.broadcast.send('New user');

	// Join to room
	// socket.join('vip', function(error) {
	// 	console.log(socket.rooms);
	// });

	socket.on('message', function(data) {
		socket.broadcast.send(data);
	});
});