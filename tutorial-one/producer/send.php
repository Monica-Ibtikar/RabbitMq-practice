<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//$connection = new AMQPStreamConnection('host', port, 'user', 'password');
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();//create channel

$channel->queue_declare('first', false, false, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'first');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();
?>
