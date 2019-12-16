<?php
namespace Site\Src\Token;

class ReservedType extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 9;
    $this->name = "reservTipo";
    $this->regex = "/^int|float|char|double$/";
  }
}
