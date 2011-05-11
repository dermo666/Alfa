<?php

namespace Domain\Model;

/** @EmbeddedDocument */
class MoneyValue
{

  /** @Float */
  private $amount;

  /** @String */
  private $currency;

  /**
   * Constructor
   */
  public function __construct($amount, $currency)
  {
    $this->amount = $amount;
    $this->currency = $currency; 
  }

  /**
   * To string.
   */
  public function __toString()
  {
    return $this->amount.' '.$this->currency;
  }
}