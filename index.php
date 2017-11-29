<?php
require_once __DIR__ .'/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

foreach ($events as $event) {
//  replyTextMessage($bot, $event->getReplyToken(), 'TextMessage');
//  replyImageMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/imgs/original.jpg', 'https://' . $_SERVER['HTTP_HOST'] . 'imgs/preview.jpg');
//  replyLocationMessage($bot, $event->getReplyToken(), 'LINE', '東京都渋谷区渋谷2-21-1 ヒカリエ27階', '35.659025', '139.703473');
  replyStickerMessage($bot, $event->getReplyToken(), 1, 1);  
  
}

function replyTextMessage($bot, $replyToken, $text) {
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text));

  if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
  
}

function replyImageMessage($bot, $replyToken, $originalImageUrl, $previewImageUrl) {
  $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalImageUrl, $previewImageUrl));
  
  if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}
  
  function replyLocationMessage($bot, $replyToken, $title, $address, $lat, $lon) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder($title, $address, $lat, $lon));
  
  if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
  }  
}

  function replyStickerMessage($bot, $replyToken, $packageId, $stickerId) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder($packageId, $stickerId));

  if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
  }      
    
}

?>
