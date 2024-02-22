<?php

namespace Drupal\vols\Utils;

use Drupal\file\Entity\File;

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

  public static function process_company_photo($vols){
    if($vols){
      $old_vols = $vols;
      $vols=[];

      foreach ($old_vols as $vl){
        $vl->photo = NULL;

        if($vl->company_photo != NULL){
          $file = File::load($vl->company_photo);

          if($file){
            $vl->photo = $file->createFileUrl();
          }
        }

        $vols[] = $vl;
      }
    }
    return $vols;
  }

}
