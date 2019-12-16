<?php
namespace Site\Src\Token;

class ReservedCond extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 7;
    $this->name = "reservCond";
    $this->regex = "/^while|for|if$/";
  }
}
