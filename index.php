<?php
require_once __DIR__ .'/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));

$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

foreach ($events as $event) {
  replyTextMessage($bot, $event->getReplyToken(), 'TextMessage');
//  replyImageMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/imgs/original.jpg', 'https://' . $_SERVER['HTTP_HOST'] . 'imgs/preview.jpg');
//  replyLocationMessage($bot, $event->getReplyToken(), 'LINE', '東京都渋谷区渋谷2-21-1 ヒカリエ27階', '35.659025', '139.703473');
//  replyStickerMessage($bot, $event->getReplyToken(), 1, 1);  
//  replyVideoMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/videos/sample.mp4', 'https://' . $_SERVER['HTTP_HOST'] . '/videos/sample_preview.jpg');
//  replyAudioMessage($bot, $event->getReplyToken(), 'https://' . $_SERVER['HTTP_HOST'] . '/audios/sample.m4a', 6000);
//  replyMultiMessage($bot, $event->getReplyToken(), 
//          new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('TextMessage'),
//          new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder('https://'.$_SERVER['HTTP_HOST'].'/imgs/original.jpg', 'https://'.$_SERVER['HTTP_HOST'].'/imgs/preview.jpg'),
//          new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder('LINE', '渋谷区渋谷2-21-1 ヒカリエ27階', 35.659025, 139.703473),
//          new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1, 1)); 
/*
  if($event instanceof \LINE\LINEBot\Event\PostbackEvent) {
      replyTextMessage($bot, $event->getReplyToken(), 'Postback受信「'.$event->getPostbackData().'」');
      continue;
    }
  replyButtonTemplate($bot, $event->getReplyToken(), 'お天気お知らせ- 今日はお天気は晴れです', 'https://'.$_SERVER['HTTP_HOST'].'/imgs/template.jpg', 'お天気お知らせ', '今日は天気は晴れです', 
          new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('明日の天気', 'Tomorrow'),
          new LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('週末の天気', 'weekend'),
          new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('Webで見る', 'http://google.jp')
        );
 * 
 */
/*
  replyConfirmTemplate($bot, $event->getReplyToken(), 'Webで詳しく見ますか？', 'Webで詳しく見ますか？',
          new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder('見る', 'http://google.jp'),
          new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('見ない', 'ignore')
        );
 * 
 */

/*  
  $columnArray = array();
  for($i=0; $i < 5; $i++) {
    $actionArray = array();
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('ボタン'.$i.'-1', 'c-'.$i.'-1'));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('ボタン'.$i.'-2', 'c-'.$i.'-2'));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder('ボタン'.$i.'-3', 'c-'.$i.'-3'));
  
   $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder(
           ($i+1) . '日後の天気', '晴れ', 'https://'.$_SERVER['HTTP_HOST'].'/imgs/template.jpg',
           $actionArray);
   array_push($columnArray, $column);
    }
    
    replyCarouselTemplate($bot, $event->getReplyToken(), '今後の天気予報', $columnArray);
*
*/  
  
//  if ($event instanceof \LINE\LINEBot\Event\MessageEvent\ImageMessage) {
/*    $content = $bot->getMessageContent($event->getMessageId());
    $headers = $content->getHeaders();
    error_log(var_export($headers,true));
    $directory_path = 'tmp';
    $filename = uniqid();
    $extension = explode('/', $headers['Content-Type'])[1];
    if(!file_exists($directory_path)) {
      if(mkdir($directory_path, 0777, true)) {
        chmod($directory_path, 0777);
      }
    }
    
    file_put_contents($directory_path . '/' . $filename . '.' . $extension, $content->getRawBody());
    
    replyTextMessage($bot, $event->getReplyToken(), 'https://'.$_SERVER['HTTP_HOST'].'/'.$directory_path.'/'.$filename.'.'.$extension);
 * 
 */
 /*
    $profile = $bot->getProfile($event->getUserId())->getJSONDecodedBody();
    $bot->replyMessage($event->getReplyToken(), 
            (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
            ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('現在のプロフィールです'))
            ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('表示名:'.$profile['displayName']))
            ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('画像URL:'.$profile['pictureUrl']))
            ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('ステータスメッセージ:'.$profile['statusMessage']))
      );
  }
*/ 
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

  function replyVideoMessage($bot, $replyToken, $originalContentUrl, $previewImageUrl) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder($originalContentUrl, $previewImageUrl));
  
  if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
  }   
}

  function replyAudioMessage($bot, $replyToken, $originalContentUrl, $audioLength) {
    $response = $bot->replyMessage($replyToken, new \LINE\LINEBot\MessageBuilder\AudioMessageBuilder($originalContentUrl, $audioLength));
  
  if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
  }  
}

  
  function replyMultiMessage($bot, $replyToken, ...$msgs) { ///...$msgsは可変長引数
    $builder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
    
    foreach($msgs as $value) {
      $builder->add($value);
    }
    $response = $bot->replyMessage($replyToken, $builder);
    
    if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
    }    
}


  function replyButtonTemplate($bot, $replyToken, $alternativeText, $imageUrl, $title, $text, ...$actions) {
    
    $actionArray = array();
    
    foreach ($actions as $value) {
      array_push($actionArray, $value);
    }
    
    $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText, 
            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder($title, $text, $imageUrl, $actionArray)
    );
    
    $response = $bot->replyMessage($replyToken, $builder);

    if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
    }    
    
  }

  function replyConfirmTemplate($bot, $replyToken, $alternativeText, $text, ...$actions) {
    
    $actionArray = array();
    foreach($actions as $value) {
      array_push($actionArray, $value);
    }
    
    $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,
            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder($text, $actionArray)
          );
    
    $response = $bot->replyMessage($replyToken, $builder);
    
    if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
    }
    
  }
  
  function replyCarouselTemplate($bot, $replyToken, $alternativeText, $columnArray) {
    $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder($alternativeText,
            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columnArray)
    );
    $response = $bot->replyMessage($replyToken, $builder);

    if (!$response->isSucceeded()) {
    error_log('Failed!' . $response->getHTTPStatus . ' ' . $response->getRawBody());
    }      
    
  }
  ?>
