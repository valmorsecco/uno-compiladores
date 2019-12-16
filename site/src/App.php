<?php
namespace Site\Src;

use Site\Config\Config;
use Site\Src\Lexer\Lexer;
use Site\Src\Parser\Parser;
use Site\Src\Semantic\Semantic;
use Site\Src\SymbolTable\SymbolTable;

class App
{
  /**
   * @var config
   */
  private $config;

  /**
   * @var lexer
   */
  private $lexer;

  /**
   * @var parser
   */
  private $parser;

  /**
   * @var semantic
   */
  private $semantic;

  /**
   * @var symbolTable
   */
  private $symbolTable;

  public function __construct()
  {
    $this->config = (new Config())->getValue();
    $this->symbolTable = (new SymbolTable())->create();
    $this->lexer = new Lexer($this->symbolTable);
  }

  public function run()
  {
    try {
      $test = @file_get_contents(__DIR__ . "/../test.txt");

      $lr = $this->lexer->run($test);
      $this->parser = new Parser($lr, true);
      $this->parser->run();

      $this->semantic = new Semantic($lr);
      $this->semantic->run();

    } catch(\Exception $exception) {
      echo $exception->getMessage();
    }
  }
}
