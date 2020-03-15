var app = require('http').createServer(handler)
var io = require('socket.io')(app);
var fs = require('fs');







app.listen(3000);

function handler (req, res) {
    fs.readFile('/socket.io/index.html',
        function (err, data) {
            if (err) {
                res.writeHead(500);
                return res.end('Error loading index.html');
            }

            res.writeHead(200);
            res.end(data);
        });
}

io.on('connection', (socket) => {
    console.log('a user connected');



    socket.on('click', function(data) {
        console.log(JSON.stringify(data)+'11');

        socket.broadcast.emit('new message', {
            username: socket.username,
            message: data
        });

    });


    let token = socket.handshake.query.token;
    let admin = socket.handshake.query.admin;

    socket.join(token);

    socket.on(token+'_write', function(msg) {

        if (admin == 1) {

            socket.broadcast.emit(token + '_write', {
                username: token,
                message: msg['message']
            });

        }
    });

  


    socket.on(token, function(msg){

        if(admin==1) {

            socket.broadcast.emit(token, {
                username: token,
                message: msg
            });

        }
         
        if(admin==0) {
            var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
            var xhr = new XMLHttpRequest();


            var body = 'my_data=' + encodeURIComponent(JSON.stringify(msg));


            xhr.open("POST", 'https://cloud.neiros.ru/send_chat', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(body);
        }
    });




});
