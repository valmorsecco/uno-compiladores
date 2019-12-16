<?php
namespace Site\Src\Token;

class LogicalOperator extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 6;
    $this->name = "opLogicos";
    $this->regex = "/^&&|\|\|$/";
  }
}
