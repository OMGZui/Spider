<?php
/**
 * Created by PhpStorm.
 * User: shengj
 * Date: 2017/8/27
 * Time: 19:29
 */
namespace Database;

trait Builder
{
    private $query_list = [];
    protected $lastSql;

    /**
     * 魔术方法，用于调用未声明的方法
     *
     * @param $name
     * @param $args
     * @return $this
     */
    public function __call($name, $args)
    {
        $func  = array('table', 'where', 'order', 'limit', 'data', 'field', 'join', 'group', 'having');
        if(in_array($name, $func)) {

            if($name === 'limit') {
                if(!$args[1]) {
                    $args[1] = $args[0];
                    $args[0] = 0;
                }
                $this->query_list['limit'] = ' limit ' . $args[0] . ',' . $args[1];
                return $this;
            }

            $this->query_list[$name] = $args[0];
            return $this;
        } else {
            die('调用函数出错，请重试！');
        }
    }

    /**
     * 新增方法
     *
     * @return mixed
     */
    public function add()
    {
        // insert into films (title,subtitle) values ('夏洛克','夏洛克和华生嘿嘿嘿')
        $sql = 'insert into '. $this->query_list['table'];
        $field = '';
        $value = '';
        foreach ($this->query_list['data'] as $key => $val){
            $field .= $key.',';
            $value .= '\''.$val.'\',';
        }
        $sql .= ' ('.rtrim($field,',').')'.' values '.'('.rtrim($value,',').')';

        return $this->execute($sql);
    }

    /**
     * 选取数据表
     *
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->query_list['table'] = $table;
        return $this;
    }

    /**
     * 获取最后一条sql
     *
     */
    public function getLastSql()
    {
        echo $this->lastSql;
    }

}