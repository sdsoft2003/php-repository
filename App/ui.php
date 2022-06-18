<?php


namespace App;


class ui
{
    private $els;

    public function __construct(){
        $this->els='';
        $this->headings();
    }
    public function __destruct(){
        $this->els=null;
    }
    // конструктивные =======================================================
    private function blank(){
    }
    public function add($el){
        $this->els.=$el;
    }
    private function clear(){
        $this->els='';
    }
    public function draw(){
        $this->jslibs();
        echo($this->els);
        $this->clear();
    }

    // базовые =======================================================
    public function br(){
        $this->add('<br>');
    }

    public function container(){
        $this->div_open('','container');
    }

    public function hr($class=""){
        $this->add('<hr class="'.$class.'">');
    }

    public function row($id='',$class='',$text='',$onclick=''){
        $this->add('<div id="'.$id.'" class="row mx-1 '.$class.'" onclick="'.$onclick.'">'.$text.'</div>');
    }
    public function row_open($id='',$class=''){
        $this->add('<div id="'.$id.'" class="row '.$class.'">');
    }
    public function row_close(){
        $this->add('</div>');
    }
    public function col_open($id='',$class='',$col=''){
        if(empty($col)) $col = 'col';
        $this->add('<div id="'.$id.'" class="'.$col.' '.$class.'">');
    }
    public function col_close(){
        $this->add('</div>');
    }
    public function form_open($action='',$method=''){
        if(empty($col)) $col = 'col';
        $this->add('<form action="'.$action.'" method="'.$method.'">');
    }
    public function form_close(){
        $this->add('</form>');
    }
    public function div_open($id='',$class=''){
        $this->add('<div id="'.$id.'" class="'.$class.'">');
    }
    public function div_close(){
        $this->add('</div>');
    }

    public function input($id='',$name='',$class='',$text='',$placeholder='',$disabled=false,$div='',$value='',$type='text'){
        if($disabled) {
            $add= 'disabled="true"';
            $divclass = '';
            $spanclass='text-muted w-200pt';
            $inputclass='disabled-input';
        }else{
            $divclass='';
            $spanclass='input-group-text';
            $inputclass='';
            $add='';
        }
        if (!empty($text)) {
            $this->add('
					<div class="input-group mb-3 ' . $class . ' ' . $divclass . ' ">
						<span class="inputspan ' . $spanclass . ' ">' . $text . '</span>
						<input ' . $add . ' id="' . $id . '" name="' . $name . '" type="' . $type . '" class="form-control ' . $inputclass . '" placeholder="' . $placeholder . '" value="' . $value . '">
						' . $div . '
					</div>
		    ');
        }else{
            $this->add('
					<div class="input-group mb-3 ' . $class . ' ' . $divclass . ' ">
						<input ' . $add . ' id="' . $id . '" name="' . $name . '" type="' . $type . '" class="form-control ' . $inputclass . '" placeholder="' . $placeholder . '" value="' . $value . '">
						' . $div . '
					</div>
		    ');
        }

    }

    public function input_find($id='',$name='',$class='',$text='',$placeholder='',$disabled=false, $value=''){
        $div='
		<div class="input-group-append">
            <button class="btn btn-primary" type="submit">Поиск</button>
        </div>';
        $this->input($id,$name,$class,$text,$placeholder,$disabled,$div,$value);
    }

    public function card_open($id='',$class='',$style='',$header=''){
        if(!empty($header)){
            $this->add('<div id="'.$id.'" class="card m-3 '.$class.'" style="'.$style.'">');
            $this->add('<div class="card-header"><b>'.$header.'</b></div>');
        }else{
            $this->add('<div id="'.$id.'" class="card '.$class.'" style="'.$style.'">');
        }
        $this->add('<div class="card-body d-flex flex-column justify-content-between">');
    }

    public function card_click_open($id='',$class='',$style='',$link='') {
        $this->add('<div onclick="window.open('."'".$link."'".','."'".'_blank'."'".').focus();" id="'.$id.'" class="card '.$class.'" style="'.$style.'">');
        $this->add('<div class="card-body d-flex flex-column justify-content-between">');
    }

    public function card_close(){
        $this->add('</div></div>');
    }

    public function card_result($proekt='',$avtor='',$stars='',$views='',$link=''){
        $this->card_click_open('','m-3',"width: 18rem;cursor:pointer;",$link);
        $this->add('
			<h5 class="card-titel">'.$proekt.'</h5>
            <p class="card-text">'.$avtor.'</p>
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <span class="" style="font-size: 10pt;"><i class="fa-solid fa-star" style="color:orange;"></i>'.$stars.'</span>
                    <span class="" style="font-size: 10pt;"><i class="fa-solid fa-eye" style="color: gray;"></i>'.$views.'</span>
                </div>    
                <a href="'.$link.'" target="_blank" class="card-link align-self-end">Перейти</a>
            </div>
		');
        $this->card_close();
    }

    // комплексные =======================================================
    public function jslibs(){
        $this->add('
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            document.querySelector('."'#search'".').addEventListener('."'input'".',(e)=>{
            document.querySelector('."'#results'".').innerHTML='."''".';
            })
        </script>
        <style>
            html {
                overflow-y: scroll;
            }
        </style>
		');

    }

    public function headings(){
        $this->add( '
        <head>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        </head>
		'
        );
    }

}