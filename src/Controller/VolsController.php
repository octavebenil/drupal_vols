<?php

namespace Drupal\vols\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\vols\Dto\Vol;

define("DEPARTURE", "departure");
define("ARRIVAL", "arrival");
class VolsController extends ControllerBase
{

  private $lome_iata = "lfw"; //code IATA de l'aeroport de Lomé
  private $niamtougou_iata = "lrl"; //code IATA de l'aeroport de Niamtougou

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

      if ($type == DEPARTURE) {
        $datas = $batch_vols->departures;
      } else {
        $datas = $batch_vols->arrivals;
      }


      $today_time = time();

      foreach ($datas as $data) {

        if($today_only){

          if ($type == DEPARTURE) {
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

    $iata = $this->lome_iata;

    $url = "https://www.skyscanner.fr/g/arrival-departure-svc/api/airports/$iata/departures?locale=en-GB";

    $vols = $this->process_vols($url, DEPARTURE);

    return [
      '#theme' => 'vols_list_template',
      '#type' => DEPARTURE,
      '#vols' => $vols
    ];
  }


  public function arrivals()
  {

    $iata = $this->lome_iata;

    $url = "https://www.skyscanner.fr/g/arrival-departure-svc/api/airports/$iata/arrivals?locale=en-GB";

    $vols = $this->process_vols($url, ARRIVAL);

    return [
      '#theme' => 'vols_list_template',
      '#type' => ARRIVAL,
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
