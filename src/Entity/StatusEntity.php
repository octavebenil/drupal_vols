<?php
namespace Drupal\vols\Entity;


use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the Weather place entity.
 *
 * @ingroup vol
 *
 * @ContentEntityType(
 *   id = "status",
 *   label = @Translation("Statut"),
 *   description = @Translation("Liste des statuts"),
 *   base_table = "status_vols",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 * )
 */
class StatusEntity extends ContentEntityBase implements ContentEntityInterface {
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type
  ) {
    $fields = [];

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Id Statut'))
      ->setRequired(TRUE)
      ->setDescription('Id')
      ->setReadOnly(TRUE);

    $fields['code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Code'))
      ->setRequired(TRUE)
      ->setDescription('Code de la statut')
      ->setSetting('max_length', 190)
      ->addConstraint('UniqueField');

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nom'))
      ->setRequired(TRUE)
      ->setDescription('Nom de la statut')
      ->setSetting('max_length', 190);


    $fields['created_at'] = BaseFieldDefinition::create('created')
      ->setLabel(t("Date de création"))
      ->setRequired(FALSE)
      ->setDescription("Date de création");

    $fields['updated_at'] = BaseFieldDefinition::create('changed')
      ->setLabel(t("Date de mise à jour"))
      ->setRequired(FALSE)
      ->setDescription("Date de mise à jour");

    return $fields;
  }
}

