<?php
namespace Site\Src\Semantic;

use Site\Src\Token\Letter;
use Site\Src\Token\Number;
use Site\Src\Token\ReservedType;
use Site\Src\Token\Variable;

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

  public function run()
  {
      $this->analyseVariables();
  }

  private function analyseVariables()
  {
    foreach($this->tokenStream->toArray() as $position => $token) {
      if($token->getType() instanceof Variable) {
        $this->analyseTypeOfVariable($token);
      }
    }
  }

  private function analyseTypeOfVariable($token)
  {
    $positions = $this->findPositionOfVariable($token);
    $variableType = $this->getVariableDeclaration($positions);
    foreach($positions as $position) {
      if($this->tokenStream->get($position + 1)->getValue() == '=') {
        $this->verifyValueToTypeAssignment($variableType, $this->tokenStream->get($position + 2));
      }
    }
  }

  private function findPositionOfVariable($tokenToFind)
  {
    $positions = [];
    foreach($this->tokenStream->toArray() as $position => $token) {
      if($token->getType() == $tokenToFind->getType() && $token->getValue() == $tokenToFind->getValue()) {
        $positions[] = $position;
      }
    }
    return $positions;
  }

  private function getVariableDeclaration($positions)
  {
    if(!$this->tokenStream->get($positions[0] - 1)->getType() instanceof ReservedType) {
      throw new \Exception("The variable '" . $this->tokenStream->get($positions[0])->getValue() . "' has not declared");
    }
    return $this->tokenStream->get($positions[0] - 1);
  }

  private function verifyValueToTypeAssignment($type, $value)
  {
    switch($type->getValue()) {
      case 'int':
        if(!$value->getType() instanceof Number) {
          throw new \Exception("Invalid type assignment to a variable at line " . $value->getLine());
        }
        break;
      case 'char':
        if(!$value->getType() instanceof Letter) {
          throw new \Exception("Invalid type assignment to a variable at line " . $value->getLine());
        }
        break;
      case 'float':
        if(!$value->getType() instanceof Number) {
          throw new \Exception("Invalid type assignment to a variable at line " . $value->getLine());
        }
        break;
    }
    return true;
  }
}
