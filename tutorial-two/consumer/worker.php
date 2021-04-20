<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq2', 5672, 'guest', 'guest');
$channel = $connection->channel();

$queueName = "task_queue2";

//$channel->queue_declare($queueName, false, false, false, false);
$channel->queue_declare($queueName, false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg){
    echo ' [x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done\n";

    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);;

};

$channel->basic_qos(null, 1, null);

//$channel->basic_consume($queueName, '', false, true, false, false, $callback);
$channel->basic_consume($queueName, '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
