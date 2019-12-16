<?php
namespace Site\Src\Lexer;

use Site\Src\SymbolTable\SymbolTableRecognizer;

class Lexer extends AbstractLexer
{
  /**
   * @var symbolTable
   */
  private $symbolTable;

  public function __construct($symbolTable)
  {
    $this->symbolTable = $symbolTable;
  }

  public function extractToken($value)
  {
    return $this->symbolTable->findTokenMatch($value);
  }
}
