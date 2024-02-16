<?php

namespace Drupal\vols\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;

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

  public function getEntities($entity_type_id, $page = 0, $limit = 10) {
    $query = $this->entityTypeManager->getStorage($entity_type_id)->getQuery();

    $query->accessCheck(TRUE);

    $query->pager($limit);
    $query->range($page * $limit, $limit);
    $entity_ids = $query->execute();
    return $this->entityTypeManager->getStorage($entity_type_id)->loadMultiple($entity_ids);
  }
}
