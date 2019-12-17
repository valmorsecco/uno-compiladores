<?php
require __DIR__ . "/vendor/autoload.php";
use Site\Src\App;
try {
  $app = new App();
  $dump = $app->run("./test.txt");
  echo json_encode(["status" => true, "values" => $dump]);
} catch(\Exception $exception) {
  echo json_encode(["status" => false, "error" => $exception->getMessage()]);
}
