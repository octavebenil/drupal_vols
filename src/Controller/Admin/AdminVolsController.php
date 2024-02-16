<?php

namespace Drupal\vols\Controller\Admin;

use Drupal\Core\PageCache\ResponsePolicy\KillSwitch;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\vols\Service\EntityCRUDService;
use Symfony\Component\HttpFoundation\Request;

class AdminVolsController extends ControllerBase
{

  protected $entityCRUDService;

  protected $killSwitch;

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

    $page = $request->query->get("page", 0);
    $limit = $request->query->get("limit", 15);

    $vols = $this->entityCRUDService->getEntities('vol', $page, $limit);

    return [
      '#theme' => 'admin_vols_list',
      "#vols" => $vols
    ];
  }

}
