<?php

namespace Drupal\vols\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\PageCache\ResponsePolicy\KillSwitch;
use Drupal\vols\Service\EntityCRUDService;
use Drupal\vols\Service\SkyScannerService;
use Drupal\vols\Utils\Constant;
use Drupal\vols\Utils\Helpers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\vols\Dto\Vol;
class VolsController extends ControllerBase
{

  private $lome_iata = "lfw"; //code IATA de l'aeroport de Lomé
  private $niamtougou_iata = "lrl"; //code IATA de l'aeroport de Niamtougou


  /**
   * Page cache kill switch.
   *
   * @var \Drupal\Core\PageCache\ResponsePolicy\KillSwitch
   */
  protected $killSwitch;

  protected $skyScannerService;

  protected $entityCRUDService;

  /**
   * {@inheritdoc}
   */
  public function __construct(KillSwitch $kill_switch,
                              SkyScannerService $skyScannerService,
                              EntityCRUDService $entityCRUDService) {
    $this->killSwitch = $kill_switch;

    $this->skyScannerService = $skyScannerService;

    $this->entityCRUDService = $entityCRUDService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('page_cache_kill_switch'),
      $container->get('vols.skyscanner_service'),
      $container->get('vols.crud_service'),
    );
  }

  public function list(Request $request)
  {
    $this->killSwitch->trigger();

    $iata = $this->lome_iata;

    $page = $request->query->get("page", 1);
    $limit = 15;

    $old_limit = $limit;

    $start = ($page == 1) ? 0 : $limit;
    $limit = $start + $limit;

    $this->skyScannerService->syncVolEntity($iata, Constant::$DEPARTURE);

    $today = date("Y-m-d", time());

    $vols = $this->entityCRUDService->getVolsByProperties("vols", array(
      "type" => Constant::$DEPARTURE,
      "scheduledDepartureTime" => $today,
    ), $start, $limit);

    $vols = Helpers::process_company_photo($vols);
    return [
      '#theme' => 'front_vols_list',
      '#type' => Constant::$DEPARTURE,
      '#vols' => $vols
    ];
  }


  public function arrivals(Request $request)
  {
    $this->killSwitch->trigger();
    $iata = $this->lome_iata;

    $page = $request->query->get("page", 1);
    $limit = 15;

    $old_limit = $limit;

    $start = ($page == 1) ? 0 : $limit;
    $limit = $start + $limit;

    $this->skyScannerService->syncVolEntity($iata, Constant::$ARRIVAL);

    $today = date("Y-m-d", time());

    $vols = $this->entityCRUDService->getVolsByProperties("vols", array(
      "type" => Constant::$ARRIVAL,
      "scheduledArrivalTime" => $today,
    ), $start, $limit);

    $vols = Helpers::process_company_photo($vols);

    return [
      '#theme' => 'front_vols_list',
      '#type' => Constant::$ARRIVAL,
      '#vols' => $vols
    ];
  }


  public function settings()
  {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Settings!'),
    ];
  }
}
