<?php
namespace Site\Src\Token;

class Comment extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 11;
    $this->name = "Comente";
    $this->regex = "/^\/\*.*\*\/$/";
  }
}
