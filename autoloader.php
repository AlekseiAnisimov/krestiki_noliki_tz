<?php

spl_autoload_register( function($classname){
    require_once("library/" .  $classname . ".php");
});