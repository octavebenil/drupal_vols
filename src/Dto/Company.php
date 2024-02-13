<?php

namespace Drupal\vols\Dto;

class Company
{
  public $name;
  public $iata;
  public $icao;

  /**
   * @param $name
   * @param $iata
   * @param $icao
   */
  public function __construct($name, $iata, $icao)
  {
    $this->name = $name;
    $this->iata = $iata;
    $this->icao = $icao;
  }

  /**
   * @return mixed
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @param mixed $name
   */
  public function setName($name): void
  {
    $this->name = $name;
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


}
