<?php
/**
* Mysql.class.php  MySQL 操作类
*
* @author      fyibmsd <fyibmsd@gmail.com>
* @copyright   phplib 2015-7-17
* @link        https://github.com/fyibmsd/phplib.git
* @version     1.0
*/


class mysql
{
	private $query_list = array();	// 查询条件

	protected $queryId;	// 当前查询ID

	protected $error = '';	// 错误

	protected $lastSql = '';
	/**
	* +----------
	* | 单例模式
	* +----------
	*/
	protected static $instance = NULL;	// 静态属性保证单一的实例

	private function __construct() {}	// 私有，防止被实例化

	private function __clone() {}	// 私有，防止被克隆

	public static function getInstance()
	{
		if(self::$instance == NULL) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	// 连接数据库操作
	public function connect($cfg)
	{
		$link = mysql_connect($cfg[ENV]['host'] . ':' . $cfg[ENV]['port'], $cfg[ENV]['user'], $cfg[ENV]['password'])
		 or die('无法连接数据库:' . mysql_error());
		// 设置字符集、选择数据库、表
		mysql_set_charset($cfg['charset']);
		mysql_select_db($cfg['db']) or die('选择数据库失败!');
		$this->query_list['table'] = $cfg['table'];
		return $link;
	}

	/**
	* +----------
	* | 设置数据对象值
	* | table, where, order, limit, data, field, join, group, having
	* +----------
     * @param $name
     * @param $args
     * @return $this
	*/

	public function __call($name, $args)
	{
		$func  = array('table', 'where', 'order', 'limit', 'data', 'field', 'join', 'group', 'having');
		if(in_array($name, $func)) {

			if($name == 'limit') {
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
	* +----------
	* | 数据操作
	* | add, delete, update, find, findAll
	* +----------
	*/

	// 执行增加操作
	public function add()
	{
		$sql = 'insert into ' . $this->query_list['table'];
		foreach ($this->query_list['data'] as $key => $val) {
			$field .= '`' . $key . '`,';
			$value .= '\'' . $val . '\',';
		}
		$sql .= ' (' . rtrim($field, ',') . ')' . ' values ' . '(' . rtrim($value, ',') . ')';
		
		return $this->execute($sql);
	}

	// 执行删除操作
	public function delete()
	{
		$sql = 'delete from ' . $this->query_list['table'] . ' where ';
		foreach ($this->query_list['data'] as $key => $val) {
			$condition .= '`' . $key . '` = \'' . $val . '\' and ';
		}
		$sql .= rtrim($condition, 'and ');

		return $this->execute($sql);
	}

	// 执行更新操作
	public function update()
	{
		$sql = 'update ' . $this->query_list['table'] . ' set ';
		foreach ($this->query_list['data'] as $key => $val) {
			$value .= '`' . $key . '` = \'' . $val . '\' and ';
		}
		foreach ($this->query_list['where'] as $key => $val) {
			$condition .= '`' . $key . '` = \'' . $val . '\' and '; 
		}
		$sql .= rtrim($value, 'and ') . ' where ' . rtrim($condition, 'and ');

		return $this->execute($sql);
	}

	// 查找一条数据
	public function find()
	{
		$sql = 'select * from ' . $this->query_list['table'];// . ' where ';
		
		foreach ($this->query_list['where'] as $key => $val) {
			$condition .= '`' . $key . '` = \'' . $val . '\' and '; 
		}
		$sql .= rtrim($condition, 'and ');
		return mysql_fetch_assoc($this->execute($sql));
	}

	// 查询多条数据
	public function findAll()
	{
		$sql = 'select * from ' . $this->query_list['table'];
		isset($this->query_list['limit']) ? $sql .= $this->query_list['limit'] : true;
		if($this->query_list['where']) {
			foreach ($this->query_list['where'] as $key => $val) {
				$sql .= ' where ';
				$condition .= '`' . $key . '` = \'' . $val . '\' and ';
			}
		}
		$sql .= rtrim($condition, 'and ');

		$result = $this->execute($sql);
		while($res = @mysql_fetch_assoc($result)) {
			$data[] = $res;
		}
		return $data;
	}
	// 返回记录数
	public function count()
	{
		$sql = 'select count(1) as count from ' . $this->query_list['table'];
		$res = mysql_fetch_assoc($this->execute($sql));
		return intval($res['count']);
	}

	// 执行查询操作
	public function execute($sql)
	{
		$this->lastSql = $sql;
		return mysql_query($sql);
	}

	public function getLastSql()
	{
		echo $this->lastSql;
	}
}