<?php
require_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR. 'App' .DIRECTORY_SEPARATOR .'_config.php';

try {
    $controller = (new \App\RepoController())
        ->setFindReposytory(
        (new \App\FindRepository())
            ->setDb(new \App\Db())
    );
    $controller->runRender();
} catch (Throwable $exception) {
    echo 'Ошибка: ' . $exception->getMessage().'<BR>';
}

?>
