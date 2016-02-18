<?php

namespace App;

use Lang;
use Session;

class Alert
{
    private function __construct($text,$title,$class) {
        $this->text = $text;
        $this->title = $title;
        $this->class = $class;
    }
    
    static public function setSuccessAlert($text = null){
         $title = Lang::get('app.success_header');
         Session::flash('alert', new Alert($text,$title,'alert-success')); 
    }
    
    static public function setInfoAlert($text = null){
         $title = Lang::get('app.info_header');
         Session::flash('alert', new Alert($text,'alert-info')); 
    }
    
    static public function setWarningAlert($text = null){
         $title = Lang::get('app.warning_header');
         Session::flash('alert', new Alert($text,'alert-warning')); 
    }
    
    static public function setErrorAlert($text = null){
         $title = Lang::get('app.error_header');
         Session::flash('alert', new Alert($text,'alert-danger')); 
    }
    
    public $text = null;
    public $title = null;
    public $class = null;
}
