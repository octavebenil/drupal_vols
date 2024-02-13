<?php
namespace Drupal\vols\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\vols\Dto\CodeShared;
use Drupal\vols\Dto\Company;
use Drupal\vols\Dto\Vol;
use Drupal\vols\Dto\VolDetail;
use const Drupal\vols\Dto\ARRIVAL;
use const Drupal\vols\Dto\DEPARTURE;

class VolsController extends ControllerBase {

  protected $access_key;

  protected $base_url;

  private $lome_icao = "DXXX"; //code ICAO de l'aeroport de Lomé
  private $niamtougou_icao = "DXNG"; //code ICAO de l'aeroport de Niamtougou

  //fitre par aeroport d'arrive
//http://api.aviationstack.com/v1/flights?arr_icao=DXXX&access_key=9a0b25c55df5b02fccc981af8d7f6ebb

  //filtre par aeroport de depart
//http://api.aviationstack.com/v1/flights?dep_icao=DXXX&access_key=9a0b25c55df5b02fccc981af8d7f6ebb


  public function __construct(){
    $this->access_key = "9a0b25c55df5b02fccc981af8d7f6ebb";

    $this->base_url = "http://api.aviationstack.com/v1";
  }

  protected function process_vols($url){

    $client = \Drupal::httpClient();


    $batch_vols = $client->get($url,[
      'headers' => [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
      ],
    ])->getBody();

    $batch_vols = json_decode($batch_vols);

    $vols = [];

    if(!empty($batch_vols)){
      foreach ($batch_vols->data as $data){
        $vol = new Vol();

        $vol->setFlightDate($data->flight_date);
        $vol->setFlightStatus($data->flight_status);
        $vol->setAircraft($data->aircraft);
        $vol->setLive($data->live);
        $vol->setFlightNumber($data->flight->number);
        $vol->setFlightIata($data->flight->iata);
        $vol->setFlightIcao($data->flight->icao);

        $depart = new VolDetail(
          $data->departure->airport,
          $data->departure->timezone,
          $data->departure->iata,
          $data->departure->icao,
          $data->departure->terminal,
          $data->departure->gate,
          $data->departure->delay,
          $data->departure->scheduled,
          $data->departure->estimated,
          $data->departure->actual,
          $data->departure->estimated_runway,
          $data->departure->actual_runway,
          DEPARTURE
        );


        $arrive = new VolDetail(
          $data->arrival->airport,
          $data->arrival->timezone,
          $data->arrival->iata,
          $data->arrival->icao,
          $data->arrival->terminal,
          $data->arrival->gate,
          $data->arrival->delay,
          $data->arrival->scheduled,
          $data->arrival->estimated,
          $data->arrival->actual,
          $data->arrival->estimated_runway,
          $data->arrival->actual_runway,
          ARRIVAL
        );

        $vol->setDeparture($depart);
        $vol->setArrival($arrive);


        $company = new Company(
          $data->airline->name,
          $data->airline->iata,
          $data->airline->icao
        );

        $vol->setCompany($company);

//        $codeshared = new CodeShared(
//          $data->flight->codeshared->airline_name,
//          $data->flight->codeshared->airline_iata,
//          $data->flight->codeshared->airline_icao,
//          $data->flight->codeshared->flight_number,
//          $data->flight->codeshared->flight_iata,
//          $data->flight->codeshared->flight_icao
//        );
//
//        $vol->setCodeShared($codeshared);

        $vols[] = $vol;

      }
    }

    return $vols;
  }

  public function list(){

    $url = $this->base_url."/flights?dep_icao=$this->lome_icao&access_key=".$this->access_key;

    $vols = $this->process_vols($url);

    return [
      '#theme' => 'vols_list_template',
      '#type' => 'departure',
      '#vols' => $vols
    ];
  }


  public function arrivals(){

    $url = $this->base_url."/flights?arr_icao=$this->lome_icao&access_key=".$this->access_key;

    $vols = $this->process_vols($url);

    return [
      '#theme' => 'vols_list_template',
      '#type' => 'arrival',
      '#vols' => $vols
    ];
  }


  public function settings(){
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Settings!'),
    ];
  }
}
