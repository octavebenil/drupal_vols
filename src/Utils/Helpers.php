<?php

namespace Drupal\vols\Utils;

class Helpers
{

  public static function dump_var($val){
    var_dump("<pre>");
    var_dump($val);
    var_dump("</pre><br/>");
    die();
  }

  public static function no_exit_dump_var($val){
    var_dump("<pre>");
    var_dump($val);
    var_dump("</pre><br/>");
  }

}
