<?php
namespace Drupal\vols\Form;

//use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\vols\Service\EntityCRUDService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class StatusCreateUpdateForm extends FormBase
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

    $this->entity_type_id = 'status';
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('vols.crud_service'),
      $container->get('entity_type.manager'),
      $container->get('renderer')
    );
  }

  public function getFormId() {
    return 'status_vol_add_update_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $entity = $this->entityTypeManager->getStorage($this->entity_type_id)->create();

    $fields = $entity->getFieldDefinitions();

    foreach ($fields as $field_name => $field_definition) {
      // Utilise getFieldWidget() pour obtenir le widget du champ.
      $field_widget = $this->getFieldWidget($field_definition);
      if ($field_widget) {
        $form[$field_name] = $field_widget;
      }
    }

    return $form;;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Récupère les valeurs soumises par le formulaire.
    $values = $form_state->getValues();

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

    $entity_id = $form_state->getValue('id', 0);

    if($entity_id > 0){
      //mise à jour
      $this->entityCRUDService->updateEntity($values, $entity_id, $this->entity_type_id);
      \Drupal::messenger()->addMessage('Mise à jour avec succès.');
    }
    else{
      //ajout
      $this->entityCRUDService->createEntity($values, $this->entity_type_id);
      \Drupal::messenger()->addMessage($this->t('Enregistrer avec succès.'));
    }

    $form_state->setRedirect('vols.status_vols');
  }

  protected function getFieldWidget(FieldDefinitionInterface $field_definition) {
    $field_type = $field_definition->getType();
    $widget = $this->entityTypeManager
      ->getViewBuilder($field_type)
      ->getDefaultForm($this->entity, $field_definition);

    return $widget;
  }
}
