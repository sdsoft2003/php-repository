<?PHP
namespace App;

class _Config
{
	const githubapiurl = "https://api.github.com/search/repositories?q=";  //API Github  
		
	//параметры подключения к базе данных 
	const database = [
            'host' => '',
            'port' => , 	
            'db' => '',        
            'login' => '',
            'passwd' => '',
	    'type' => 'mysql', //в переменной type указывается pgsql - если БД postgresql или mysql - для БД mysql
	    'schema' => 'repository', //только при использовании POSTGRESQL
            'table' => 'repo'	
        ];
}

//автозагрузка
include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'includes'. DIRECTORY_SEPARATOR .'autoload.php';
