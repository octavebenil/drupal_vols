<?php

namespace Drupal\vols\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\vols\Dto\Vol;
use Drupal\vols\Utils\Constant;
use Drupal\vols\Utils\Helpers;

class SkyScannerService
{
  protected $entityTypeManager;

  protected $entityCRUDService;

  protected $skyscanner_base_url = "https://www.skyscanner.fr";

  protected $default_type;
  public function __construct(EntityTypeManagerInterface $entityTypeManager,
                              EntityCRUDService $entityCRUDService) {
    $this->entityTypeManager = $entityTypeManager;
    $this->entityCRUDService = $entityCRUDService;

    $this->default_type = Constant::$DEPARTURE;
  }

  public function loadData($iata_code, $type, $per_date=false, $locale="en-GB")
  {

    if ($type == Constant::$DEPARTURE) {
      $type_req = "departures";
    }
    else
    {
      $type_req = "arrivals";
    }

    $client = \Drupal::httpClient();

    $url = $this->skyscanner_base_url."/g/arrival-departure-svc/api/airports/$iata_code/$type_req?locale=$locale";

    $batch_vols = $client->get($url, [
      'headers' => [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
      ],
    ])->getBody();

    $batch_vols = json_decode($batch_vols);

    $vols = [];

    if (!empty($batch_vols)) {

      if ($type == Constant::$DEPARTURE) {
        $datas = $batch_vols->departures;
      } else {
        $datas = $batch_vols->arrivals;
      }

      foreach ($datas as $data) {

        if($per_date){

          if ($type == Constant::$DEPARTURE) {
            $date = $data->scheduledDepartureTime;
          } else {
            $date = $data->scheduledArrivalTime;
          }

          //on ignore les autres date
          if(date("d-m-Y", $per_date) != date("d-m-Y", strtotime($date))) continue;
        }

        $vol = array(
          "company" => array(
            "code" =>  $data->airlineId,
            "name" =>  $data->airlineName,
          ),
          "airport_arrival" => array(
            "code" =>  $data->arrivalAirportCode,
            "name" =>  $data->arrivalAirportName,
          ),

          "airport_departure" => array(
            "code" =>  $data->departureAirportCode,
            "name" =>  $data->departureAirportName,
          ),

          "status" => array(
            "code" =>  $data->status,
            "name" =>  $data->status,
          ),

          "flightNumber" =>  $data->flightNumber,
          "scheduledArrivalTime" =>  $data->scheduledArrivalTime,
          "localisedScheduledArrivalTime" =>  $data->localisedScheduledArrivalTime,
          "estimatedArrivalTime" =>  $data->estimatedArrivalTime,
          "localisedEstimatedArrivalTime" =>  $data->localisedEstimatedArrivalTime,
          "arrivalTerminal" =>  $data->arrivalTerminal,
          "arrivalTerminalLocalised" =>  $data->arrivalTerminalLocalised,
          "scheduledDepartureTime" =>  $data->scheduledDepartureTime,
          "localisedScheduledDepartureTime" =>  $data->localisedScheduledDepartureTime,
          "estimatedDepartureTime" =>  $data->estimatedDepartureTime,
          "localisedEstimatedDepartureTime" =>  $data->localisedEstimatedDepartureTime,
          "departureTerminal" =>  $data->departureTerminal,
          "departureTerminalLocalised" =>  $data->departureTerminalLocalised,

          "statusLocalised" =>  $data->statusLocalised,

          "opFlightNumber" =>  $data->opFlightNumber,
          "arrivalGate" =>  $data->arrivalGate,
          "boardingGate" =>  $data->boardingGate,
          "codeshares" =>  ($data->codeshares) ? json_encode($data->codeshares) : NULL,
          "codeShare" =>  ($data->codeShare) ? 1 : 0,
          "type" =>  $type
        );

        $vols[] = $vol;

      }
    }
    return $vols;
  }

  public function syncVolEntity($iata_code="lfw", $type=NULL, $per_date=false, $locale="en-GB"){

      if($type == NULL){
        $type = $this->default_type;
      }

      $vols = $this->loadData($iata_code, $type, $per_date, $locale);

      $volsEntities = [];

      if(!empty($vols)){
        foreach ($vols as $vol){
          $company_values = $vol["company"];


          $airport_arrival_values = $vol["airport_arrival"];
          $airport_departure_values = $vol["airport_departure"];

          $status_values = $vol["status"];


          $company = $this->entityCRUDService->createOrIgnoreIfExistEntity($company_values, "company", "code");

          $airport_arrival = $this->entityCRUDService->createOrIgnoreIfExistEntity($airport_arrival_values, "airport", "code");

          $airport_departure = $this->entityCRUDService->createOrIgnoreIfExistEntity($airport_departure_values, "airport", "code");

          $status = $this->entityCRUDService->createOrIgnoreIfExistEntity($status_values, "status", "code");


          if($company){
            $vol["company"] = $company->id;
          }
          else{
            $vol["company"] = 0;
          }

          if($airport_arrival){
            $vol["airport_arrival"] = $airport_arrival->id;
          }
          else{
            $vol["airport_arrival"] = 0;
          }


          if($airport_departure){
            $vol["airport_departure"] = $airport_departure->id;
          }
          else{
            $vol["airport_departure"] = 0;
          }

          if($status){
            $vol["status"] = $status->id;
          }
          else{
            $vol["status"] = 0;
          }

          $volsEntities[] = $this->entityCRUDService->createUpdateEntity($vol, "vol", "flightNumber");
        }
      }

      return $volsEntities;
  }
}
