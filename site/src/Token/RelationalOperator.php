<?php
namespace Site\Src\Token;

class RelationalOperator extends AbstractTokenType
{
  public function __construct()
  {
    $this->id = 5;
    $this->name = "opRelacionais";
    $this->regex = "/^>=|<=|==|!=|<|>$/";
  }
}
