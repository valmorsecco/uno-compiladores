<?php
namespace Site\Config;

use Symfony\Component\Dotenv\Dotenv;

class Config
{
  /**
   * @var value
   */
  protected $value;

  public function __construct()
  {
    $this->value = $this->load();
  }

  public function getValue()
  {
    return $this->value;
  }

  private function load()
  {
    $dotenv = new Dotenv();

    $dotenv->load(__DIR__ . "/../.env");

    $config = [
      "dir" => [
        "base" => __DIR__ . "/..",
        "view" => __DIR__ . "/.." . $_ENV["APP_DIR_VIEW"]
      ],
      "env" => $_ENV["APP_ENV"],
      "title" => $_ENV["APP_TITLE"],
      "version" => "1"
    ];

    $config = json_decode(json_encode($config), FALSE);

    return $config;
  }
}
