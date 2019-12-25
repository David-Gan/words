<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.bootcss.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="/?action=sentences">Sentences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/?action=words">Words</a>
        </li>
      </ul>
    </div>
    <?=$content?>
  </body>
  <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
  <script><?=$js?></script>
</html>