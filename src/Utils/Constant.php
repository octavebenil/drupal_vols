<?php
namespace Drupal\vols\Utils;

class Constant {

  public static string $DEPARTURE = 'departure';

  public static string $ARRIVAL = 'arrival';

  public static array $ENTITY_FORM_FIELD = array(
    "integer" => "number",
    "string" => "textfield",
    "file" => "file",
    "text" => "textarea",
    "entity_reference" => "select",
    "bool" => "checkbox",
    "boolean" => "checkbox",
    "date" => "date",
    "datetime" => "textfield",
    "created" => "datetime",
    "changed" => "datetime",
  );

  public static function getFieldFromEntityType($entity_type){
     if(isset(self::$ENTITY_FORM_FIELD[$entity_type])){
        return self::$ENTITY_FORM_FIELD[$entity_type];
     }
     return "textfield"; //par defaut
  }

}
