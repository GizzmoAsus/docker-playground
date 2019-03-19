<?php
require __DIR__ . '/vendor/autoload.php';

$configuration = file_get_contents('./checks/config.json');
$config = json_decode($configuration, true);

include_once('./checks/mysql.php');
include_once('./checks/redis.php');
include_once('./checks/elasticsearch.php');

# vars
$services = array(
  'nginx' => array(
    'service_up' => true,
    'title' => "Nginx Web Server / Proxy",
    'icon' => 'fas fa-server',
    'success' => 'Nginx is working fine, you\'re connected to it :)',
    'error' => 'I\'m not sure how this happens when your connected to it but nginx is down'
  ),
  'php-fpm' => array(
    'service_up' => true,
    'title' => 'PHP-FPM Socket Service',
    'icon' => 'fab fa-php',
    'success' => 'PHP FPM is working fine, that\'s what\'s serving this page :)',
    'error' => 'I\'m not sure how this happens when your connected to it but php-fpm is down'
  ),
  'mysql' => array(
    'service_up' => test_mysql_connection($config['mysql']),
    'title' => 'MySQL Database Service',
    'icon' => 'fas fa-database',
    'success' => 'MySQL is connected and responding as we knew it would',
    'error' => 'It appears there\'s an issue connecting to MySQL .. take a looksie at the logs'
  ),
  'redis' => array(
    'service_up' => test_redis_connection($config['redis']),
    'title' => 'Redis Service',
    'icon' => 'fas fa-box-open',
    'success' => 'Sweeeet Redis is working as expected',
    'error' => 'It appears there\'s an issue connecting to Redis ... da logs may contain more info'
  ),
  'elasticsearch' => array(
    'service_up' => test_elasticsearch_connection($config['elasticsearch']),
    'title' => 'Elasticsearch Service',
    'icon' => 'fas fa-search',
    'success' => 'Elasticsearch is connected and responding just fine',
    'error' => 'Hmmmm can\'t seem to connect to Elasticsearch, anything in the logs?'
  )
);
$mysql_class = $redis_class = $nginx_class = $phpfpm_class = 'bg-succss';

# now out put it all
?>
<!DOCTYPE html>
<head>
  <title>App One Health Checks</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.5/css/mdb.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row"> 
    <h1>Service Health Checks...</h1>
  </div>

<?php
$count = 1;
foreach ($services as $service) {
  $success = $service['service_up'];
  if ($success) {
    $style_class = 'bg-success';
    $message = $service['success'];
  } else {
    $style_class = 'bg-danger';
    $message = $service['error'];
  }
  
  if ($count % 2 !== 0) {
    ?>
  <div class="row">
    <?php
  }
?>
    <div class="col-md-6">
      <div class="card text-white <?= $style_class ?> mb-3" style="max-width: 20rem;">
      <div class="card-body">
          <h5 class="card-title"><i class="<?= $service['icon'] ?>"></i> <?= $service['title'] ?></h5>
          <p class="card-text text-white"><?= $message ?></p>
        </div>
      </div>
    </div>
<?php
  if ($count % 2 == 0) {
    ?>
  </div>
    <?php
  }
  $count++;
}
?>
  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.5/js/mdb.min.js"></script>
</body>
</html>