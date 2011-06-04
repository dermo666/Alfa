<?php
/**
 * Invoice entity.
 * 
 * @author tomas
 *
 */

namespace Domain\Model;

use Zend\Registry;

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
   * @var    Domain\Model\MoneyValue
   * 
   * @EmbedOne(targetDocument="MoneyValue") 
   */
  private $total;

  /**
   * Created By.
   * 
   * @var    Domain\Model\User
   * 
   * @ReferenceOne(targetDocument="User")
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
   * @var    Domain\Model\User
   * 
   * @ReferenceOne(targetDocument="User")
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
  
  /**
   * Get Created By.
   * 
   * @return User.
   */
  public function getCreatedBy()
  {
    return $this->createdBy;
  }
  
  /**
   * Get Modified By.
   * 
   * @return User.
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