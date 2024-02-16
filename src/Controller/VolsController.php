<?php

namespace Drupal\vols\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\PageCache\ResponsePolicy\KillSwitch;
use Drupal\vols\Utils\Constant;
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

  /**
   * {@inheritdoc}
   */
  public function __construct(KillSwitch $kill_switch) {
    $this->killSwitch = $kill_switch;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('page_cache_kill_switch')
    );
  }

  protected function process_vols($url, $type, $today_only=true)
  {

    $client = \Drupal::httpClient();


    $batch_vols = $client->get($url, [
      'headers' => [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
      ],
    ])->getBody();

    $batch_vols = json_decode($batch_vols);

    $vols = [];

    if (!empty($batch_vols)) {

      $datas = [];

      if ($type == Constant::$DEPARTURE) {
        $datas = $batch_vols->departures;
      } else {
        $datas = $batch_vols->arrivals;
      }


      $today_time = time();

      foreach ($datas as $data) {

        if($today_only){

          if ($type == Constant::$DEPARTURE) {
            $date = $data->scheduledDepartureTime;
          } else {
            $date = $data->scheduledArrivalTime;
          }

          //on ignore les autres date

//          if(date("d-m-Y", $today_time) != date("d-m-Y", strtotime($date))) continue;
        }

        $vol = new Vol(
          $data->airlineId,
          $data->airlineName,
          $data->arrivalAirportCode,
          $data->departureAirportCode,
          $data->arrivalAirportName,
          $data->departureAirportName,
          $data->flightNumber,
          $data->scheduledArrivalTime,
          $data->localisedScheduledArrivalTime,
          $data->estimatedArrivalTime,
          $data->localisedEstimatedArrivalTime,
          $data->arrivalTerminal,
          $data->arrivalTerminalLocalised,
          $data->scheduledDepartureTime,
          $data->localisedScheduledDepartureTime,
          $data->estimatedDepartureTime,
          $data->localisedEstimatedDepartureTime,
          $data->departureTerminal,
          $data->departureTerminalLocalised,
          $data->status,
          $data->statusLocalised,
          $data->opFlightNumber,
          $data->arrivalGate,
          $data->boardingGate,
          $data->codeshares,
          $data->codeShare,
          $type
        );
        $vols[] = $vol;

      }
    }

    return $vols;
  }

  public function list()
  {
    $this->killSwitch->trigger();

    $iata = $this->lome_iata;

    $url = "https://www.skyscanner.fr/g/arrival-departure-svc/api/airports/$iata/departures?locale=en-GB";

    $vols = $this->process_vols($url, Constant::$DEPARTURE);

    return [
      '#theme' => 'vols_list_template',
      '#type' => Constant::$DEPARTURE,
      '#vols' => $vols
    ];
  }


  public function arrivals()
  {
    $this->killSwitch->trigger();
    $iata = $this->lome_iata;

    $url = "https://www.skyscanner.fr/g/arrival-departure-svc/api/airports/$iata/arrivals?locale=en-GB";

    $vols = $this->process_vols($url, Constant::$ARRIVAL);

    return [
      '#theme' => 'vols_list_template',
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
