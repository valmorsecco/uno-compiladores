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
  }

  public function run($file = false)
  {
    try {
      $text = @file_get_contents($file);

      $this->lexer = new Lexer($this->symbolTable, $text);
      $tokenStream = $this->lexer->run();

      $this->parser = new Parser($tokenStream, true);
      $this->parser->run();

      $this->semantic = new Semantic($tokenStream);
      $this->semantic->run();

      return [
        "text" => $text,
        "lexer" => $tokenStream->toDump(),
        "parser" => $this->parser->getLog()
      ];
    } catch(\Exception $exception) {
      throw new \Exception($exception->getMessage());
    }
  }
}
