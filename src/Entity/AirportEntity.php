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
 *   id = "airport",
 *   label = @Translation("Aeroports"),
 *   description = @Translation("Liste des aeroports"),
 *   base_table = "airports",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 * )
 */
class AirportEntity extends ContentEntityBase implements ContentEntityInterface {
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type
  ) {
    $fields = [];

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Id Aeroprot'))
      ->setRequired(TRUE)
      ->setDescription('Id de aeroport')
      ->setReadOnly(TRUE);


    $fields['code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Code (IATA)'))
      ->setRequired(TRUE)
      ->setDescription('Code de l\'aeroport')
      ->setSetting('max_length', 190)
      ->addConstraint('UniqueField');

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nom de l\'aeroport'))
      ->setRequired(TRUE)
      ->setDescription('Nom de l\'aeroport')
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

