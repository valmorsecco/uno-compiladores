<?php
require __DIR__ . "/vendor/autoload.php";

@ini_set("display_errors", false);

$file = "./test.txt";
$text = "";
if($fp = fopen($file, "r")) {
  $text = fread($fp, filesize($file));
}

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Unochapecó - Compiladores</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./public/assets/css/app.css" rel="stylesheet" />
    <link href="./public/assets/css/loader.css" rel="stylesheet" />
    <link href="./public/assets/css/main.css" rel="stylesheet" />
    <link href="./public/assets/codemirror/lib/codemirror.css" rel="stylesheet"/>
  </head>
  <body data-load="false">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root">
       <main class="main">
          <section class="section-default section-text">
            <h3>Texto:</h3>
            <textarea id="default-text"><?=$text?></textarea>
            <button id="save" type="button" class="btn btn-success">Salvar</button>
          </section>
          <section class="section-default section-lexer">
            <h3>Lexer:</h3>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id</th>
                    <th scope="col">Token</th>
                    <th scope="col">Value</th>
                  </tr>
                </thead>
                <tbody data-values-lexer="true"></tbody>
              </table>
            </div>
          </section>
          <section class="section-default section-parser">
            <h3>Parser:</h3>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Message</th>
                  </tr>
                </thead>
                <tbody data-values-parser="true"></tbody>
              </table>
            </div>
          </section>
       </main>
    </div>
    <div id="root-loader">
      <div class="spinner-border text-light spinner-border-lg"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="./public/assets/js/index.js"></script>
    <script src="./public/assets/js/app.js"></script>
    <script src="./public/assets/codemirror/lib/codemirror.js"></script>
    <script>
      $(document).ready(function() {
        window.default = app;
        window.default.run();
      });
    </script>
  </body>
</html>
