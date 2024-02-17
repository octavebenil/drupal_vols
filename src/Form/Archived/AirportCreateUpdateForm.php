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

class AirportCreateUpdateForm extends FormBase
{
  protected $entityCRUDService;

  protected $entityTypeManager;

  protected $render;

  protected $entity_type_id;

  public function __construct(EntityCRUDService $entityCRUDService,
                              EntityTypeManagerInterface $entityTypeManager,
                              RendererInterface $render){

    $this->entityCRUDService = $entityCRUDService;

    $this->entityTypeManager = $entityTypeManager;

    $this->render = $render;

    $this->entity_type_id = 'airport';
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('vols.crud_service'),
      $container->get('entity_type.manager'),
      $container->get('renderer')
    );
  }

  public function getFormId() {
    return 'airport_add_update_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state, $id=NULL) {
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
        $entity = $this->entityTypeManager->getStorage($this->entity_type_id)->load($id);

        $default_value = $entity->get($field_definition->getName())->value;

      }

      $description = (string) $field_definition->getDescription();

      $form[$field_name] = [
        '#type' => $field_type,
        '#title' => $this->t($title),
        '#description' => $this->t($description),
        '#default_value' => $default_value
      ];
    }

    if($id != NULL){
      $form["id"] = [
        '#type' => 'hidden',
        '#default_value' => $id
      ];
    }

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enregistrer'),
    ];

    $form['actions']['back'] = [
      '#type' => 'link',
      '#title' => $this->t('Retour'),
      '#url' => \Drupal\Core\Url::fromRoute('vols.airport_list'),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Récupère les valeurs soumises par le formulaire.
    $values = $form_state->getValues();

    if(!isset($values['id'])){
      $values['id'] = 0;
    }

    // Récupère l'entité pour la validation.
    $entity = $this->entityTypeManager->getStorage($this->entity_type_id)->create($values);

    // Valide l'entité.
    $violations = $entity->validate();

    // Si des violations sont trouvées, ajoute-les aux formulaires pour les afficher.
    foreach ($violations as $violation) {
      $form_state->setErrorByName($violation->getPropertyPath(), $violation->getMessage());
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

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

    $form_state->setRedirect('vols.airport_list');
  }
}
