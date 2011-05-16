<?php
/**
 * Invoice Repository Class.
 * 
 * Based on blog post explaining why Specific Repositories are better than Generic ones:
 * 
 * http://codebetter.com/gregyoung/2009/01/16/ddd-the-generic-repository/
 * 
 * @author tomas
 *
 */

namespace Domain\Repository;

use Doctrine\ODM\MongoDB\DocumentManager,
    Domain\Model\Invoice;

class InvoiceRepository
{
  
  const ENTITY_NAME = 'Domain\Model\Invoice';
  
  /**
   * Document Manager.
   * 
   * @var   DocumentManager
   */
  private $dm = NULL;
  
  /**
   * Constructor
   * 
   * @param DocumentManager $dm Document Manager
   */
  public function __construct(DocumentManager $dm)
  {
    $this->dm = $dm;
  }

  /**
   * Find By Id.
   * 
   * @param mixed $id Id of the Entity.
   * 
   * @return mixed
   */
  public function find($id)
  {
    return $this->dm->getRepository(self::ENTITY_NAME)->find($id);
  }
  
  /**
   * Find By Total.
   * 
   * @param float $total Total of the Invoice.
   * 
   * @return array
   */
  public function findByTotal($total)
  {
    $qb    = $this->dm->createQueryBuilder(self::ENTITY_NAME)
                      ->field('total.amount')->equals(floatval($total));
    $query = $qb->getQuery();
    return $query->execute();
  }
  
  /**
   * Add Entity to Collection.
   * 
   * @param mixed $entity Entity.
   * 
   * @return void
   */
  public function add($entity)
  {
    $this->dm->persist($entity);
  }
  
  /**
   * Removes Entity from Collection.
   * 
   * @param mixed $entity Entity.
   * 
   * @return void
   */
  public function remove($entity)
  {
    $this->dm->remove($entity);
  }
}