<?php

namespace Drupal\vols\Dto;

class Vol
{
   protected $airlineId;
   protected $airlineName;
   protected $arrivalAirportCode;
   protected $departureAirportCode;
   protected $arrivalAirportName;
   protected $departureAirportName;
   protected $flightNumber;
   protected $scheduledArrivalTime;
   protected $localisedScheduledArrivalTime;
   protected $estimatedArrivalTime;
   protected $localisedEstimatedArrivalTime;
   protected $arrivalTerminal;
   protected $arrivalTerminalLocalised;
   protected $scheduledDepartureTime;
   protected $localisedScheduledDepartureTime;
   protected $estimatedDepartureTime;
   protected $localisedEstimatedDepartureTime;
   protected $departureTerminal;
   protected $departureTerminalLocalised;
   protected $status;
   protected $statusLocalised;
   protected $opFlightNumber;
   protected $arrivalGate;
   protected $boardingGate;
   protected $codeshares;
   protected $codeShare;

   protected $type;

  /**
   * @param $airlineId
   * @param $airlineName
   * @param $arrivalAirportCode
   * @param $departureAirportCode
   * @param $arrivalAirportName
   * @param $departureAirportName
   * @param $flightNumber
   * @param $scheduledArrivalTime
   * @param $localisedScheduledArrivalTime
   * @param $estimatedArrivalTime
   * @param $localisedEstimatedArrivalTime
   * @param $arrivalTerminal
   * @param $arrivalTerminalLocalised
   * @param $scheduledDepartureTime
   * @param $localisedScheduledDepartureTime
   * @param $estimatedDepartureTime
   * @param $localisedEstimatedDepartureTime
   * @param $departureTerminal
   * @param $departureTerminalLocalised
   * @param $status
   * @param $statusLocalised
   * @param $opFlightNumber
   * @param $arrivalGate
   * @param $boardingGate
   * @param $codeshares
   * @param $codeShare
   * @param $type
   */
  public function __construct($airlineId, $airlineName, $arrivalAirportCode, $departureAirportCode, $arrivalAirportName, $departureAirportName, $flightNumber, $scheduledArrivalTime, $localisedScheduledArrivalTime, $estimatedArrivalTime, $localisedEstimatedArrivalTime, $arrivalTerminal, $arrivalTerminalLocalised, $scheduledDepartureTime, $localisedScheduledDepartureTime, $estimatedDepartureTime, $localisedEstimatedDepartureTime, $departureTerminal, $departureTerminalLocalised, $status, $statusLocalised, $opFlightNumber, $arrivalGate, $boardingGate, $codeshares, $codeShare, $type)
  {
    $this->airlineId = $airlineId;
    $this->airlineName = $airlineName;
    $this->arrivalAirportCode = $arrivalAirportCode;
    $this->departureAirportCode = $departureAirportCode;
    $this->arrivalAirportName = $arrivalAirportName;
    $this->departureAirportName = $departureAirportName;
    $this->flightNumber = $flightNumber;

    $this->scheduledArrivalTime = $scheduledArrivalTime;
    $this->localisedScheduledArrivalTime = $localisedScheduledArrivalTime;
    $this->estimatedArrivalTime = $estimatedArrivalTime;
    $this->localisedEstimatedArrivalTime = $localisedEstimatedArrivalTime;


    $this->arrivalTerminal = $arrivalTerminal;
    $this->arrivalTerminalLocalised = $arrivalTerminalLocalised;

    $this->scheduledDepartureTime = $scheduledDepartureTime;
    $this->localisedScheduledDepartureTime = $localisedScheduledDepartureTime;
    $this->estimatedDepartureTime = $estimatedDepartureTime;
    $this->localisedEstimatedDepartureTime = $localisedEstimatedDepartureTime;

    $this->departureTerminal = $departureTerminal;
    $this->departureTerminalLocalised = $departureTerminalLocalised;

    $this->status = $status;
    $this->statusLocalised = $statusLocalised;
    $this->opFlightNumber = $opFlightNumber;

    $this->arrivalGate = $arrivalGate;
    $this->boardingGate = $boardingGate;
    $this->codeshares = $codeshares;
    $this->codeShare = $codeShare;

    $this->type = $type;
  }


  /**
   * @return mixed
   */
  public function getAirlineId()
  {
    return $this->airlineId;
  }

