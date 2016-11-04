<?php
class crud extends Application{
    public function index(){
      $origin = $_SERVER['HTTP_REFERER'];
  		redirect($origin);
    }
}
