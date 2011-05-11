<?php

namespace Domain\Model;

/** @Document */
class Invoice
{

  /** @Id */
  private $id;
  
  /** @EmbedOne(targetDocument="MoneyValue") */
  private $total;

  public function __construct()
  {
  }
  
  /**
   * @return the $id
    */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return the $total
   */
  public function getTotal()
  {
    return $this->total;
  }

  /**
   * @param $total the $total to set
   */
  public function setTotal(MoneyValue $total)
  {
    $this->total = $total;
  }
}