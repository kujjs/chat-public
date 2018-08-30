

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

//creación de cliente de redis
var redis = require('redis');
var redisClient = redis.createClient({host:'redis'});

//suscripción a canal de redis
redisClient.subscribe('canal');

//evento de conección de cliente de sockets
io.on('connection', function(socket){
    console.log('usuario conectado');
});

//cuando llegue un mensaje a redis
redisClient.on('message', function(channel, messageStr){
    var message = JSON.parse(messageStr);
    console.log(message);
    io.emit('message', message);
});

http.listen(3000, function(){
    console.log('listening on 3000');
});