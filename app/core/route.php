<?

session_start();


/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{

	static function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'home';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		array_shift($routes);
		
		// получаем имя контроллера
		if ( !empty($routes[0]) )
		{	
			$controller_name = array_shift($routes);
		}
		
		// получаем имя экшена
		if ( !empty($routes[0]) )
		{
			$action_name = array_shift($routes);
		}
		
		if (!empty($action_name))
		{
			$_params = array();
			for ($i = 0; $i < count($routes); $i++)
			{
				$_params[$routes[$i]] = $routes[++$i];
			}
			$_POST['_params'] = $_params;
		}

		//echo $action_name;
		
		// добавляем префиксы
		//$model_name = 'Model_'.$controller_name;
		$controller_name = 'controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		/*
		echo "Model: $model_name <br>";
		echo "Controller: $controller_name <br>";
		echo "Action: $action_name <br>";
		*/

		// подцепляем файл с классом модели (файла модели может и не быть)

		/*$model_file = strtolower($model_name).'.php';
		$model_path = "app/models/".$model_file;
		if(file_exists($model_path))
		{
			include "app/models/".$model_file;
		}*/

		// подцепляем файл с классом контроллера
		
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "app/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "app/controllers/".$controller_file;
		}
		else
		{
			/*
			 правильно было бы кинуть здесь исключение,
			 но для упрощения сразу сделаем редирект на страницу 404
			 */
			Route::Redirect(1,'404 <br/> Запрашиваемая страница не существует ('.urldecode($controller_name).').', '/404');
		}
		
		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))
		{
			// вызываем действие контроллера
			$controller->$action();
		}
		else
		{
			// здесь также разумнее было бы кинуть исключение
			//echo $action_name;
			//exit();
			Route::Redirect(1,'404 <br/> Запрашиваемая страница не существует ('.urldecode($action_name).').', '/404');
		}
	}

	public static function Redirect($type = 0, $message = '', $path = '')
	{
		$_SESSION['message_type']=$type;
		$_SESSION['message'] = $message;	
		
		if 	(!empty($path)) $_SERVER['HTTP_REFERER'] = $path;
		exit (header('Location: '.$_SERVER['HTTP_REFERER']));
	}
	
	public static function MessageShow ()
	{
		if(!empty($_SESSION['message'])&&!empty($_SESSION['message_type']))
		{
			$msg = View::messageFrame($_SESSION['message'],$_SESSION['message_type']);
			
			$_SESSION['message_type'] = []; unset($_SESSION['message_type']);
			$_SESSION['message'] = []; unset($_SESSION['message']);
			return $msg;
		}
	}
    
}

