<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$exchange = "publisher-confirms";
$connection = new AMQPStreamConnection('rabbitmq7c', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare($exchange, 'fanout', false, false, true);
list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

$channel->queue_bind($queue_name, $exchange);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg){
    echo ' [x] Received ', $msg->body, "\n";
    //$msg->ack();
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);;

};

$channel->basic_consume($queue_name, '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
