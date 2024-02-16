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
 *   id = "company",
 *   label = @Translation("Compagnies"),
 *   description = @Translation("Liste des compagnies"),
 *   base_table = "companies",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 * )
 */
class CompanyEntity extends ContentEntityBase implements ContentEntityInterface {



  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type
  ) {

    $fields = [];

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Id Compagnie'))
      ->setRequired(TRUE)
      ->setDescription('Id de compagnie')
      ->setReadOnly(TRUE);


    $fields['code'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Code (IATA) de la companie'))
      ->setRequired(TRUE)
      ->setDescription('Identifiant de la compagnie')
      ->setSetting('max_length', 190);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Nom de la compagnie'))
      ->setRequired(TRUE)
      ->setDescription('Nom de la compagnie')
      ->setSetting('max_length', 190);


    $fields['photo'] =  BaseFieldDefinition::create('file')
      ->setLabel('Logo de la compagnie')
      ->setSettings([
        'uri_scheme' => 'public',
        'file_directory' => 'companies_logo',
        'file_extensions' => 'png jpg jpeg',
      ])
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'file',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'file',
        'weight' => -1,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


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

