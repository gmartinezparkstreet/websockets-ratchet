<?php
namespace App\Providers;


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServerService implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = array();
    }

    public function onOpen(ConnectionInterface $conn) {
        // crmIds is the list of crmClassesIds that are connected to the websocket
        // the $conn->resourceId is the unique id of the connection
        $this->clients[$conn->resourceId]["crmIds"] = array();
        $this->clients[$conn->resourceId]["connection"] = $conn;

        var_dump ("New connection! ({$conn->resourceId})");
        var_dump($conn->resourceId);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        var_dump("from Properties {$from->resourceId}");
        $msg = json_decode($msg, true);
        var_dump("ClientId: {$msg["clientId"]} - Message: {$msg["message"]} ");

        if (isset($msg["addClientId"]) && $msg["addClientId"] == true) {
            var_dump("Message for a specific client : {$msg["clientId"]} - Resource: {$from->resourceId}");

            if (in_array($msg["clientId"], $this->clients[$from->resourceId]["crmIds"]) === false) {
                var_dump("Adding client to the list");
                array_push($this->clients[$from->resourceId]["crmIds"], $msg["clientId"]);
            }
        }

        // Instead of sending the message to all the clients / resources Ids
        // We will send the message to the clients that are in the list of the sender
        foreach ($this->clients as $key => $client) {
            // I left this so you can see the resourceId is different from the clientId
            var_dump("ResourceId: {$key}");
            if (in_array($msg["clientId"], $client["crmIds"])) {
                var_dump("Sending message to client: {$msg["clientId"]}");
                // The sender is not the receiver, send to each client connected
                $client['connection']->send($msg["message"]);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->clients[$conn->resourceId]);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        var_dump("An error has occurred:");
        var_dump($e->getMessage());
        var_dump($e->getTrace());

        $conn->close();
    }
}