  /**
   * @param mixed $airlineId
   */
  public function setAirlineId($airlineId): void
  {
    $this->airlineId = $airlineId;
  }

  /**
   * @return mixed
   */
  public function getAirlineName()
  {
    return $this->airlineName;
  }

  /**
   * @param mixed $airlineName
   */
  public function setAirlineName($airlineName): void
  {
    $this->airlineName = $airlineName;
  }

  /**
   * @return mixed
   */
  public function getArrivalAirportCode()
  {
    return $this->arrivalAirportCode;
  }

  /**
   * @param mixed $arrivalAirportCode
   */
  public function setArrivalAirportCode($arrivalAirportCode): void
  {
    $this->arrivalAirportCode = $arrivalAirportCode;
  }

  /**
   * @return mixed
   */
  public function getDepartureAirportCode()
  {
    return $this->departureAirportCode;
  }

  /**
   * @param mixed $departureAirportCode
   */
  public function setDepartureAirportCode($departureAirportCode): void
  {
    $this->departureAirportCode = $departureAirportCode;
  }

  /**
   * @return mixed
   */
  public function getArrivalAirportName()
  {
    return $this->arrivalAirportName;
  }

  /**
   * @param mixed $arrivalAirportName
   */
  public function setArrivalAirportName($arrivalAirportName): void
  {
    $this->arrivalAirportName = $arrivalAirportName;
  }

  /**
   * @return mixed
   */
  public function getDepartureAirportName()
  {
    return $this->departureAirportName;
  }

  /**
   * @param mixed $departureAirportName
   */
  public function setDepartureAirportName($departureAirportName): void
  {
    $this->departureAirportName = $departureAirportName;
  }

  /**
   * @return mixed
   */
  public function getFlightNumber()
  {
    return $this->flightNumber;
  }

  /**
   * @param mixed $flightNumber
   */
  public function setFlightNumber($flightNumber): void
  {
    $this->flightNumber = $flightNumber;
  }

  /**
   * @return mixed
   */
  public function getScheduledArrivalTime()
  {
    return $this->scheduledArrivalTime;
  }

  /**
   * @param mixed $scheduledArrivalTime
   */
  public function setScheduledArrivalTime($scheduledArrivalTime): void
  {
    $this->scheduledArrivalTime = $scheduledArrivalTime;
  }

  /**
   * @return mixed
   */
  public function getLocalisedScheduledArrivalTime()
  {
    return $this->localisedScheduledArrivalTime;
  }

  /**
   * @param mixed $localisedScheduledArrivalTime
   */
  public function setLocalisedScheduledArrivalTime($localisedScheduledArrivalTime): void
  {
    $this->localisedScheduledArrivalTime = $localisedScheduledArrivalTime;
  }

  /**
   * @return mixed
   */
  public function getEstimatedArrivalTime()
  {
    return $this->estimatedArrivalTime;
  }

  /**
   * @param mixed $estimatedArrivalTime
   */
  public function setEstimatedArrivalTime($estimatedArrivalTime): void
  {
    $this->estimatedArrivalTime = $estimatedArrivalTime;
  }

  /**
   * @return mixed
   */
  public function getLocalisedEstimatedArrivalTime()
  {
    return $this->localisedEstimatedArrivalTime;
  }

  /**
   * @param mixed $localisedEstimatedArrivalTime
   */
  public function setLocalisedEstimatedArrivalTime($localisedEstimatedArrivalTime): void
  {
    $this->localisedEstimatedArrivalTime = $localisedEstimatedArrivalTime;
  }

  /**
   * @return mixed
   */
  public function getArrivalTerminal()
  {
    return $this->arrivalTerminal;
  }

  /**
   * @param mixed $arrivalTerminal
   */
  public function setArrivalTerminal($arrivalTerminal): void
  {
    $this->arrivalTerminal = $arrivalTerminal;
  }

  /**
   * @return mixed
   */
  public function getArrivalTerminalLocalised()
  {
    return $this->arrivalTerminalLocalised;
  }

  /**
   * @param mixed $arrivalTerminalLocalised
   */
  public function setArrivalTerminalLocalised($arrivalTerminalLocalised): void
  {
    $this->arrivalTerminalLocalised = $arrivalTerminalLocalised;
  }

