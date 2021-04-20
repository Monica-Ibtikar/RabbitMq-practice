<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq2', 5672, 'guest', 'guest');
$channel = $connection->channel();

$queueName = "task_queue2";

//$channel->queue_declare($queueName, false, false, false, false);
$channel->queue_declare($queueName, false, true, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}
$msg = new AMQPMessage(
    $data
    , array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);

$routingKey = $queueName;
$channel->basic_publish($msg, '', $routingKey);

echo ' [x] Sent ', $data, "\n";

$channel->close();
$connection->close();

?>
