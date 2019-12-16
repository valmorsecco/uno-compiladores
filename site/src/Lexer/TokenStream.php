<?php
namespace Site\Src\Lexer;

use Traversable;

class TokenStream
{
  /**
   * @var tokens
   */
  protected $tokens;

  /**
   * @var position
   */
  protected $position = 0;

  public function __construct($tokens)
  {
    $this->tokens = $tokens;
  }

  public function getIterator()
  {
    return new \ArrayIterator($this->tokens);
  }

  public function count()
  {
    return count($this->tokens);
  }

  public function getPosition()
  {
    return $this->position;
  }

  public function getCurrentToken()
  {
    return $this->tokens[$this->position];
  }

  public function lookAhead($position)
  {
    if(!isset($this->tokens[$this->position + $position])) {
      throw new \Exception("Invalid look-ahead.");
    }
    return $this->tokens[$this->position + $position];
  }

  public function get($position)
  {
    if(!isset($this->tokens[$position])) {
      throw new \Exception("Invalid index.");
    }
    return $this->tokens[$position];
  }

  public function move($position)
  {
    if(!isset($this->tokens[$position])) {
      throw new \Exception("Invalid index to move to.");
    }
    $this->position = $position;
  }

  public function seek($value)
  {
    if(!isset($this->tokens[$this->position + $value])) {
      throw new \Exception("Invalid seek.");
    }
    $this->position += $value;
  }

  public function next()
  {
    if(!isset($this->tokens[$this->position + 1])) {
      throw new \Exception("Attempting to move beyond the end of the stream.");
    }
    $this->position++;
  }

  public function toArray()
  {
    return $this->tokens;
  }
}
