<?php
namespace Site\Src\Token;

class BlockStartEnd extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 12;
    $this->name = "blocoIniFim";
    $this->regex = "/^\(|\)$/";
  }
}
