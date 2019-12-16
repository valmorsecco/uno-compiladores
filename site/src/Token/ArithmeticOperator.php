<?php
namespace Site\Src\Token;

class ArithmeticOperator extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 4;
    $this->name = "opAritmeticos";
    $this->regex = "/^\+|\-|\*|\/$/";
  }
}
