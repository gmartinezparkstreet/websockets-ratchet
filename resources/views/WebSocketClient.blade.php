<!DOCTYPE html>
<html>
<head>
    <title>WebSocket Chat</title>
    <style>
        #chatbox {
            height: 300px;
            width: 500px;
            border: 1px solid black;
            overflow: auto;
        }
        .bordered {
            border-bottom: 1px solid black;
        }
    </style>
</head>
<body>
    <div id="chatbox"></div>

    <script>
        const clientId = Math.floor(Math.random() * 1000);
        const conn = new WebSocket('ws://127.0.0.1:8090/chat');
        let chatbox = document.getElementById('chatbox');
        let message = document.getElementById('message');

        conn.onopen = function(e) {
            console.log("Connection established!");

            let initialMessage = {
                message: 'This will be client ID: ' + clientId,
                addClientId: true,
                clientId: clientId
            };

            conn.send(JSON.stringify(initialMessage));
        };

        conn.onmessage = function(e) {
            let p = document.createElement('p');
            p.className = 'bordered';
            p.innerText = e.data;
            chatbox.appendChild(p);
            chatbox.scrollTop = chatbox.scrollHeight;

            console.log(e);
        };
    </script>
</body>
</html>