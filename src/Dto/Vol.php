<?php

namespace Drupal\vols\Dto;

class Vol
{
   public $flight_date;

   public $flight_status;

  public $flight_number;
  public $flight_iata;
  public $flight_icao;
  public $aircraft;
  public $live;

   public VolDetail $departure;
   public VolDetail $arrival;

   public Company $company;

   public CodeShared $codeShared;

  /**
   * @return mixed
   */
  public function getFlightDate()
  {
    return $this->flight_date;
  }

  /**
   * @param mixed $flight_date
   */
  public function setFlightDate($flight_date): void
  {
    $this->flight_date = $flight_date;
  }

  /**
   * @return mixed
   */
  public function getFlightStatus()
  {
    return $this->flight_status;
  }

  /**
   * @param mixed $flight_status
   */
  public function setFlightStatus($flight_status): void
  {
    $this->flight_status = $flight_status;
  }

  /**
   * @return mixed
   */
  public function getFlightNumber()
  {
    return $this->flight_number;
  }

  /**
   * @param mixed $flight_number
   */
  public function setFlightNumber($flight_number): void
  {
    $this->flight_number = $flight_number;
  }

  /**
   * @return mixed
   */
  public function getFlightIata()
  {
    return $this->flight_iata;
  }

  /**
   * @param mixed $flight_iata
   */
  public function setFlightIata($flight_iata): void
  {
    $this->flight_iata = $flight_iata;
  }

  /**
   * @return mixed
   */
  public function getFlightIcao()
  {
    return $this->flight_icao;
  }

  /**
   * @param mixed $flight_icao
   */
  public function setFlightIcao($flight_icao): void
  {
    $this->flight_icao = $flight_icao;
  }

  /**
   * @return mixed
   */
  public function getAircraft()
  {
    return $this->aircraft;
  }

  /**
   * @param mixed $aircraft
   */
  public function setAircraft($aircraft): void
  {
    $this->aircraft = $aircraft;
  }

  /**
   * @return mixed
   */
  public function getLive()
  {
    return $this->live;
  }

  /**
   * @param mixed $live
   */
  public function setLive($live): void
  {
    $this->live = $live;
  }

  /**
   * @return VolDetail
   */
  public function getDeparture(): VolDetail
  {
    return $this->departure;
  }

  /**
   * @param VolDetail $departure
   */
  public function setDeparture(VolDetail $departure): void
  {
    $this->departure = $departure;
  }

  /**
   * @return VolDetail
   */
  public function getArrival(): VolDetail
  {
    return $this->arrival;
  }

  /**
   * @param VolDetail $arrival
   */
  public function setArrival(VolDetail $arrival): void
  {
    $this->arrival = $arrival;
  }

  /**
   * @return Company
   */
  public function getCompany(): Company
  {
    return $this->company;
  }

  /**
   * @param Company $company
   */
  public function setCompany(Company $company): void
  {
    $this->company = $company;
  }

  /**
   * @return CodeShared
   */
  public function getCodeShared(): CodeShared
  {
    return $this->codeShared;
  }

  /**
   * @param CodeShared $codeShared
   */
  public function setCodeShared(CodeShared $codeShared): void
  {
    $this->codeShared = $codeShared;
  }
}
