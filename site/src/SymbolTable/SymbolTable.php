<?php
namespace Site\Src\SymbolTable;

use Site\Src\Token\ArithmeticOperator;
use Site\Src\Token\BlockStartEnd;
use Site\Src\Token\Comment;
use Site\Src\Token\EspecialCharacters;
use Site\Src\Token\Letter;
use Site\Src\Token\LogicalOperator;
use Site\Src\Token\Main;
use Site\Src\Token\Number;
use Site\Src\Token\RelationalOperator;
use Site\Src\Token\ReservedCond;
use Site\Src\Token\ReservedStartEnd;
use Site\Src\Token\ReservedType;
use Site\Src\Token\Variable;
use Site\Src\Token\IncDec;

class SymbolTable
{
  public function create()
  {
    $symbolTableRecognizer = new SymbolTableRecognizer();
    $symbolTableRecognizer->add(new Comment());
    $symbolTableRecognizer->add(new Main());
    $symbolTableRecognizer->add(new EspecialCharacters());
    $symbolTableRecognizer->add(new ReservedCond());
    $symbolTableRecognizer->add(new ReservedType());
    $symbolTableRecognizer->add(new RelationalOperator());
    $symbolTableRecognizer->add(new ArithmeticOperator());
    $symbolTableRecognizer->add(new LogicalOperator());
    $symbolTableRecognizer->add(new ReservedStartEnd());
    $symbolTableRecognizer->add(new BlockStartEnd());
    $symbolTableRecognizer->add(new Variable());
    $symbolTableRecognizer->add(new Number());
    $symbolTableRecognizer->add(new Letter());
    $symbolTableRecognizer->add(new IncDec());
    return $symbolTableRecognizer;
  }
}
