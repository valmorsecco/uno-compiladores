<?php
namespace Site\Src\Token;

class Number extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 3;
    $this->name = "Digito";
    $this->regex = "/^[0-9]+$/";
  }
}
