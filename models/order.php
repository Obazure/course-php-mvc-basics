<?
session_start();

class Order extends Model{
	private static $_singleton;
	
	private $extra;
	
	public static function getInstance() {
		if(!self::$_singleton) {
			self::$_singleton = new Order();
		}
		return self::$_singleton;
	}
	
	
	public function getPayment($user_id,$order){
		return $this->db->select_query('users_payment_store','*',['user'=>$user_id],' AND hash <> "" ORDER BY timestamp DESC LIMIT '.$order.',1');
	}
		
	public function getPrevOrder($user_id, $current){
		$prev = $current + 1;
		$prevorder = $this->db->select_query('users_payment_store','id',['user'=>$user_id],' AND hash <> "" ORDER BY timestamp DESC LIMIT '.$prev.',1');
		if (!empty($prevorder['id'])) return '/user/account/order/'.$prev;
		return null;
	}
	
	public function getNextOrder($current){
		if ($current <= 0) return null;
		if ($current > 0) return '/user/account/order/'.($current-1).'';
		return '/room/user';
	}
	
	public function getOrdersForToday(){
		$orders = $this->db->execute_select_query('users_payment_store','*',' WHERE `timestamp` >=CURDATE() AND `amount`<0  ORDER BY user');/*AND `closed`=0*/
		
		if($orders[0]=='' and !empty($orders)) $orders = array($orders);
		
		for ($i=0,$size=sizeof($orders);$i<$size;$i++){
			$tmp = $this->db->select_query('users','name',['id'=>$orders[$i]['user']]);
			$orders[$i]['name'] = $tmp['name'];
			
			 $food = $this->db->execute_select_query('food', '*', ' INNER JOIN  `food_user_order` ON  `food_user_order`.`food` =  `food`.`id` 
					WHERE  `food_user_order`.`hash` =  \''.$orders[$i]['hash'].'\'
					AND  `food_user_order`.`closed` = 0');
			 
			 
			 if($food[0]=='' and !empty($food)) $food = array($food);
			 $orders[$i]['food'] = $food;
			 
		}
		
		
		return $orders;
	}
	
	public function getOrdersMinusExtra($orders){
		$this->extra=0;
		
		$costs = $this->db->execute_select_query('food_extra_cost','SUM(cost)',null);
		for($i=0,$size=sizeof($orders);$i<$size;$i++)	
		{
			$orders[$i]['amount'] += $costs['SUM(cost)'];
			$this->extra += $costs['SUM(cost)'];
		}
		
		#if($orders[0]=='')return array($orders);
		return $orders;
	
	}
	public function getExtra(){
		return $this->extra;
	}
	
	public function clearOrder($orderhash){
		$orderhash = $this->makeCharsSecure($orderhash);
		
		$this->db->execute_query('DELETE FROM `users_payment_store` WHERE hash=\''.$orderhash.'\'');
		$this->db->execute_query('DELETE FROM `food_user_order` WHERE hash=\''.$orderhash.'\'');
		return true;
	}
	
}