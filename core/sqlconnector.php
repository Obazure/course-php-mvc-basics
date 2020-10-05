<?

session_start();

class SQLCONNECTOR
{
	
	private static $_singleton;
	
	private $result = array(); 
	
	public static function getInstance() {
		if(!self::$_singleton) {
			self::$_singleton = new SQLCONNECTOR();
		}
		return self::$_singleton;
	}
	
	private function __construct()
	{
		if(!$this->con)
		{
			$this->result = '';
			include ('sqlconnector.config.php');
			
			$myconn = @mysql_connect($db_host, $db_user, $db_pass);
			
			if($myconn)
			{
				$seldb = @mysql_select_db($db_name,$myconn);
				if($seldb)
				{
					mysql_query("set names utf8");
					mysql_query("SET GLOBAL time_zone = 'Asia/Almaty';");
					mysql_query("SET time_zone = 'Asia/Almaty';");
					$this->con = true;
					return true;
				} else
				{
					return false;
				}
			} else
			{
				return false;
			}
		} else
		{
			return true;
		}
	}
		
    public function disconnect()
	{
		$this->result = '';
		if($this->con)
		{
			if(@mysql_close())
			{
				$this->con = false;
				return true;
			}else
			{
				return false;
			}
		}
	}

	public function getResult() 
	{ 
		return $this->result;
	}

	public function select_query ($table,$select=' * ', $where='', $string='')
	{
		$this->result = '';
		
		if(!empty($where)){
			$wherevalues = array_map('mysql_real_escape_string', array_values($where));
			$wherekeys = array_keys($where);
			$where = ' WHERE ';
		
			for($i=0,$size=sizeof($wherekeys);$i<$size;$i++){
				$where.= '`'.$wherekeys[$i].'`=\''.$wherevalues[$i].'\' ';
				if(!empty($wherekeys[$i+1])) $where.= ' AND ';
			}
		}
			
		$query = @mysql_query('SELECT '.$select.' FROM '.$table.' '.$where.' '.$string);
		if ($query==null)return false;
		return ($this->fetchAndSetResult($query));
	}
	
	public function sql_query ($string){
		$this->result = '';
		
		$query = @mysql_query($string);
		if($query==true)return true;
		if($query==false)return false;
		return ($this->fetchAndSetResult($query));
	}
	
	function insert_query($table, $inserts) {
		$values = array_map('mysql_real_escape_string', array_values($inserts));
		$keys = array_keys($inserts);
		mysql_query('INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')');
		return mysql_insert_id();
	}
	
	function update_query($table, $inserts, $where){


		$values = array_map('mysql_real_escape_string', array_values($inserts));
		$keys = array_keys($inserts);
		
		$tmp = '';
for($i=0, $size=sizeof($values); $i<$size; $i++)
{
 $tmp .= ' '.$keys[$i].'=\''.$values[$i].'\' ';
if(!empty($values[$i+1]) and $values[$i+1]!='') $tmp .= ', ';
}
$inserts = $tmp; 
		
			$wherevalues = array_map('mysql_real_escape_string', array_values($where));
			$wherekeys = array_keys($where);
			$where = ' WHERE ';
		
			for($i=0,$size=sizeof($wherekeys);$i<$size;$i++){
				$where.= '`'.$wherekeys[$i].'`=\''.$wherevalues[$i].'\' ';
				if(!empty($wherekeys[$i+1])) $where.= ' AND ';
		}
		
$str = 'UPDATE `'.$table.'` SET '.$inserts.' '.$where;
	 mysql_query($str);
		
		return true;
	}
	
	public function execute_query ($query)
	{
		$this->result = '';
		return $query = (@mysql_query($query)) ? true : false;
	}
	
	
	public function execute_select_query ($table,$select=' * ', $string)
	{
		$this->result = '';
		$query = 'SELECT '.$select.' FROM '.$table.' '.$string;
		$query = @mysql_query($query);
		return ($this->fetchAndSetResult($query));
	}
	
	/*
	 * Вставляем значения в таблицу
	 * Требуемые: table (наименование таблицы)
	 *            values (вставляемые значения, передается массив  значений, например,
	 * array(3,"Name 4","this@wasinsert.ed"); )
	 * Опционально:
	 *             rows (название столбцов, куда вставляем значения, передается строкой,
	 *            например, 'title,meta,date'
	 *
	 */
	
	private function fetchAndsetResult($query){
		if($query)
		{
			unset ($this->result);
		
			$this->numResults = mysql_num_rows($query);
			for($i = 0; $i < $this->numResults; $i++)
			{
				$r = mysql_fetch_array($query);
				$key = array_keys($r);
				for($x = 0; $x < count($key); $x++)
				{
					// Sanitizes keys so only alphavalues are allowed
					if(!is_int($key[$x]))
					{
						if(mysql_num_rows($query) > 1)
							$this->result[$i][$key[$x]] = $r[$key[$x]];
							else if(mysql_num_rows($query) < 1)
								$this->result = null;
								else
									$this->result[$key[$x]] = $r[$key[$x]];
					}
				}
			}
			$rtn = true;
		}
		else $rtn = false;
		if ($rtn==true) return $this->getResult();
		return $rtn;
	}
	

}  
?>
