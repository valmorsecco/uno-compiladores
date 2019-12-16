<?php
namespace Site\Src\Util;

class RegexRecognizer
{
  public static function match($regex, $string)
  {
    $r = preg_match($regex, $string, $match, PREG_OFFSET_CAPTURE);
    return ($r === 1 && $match[0][1] === 0);
  }
}
