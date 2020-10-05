<?

session_start();

class Food extends Model{
	
	private static $_singleton;
	
	public static function getInstance() {
		if(!self::$_singleton) {
			self::$_singleton = new Food();
		}
		return self::$_singleton;
	}
	
	public function getAll(){
		$food = $this->db->select_query('food','id,name,type,cost',null,'ORDER BY type,name');
		$food_type = $this->db->select_query('food_types','id,name');
		for ($i=0,$arrsize = sizeof($food);$i<$arrsize; $i++)
			$food[$i]['type'] = $food_type[$food[$i]['type']-1]['name'];
		return $food;
	}
	
	public function getFoodForToday(){
		$food_for_today = $this->db->execute_select_query('food_for_today','food as id', ' WHERE `timestamp` >=CURDATE()');  
		
		$in = [];
		for($i=0,$size=sizeof($food_for_today);$i<$size;$i++)
		{
			$in[$i] = $food_for_today[$i]['id'];
		}
		return $this->getFoodListWithWhereInArray($in);
	}	
	
	public function getSelectedFoodForTodayWithCost($in){
		$food = $this->getFoodListWithWhereInArray($in);
		if(!empty($food['id']))return array($food);
		return $food;
	}
	
	/*public function getCheckersForFood($food,$user_id){
		#print_r($food);
		for ($i=0,$size=sizeof($food);$i<$size;$i++){
		
			#$tmp_id = $this->db->select_query('food_user_order','food',['food'=>$food[$i]['id'],'user'=>$user_id,'timestamp'=>],' LIMIT 1');
			$tmp_id = $this->db->execute_select_query('food_user_order','food',' WHERE food='.$food[$i]['id'].' AND user='.$user_id.' AND timestamp >=CURDATE() ORDER BY timestamp DESC LIMIT 1');
			if($food[$i]['id'] == $tmp_id['food'])
				$food[$i]['checked']='checked';
		}
		print_r($food);
		return $food;
	}*/
	
	public function checkFoodInMenu($id){
		$isexist = $this->db->select_query('food','id',['id'=>$id],'LIMIT 1');
		if($isexist['id']==$id)
			return true;
			else return false;
	}
	
	public function saveOrder($user, $food, $cost){
		
		#$this->db->execute_query("DELETE FROM `food_user_order` WHERE timestamp < (NOW() - INTERVAL 1 DAY)");
			
		$hash = $this->generateCode(16);
		$time = date('Y-m-d G:i:s');
		for ($i=0,$size=sizeof($food);$i<$size;$i++){
			$this->db->insert_query('food_user_order', ['timestamp'=>$time,'user'=>$user['id'],'food'=>$food[$i]['id'], 'hash'=>$hash]);
		}
		
		$this->db->insert_query('users_payment_store', ['timestamp'=>$time,'user'=>$user['id'],'amount'=>'-'.$cost,'hash'=>$hash]);
		return true;	
	}
	
	public function getOrderedFood($hash){
		$ids = $this->db->select_query('food_user_order','food',['hash'=>$hash]);
		
		if(!empty($ids['food'])) $ids = array($ids);
		
		$tmp_ids = array();
		for ($i=0,$size=sizeof($ids);$i<$size;$i++){
			$tmp_ids[] = $ids[$i]['food'];
		}
		
		$food = $this->getFoodListWithWhereInArray($tmp_ids);
		if(!empty($food['id']))return array($food);
		return $food;
	}
	
	private function getFoodListWithWhereInArray($arr){
		$arr = implode(',',$arr);
		$food = $this->db->execute_select_query('food','id,name,cost,type', ' WHERE `id` IN ('.$arr.') ORDER BY type');
		$food_type = $this->db->select_query('food_types','id,name');
		for ($i=0,$arrsize = sizeof($food);$i<$arrsize; $i++)
			$food[$i]['type'] = $food_type[$food[$i]['type']-1]['name'];
		return $food;
	}
	public function getTypes(){
		$rtn = $this->db->select_query('food_types','id,name','');
		return $rtn;
	}
	
	public function getFood($foodid){
		$foodid +=0;
		$rtn = $this->db->select_query('food','*',['id'=>$foodid],'LIMIT 1');
		return $rtn;
	}
	
	
	public function add($name,$cost,$type){
		$name = $this->makeCharsSecure($name);
		$cost +=0;
		$type +=0;
		$this->db->insert_query('food', ['cost'=>$cost,'type'=>$type,'name'=>$name]);
		
	}
	public function update($id,$name,$cost,$type){
		$name = $this->makeCharsSecure($name);
		$cost +=0;
		$type +=0;
		$this->db->update_query('food',['cost'=>$cost,'type'=>$type,'name'=>$name],['id'=>$id]);
	}	
	
	public function getSetterFoodForToday(){
		$all = $this->getAll();
		$selected = $this->getFoodForToday();
	
		for ($i=0,$allsize = sizeof($all);$i<$allsize; $i++){
			for ($j=0,$selectedsize = sizeof($selected);$j<$selectedsize; $j++){
				if($all[$i]['id']==$selected[$j]['id']){
					$all[$i]['checked']=1;
				}
			}
		}
		
		
		return $all;
	}	
	
	public function setFoodForToday($inserts){
		
		$this->db->execute_query("TRUNCATE `food_for_today`");
		
		for ($i=0,$insertssize = sizeof($inserts);$i<$insertssize; $i++){
			$this->db->insert_query('food_for_today', ['food'=>$inserts[$i]]);
		}
		return true;
	}
}
