<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/12/21
 * Time: 11:53
 */

if (!function_exists('sort_multi')) {
    /**
     * 数组按值排序
     *
     * @param $result
     * @param $choose
     * @param int $desc
     * @return mixed
     */
    function sort_multi($result, $choose, $desc = SORT_DESC)
    {
        // 取得列的列表
        foreach ($result as $key => $row) {
            $volume[$key] = $row[$choose];
        }

        array_multisort($volume, $desc, $result);
        return $result;
    }
}