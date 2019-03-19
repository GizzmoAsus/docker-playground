<?php
function test_mysql_connection(array $config) {
  try{
    $dbh = new pdo(
      'mysql:host='.$config['server'].':'.$config['port'].';dbname='. $config['database'],
      $config['username'],
      $config['password'],
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    $output = json_encode(array('Connection: ' => true), JSON_PRETTY_PRINT);
  } catch(PDOException $ex){
    $output = json_encode(
      array(
        'outcome' => false,
        'message' => 'Unable to connect (' . $ex->getMessage().')'
      ),
      JSON_PRETTY_PRINT
    );
  }

  return $output;
}