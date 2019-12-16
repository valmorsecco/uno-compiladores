<?php
namespace Site\Src\Lexer;

use Site\Src\Token\Comment;
use Site\Src\Token\Token;

abstract class AbstractLexer
{
  const EOF_TOKEN_TYPE = '$eof';

  /**
   * @var currentLine
   */
  private $currentLine = 1;

  protected function getCurrentLine()
  {
    return $this->currentLine;
  }

  protected static function normalizeLineEndings($string)
  {
    return strtr($string, array("\r\n" => "\n", "\r" => "\n"));
  }

  protected static function removeComments($string): string
  {
    $comment = new Comment();
    return preg_replace($comment->getRegex(), "", $string);
  }

  public abstract function extractToken($value);

  public function splitWords($string)
  {
    $words = explode(' ', $string);
    return $words;
  }
  public function run($string)
  {
    $string = self::normalizeLineEndings($string);
    //$string = self::removeComments($string);
    //var_dump($string); die();
    $words = $this->splitWords($string);

    $tokens = array();
    foreach ($words as $word) {
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

    //$tokens[] = new Token(self::EOF_TOKEN_TYPE, '', $this->getCurrentLine());
    return new TokenStream($tokens);
  }
}
