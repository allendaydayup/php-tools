<?php
namespace tool;

class GeoTool
{
    /**
     * 计算经纬度
     * @param $geomJson
     * @return string|null
     */
    public static function formatGeomToStr($geomJson)
    {
        if (empty($geomJson)) {
            return null;
        }
        $geomStr = '';
        $data = json_decode($geomJson, true);
        if ($data['lng'] !== '' && $data['lat'] !== '') {
            $geomStr = "POINT({$data['lng']} {$data['lat']})";
        }

        return $geomStr;
    }

    /**
     * 基于经纬度进行计算 坐标之间距离
     * @param $loc1
     * @param $loc2
     * @return false|float|int
     */
    public static function calcDistance($loc1, $loc2)
    {
        if (empty($loc1) || empty($loc2) || count($loc2) != 2 || count($loc1) != 2) {
            return -1;
        }

        $radLat1 = deg2rad(floatval($loc1['lat']));
        $radLat2 = deg2rad(floatval($loc2['lat']));
        $radLng1 = deg2rad(floatval($loc1['lng']));
        $radLng2 = deg2rad(floatval($loc2['lng']));
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137;
        return round($s, 3);
    }

}