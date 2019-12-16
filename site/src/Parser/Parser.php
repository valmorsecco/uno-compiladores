<?php
namespace Site\Src\Parser;

use Site\Src\Token\ArithmeticOperator;
use Site\Src\Token\BlockStartEnd;
use Site\Src\Token\EspecialCharacters;
use Site\Src\Token\LogicalOperator;
use Site\Src\Token\Main;
use Site\Src\Token\Number;
use Site\Src\Token\RelationalOperator;
use Site\Src\Token\ReservedCond;
use Site\Src\Token\ReservedStartEnd;
use Site\Src\Token\ReservedType;
use Site\Src\Token\Variable;
use Site\Src\Token\IncDec;

/*
S <- main {A}
A <- BA | if(ident H opRel GF) {A} A | while(ident H opRel GF){A} A | for(B ident H opRel GF; ident = G) {A} A| &
B <- tipo ident C | ident C
C <- = D | ;
D <- ident E | valor E
E <- opArit D | ;
F <- opLog ident H opRel GF | &
G <- ident H | valor H
H <- opArit G | &
*/

class Parser
{
  /**
   * @var tokenStream
   */
  private $tokenStream;

  /**
   * @var logs
   */
  private $logs = [];

  /**
   * @var verbose
   */
  private $verbose;

  public function __construct($tokenStream, $verbose = false)
  {
    $this->tokenStream = $tokenStream;
    $this->verbose = $verbose;
  }

  protected function addSyntaxError($message)
  {
    throw new \Exception($message);
    //$this->errors[] = $message;
  }

  public function getLog()
  {
    return $this->logs;
  }

  protected function getCurrentToken()
  {
    return $this->tokenStream->getCurrentToken();
  }

  protected function log($message)
  {
    if($this->verbose) {
      $this->logs[] = $message;
    }
  }

  private function matchCurrentToken($tokenType)
  {
    return $this->getCurrentToken()->getType() instanceof $tokenType;
  }

  public function run()
  {
      $this->S();
  }

