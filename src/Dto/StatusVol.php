<?php


namespace Drupal\vols\Dto;

class StatusVol{
  protected $id;

  protected $code;

  protected $name;
  protected $created_at;
  protected $updated_at;

  /**
   * @param $id
   * @param $code
   * @param $name
   * @param $created_at
   * @param $updated_at
   */
  public function __construct($id, $code, $name, $created_at, $updated_at)
  {
    $this->id = $id;
    $this->code = $code;
    $this->name = $name;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id): void
  {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getCode()
  {
    return $this->code;
  }

  /**
   * @param mixed $code
   */
  public function setCode($code): void
  {
    $this->code = $code;
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
  public function getCreatedAt()
  {
    return $this->created_at;
  }

  /**
   * @param mixed $created_at
   */
  public function setCreatedAt($created_at): void
  {
    $this->created_at = $created_at;
  }

  /**
   * @return mixed
   */
  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

  /**
   * @param mixed $updated_at
   */
  public function setUpdatedAt($updated_at): void
  {
    $this->updated_at = $updated_at;
  }
}
