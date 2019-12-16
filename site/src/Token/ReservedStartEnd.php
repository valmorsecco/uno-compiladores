<?php
namespace Site\Src\Token;

class ReservedStartEnd extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 8;
    $this->name = "reservInFin";
    $this->regex = "/^{|}$/";
  }
}
