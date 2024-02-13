<?php

namespace Drupal\vols\Dto;

const DEPARTURE = 'departure';
const ARRIVAL = 'arrival';

$TYPE_VOLS = [
  DEPARTURE => "Départ",
  ARRIVAL => "Arrivé"
];
class VolDetail
{
  public $airport;

  public $timezone;
  public $iata;
  public $icao;
  public $terminal;
  public $gate;
  public $delay;
  public $scheduled;
  public $estimated;
  public $actual;
  public $estimated_runway;
  public $actual_runway;

  public $type_vol = "departure";

  /**
   * @param $airport
   * @param $timezone
   * @param $iata
   * @param $icao
   * @param $terminal
   * @param $gate
   * @param $delay
   * @param $scheduled
   * @param $estimated
   * @param $actual
   * @param $estimated_runway
   * @param $actual_runway
   * @param string $type_vol
   */
  public function __construct($airport, $timezone, $iata, $icao, $terminal, $gate, $delay, $scheduled, $estimated, $actual, $estimated_runway, $actual_runway, string $type_vol)
  {
    $this->airport = $airport;
    $this->timezone = $timezone;
    $this->iata = $iata;
    $this->icao = $icao;
    $this->terminal = $terminal;
    $this->gate = $gate;
    $this->delay = $delay;
    $this->scheduled = $scheduled;
    $this->estimated = $estimated;
    $this->actual = $actual;
    $this->estimated_runway = $estimated_runway;
    $this->actual_runway = $actual_runway;
    $this->type_vol = $type_vol;
  }

  /**
   * @return mixed
   */
  public function getAirport()
  {
    return $this->airport;
  }

  /**
   * @param mixed $airport
   */
  public function setAirport($airport): void
  {
    $this->airport = $airport;
  }

  /**
   * @return mixed
   */
  public function getTimezone()
  {
    return $this->timezone;
  }

  /**
   * @param mixed $timezone
   */
  public function setTimezone($timezone): void
  {
    $this->timezone = $timezone;
  }

  /**
   * @return mixed
   */
  public function getIata()
  {
    return $this->iata;
  }

  /**
   * @param mixed $iata
   */
  public function setIata($iata): void
  {
    $this->iata = $iata;
  }

  /**
   * @return mixed
   */
  public function getIcao()
  {
    return $this->icao;
  }

  /**
   * @param mixed $icao
   */
  public function setIcao($icao): void
  {
    $this->icao = $icao;
  }

  /**
   * @return mixed
   */
  public function getTerminal()
  {
    return $this->terminal;
  }

  /**
   * @param mixed $terminal
   */
  public function setTerminal($terminal): void
  {
    $this->terminal = $terminal;
  }

  /**
   * @return mixed
   */
  public function getGate()
  {
    return $this->gate;
  }

  /**
   * @param mixed $gate
   */
  public function setGate($gate): void
  {
    $this->gate = $gate;
  }

  /**
   * @return mixed
   */
  public function getDelay()
  {
    return $this->delay;
  }

  /**
   * @param mixed $delay
   */
  public function setDelay($delay): void
  {
    $this->delay = $delay;
  }

  /**
   * @return mixed
   */
  public function getScheduled()
  {
    return $this->scheduled;
  }

  /**
   * @param mixed $scheduled
   */
  public function setScheduled($scheduled): void
  {
    $this->scheduled = $scheduled;
  }

  /**
   * @return mixed
   */
  public function getEstimated()
  {
    return $this->estimated;
  }

  /**
   * @param mixed $estimated
   */
  public function setEstimated($estimated): void
  {
    $this->estimated = $estimated;
  }

  /**
   * @return mixed
   */
  public function getActual()
  {
    return $this->actual;
  }

  /**
   * @param mixed $actual
   */
  public function setActual($actual): void
  {
    $this->actual = $actual;
  }

  /**
   * @return mixed
   */
  public function getEstimatedRunway()
  {
    return $this->estimated_runway;
  }

  /**
   * @param mixed $estimated_runway
   */
  public function setEstimatedRunway($estimated_runway): void
  {
    $this->estimated_runway = $estimated_runway;
  }

  /**
   * @return mixed
   */
  public function getActualRunway()
  {
    return $this->actual_runway;
  }

  /**
   * @param mixed $actual_runway
   */
  public function setActualRunway($actual_runway): void
  {
    $this->actual_runway = $actual_runway;
  }

  /**
   * @return string
   */
  public function getTypeVol(): string
  {
    return $this->type_vol;
  }

  /**
   * @param string $type_vol
   */
  public function setTypeVol(string $type_vol): void
  {
    $this->type_vol = $type_vol;
  }

}
