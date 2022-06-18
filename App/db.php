<?php


namespace App;


class Db
{
    private \PDO $dbh;

    public function __construct(array $params=_Config::database)
    {
        if ($this->checkParam($params)===false) {
            throw new \Exception('параметры подключения к БД не найдены в config файле!');
        }
        $this->checkDataBase(new \PDO($params['type'] . ':host=' . $params['host'], $params['login'], $params['passwd'], [\PDO::ATTR_PERSISTENT => false]),$params['db'],$params['login'],$params['type']);

        $this->dbh = new \PDO($params['type'] . ':host=' . $params['host'] . ';dbname=' . $params['db'], $params['login'], $params['passwd'], [\PDO::ATTR_PERSISTENT => false]);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->checkRepositoryTable($params['db'],'repo',$params['login'], $params['type']);
    }
    //проверка параметров для работы с БД
    private function checkParam(array $prm):bool {
        if (empty($prm['host']) || !isset($prm['host'])) return false;
        if (empty($prm['login']) || !isset($prm['login'])) return false;
        if (empty($prm['passwd']) || !isset($prm['passwd'])) return false;
        if (empty($prm['db']) || !isset($prm['db'])) return false;
        if (empty($prm['type']) || !isset($prm['type'])) return false;
        if (strlen($prm['type']) !=5) return false;
        if (mb_stristr('pgsql',$prm['type'])===false && mb_stristr('mysql',$prm['type'])===false) return false;
        return true;
    }
    //проверяем существоание БД если нет создаем ее
    private function checkDataBase(\PDO $dbchk, string $dbname, string $dbuser, string $type) {
       mb_stristr('mysql',$type)!==false ? $sql="SELECT exists(select schema_name FROM information_schema.schemata WHERE schema_name = '$dbname') as found;" : $sql= "SELECT exists(SELECT datname FROM pg_database WHERE datname='$dbname') as found;";
       $chk=$dbchk->query($sql,\PDO::FETCH_ASSOC);
       $chk=$chk->fetch(\PDO::FETCH_ASSOC);
       if ($chk['found']==0  || $chk['found']===false){
          //создаем БД
           mb_stristr('mysql',$type)!==false ? $sql="CREATE DATABASE IF NOT EXISTS ".$dbname." CHARACTER SET = 'utf8mb3';" : $sql="CREATE DATABASE $dbname WITH OWNER = $dbuser ENCODING = 'UTF8' CONNECTION LIMIT = -1;";
           $dbchk->exec($sql);
       }
       $dbchk=$chk=null;
       return true;
    }
    //проверяем существоание в БД таблицы если нет создаем ее
    private function checkRepositoryTable(string $dbname, string $table, string $dbuser, string $type) {
        if (mb_stristr('mysql',$type)!==false) {
            $res = $this->query("SHOW TABLES FROM `$dbname` like '$table';");
            if ($res === false || empty($res)) {
                $sql = "CREATE TABLE IF NOT EXISTS `$dbname`.`$table` ( `id` INT NOT NULL AUTO_INCREMENT , `stroka` TEXT NULL DEFAULT NULL , `resultat` LONGTEXT NULL DEFAULT NULL , PRIMARY KEY (`id`))";
                if (mb_stristr('mysql', $type) !== false) $sql .= " ENGINE = InnoDB;";
                $this->dbh->exec($sql);
            }
        }
        //если БД Postgres то проверяем и создаем еще и схему
        if (mb_stristr('pgsql',$type)!==false) {
            //проверка схемы
            $chk=$this->query("SELECT exists(select schema_name FROM information_schema.schemata WHERE schema_name = 'repository') as found;");
            if ($chk[0]['found']==0 || $chk[0]['found']===false){
                //создаем БД
                $sql="CREATE SCHEMA repository AUTHORIZATION $dbuser;";
                $this->query($sql);
            }
            //проверка таблицы
            $chk=$this->query("SELECT EXISTS(SELECT table_name FROM information_schema.tables WHERE table_schema = 'repository' AND table_name='repo') as found;");
            if ($chk[0]['found']==0 || $chk[0]['found']===false){
                //создаем БД
                $sql="CREATE TABLE repository.repo(id serial NOT NULL, stroka text, resultat text, PRIMARY KEY (id)) WITH (OIDS = FALSE) TABLESPACE pg_default; ALTER TABLE IF EXISTS repository.repo OWNER to $dbuser;";
                $this->dbh->exec($sql);
            }
        }
        $res=$sql=null;
        return true;
    }
    //Выполнение запросов к БД
    public function query(string $sql, array $params = []):array  {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}