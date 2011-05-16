<?php
/**
 * Invoice entity.
 * 
 * @author tomas
 *
 */

namespace Domain\Model;

/** 
 * @Document 
 */
class Invoice
{

  /**
   * Invoice Entity Id.
   * 
   * @var   string
   * 
   * @Id 
   */
  private $id;
  
  /**
   * Total Value of Invoice.
   *  
   * @var    Domain\Model\MoneyValue
   * 
   * @EmbedOne(targetDocument="MoneyValue") 
   */
  private $total;

  /**
   * Get Invoice Entity Id.
   * 
   * @return string
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get Invoice Total.
   * 
   * @return Domain\Model\MoneyValue
   */
  public function getTotal()
  {
    return $this->total;
  }

  /**
   * Set Invoice Total.
   * 
   * @param Domain\Model\MoneyValue $total Invoice Total
   * 
   * @return void
   */
  public function setTotal(MoneyValue $total)
  {
    $this->total = $total;
  }
}