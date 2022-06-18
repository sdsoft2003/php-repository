<?php


namespace App;


class RepoController
{
    private FindRepository $findRepository;

    public function setFindReposytory(FindRepository $findRepository):self
    {
        $this->findRepository=$findRepository;
        return $this;
    }

    public function runRender() {
        $value='';
        if(isset($_POST['search']) && !empty($_POST['search'])){$value=trim($_POST['search']);}
        $ui = new \App\ui();
        $ui->div_open('','container py-5');
        $ui->row_open();
        $ui->col_open('',"mx-auto","col-auto");
        $ui->form_open('','post');
        $ui->input_find("search","search","","","Введите запрос",false,$value);
        $ui->form_close();
        $ui->col_close();
        $ui->row_close();
        if (!empty($value) || $value!=''){
            $result=$this->findRepository->find($value);
            $ui->div_open("results", "row d-flex flex-wrap justify-content-around");
            foreach ($result as $card) {
                $ui->card_result($card['proekt'], $card['owner'], $card['stargazers'], $card['watchers'], $card['link']);
            }
            $ui->div_close();
        }
        $ui->div_close();
        $ui->draw();
    }
}