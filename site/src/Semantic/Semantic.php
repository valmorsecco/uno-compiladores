<?php
namespace Site\Src\Semantic;

class Semantic
{
  /**
   * @var tokenStream
   */
  private $tokenStream;

  public function __construct($tokenStream)
  {
    $this->tokenStream = $tokenStream;
  }
}
