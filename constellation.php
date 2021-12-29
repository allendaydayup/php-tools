<?php

class ConstellationTool
{
    /**
     * 根据生日获取星座
     * @param $birth
     * @return mixed|string
     */
    public static function getZodiacSign($birth)
    {
        $month = date('m', $birth);
        $day = date('d', $birth);
        $signs = [
            ["20" => "水瓶座"],
            ["19" => "双鱼座"],
            ["21" => "白羊座"],
            ["20" => "金牛座"],
            ["21" => "双子座"],
            ["22" => "巨蟹座"],
            ["23" => "狮子座"],
            ["23" => "处女座"],
            ["23" => "天秤座"],
            ["24" => "天蝎座"],
            ["22" => "射手座"],
            ["22" => "摩羯座"]
        ];
        $signStart = array_key_first($signs[$month - 1]);
        $signName = $signs[$month - 1][$signStart];
        if ($day < $signStart) {
            $sign = array_values($signs[($month - 2 < 0) ? $month = 11 : $month -= 2]);
            $signName = array_shift($sign);
        }
        return $signName;
    }

}