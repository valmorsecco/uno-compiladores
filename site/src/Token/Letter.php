<?php
namespace Site\Src\Token;

class Letter extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 2;
    $this->name = "Letra";
    $this->regex = "/^[A-Za-z]$/";
  }
}
