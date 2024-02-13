<?php

namespace Drupal\vols\Dto;

class CodeShared
{
  public  $airline_name;
  public  $airline_iata;
  public  $airline_icao;
  public  $flight_number;
  public  $flight_iata;
  public  $flight_icao;

  /**
   * @param $airline_name
   * @param $airline_iata
   * @param $airline_icao
   * @param $flight_number
   * @param $flight_iata
   * @param $flight_icao
   */
  public function __construct($airline_name, $airline_iata, $airline_icao, $flight_number, $flight_iata, $flight_icao)
  {
    $this->airline_name = $airline_name;
    $this->airline_iata = $airline_iata;
    $this->airline_icao = $airline_icao;
    $this->flight_number = $flight_number;
    $this->flight_iata = $flight_iata;
    $this->flight_icao = $flight_icao;
  }


  /**
   * @return string
   */
  public function getAirlineName(): string
  {
    return $this->airline_name;
  }

  /**
   * @param string $airline_name
   */
  public function setAirlineName(string $airline_name): void
  {
    $this->airline_name = $airline_name;
  }

  /**
   * @return string
   */
  public function getAirlineIata(): string
  {
    return $this->airline_iata;
  }

  /**
   * @param string $airline_iata
   */
  public function setAirlineIata(string $airline_iata): void
  {
    $this->airline_iata = $airline_iata;
  }

  /**
   * @return string
   */
  public function getAirlineIcao(): string
  {
    return $this->airline_icao;
  }

  /**
   * @param string $airline_icao
   */
  public function setAirlineIcao(string $airline_icao): void
  {
    $this->airline_icao = $airline_icao;
  }

  /**
   * @return string
   */
  public function getFlightNumber(): string
  {
    return $this->flight_number;
  }

  /**
   * @param string $flight_number
   */
  public function setFlightNumber(string $flight_number): void
  {
    $this->flight_number = $flight_number;
  }

  /**
   * @return string
   */
  public function getFlightIata(): string
  {
    return $this->flight_iata;
  }

  /**
   * @param string $flight_iata
   */
  public function setFlightIata(string $flight_iata): void
  {
    $this->flight_iata = $flight_iata;
  }

  /**
   * @return string
   */
  public function getFlightIcao(): string
  {
    return $this->flight_icao;
  }

  /**
   * @param string $flight_icao
   */
  public function setFlightIcao(string $flight_icao): void
  {
    $this->flight_icao = $flight_icao;
  }


}
