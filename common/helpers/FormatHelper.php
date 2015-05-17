<?php
class FormatHelper{
    public static function formatTime($time){
        if(!is_long($time)){
            $time = strtotime($time);
        }
        return Yii::app()->params['day.of.week'][date('N',$time)].date(' d/m/Y h:i a',$time);
    }

    public static function formatDuration($duration){
        if(!$duration)return "00:00";
        $minute= floor($duration/60);
        $second = $duration % 60;
        return ($minute<10?'0'.$minute:$minute).':'.($second<10?'0'.$second:$second);
    }
    public static function formatDayOfWeek($datetime)
    {
        $dayOfWeek = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
        $dayOfWeekVn = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');//array('Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy','Chủ nhật');
        $dateString = date("D, d/m/Y", strtotime($datetime));
        //return str_replace($dayOfWeek, $dayOfWeekVn, $dateString);
        return $dateString;
    }
    static public function formatTimeAgo($time)
    {
        if(!is_long($time))
        {
            $time = strtotime($time);
        }
        $timeDiff = time() - $time;
        if ($timeDiff < 60)
        {
            return Yii::t('web','một phút trước');
        }
        else
        {
            if ($timeDiff < 3600)
            {
                $min = round($timeDiff/60);
                return Yii::t('web','{minute} phút trước',array('{minute}'=>$min));
            }
            else if ($timeDiff < 86400)
            {
                $hour = round($timeDiff/3600);
                return Yii::t('web','{hour} giờ trước',array('{hour}'=>$hour));
            }
            else if ($timeDiff < 2592000)
            {
                $day = round($timeDiff/86400);
                return Yii::t('web','{day} ngày trước',array('{day}'=>$day));
            }
            else if ($timeDiff < 31536000)
            {
                $month = round($timeDiff/2592000);
                return Yii::t('web','{month} tháng trước',array('{month}'=>$month));
            }
            else
            {
                $year = round($timeDiff/31536000);
                return Yii::t('web','{year} năm trước',array('{year}'=>$year));
            }
        }
        return '';
    }

    static public function substring($string, $space, $numspace, $max = 1000){
        return self::smartCut($string,$max);
    }
    static public function smartCut($text,$limit=12,$start=0,$surfix='...')
    {
        $text = trim($text);
        if (function_exists('mb_substr')) {
            $more = (mb_strlen($text,'utf-8') > $limit)?true : false;
            $text = mb_substr($text, 0, $limit, 'UTF-8');
            $val = array($text, $more);
        } elseif (function_exists('iconv_substr')) {
            $more = (iconv_strlen($text) > $limit) ? true : false;
            $text = iconv_substr($text, 0, $limit, 'UTF-8');
            $val = array($text, $more);
        } else {
            preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);
            if(func_num_args() >= 3) {
                if (count($ar[0])>$limit) {
                    $more = true;
                    $text = join("",array_slice($ar[0],0,$limit))."...";
                }
                $more = true;
                $text = join("",array_slice($ar[0],0,$limit));
            } else {
                $more = false;
                $text =  join("",array_slice($ar[0],0));
            }
            $val =  array($text, $more);
        }
        return ($val[1])? $val[0].$surfix : $val[0];
    }

    public static function clean($string) {
        /* $regExpression = "`\W`i";
        $string = preg_replace( array($regExpression, "`[-]+`",) , " ", $string); */
        $string = preg_replace('/[^0-9\-\pL.\s\'\(\)\/]/u', '', $string);
        return $string;
    }

    public static function time_elapsed($secs){
        $bit = array(
            ' year'      => $secs / 31556926 % 12,
            ' week'      => $secs / 604800 % 52,
            ' day'       => $secs / 86400 % 7,
            ' hour'      => $secs / 3600 % 24,
            ' minute'    => $secs / 60 % 60,
            ' second'    => $secs % 60
        );

        foreach($bit as $k => $v){
            if($v > 1)$ret[] = $v . $k . 's';
            if($v == 1)$ret[] = $v . $k;
        }
        array_splice($ret, count($ret)-1, 0, 'and');
        $ret[] = 'ago.';

        return join(' ', $ret);
    }
}
