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
 *   id = "vol",
 *   label = @Translation("Vols"),
 *   description = @Translation("Liste des vols"),
 *   base_table = "vols",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 * )
 */
class VolEntity extends ContentEntityBase implements ContentEntityInterface
{
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type
  )
  {
    $fields = [];

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Id Vol'))
      ->setRequired(TRUE)
      ->setDescription('Id de vol')
      ->setReadOnly(TRUE);


//    $fields['airlineId'] = BaseFieldDefinition::create('string')
//      ->setLabel(t('Compagnie Id'))
//      ->setRequired(TRUE)
//      ->setDescription('Identifiant de la compagnie')
//      ->setSetting('max_length', 190);
//
//    $fields['airlineName'] = BaseFieldDefinition::create('string')
//      ->setLabel(t('Nom de la compagnie'))
//      ->setRequired(TRUE)
//      ->setDescription('Nom de la compagnie')
//      ->setSetting('max_length', 190);

//    $fields['arrivalAirportCode'] = BaseFieldDefinition::create('string')
//      ->setLabel(t("Code de l'aeroport d'arrivée"))
//      ->setRequired(TRUE)
//      ->setDescription("Aeroport d'arrivée")
//      ->setSetting('max_length', 190);
//
//
//    $fields['departureAirportCode'] = BaseFieldDefinition::create('string')
//      ->setLabel(t("Code de l'aeroport de départ"))
//      ->setRequired(TRUE)
//      ->setDescription("Aeroport de départ")
//      ->setSetting('max_length', 190);
//
//
//    $fields['arrivalAirportName'] = BaseFieldDefinition::create('string')
//      ->setLabel(t("Nom de l'aeroport d'arrivée"))
//      ->setRequired(TRUE)
//      ->setDescription("Aeroport d'arrivée")
//      ->setSetting('max_length', 190);
//
//
//    $fields['departureAirportName'] = BaseFieldDefinition::create('string')
//      ->setLabel(t("Nom de l'aeroport de départ"))
//      ->setRequired(TRUE)
//      ->setDescription("Aeroport de départ")
//      ->setSetting('max_length', 190);

//    $fields['status'] = BaseFieldDefinition::create('string')
//      ->setLabel(t("Statut"))
//      ->setRequired(TRUE)
//      ->setDescription("Statut de vol")
//      ->setSetting('max_length', 190);


    $fields['flightNumber'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Numéro de vol"))
      ->setRequired(TRUE)
      ->setDescription("Numéro de vol")
      ->setSetting('max_length', 190);

    $fields['arrivalTerminal'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Terminale d'arrivée"))
      ->setRequired(FALSE)
      ->setDescription("Terminal d'arrivée")
      ->setSetting('max_length', 190);


    $fields['arrivalTerminalLocalised'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Localisation du terminale d'arrivée"))
      ->setRequired(FALSE)
      ->setDescription("Localisation")
      ->setSetting('max_length', 190);


    $fields['departureTerminal'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Terminale de départ"))
      ->setRequired(FALSE)
      ->setDescription("Terminal de départ")
      ->setSetting('max_length', 190);


    $fields['departureTerminalLocalised'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Localisation du terminale de départ"))
      ->setRequired(FALSE)
      ->setDescription("Localisation")
      ->setSetting('max_length', 190);

    $fields['statusLocalised'] = BaseFieldDefinition::create('string')
      ->setLabel(t("statusLocalised"))
      ->setRequired(FALSE)
      ->setDescription("statusLocalised")
      ->setSetting('max_length', 190);


    $fields['opFlightNumber'] = BaseFieldDefinition::create('string')
      ->setLabel(t("opFlightNumber"))
      ->setRequired(FALSE)
      ->setDescription("opFlightNumber")
      ->setSetting('max_length', 190);


    $fields['arrivalGate'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Portail d'arrivée"))
      ->setRequired(FALSE)
      ->setDescription("Arrival Gate")
      ->setSetting('max_length', 190);

    $fields['boardingGate'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Portail d'embarquement"))
      ->setRequired(FALSE)
      ->setDescription("Boarding Gate")
      ->setSetting('max_length', 190);


    $fields['codeshares'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t("codeshares"))
      ->setRequired(FALSE)
      ->setDescription("codeshares");


    $fields['codeShare'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t("codeShare"))
      ->setRequired(FALSE)
      ->setDescription("codeShare")
      ->setDefaultValue(FALSE);


    $fields['user_update'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t("Mis à jour manuellement"))
      ->setRequired(FALSE)
      ->setDescription("Si cocher c'est qu'un utilisateur à déjà effectué une mise à jour.
      Decocher la case si vous voulez une mise à jour automatique depuis l'API")
      ->setDefaultValue(FALSE);


    $fields['type'] = BaseFieldDefinition::create('string')
      ->setLabel(t("type"))
      ->setRequired(FALSE)
      ->setDescription("type")
      ->setSetting('max_length', 190);

    //date
    $fields['scheduledArrivalTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("Date d'arrivée prévue"))
      ->setRequired(FALSE)
      ->setDescription("scheduled Arrival Time");

    $fields['localisedScheduledArrivalTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("localised Scheduled Arrival Time"))
      ->setRequired(FALSE)
      ->setDescription("localisedScheduledArrivalTime");

    $fields['estimatedArrivalTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("Date d'arrivé estimé"))
      ->setRequired(FALSE)
      ->setDescription("estimated Arrival Time");

    $fields['localisedEstimatedArrivalTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("localised Estimated Arrival Time"))
      ->setRequired(FALSE)
      ->setDescription("localisedEstimatedArrivalTime");

    //date depart
    $fields['scheduledDepartureTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("Date de départ prévu"))
      ->setRequired(FALSE)
      ->setDescription("scheduled Departure Time");

    $fields['localisedScheduledDepartureTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("localised Scheduled Departure Time"))
      ->setRequired(FALSE)
      ->setDescription("localisedScheduledDepartureTime");

    $fields['estimatedDepartureTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("Date départ estimé"))
      ->setRequired(FALSE)
      ->setDescription("estimated Departure Time");

    $fields['localisedEstimatedDepartureTime'] = BaseFieldDefinition::create('datetime')
      ->setSetting('datetime_type', 'datetime')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setLabel(t("localised Estimated Departure Time"))
      ->setRequired(FALSE)
      ->setDescription("localisedEstimatedDepartureTime");


    $fields['created_at'] = BaseFieldDefinition::create('created')
      ->setLabel(t("Date de création"))
      ->setRequired(FALSE)
      ->setDescription("Date de création");

    $fields['updated_at'] = BaseFieldDefinition::create('changed')
      ->setLabel(t("Date de mise à jour"))
      ->setRequired(FALSE)
      ->setDescription("Date de mise à jour");


    //relationship
    //comapanie
    $fields['company'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t("Compagnie"))
      ->setDescription(t("Compagnie"))
      ->setSetting('target_type', 'company')
      ->setRequired(TRUE);

    // Ajouter une contrainte de clé étrangère.
//    $fields['company']->addConstraint('ForeignKey');


    //aeroport de depart
    $fields['airport_departure'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t("Aeroport de départ"))
      ->setDescription(t("Nom de l'aeroport de départ"))
      ->setSetting('target_type', 'airport')
      ->setRequired(TRUE);

    // Ajouter une contrainte de clé étrangère.
//    $fields['airport_departure']->addConstraint('ForeignKey');


    //aeroport dùarrivée
    $fields['airport_arrival'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t("Aeroport d'arrivé"))
      ->setDescription(t("Nom de l'aeroport d'arrivé"))
      ->setSetting('target_type', 'airport')
      ->setRequired(TRUE);

    // Ajouter une contrainte de clé étrangère.
//    $fields['airport_arrival']->addConstraint('ForeignKey');


    //Status
    $fields['status'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t("Statut de vol"))
      ->setDescription(t("Statut de vol"))
      ->setSetting('target_type', 'status')
      ->setRequired(TRUE);

    // Ajouter une contrainte de clé étrangère.
//    $fields['status']->addConstraint('ForeignKey');

    return $fields;
  }
}

