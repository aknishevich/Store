<?php
class Render{
    public $values;
    public function __construct($str, $val="")
    {
        include"templates/header.phtml";
        include"templates/menu.phtml";
        $this->values = $val;
        include"templates/{$str}.phtml";
        include"templates/footer.phtml";
        
    }
}