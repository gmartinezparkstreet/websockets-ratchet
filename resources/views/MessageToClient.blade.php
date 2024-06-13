<!DOCTYPE html>
<html>
<head>
    <title>WebSocket Chat</title>
    <style>
        #chatbox {
            height: 300px;
            width: 705px;
            border: 1px solid black;
            overflow: auto;
            margin-bottom: 10px;
        }
        #message {
            width: 400px;
        }
        .bordered {
            border-bottom: 1px solid black;
        }
    </style>
</head>
<body>
    <div id="chatbox"></div>
    <input id="message" type="text" placeholder="Enter message">
    <input id="client-id" type="text" placeholder="Enter client ID">
    <button id="send">Send</button>

    <script>
        let conn = new WebSocket('ws://127.0.0.1:8090/chat');
        let chatbox = document.getElementById('chatbox');
        let message = document.getElementById('message');
        let clientId = document.getElementById('client-id');
        let send = document.getElementById('send');

        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
            let p = document.createElement('p');
            p.className = 'bordered';
            p.innerText = e.data;
            chatbox.appendChild(p);
            chatbox.scrollTop = chatbox.scrollHeight;

            console.log(e);
        };

        send.onclick = function() {
            let msg = {
              message: message.value,
              clientId: clientId.value
            };

            msg = JSON.stringify(msg);
            console.log(msg);
            conn.send(msg);
            message.value = "";
        };

    </script>
</body>
</html>