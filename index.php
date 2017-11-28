<?php
require_once __DIR__ .'/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

$signiture = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$event = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

foreach ($events as $event) {
  $bot->replyText($event->getReplyToken(), 'TextMessage');
}

?>