  /**
   * @return mixed
   */
  public function getScheduledDepartureTime()
  {
    return $this->scheduledDepartureTime;
  }

  /**
   * @param mixed $scheduledDepartureTime
   */
  public function setScheduledDepartureTime($scheduledDepartureTime): void
  {
    $this->scheduledDepartureTime = $scheduledDepartureTime;
  }

  /**
   * @return mixed
   */
  public function getLocalisedScheduledDepartureTime()
  {
    return $this->localisedScheduledDepartureTime;
  }

  /**
   * @param mixed $localisedScheduledDepartureTime
   */
  public function setLocalisedScheduledDepartureTime($localisedScheduledDepartureTime): void
  {
    $this->localisedScheduledDepartureTime = $localisedScheduledDepartureTime;
  }

  /**
   * @return mixed
   */
  public function getEstimatedDepartureTime()
  {
    return $this->estimatedDepartureTime;
  }

  /**
   * @param mixed $estimatedDepartureTime
   */
  public function setEstimatedDepartureTime($estimatedDepartureTime): void
  {
    $this->estimatedDepartureTime = $estimatedDepartureTime;
  }

  /**
   * @return mixed
   */
  public function getLocalisedEstimatedDepartureTime()
  {
    return $this->localisedEstimatedDepartureTime;
  }

  /**
   * @param mixed $localisedEstimatedDepartureTime
   */
  public function setLocalisedEstimatedDepartureTime($localisedEstimatedDepartureTime): void
  {
    $this->localisedEstimatedDepartureTime = $localisedEstimatedDepartureTime;
  }

  /**
   * @return mixed
   */
  public function getDepartureTerminal()
  {
    return $this->departureTerminal;
  }

  /**
   * @param mixed $departureTerminal
   */
  public function setDepartureTerminal($departureTerminal): void
  {
    $this->departureTerminal = $departureTerminal;
  }

  /**
   * @return mixed
   */
  public function getDepartureTerminalLocalised()
  {
    return $this->departureTerminalLocalised;
  }

  /**
   * @param mixed $departureTerminalLocalised
   */
  public function setDepartureTerminalLocalised($departureTerminalLocalised): void
  {
    $this->departureTerminalLocalised = $departureTerminalLocalised;
  }

  /**
   * @return mixed
   */
  public function getStatus()
  {
    return $this->status;
  }

  /**
   * @param mixed $status
   */
  public function setStatus($status): void
  {
    $this->status = $status;
  }

  /**
   * @return mixed
   */
  public function getStatusLocalised()
  {
    return $this->statusLocalised;
  }

  /**
   * @param mixed $statusLocalised
   */
  public function setStatusLocalised($statusLocalised): void
  {
    $this->statusLocalised = $statusLocalised;
  }

  /**
   * @return mixed
   */
  public function getOpFlightNumber()
  {
    return $this->opFlightNumber;
  }

  /**
   * @param mixed $opFlightNumber
   */
  public function setOpFlightNumber($opFlightNumber): void
  {
    $this->opFlightNumber = $opFlightNumber;
  }

  /**
   * @return mixed
   */
  public function getArrivalGate()
  {
    return $this->arrivalGate;
  }

  /**
   * @param mixed $arrivalGate
   */
  public function setArrivalGate($arrivalGate): void
  {
    $this->arrivalGate = $arrivalGate;
  }

  /**
   * @return mixed
   */
  public function getBoardingGate()
  {
    return $this->boardingGate;
  }

  /**
   * @param mixed $boardingGate
   */
  public function setBoardingGate($boardingGate): void
  {
    $this->boardingGate = $boardingGate;
  }

  /**
   * @return mixed
   */
  public function getCodeshares()
  {
    return $this->codeshares;
  }

  /**
   * @param mixed $codeshares
   */
  public function setCodeshares($codeshares): void
  {
    $this->codeshares = $codeshares;
  }

  /**
   * @return mixed
   */
  public function getCodeShare()
  {
    return $this->codeShare;
  }

  /**
   * @param mixed $codeShare
   */
  public function setCodeShare($codeShare): void
  {
    $this->codeShare = $codeShare;
  }

  /**
   * @return mixed
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * @param mixed $type
   */
  public function setType($type): void
  {
    $this->type = $type;
  }
}
