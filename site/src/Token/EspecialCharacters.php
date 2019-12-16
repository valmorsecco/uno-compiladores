<?php
namespace Site\Src\Token;

class EspecialCharacters extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 10;
    $this->name = "caractEspeciais";
    $this->regex = "/^[,]|[;]|[.]|[?]|[!]|[=]$/";
  }
}
