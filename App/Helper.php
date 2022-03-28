<?php


namespace App;

class Helper
{
    public static function botLog($data = [])
    {
        $key = 'bot_log_' . date('Y_m_d');

        $log   = get_option($key) ?: [];
        $log[] = array_merge(['time' => date('Y-m-d H:i:s')], $data);
        update_option($key, $log, 0);
    }

    public static function debug()
    {
        global $wpdb;
        //$url = 'https://api.telegram.org/bot475995439:AAFjnfj-rttwIsSmT-VQMpYlq3s-V54ELP4/sendMessage?chat_id=-209581666&text=%D1%82%D0%B5%D1%81%D1%82%0A%2B38+%28000%29+000-00-00%0A%0A%D0%97%D0%B0%D0%BF%D0%BE%D1%80%D0%BE%D0%B6%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D0%BD%D0%B0%D1%8F+%D0%B1%D0%BE%D0%BB%D1%8C%D0%BD%D0%B8%D1%86%D0%B0%0A%D0%9C%D0%A0%D0%A2+%D0%B3%D0%BE%D0%BB%D0%BE%D0%B2%D0%BD%D0%BE%D0%B3%D0%BE+%D0%BC%D0%BE%D0%B7%D0%B3%D0%B0%0A%D0%9C%D0%A0%D0%A2+0%2C3+%D0%A2%D0%B5%D1%81%D0%BB%D0%B0+600+%D0%B3%D1%80%D0%BD%2F1550+%D0%B3%D1%80%D0%BD+%28%D1%81+%D0%BA%D0%BE%D0%BD%D1%82%D1%80%D0%B0%D1%81%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5%D0%BC%29%0A%0A000';


        if(isset($_GET['bot-test'])) {
            Bot::sendText(Bot::$tmGroup, 'test');
        }

        if(isset($_GET['cron-debug'])) {
//            Helper::dump(get_option('cron'));
//            Helper::dump(wp_next_scheduled(Company::$cronTaskRatings));
            Helper::dump(wp_schedule_event(time() + 1, 'monthly', Company::$cronTaskRatings));
//            die();
        }

        if (isset($_GET['bot-log'])) {
            $raw  = $wpdb->get_results("SELECT * FROM $wpdb->options WHERE `option_name` LIKE 'bot_log%' ORDER BY `option_name` DESC");
            $data = [];
            foreach ($raw as $row) {
                $data[$row->option_name] = maybe_unserialize($row->option_value);
            }
            self::dump($data);
        }

        if (isset($_GET['php-info'])) {
            phpinfo();
            die();
        }

        if (isset($_GET['bot-test'])) {
            $url = 'https://api.telegram.org/bot824291007:AAFr1WvP6SGprkNXE8uc3nmcdkVQFf5C_0k/sendMessage?chat_id=-214862049&text=111';

            if ($ch = curl_init()) {
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//                curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_SSLv3);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
                $data = curl_exec($ch);

                var_dump($data);
                var_dump(curl_error($ch));
                var_dump(curl_errno($ch));
                curl_close($ch);
                die();
            }
        }
    }

    public static function replaceUaQuotesToRussian($content = '')
    {
        $ruVersion = ['&#171;', '&#187;'];
        $uaVersion = ['&#8220;', '&#8221;'];

        return str_replace($uaVersion, $ruVersion, $content);
    }

    public static function timezoneUA()
    {
        return new \DateTimeZone('Europe/Kiev');
    }

    public static function timezoneUTC()
    {
        return new \DateTimeZone('UTC');
    }

    public static function dump($data = [], $vardump = false)
    {
        if (!$vardump) {
            ob_get_clean();
            header('Content-Type: application/json');
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            ob_get_clean();
            echo '<pre>';
            echo print_r($data, JSON_PRETTY_PRINT);
            echo '</pre>';
        }

        die();
    }

    public static function urlRemovePage($string = '')
    {
        return preg_replace('/(?:\/page.*)/m', '', $string);
    }
}