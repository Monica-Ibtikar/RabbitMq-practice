<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq7', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

$messagesCount = 2;

while ($messagesCount > 0) {
    $data = "Hello World!";
    $msg = new AMQPMessage($data);
    $channel->basic_publish($msg, '', 'task_queue');
    sleep(10);
    echo 'sending';
    // uses a 5 second timeout
    $channel->wait_for_pending_acks(5.000);
    echo ' [x] Sent ', $data, "\n";
    $messagesCount--;
}

$channel->close();
$connection->close();

?>
