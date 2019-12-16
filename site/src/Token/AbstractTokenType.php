<?php
namespace Site\Src\Token;

abstract class AbstractTokenType
{
  /**
   * @var id
   */
  protected $id;

  /**
   * @var regex
   */
  protected $regex;

  /**
   * @var name
   */
  protected $name;

  public function getId()
  {
    return $this->id;
  }

  public function getRegex()
  {
    return $this->regex;
  }

  public function getName()
  {
    return $this->name;
  }
}
