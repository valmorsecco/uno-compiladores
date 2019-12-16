<?php
namespace Site\Src\Token;

class Variable extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 1;
    $this->name = "Identificador";
    $this->regex = "/^[a-z][A-Za-z0-9]*$/";
  }
}
