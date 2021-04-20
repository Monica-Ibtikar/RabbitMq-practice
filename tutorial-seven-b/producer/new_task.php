<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbitmq7b', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->confirm_select();

$channel->queue_declare('task_queue', false, true, false, false);

$batch_size = 100;
$outstanding_message_count = 0;
$messagesCount = 200;

while ($messagesCount > 0) {
    $data = "Hello World!";
    $msg = new AMQPMessage($data);
    $channel->basic_publish($msg, '', 'task_queue');
    $outstanding_message_count++;
    if ($outstanding_message_count === $batch_size) {
        // uses a 5 second timeout
        $channel->wait_for_pending_acks( 5.000 );
        $outstanding_message_count = 0;
    }
    $messagesCount--;
}
if ($outstanding_message_count > 0) {
    echo "batch > messages\n";
    $channel->wait_for_pending_acks(5.000);
}

$channel->close();
$connection->close();

?>
