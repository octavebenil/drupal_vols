<?php
namespace Drupal\vols\Form;

//use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\vols\Service\EntityCRUDService;
use Drupal\vols\Utils\Constant;
use Drupal\vols\Utils\Helpers;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class CreateUpdateForm extends FormBase
{
  protected $entityCRUDService;

  protected $entityTypeManager;

  protected $entity_type_id;
  protected $entity_list;

  protected $module_name="vols";

  public function __construct(EntityCRUDService $entityCRUDService,
                              EntityTypeManagerInterface $entityTypeManager){

    $this->entityCRUDService = $entityCRUDService;
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('vols.crud_service'),
      $container->get('entity_type.manager'),
    );
  }

  public function getFormId() {
    $request = \Drupal::request();
    $this->entity_type_id = $request->get("entity_id", "vols");
    return $this->entity_type_id."_".$this->module_name."_add_update_form";
  }

  public function buildForm(array $form, FormStateInterface $form_state, $id=NULL, $entity_id=NULL, $entity_list=NULL) {

    $this->entity_type_id = $entity_id;
    $this->entity_list = $this->module_name.".".$entity_list;

    $entity = $this->entityTypeManager->getStorage($this->entity_type_id)->create();

    $fields = $entity->getFieldDefinitions();


    foreach ($fields as $field_name => $field_definition) {

      if($field_name == 'id'
        || $field_name == 'created_at'
        || $field_name == 'updated_at'
      ) continue;

      $title = (string) $field_definition->getLabel();
      $field_type = Constant::getFieldFromEntityType($field_definition->getType());

      $default_value = NULL;
      if ($id !== NULL) {
        // Récupérer l'entité à partir de l'ID.

        if($field_definition->getType() == "entity_reference"){

          $table_name = $this->entityTypeManager->getStorage($this->entity_type_id)->getEntityType()->getBaseTable();

          $query = \Drupal::database()->select($table_name, "t");
          $query->fields("t", []);
          $query->where("id=$id");
          $item = $query->execute()->fetch();

          if($item){
            $default_value = (isset($item->$field_name)) ? $item->$field_name : NULL;
          }
        }
        else
        {
          $entity = $this->entityTypeManager->getStorage($this->entity_type_id)->load($id);

          $default_value = $entity->get($field_definition->getName())->value;
        }

      }

      $description = (string) $field_definition->getDescription();

      //cas ou c'est une relation ; type: entity_reference
      if($field_definition->getType() == "entity_reference" || $field_definition->getType() == "entity_autocomplete"){

        $settings = $field_definition->getSettings();

        $target_type = isset($settings['target_type']) ? $settings['target_type'] : $field_definition->getTargetEntityTypeId();


        $form[$field_name] = [
          '#type' => $field_type,
          '#title' => $this->t($title),
          '#description' => $this->t($description),
          '#default_value' => $default_value,
          '#target_type' => $target_type,
          '#tags' => FALSE
        ];

        $table_name = $this->entityTypeManager->getStorage($target_type)->getEntityType()->getBaseTable();

        $items = $this->entityCRUDService->getAllEntities($table_name);

        $options = [];
        foreach ($items as $item) {
          $options[$item->id] = $item->name;
        }

        $form[$field_name]['#options'] = $options;
      }
      else{

        if($field_name == "user_update"){
          $default_value = 1;
        }

        $form[$field_name] = [
          '#type' => $field_type,
          '#title' => $this->t($title),
          '#description' => $this->t($description),
          '#default_value' => $default_value
        ];
      }

    }

    if($id != NULL){
      $form["id"] = [
        '#type' => 'hidden',
        '#default_value' => $id
      ];
    }

    $form["entity_type_id"] = [
      '#type' => 'hidden',
      '#default_value' => $this->entity_type_id
    ];

    $form["entity_list"] = [
      '#type' => 'hidden',
      '#default_value' => $this->entity_list
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enregistrer'),
    ];

    $form['actions']['back'] = [
      '#type' => 'link',
      '#title' => $this->t('Retour'),
      '#url' => \Drupal\Core\Url::fromRoute($this->entity_list),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Récupère les valeurs soumises par le formulaire.
    $values = $form_state->getValues();

    if(!isset($values['id'])){
      $values['id'] = 0;
    }

    //les codes est au majuscule
    if(isset($values['code'])){
      $values['code'] = strtoupper($values['code']);
    }

    //on desactive validation de tous ce qui est fichier
    //@TODO faire la validation des fichiers
    unset($values["photo"]);
    unset($values["file"]);
    unset($values["files"]);
    unset($values["ForeignKey"]);

    $values_to_validates = $values;

    unset($values_to_validates["entity_type_id"]);
    unset($values_to_validates["entity_list"]);

    //@TODO Pour cause d'erreur on ignore la validation de type datetime
    $entity = $this->entityTypeManager->getStorage($values["entity_type_id"])->create();

    $fields = $entity->getFieldDefinitions();
    foreach ($fields as $field_name => $field_definition) {
        $type = $field_definition->getType();
        if($type == "datetime" || $type == "date"){
          unset($values_to_validates[$field_name]);
        }
    }
    //end @TODO

    // Récupère l'entité pour la validation.
    $entity = $this->entityTypeManager->getStorage($values["entity_type_id"])->create($values_to_validates);

    // Valide l'entité.
    $violations = $entity->validate();

    // Si des violations sont trouvées, ajoute-les aux formulaires pour les afficher.
    foreach ($violations as $violation) {
      $form_state->setErrorByName($violation->getPropertyPath(), $violation->getMessage());
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->entity_type_id = $values["entity_type_id"];
    $this->entity_list = $values["entity_list"];

    unset($values["entity_type_id"]);
    unset($values["entity_list"]);

    //les codes est au majuscule
    if(isset($values['code'])){
      $values['code'] = strtoupper($values['code']);
    }

    $entity_id = isset($values["id"]) ? $values["id"] : 0;

    if($entity_id > 0){
      //mise à jour
      $vals = [];

      $entityUpdate = $this->entityTypeManager->getStorage($this->entity_type_id)->load($entity_id);

      $entity = $this->entityTypeManager->getStorage($this->entity_type_id)->create();

      $fields = $entity->getFieldDefinitions();

      foreach ($fields as $field_name => $field_definition) {

        if ($field_name == 'id'
          || $field_name == 'created_at'
          || $field_name == 'updated_at'
        ) continue;

        $vals[$field_name] = isset($values[$field_name]) ? $values[$field_name] : $entityUpdate->get($field_name)->value;
      }

      $this->entityCRUDService->updateEntity($vals, $entity_id, $this->entity_type_id);
      \Drupal::messenger()->addMessage('Mise à jour avec succès.');
    }
    else{
      //ajout
      $this->entityCRUDService->createEntity($values, $this->entity_type_id);
      \Drupal::messenger()->addMessage($this->t('Enregistrer avec succès.'));
    }
    $form_state->setRedirect($this->entity_list);
  }
}
