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

class AdminVolsController extends ControllerBase
{

  protected $entityCRUDService;

  protected $killSwitch;

  protected $tables = "vols";

  protected $entity_type_id = "vol";

  public function __construct(EntityCRUDService $entityCRUDService, KillSwitch $kill_switch)
  {
    $this->entityCRUDService = $entityCRUDService;
    $this->killSwitch = $kill_switch;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('vols.crud_service'),
      $container->get('page_cache_kill_switch')
    );
  }

  public function list(Request $request)
  {

    $this->killSwitch->trigger();

    $page = $request->query->get("page", 1);
    $limit = 15;

    $old_limit = $limit;

    $start = ($page == 1) ? 0 : $limit;
    $limit = $start + $limit;

    $vol = $this->entityCRUDService->getVolsByProperties($this->tables, [], $start, $limit);

    $total_vol = $this->entityCRUDService->countEntities($this->entity_type_id);

    $nbre_page = floor($total_vol / $old_limit);

    $nbre_page = ($nbre_page > 0) ? $nbre_page : 1;


    return [
      '#theme' => 'admin_vol_list',
      "#items" => $vol,
      "#total_item" => count($vol),
      "#total_row" => $total_vol,
      "#page" => $page,
      "#limit" => $limit,
      "#nbre_page" => $nbre_page,
    ];
  }

  public function view($id)
  {
    $vol = $this->entityCRUDService->findById($id, $this->tables);

    return [
      '#theme' => 'admin_vol_view',
      "#vol" => $vol
    ];
  }


  public function delete($id, Request $request)
  {

    if (!$request->isMethod('POST')) {
      \Drupal::messenger()->addMessage($this->t('Methode non autorisée.'));
    } else {
      $res = $this->entityCRUDService->deleteEntity($id, $this->entity_type_id);

      if ($res) {
        \Drupal::messenger()->addMessage($this->t('Supprimer avec succès.'));
      } else {
        \Drupal::messenger()->addMessage($this->t('Erreur lors de la suppression.'));
      }
    }
    return $this->redirect('vols.vol_list');
  }

}
