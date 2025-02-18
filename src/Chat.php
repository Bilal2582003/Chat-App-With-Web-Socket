<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require dirname(__DIR__)."/database/User.php";
require dirname(__DIR__)."/database/Chatroom.php";
class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    // use for new client connected 
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    // when a new message is received by connection 
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

            $data = json_decode($msg, true);

            $chat_obj = new \ChatRoom();
            $chat_obj->setUserId($data['userId']);
            $chat_obj->setMsg($data['msg']);
            $chat_obj->setCreatedOn(date("Y-m-d h:i:s"));
            $chat_obj->save_chat(); 

            $user_obj = new \Users();
            $user_obj->setUserId($data['userId']);
            $user_data = $user_obj->get_user_data_by_id();
            $user_name = $user_data['name'];
            $data['dt'] = date("Y-m-d h:i:s");

        foreach ($this->clients as $client) {
            // if ($from !== $client) {
            //     // The sender is not the receiver, send to each client connected
            //     $client->send($msg);
            // }
            if($from == $client ){
                $data['from'] = 'Me';
            }else{
                $data['from'] = $user_name;
            }
            $client->send(json_encode($data));
        }
    }

    // when connection has been closed 
    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    // when error occur 
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}