<?php
class app{
    public static function Run(){
        include "models/Connect.php";
        include"layout/default.php";
        $project = new RunProject();
        $object = new $project->object();
        $name = $project->action;
        $object->$name();
    }
}