<?php
/****************ESTADO DO USER*************/
define('TIMEZONE', 'Africa/Luanda');
date_default_timezone_set(TIMEZONE);
function last_seen($date_time)
{
    $time_stamp = strtotime($date_time);#PESQUISAR A FUNÇÃO DO MÉTODO strtotime()
    $strTime = array("second", "minute", "hour", "day", "month", "year");
    $length = array("60", "60", "24", "30", "12", "10");
    $currentTime = time();#PESQUISAR A FUNÇÃO DO MÉTODO time();
    if ($currentTime >= $time_stamp) {
        $diff = time() - $time_stamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        if ($diff < 59 && $strTime[$i] == "second") {
            return 'Ativo';
        } else {
            return $diff . "" . $strTime[$i] . "(s) ago";
        }
    }
}

?>