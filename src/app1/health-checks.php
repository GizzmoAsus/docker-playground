<?php
require __DIR__ . '/vendor/autoload.php';

$service_config = file_get_contents('./config/service_config.json');
$config = json_decode($service_config, true);

include_once('./checks/mysql.php');
include_once('./checks/redis.php');
include_once('./checks/elasticsearch.php');

# vars
$health_config = file_get_contents('./config/health_config.json');
$services = json_decode($health_config, true);

try {
  $services['mysql']['service_up'] = test_mysql_connection($config["mysql"]);
  $services['redis']['service_up'] = test_redis_connection($config["redis"]);
  $services['elasticsearch']['service_up'] = test_elasticsearch_connection($config["elasticsearch"]);
} catch (Exception $e) {
  error_log("Seems to be an error with the config files: " . $e->getMessage());
}
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
  <style type="text/css">
    html {
      font-size: 1.5rem;
    }
  </style>
</head>
<body>
<!-- Purple Header -->
<div class="edge-header unique-color"></div>
<div class="container free-bird">
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
  </div>
</div>
  <!-- Footer -->
  <footer class="page-footer font-small unique-color-dark fixed-bottom">
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2019 Copyright:
      <a href="https://kelcode.co.uk" target="_blank"> Kelcode.co.uk</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
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