  private function S()
  {
    $this->log("Entrou no S");
    if(!$this->matchCurrentToken(Main::class)) {
      $this->addSyntaxError("Expected a 'Main' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(ReservedStartEnd::class)) {
      $this->addSyntaxError("Expected '{' at line " . $this->getCurrentToken()->getLine());
      return false;
    }

    $this->tokenStream->next();
    $this->A();

    if(!$this->matchCurrentToken(ReservedStartEnd::class)) {
      $this->addSyntaxError("Expected '}' at line " . $this->getCurrentToken()->getLine());
      return false;
    }
    return true;
  }

  private function ifAndWhileBlock()
  {
    $currentTokenValue = $this->getCurrentToken()->getValue();
    if($currentTokenValue != 'if' && $currentTokenValue != 'while') {
      return false;
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(BlockStartEnd::class)) {
      $this->addSyntaxError("Expected '(' at line " . $this->getCurrentToken()->getLine());
      return false;
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(Variable::class)) {
      $this->addSyntaxError("Expected a 'Variable' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->H();

    if(!$this->matchCurrentToken(RelationalOperator::class)) {
      $this->addSyntaxError("Expected a 'RelationalOperator' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    $this->G();
    $this->F();

    if(!$this->matchCurrentToken(BlockStartEnd::class)) {
      $this->addSyntaxError("Expected a ')' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(ReservedStartEnd::class)) {
      $this->addSyntaxError("Expected a '{' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->A();

    if(!$this->matchCurrentToken(ReservedStartEnd::class)) {
      $this->addSyntaxError("Expected a '}' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->A();

    return true;
  }

  private function forBlock()
  {
    if(!$this->matchCurrentToken(BlockStartEnd::class)) {
      $this->addSyntaxError("Expected a '(' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->B();

    if(!$this->matchCurrentToken(Variable::class)) {
      $this->addSyntaxError("Expected a 'Variable' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(RelationalOperator::class)) {
      $this->addSyntaxError("Expected a 'RelationalOperator' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->G();

    if(!$this->matchCurrentToken(EspecialCharacters::class) && $this->getCurrentToken()->getValue() == ';') {
      $this->addSyntaxError("Expected a ';' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(Variable::class)) {
      $this->addSyntaxError("Expected a 'Variable' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(IncDec::class) && ! $this->getCurrentToken()->getValue() == ('++'||'--')) {
      $this->addSyntaxError("Expected a '++ or --' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(BlockStartEnd::class)) {
      $this->addSyntaxError("Expected a ')' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(ReservedStartEnd::class)) {
      $this->addSyntaxError("Expected a '{' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->A();

    if(!$this->matchCurrentToken(ReservedStartEnd::class)) {
      $this->addSyntaxError("Expected a '}' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->A();
  }

  private function A()
  {
    $this->log("Entrou no A");
    if($this->matchCurrentToken(ReservedStartEnd::class) && $this->getCurrentToken()->getValue() == '}') {
      return true;
    }

    if($this->matchCurrentToken(ReservedCond::class) && $this->getCurrentToken()->getValue() != 'for') {
      $this->ifAndWhileBlock();
      return true;
    }

    if($this->matchCurrentToken(ReservedCond::class) && $this->getCurrentToken()->getValue() == 'for') {
      $this->tokenStream->next();
      $this->forBlock();
      return true;
    }

    $this->B();
    $this->A();

    return true;
  }

  private function B()
  {
    $this->log("Entrou no B");
    if($this->matchCurrentToken(ReservedType::class)) {
      $this->tokenStream->next();
    }

    if(!$this->matchCurrentToken(Variable::class)) {
      $this->addSyntaxError("Expected a 'Variable' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->C();
  }

  private function C()
  {
    $this->log("Entrou no C");
    if($this->matchCurrentToken(EspecialCharacters::class) && $this->getCurrentToken()->getValue() == ';') {
      $this->tokenStream->next();
      return true;
    }

    if(!$this->matchCurrentToken(EspecialCharacters::class) && $this->getCurrentToken()->getValue() == '=') {
      $this->addSyntaxError("Expected a '=' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->D();
    return true;
  }

  private function D()
  {
    $this->log("Entrou no D");
    if(!$this->matchCurrentToken(Variable::class) && ! $this->matchCurrentToken(Number::class)) {
      $this->addSyntaxError("Expected 'Variable' or 'Number' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->E();
  }

  private function E()
  {
    $this->log("Entrou no E");
    if($this->matchCurrentToken(EspecialCharacters::class) && $this->getCurrentToken()->getValue() == ';') {
      $this->tokenStream->next();
      return true;
    }

    if(!$this->matchCurrentToken(ArithmeticOperator::class)) {
      $this->addSyntaxError("Expected a 'ArithmeticOperator' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->D();
    return true;
  }

  private function F()
  {
    $this->log("Entrou no F");
    if($this->matchCurrentToken(BlockStartEnd::class) || ($this->matchCurrentToken(ReservedCond::class) && $this->getCurrentToken()->getValue() == ';')) {
      return true;
    }

    if(!$this->matchCurrentToken(LogicalOperator::class)) {
      $this->addSyntaxError("Expected 'LogicalOperator' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if(!$this->matchCurrentToken(Variable::class)) {
      $this->addSyntaxError("Expected a 'Variable' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->H();

    if(!$this->matchCurrentToken(RelationalOperator::class)) {
      $this->addSyntaxError("Expected a 'Relational Operator' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->G();
    $this->F();

    return true;
  }

  private function G()
  {
    $this->log("Entrou no G");
    if(!$this->matchCurrentToken(Variable::class) && ! $this->matchCurrentToken(Number::class)) {
      $this->addSyntaxError("Expected 'Variable' or a 'Number' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();

    if($this->matchCurrentToken(LogicalOperator::class) || ($this->matchCurrentToken(EspecialCharacters::class) && $this->getCurrentToken()->getValue() == ';') || ($this->matchCurrentToken(BlockStartEnd::class) && $this->getCurrentToken()->getValue() == ')')) {
      //$this->tokenStream->next();
      return true;
    }
    $this->H();
  }

  private function H()
  {
    $this->log("Entrou no H");
    if($this->matchCurrentToken(RelationalOperator::class)) {
      // if is not 'H' follow
      return false;
    }

    if(!$this->matchCurrentToken(ArithmeticOperator::class)) {
      $this->addSyntaxError("Expected 'ArithmeticOperator' at line " . $this->getCurrentToken()->getLine());
    }

    $this->tokenStream->next();
    $this->G();

    return true;
  }
}
