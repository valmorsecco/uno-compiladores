<?php
namespace Site\Src\Token;

class Token
{
  /**
   * @var type
   */
  private $type;

  /**
   * @var value
   */
  private $value;

  /**
   * @var line
   */
  private $line;

  public function __construct($type, $value, $line)
  {
    $this->type = $type;
    $this->value = $value;
    $this->line = $line;
  }

  public function getType()
  {
    return $this->type;
  }

  public function getValue()
  {
    return $this->value;
  }

  public function getLine()
  {
    return $this->line;
  }

  public function setLine($line)
  {
    $this->line = $line;
  }
}
