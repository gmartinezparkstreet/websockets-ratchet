# Run Server

```php -S localhost:8000 -t public```

## Available routes

- **/websocketclient** UI of the client that recieves the messages
- **/messagetoclient** UI to send messages to a client by ID

## WebSocketServer

We are using the same configuration as the `WebSocketSecureServer.php` in cockpit. This can be checked here [WebSocketSecureServer](WebSocketSecureServer.php)

### MessageComponentInterface

The MessageComponentInterface is a fundamental interface in the Ratchet library, which is a PHP library for asynchronously serving WebSockets. This is the one that we current use in cockpit.

This interface defines the basic methods that a class must implement to interact with WebSocket connections. These methods are:

- **onOpen(ConnectionInterface $conn):** This method is called when a new connection is opened. 

- **onMessage(ConnectionInterface $from, $msg):** This method is called when a message is received from a connection.

- **onClose(ConnectionInterface $conn):**: This method is called when a connection is closed. 

- **onError(ConnectionInterface $conn, \Exception $e):** This method is called when an error occurs on a connection. 

> We added some changes to the **onMessage** and **onOpen** methods so we can store/filter the **crmIds** that are going to recieve updates/messages when needed. You can see the details in [WebSocketServerService](/app/Providers/WebSocketServerService.php)

## WampServerInterface

The WampServerInterface (WAMP Web Application Messaging Protocol) is an interface provided by the Ratchet library . It's a protocol that provides two application messaging patterns in one unified protocol: Remote Procedure Calls (RPC) and Publish & Subscribe (PubSub).

The WampServerInterface is used to create a server that can handle WAMP connections. It extends the MessageComponentInterface and adds four additional methods:

- **onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible):** This method is triggered when a publish event is received from a client. The $topic parameter is the topic URI, $event is the event payload, $exclude is an array of connection IDs that should be excluded from receiving the event, and $eligible is an array of connection IDs that are eligible to receive the event.

- **onCall(ConnectionInterface $conn, $id, $topic, array $params):** This method is triggered when a call event is received from a client. The $id parameter is the unique ID of the call, $topic is the topic URI, and $params are the call parameters.

- **onSubscribe(ConnectionInterface $conn, $topic):** This method is triggered when a subscribe event is received from a client. The $topic parameter is the topic URI.

- **onUnSubscribe(ConnectionInterface $conn, $topic):** This method is triggered when an unsubscribe event is received from a client. The $topic parameter is the topic URI.

These methods allow us to handle different types of events that can occur in a WAMP connection.

> **If we are looking to extend the configuration of our websockets this can be an interesting approach.**