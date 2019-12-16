<?php
namespace Site\Src\Token;

class Main extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 13;
    $this->name = "main";
    $this->regex = "/^main$/";
  }
}
