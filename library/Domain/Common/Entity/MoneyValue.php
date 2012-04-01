<?php

namespace Domain\Common\Entity;

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
   * Add Amount of Money.
   * 
   * @return MoneyValue
   */
  public function add(MoneyValue $amount)
  {
    if ($amount->currency != $this->currency)
      throw new DomainException('Invalid Currency for adding amount.');
      
    $amount = $this->amount + $amount->amount;
    return new self($amount, $this->currency);  
  }
  
  /**
   * Sub Amount of Money.
   * 
   * @return MoneyValue
   */
  public function sub(MoneyValue $amount)
  {
    if ($amount->currency != $this->currency)
      throw new DomainException('Invalid Currency for adding amount.');
      
    $amount = $this->amount - $amount->amount;
    return new self($amount, $this->currency);  
  }  
  
  /**
   * To string.
   */
  public function __toString()
  {
    return $this->amount.' '.$this->currency;
  }
}