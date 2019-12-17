<?php
namespace Site\Src\Lexer;

use Site\Src\Token\Comment;
use Site\Src\Token\Token;

class Lexer
{
  /**
   * @var currentLine
   */
  private $currentLine;

  /**
   * @var symbolTable
   */
  private $symbolTable;

  /**
   * @var text
   */
  private $text;

  public function __construct($symbolTable, $text)
  {
    $this->currentLine = 1;
    $this->symbolTable = $symbolTable;
    $this->text = $text;
  }

  public function extractToken($value)
  {
    return $this->symbolTable->findTokenMatch($value);
  }

  protected function getCurrentLine()
  {
    return $this->currentLine;
  }

  protected function normalizeLineEndings($string)
  {
    return strtr($string, array("\r\n" => "\n", "\r" => "\n"));
  }

  protected function removeComments($string)
  {
    return preg_replace((new Comment())->getRegex(), "", $string);
  }

  public function splitWords($string)
  {
    return explode(' ', $string);
  }

  public function run()
  {
    $string = $this->normalizeLineEndings($this->text);
    $string = $this->removeComments($string);

    if(trim($string) === "") {
      throw new \Exception("Text is empty!");
    }

    $words = $this->splitWords($string);
    $tokens = [];
    foreach($words as $word) {
      if($word == ' ' || $word == '') {
        continue;
      }
      if($word == "\n") {
        $this->currentLine++;
        continue;
      }
      $tokenType = $this->extractToken($word);
      $tokens[] = new Token($tokenType, $word, $this->currentLine);
    }
    return new TokenStream($tokens);
  }
}
