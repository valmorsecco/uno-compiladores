<?php
namespace Site\Src\SymbolTable;

use Site\Src\Util\RegexRecognizer;

class SymbolTableRecognizer
{
  /**
   * @var tokens
   */
  protected $tokens = [];

  public function add($token)
  {
    $this->tokens[] = $token;
  }

  public function getTokens()
  {
    return $this->tokens;
  }

  public function findTokenMatch($string)
  {
    foreach ($this->tokens as $token) {
      if(RegexRecognizer::match($token->getRegex(), $string)) {
        return $token;
      }
    }
    throw new \Exception($string);
  }
}
