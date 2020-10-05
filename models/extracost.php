<?

session_start();

class ExtraCosts extends Model{
	
	private static $_singleton;
	
	public static function getInstance() {
		if(!self::$_singleton) {
			self::$_singleton = new ExtraCosts();
		}
		return self::$_singleton;
	}
	
	public function getAll(){
		$costs = $this->db->select_query('food_extra_cost','name,cost',null,'ORDER BY name');
		return $costs;
	}
	
	
}

?>