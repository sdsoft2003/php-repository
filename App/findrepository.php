<?php


namespace App;


class FindRepository
{
    private $apiurl;
    private DB $db;
    private string $table;

    public function __construct()
    {
        $this->apiurl = _Config::githubapiurl;
        mb_stristr('mysql',_Config::database['type'])!==false ? $this->table=_Config::database['table'] : $this->table=_Config::database['schema']._Config::database['table'];
    }

    public function setDb(DB $db):self {
        $this->db=$db;
        return $this;
    }

    //поиск материала на GITHUB
    private function findInGithub(string $search) {
        $url=$this->apiurl.urlencode($search);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERAGENT,'test App');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $server_output = curl_exec($ch);
        if($server_output=== false)
        {
            throw new \Exception(curl_error($ch));
        }else{
            $res=$server_output;
            $res=str_replace(array("\n", "\r", "\t","<b>","</b>","<br>","\xEF\xBB\xBF"), '', $res);
            $res=json_decode($res,true);
        }
        curl_close ($ch);
        $items=[];
        foreach ($res['items'] as $card) {
            $items[]=[
                'proekt'=>$card['name'],
                'owner'=>$card['owner']['login'],
                'stargazers'=>$card['stargazers_count'],
                'watchers'=>$card['watchers_count'],
                'link'=>$card['html_url']
            ];
        }
        $this->saveSearch($search, $items);
        return $items;
    }
    //поиск материала в БД
    private function findInDB(string $search) {
        $resdb = $this->db->query("SELECT resultat FROM $this->table WHERE stroka LIKE '%".$search."%';");
        return !empty($resdb) ? json_decode($resdb[0]['resultat'],true) : [];
    }
    //запись результата поиска в БД
    private function saveSearch(string $search, array $items){
        $sql = "INSERT INTO $this->table (stroka, resultat) VALUES( '". $search."'"." ,"."'".json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION). "');";
        $this->db->query($sql);
    }
    //функция поиска материал
    public function find(string $search){
        $fnd=$this->findInDB($search);
        if (empty($fnd)) $fnd=$this->findInGithub($search);
        return $fnd;
    }
    //вывод всех результатов поиска для API
    public function getAllrepo(){
        $resdb = $this->db->query("SELECT * FROM $this->table;");
        return $resdb;
    }
    //удаление результата поиска по ID
    public function deleteId(int $id){
        $resdb = $this->db->query("SELECT EXISTS(SELECT * FROM repo where id=$id) as found;");
        if ($resdb[0]['found']==0 || $resdb[0]['found']===false) return 'ошибка: запись не существует!';
        $resdb = $this->db->query("DELETE FROM $this->table WHERE id=$id;");
        return empty($resdb) ? 'ok' : $resdb;
    }
}