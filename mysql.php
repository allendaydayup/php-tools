<?php
namespace tool;

class MysqlTool
{
    /**
     * mysql批量写入
     * @param $multipleData
     * @param $tableName
     * @return mixed
     */
    public static function batchUpdate($multipleData, $tableName)
    {
        $firstRow = current($multipleData);

        $updateColumn = array_keys($firstRow);
        $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
        unset($updateColumn[0]);
        // 拼接sql语句
        $updateSql = "UPDATE " . $tableName . " SET ";
        $sets = [];
        $bindings = [];
        foreach ($updateColumn as $uColumn) {
            $setSql = '"' . $uColumn . '" = CASE ';
            foreach ($multipleData as $data) {
                $setSql .= 'WHEN "' . $referenceColumn . '" = ? THEN ? ';
                $bindings[] = $data[$referenceColumn];
                $bindings[] = $data[$uColumn];
            }
            $setSql .= 'ELSE "' . $uColumn . '" END ';
            $sets[] = $setSql;
        }
        $updateSql .= implode(', ', $sets);
        $whereIn = collect($multipleData)->pluck($referenceColumn)->values()->all();
        $bindings = array_merge($bindings, $whereIn);
        $whereIn = rtrim(str_repeat('?,', count($whereIn)), ',');
        $updateSql = rtrim($updateSql, ", ") . ' WHERE "' . $referenceColumn . '" IN (' . $whereIn . ")";
        return DB::connection('myProject')->update($updateSql, $bindings);
    }

}