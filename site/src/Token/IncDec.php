<?php
namespace Site\Src\Token;

class IncDec extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 14;
    $this->name = "IncDec";
    $this->regex = "/^\+\+|\-\-$/";
  }
}
