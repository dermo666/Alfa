<?php
/**
 * Invoice entity.
 * 
 * @author tomas
 *
 */

namespace Domain\Invoice\Entity;

use Zend\Registry,
    Domain\Common\Entity\MoneyValue,
    Domain\User\Entity\User;

/** 
 * @Document @HasLifecycleCallbacks
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
   * @var    Domain\Common\Entity\MoneyValue
   * 
   * @EmbedOne(targetDocument="Domain\Common\Entity\MoneyValue") 
   */
  private $total;

  /**
   * Created By.
   * 
   * @var    Domain\User\Entity\User
   * 
   * @ReferenceOne(targetDocument="Domain\User\Entity\User")
   */
  private $createdBy;
  
  /**
   * Created On.
   * 
   * @var    Date
   * 
   * @Field
   */
  private $createdAt;
  
  /**
   * Modified By.
   * 
   * @var    Domain\Entity\User
   * 
   * @ReferenceOne(targetDocument="Domain\User\Entity\User")
   */
  private $modifiedBy;
  
  /**
   * Modified On.
   * 
   * @var    Date
   * 
   * @Field
   */
  private $modifiedAt;  
  
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
   * @return Domain\Common\Entity\MoneyValue
   */
  public function getTotal()
  {
    return $this->total;
  }

  /**
   * Set Invoice Total.
   * 
   * @param Domain\Common\Entity\MoneyValue $total Invoice Total
   * 
   * @return void
   */
  public function setTotal(MoneyValue $total)
  {
    $this->total = $total;
  }
  
  /**
   * Get Created By.
   * 
   * @return Domain\User\Entity\User.
   */
  public function getCreatedBy()
  {
    return $this->createdBy;
  }
  
  /**
   * Get Modified By.
   * 
   * @return Domain\User\Entity\User.
   */
  public function getModifiedBy()
  {
    return $this->modifiedBy;
  }
  
  /**
   * Set basic prePersist data.
   * 
   * @PrePersist
   */
  public function prePersist()
  {
    $this->createdBy = Registry::getInstance()->get('user');
    $this->createdAt = date('c');
  }

  /**
   * Set basic preUpdate data.
   * 
   * @PreUpdate
   */
  public function preUpdate()
  {
    $this->modifiedBy = Registry::getInstance()->get('user');
    $this->modifiedAt = date('c');
  }
}