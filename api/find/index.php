<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'routeam'. DIRECTORY_SEPARATOR. 'App' .DIRECTORY_SEPARATOR .'_config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$method = $_SERVER['REQUEST_METHOD'];
$request = preg_split("//", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
    case 'POST':
        $post = json_decode(file_get_contents('php://input'), true);
        $repo=(new \App\FindRepository())->setDb(new \App\Db());
        echo json_encode($repo->find($post['search']), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION);
    break;
    case 'GET':
        $repo=(new \App\FindRepository())->setDb(new \App\Db());
        echo json_encode($repo->getAllrepo(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION);
    break;
    case 'DELETE':
        $delete=json_decode(file_get_contents('php://input'),true);
        $repo=(new \App\FindRepository())->setDb(new \App\Db());
        echo json_encode(['status'=>$repo->deleteId(intval($delete))], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION);
    break;
    default:
        http_response_code(405);
        echo json_encode(['error'=>$method.' не поддерживается'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION);
}
