<?php
require __DIR__ . '/vendor/autoload.php';

$configuration = file_get_contents('./checks/config.json');
$config = json_decode($configuration, true);

include_once('./checks/mysql.php');
include_once('./checks/redis.php');
?>


<!DOCTYPE html>
<head>
  <title>App One Health Checks</title>
</head>
<body>
<h1>Service Health Checks...</h1>
<h2>MySQL:</h2>
<pre class="json">
<?php
  print test_mysql_connection($config['mysql']);
?>
</pre>
<h2>Redis:</h2>
<pre class="json">
<?php
  print test_redis_connection($config['redis']);
?>
</pre>
</body>
</html>