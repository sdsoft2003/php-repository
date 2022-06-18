<?PHP
namespace App;

class _Config
{
	const githubapiurl = "https://api.github.com/search/repositories?q=";  //API Github  
		
	//параметры подключения к базе данных 
	const database = [
            'host' => '',
            'port' => 3306, 	
            'db' => '',        
            'login' => '',
            'passwd' => '',
			'type' => 'mysql' //в переменной type указывается pgsql - если БД postgresql или mysql - для БД mysql
        ];
}

//автозагрузка
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'includes'. DIRECTORY_SEPARATOR .'autoload.php';
