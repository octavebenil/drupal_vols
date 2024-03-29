<?php

namespace Drupal\vols\Controller\Admin;

use Drupal\Core\PageCache\ResponsePolicy\KillSwitch;
use Drupal\vols\Utils\Helpers;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\vols\Service\EntityCRUDService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class StatusController extends ControllerBase
{

  protected $entityCRUDService;

  protected $killSwitch;

  protected $tables = "status_vols";

  protected $entity_type_id = "status";

  public function __construct(EntityCRUDService $entityCRUDService, KillSwitch $kill_switch){
    $this->entityCRUDService = $entityCRUDService;
    $this->killSwitch = $kill_switch;
  }

  public static function create(ContainerInterface $container){
    return new static(
      $container->get('vols.crud_service'),
      $container->get('page_cache_kill_switch')
    );
  }

  public function list(Request $request){

    $this->killSwitch->trigger();

    $page = $request->query->get("page", 1);
    $limit = 15;

    $old_limit = $limit;

    $start = ($page == 1) ? 0 : $limit;
    $limit = $start + $limit;

    $status = $this->entityCRUDService->getEntities($this->tables, $start, $limit);

    $total_status = $this->entityCRUDService->countEntities($this->entity_type_id);

    $nbre_page = floor($total_status/$old_limit);

    $nbre_page = ($nbre_page > 0 ) ? $nbre_page : 1;

    return [
      '#theme' => 'admin_status_list',
      "#items" => $status,
      "#total_item" => count($status),
      "#total_row" => $total_status,
      "#page" => $page,
      "#limit" => $limit,
      "#nbre_page" => $nbre_page,
    ];
  }

  public function view($id) {
      $status = $this->entityCRUDService->findById($id, $this->tables);

      return [
        '#theme' =>  'admin_status_view',
        "#status" => $status
      ];
  }


  public function delete($id, Request $request) {

    if (!$request->isMethod('POST')) {
      \Drupal::messenger()->addMessage($this->t('Methode non autorisée.'));
    }
    else{
      $res  = $this->entityCRUDService->deleteEntity($id, $this->entity_type_id);

      if($res){
        \Drupal::messenger()->addMessage($this->t('Supprimer avec succès.'));
      }
      else{
        \Drupal::messenger()->addMessage($this->t('Erreur lors de la suppression.'));
      }
    }
    return $this->redirect('vols.status_vols');
  }

}
