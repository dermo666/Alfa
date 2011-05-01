<?php

namespace Domain\Model;

/** @Document */
class User
{

  /** @Id */
  private $id;

  /** @String */
  private $name;

  /** @String */
  private $email;

  /**
   * @return the $id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @return the $name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return the $email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * @param $id the $id to set
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @param $name the $name to set
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @param $email the $email to set
   */
  public function setEmail($email)
  {
    $this->email = $email;
  }
  
//    /** @ReferenceMany(targetDocument="BlogPost", cascade="all") */
//    private $posts = array();
}