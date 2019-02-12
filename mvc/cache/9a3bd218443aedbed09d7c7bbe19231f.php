<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="public/css/common.css">
 <title><?=$title;?></title>
</head>
<body>
 <div class="w400">
  include 包含的文件
  <?php include"./cache/e58aa64a0f74ee56ee7b90fcd9bfb87b.php"?>
 </div>
 <div class="w500">
  <?php foreach($data as $value): ?>
   <?=$value;?><br>
  <?php endforeach ?>
 </div>
</body>
</html>