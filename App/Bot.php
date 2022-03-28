<?php

namespace App;

class Bot {
    public static $tmGroup    = '-214862049'; //BOTS TEST
//    public static $tmGroup    = '-511435056'; //МедИнфо САЙТ
    public static $tmChannellGroup    = '-214862049'; //BOTS TEST
//    public static $tmChannellGroup    = '-1001592244139'; //МедИнфо Канал
    public static $tmBotToken = '2050004397:AAFxofedHlELG_uQ8YLvGDEJcI29zfmgzqI'; //ff_medinfo_bot

    //https://api.telegram.org/bot2050004397:AAFxofedHlELG_uQ8YLvGDEJcI29zfmgzqI/getUpdates


    public static function sendText($chatId = '', $string = '')
    {
        empty($chatId) && $chatId = self::$tmGroup;

        $params = [
            'chat_id'    => $chatId,
            'text'       => $string,
            'parse_mode' => 'HTML'
        ];

        Helper::botLog($params);

        if (empty($chatId) || empty($string)) {
            return;
        }

        $url = 'https://api.telegram.org/bot' . self::$tmBotToken . '/sendMessage?' . http_build_query($params);

        $proxyUrl = 'http://resonance.com.ua?proxy';

        if ($ch = @curl_init()) {
            curl_setopt($ch, CURLOPT_URL, $proxyUrl);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['url' => $url]));
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
            $data = curl_exec($ch);
            curl_close($ch);
        }

//        if ($ch = @curl_init()) {
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_HEADER, false);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
//            $data = curl_exec($ch);
//            curl_close($ch);
//        }
    }
}