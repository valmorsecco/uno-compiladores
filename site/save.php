<?php
require __DIR__ . "/vendor/autoload.php";

use Site\Src\App;

$data = json_decode(file_get_contents("php://input"));
$file = "./test.txt";
unlink($file);
if($fp = fopen($file, "w")) {
  fwrite($fp, $data->values);
}

try {
  $app = new App();
  $dump = $app->run($file);
  echo json_encode(["status" => true, "values" => $dump]);
} catch(\Exception $exception) {
  echo json_encode(["status" => false, "error" => $exception->getMessage()]);
}
