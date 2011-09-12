<?php

/**
 * 
 * @author KNIGHTRCOM
 *
 */
class DBUtil {

    /**
     * @param $table string table name
     * @param $data  array  e.g. array(col => val, col=> DBUtil::makeSqlFuncExp(val) ...)
     * @return int
     */
    public static function insert($table, $data) {

        $columns = implode(array_keys($data));
        $values = array();
        foreach ($data as $col => $val) {
            // 字符、数字、日期等类型均用字符串表示形式
            if ($val === null) {
                $values[] = 'NULL';
            } else if (is_array($val)) {
                $values[] = $val[0];
            } else {
                $values[] = $this->quote($val);
            }
        }
        $values = implode($values);
        $sqlStatement = "INSERT INTO $table($columns) VALUES($values)";
        mypdo()->exec($sqlStatement);
        return mypdo()->lastInsertId();
    }

//    public function update($table, $data) {
//        $sqlStatement = "INSERT INTO $table($columns) VALUES($values)";
//    }
//    
//    public function delete($table, $data) {
//        $sqlStatement = "INSERT INTO $table($columns) VALUES($values)";
//    }

    public static function &makeSqlFuncExp($data) {
        return array($data);
    }
    
    private function quote($data) {
        mypdo()->quote($data);
    }
}

/**
 * 简化初始化与命名
 * 
 * @return PDO
 */
function mypdo() {
    static $pdo = null;
    if (!$pdo) {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    }
    return $pdo;
}