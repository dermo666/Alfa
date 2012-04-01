<?php

namespace Domain\User\Entity;

/**
 * @Document
 */
class User
{

  /** @Id */
  private $id;

  /** @String */
  private $name;

  /** @String */
  private $email;

  /**
   * Get Id.
   * 
   * @return the $id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get Name.
   * 
   * @return the $name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Get Email.
   * 
   * @return the $email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set Name.
   * 
   * @param $name the $name to set
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * Set Email.
   * 
   * @param $email the $email to set
   */
  public function setEmail($email)
  {
    $this->email = $email;
  }
}