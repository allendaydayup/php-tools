<?php
namespace tool;

class TimeTool
{
    /**
     * 时间格式化
     * @param $timestamp
     * @return string
     */
    public static function formatTimestampForClient($timestamp)
    {
        $formatString = '';
        $now = time();
        //一个小时内
        $diffTime = $now - $timestamp;
        if ($diffTime < 60) {
            $formatString = '刚刚';
        } else if ($diffTime < 3600) {
            $formatString = intval($diffTime / 60) . "分钟前";
        } else if ($diffTime < 12 * 3600) {
            $formatString = intval($diffTime / 3600) . "小时前";
        } else if ($diffTime < 24 * 3600) {
            $formatString = "1天内";
        } else if ($diffTime < 3 * 24 * 3600) {
            $formatString = "3天内";
        }

        return $formatString;
    }

    //获取N天的0点时间戳
    public static function getNDayTimestamp($n = 1)
    {
        return strtotime(date('Y-m-d', strtotime('+' . $n . ' day')));
    }

    //获取N天前0点时间戳
    public static function getBeforeNDayTimestamp($n = 1)
    {
        return strtotime(date('Y-m-d', strtotime('-' . $n . ' day')));
    }

}