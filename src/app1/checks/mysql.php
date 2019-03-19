<?php
function test_mysql_connection(array $config) {
  try{
    $dbh = new pdo(
      'mysql:host='.$config['server'].':'.$config['port'].';dbname='. $config['database'],
      $config['username'],
      $config['password'],
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    return true;
  } catch(PDOException $ex){
    return false;
  }
}