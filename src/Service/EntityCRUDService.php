<?php

namespace Drupal\vols\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\vols\Utils\Helpers;

class EntityCRUDService {

  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  public function createEntity(array $values, $entity_type_id) {
    $entity = $this->entityTypeManager->getStorage($entity_type_id)->create($values);
    $entity->save();
    return $entity;
  }

  public function createUpdateEntity(array $values, $entity_type_id, $check_colomn) {
     $check_value = $values[$check_colomn];


     $table_name = $this->entityTypeManager->getStorage($entity_type_id)->getEntityType()->getBaseTable();

     $item = $this->findOneByProperty($check_colomn, $check_value, $table_name);

     if($item){
       //mise a jour
       $user_updated = (isset($item->user_update)) ? $item->user_update : FALSE;

       if(!$user_updated){
         $this->updateEntity($values, $item->id, $entity_type_id);
       }
     }
     else
      {
        $this->createEntity($values, $entity_type_id);
      }

     return $this->findOneByProperty($check_colomn, $check_value, $table_name);

  }

  public function createOrIgnoreIfExistEntity(array $values, $entity_type_id, $check_colomn) {
    $check_value = $values[$check_colomn];


    $table_name = $this->entityTypeManager->getStorage($entity_type_id)->getEntityType()->getBaseTable();

    $item = $this->findOneByProperty($check_colomn, $check_value, $table_name);

    if($item){
      //on ignore par ca existe déjà
    }
    else
    {
      $this->createEntity($values, $entity_type_id);
    }

    return $this->findOneByProperty($check_colomn, $check_value, $table_name);

  }

  public function updateEntity(array $values, $entity_id, $entity_type_id) {
    $entity = $this->entityTypeManager->getStorage($entity_type_id)->load($entity_id);
    if ($entity) {
      foreach ($values as $key => $value) {
        $entity->set($key, $value);
      }
      $entity->save();
      return $entity;
    }
    return NULL;
  }

  public function deleteEntity($entity_id, $entity_type_id) {
    $entity = $this->entityTypeManager->getStorage($entity_type_id)->load($entity_id);
    if ($entity) {
      $entity->delete();
      return TRUE;
    }
    return FALSE;
  }

  public function loadEntity($entity_id, $entity_type_id) {
    return $this->entityTypeManager->getStorage($entity_type_id)->load($entity_id);
  }

  public function findById($entity_id, $table_name) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);
    $query->where("id=$entity_id");
    return $query->execute()->fetch();
  }

  public function findByCode($code, $table_name) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);
    $query->where("code='$code'");
    return $query->execute()->fetch();
  }

  public function findOneByProperty($property, $value, $table_name) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);
    $query->where("$property='$value'");
    return $query->execute()->fetch();
  }

  public function findAllByProperty($property, $value, $table_name) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);
    $query->where("$property='$value'");
    return $query->execute()->fetchAll();
  }
  public function getEntities($table_name, $page = 0, $limit = 10) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);
    $query->range($page, $limit);
    return $query->execute()->fetchAll();
  }

  public function prepareEntitiesQuery($table_name, $selected_fields=[], $page = 0, $limit = 10) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", $selected_fields);
    $query->range($page, $limit);
    return $query;
  }

  public function getEntitiesByProperties($table_name, array $properties, $page = 0, $limit = 10) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);

    if($properties){
      foreach ($properties as $property => $value){
        $query->where("$property='$value'");
      }
    }

    $query->range($page, $limit);
    return $query->execute()->fetchAll();
  }


  public function getVolsByProperties($table_name, array $properties, $page = 0, $limit = 10) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);

    $query->join("companies", "comp", "comp.id = t.company");
    $query->join("status_vols", "stat", "stat.id = t.status");
    $query->join("airports", "dep_aero", "dep_aero.id = t.airport_departure");
    $query->join("airports", "arr_aero", "arr_aero.id = t.airport_arrival");

    $query->addField("stat", "code", "stat_code");
    $query->addField("stat", "name", "status");

    $query->addField("comp", "code", "comp_code");
    $query->addField("comp", "name", "company");
    $query->addField("comp", "photo__target_id", "company_photo");

    $query->addField("dep_aero", "code", "dep_aero_code");
    $query->addField("dep_aero", "name", "departureAirportName");

    $query->addField("arr_aero", "code", "arr_aero_code");
    $query->addField("arr_aero", "name", "arrivalAirportName");

    if($properties){
      foreach ($properties as $property => $value){
        $query->where("$property='$value'");
      }
    }

    $query->range($page, $limit);

    $query->orderBy("scheduledArrivalTime", "DESC");
    $query->orderBy("scheduledDepartureTime", "DESC");

    return $query->execute()->fetchAll();
  }

  public function getAllEntities($table_name) {
    $query = \Drupal::database()->select("$table_name", "t");
    $query->fields("t", []);
    return $query->execute()->fetchAll();
  }

  public function countEntities($entity_type_id) {
    $query = $this->entityTypeManager->getStorage($entity_type_id)->getQuery();
    $query->accessCheck(TRUE);
    $count = $query->count()->execute();
    return $count;
  }
}
