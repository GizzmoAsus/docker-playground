<?php

function test_redis_connection($config) {
  try {
    // Parameters passed using a named array:
    $client = new Predis\Client([
      'scheme'    => 'tcp',
      'host'      => $config['server'],
      'port'      => $config['port'],
      'password'  => $config['password']
    ]);

    $client->set('foo', 'cowabunga');
    $response = $client->get('foo');

    $output = json_encode(array('Redis responded with ' . $response), JSON_PRETTY_PRINT);
  } catch (Exception $e) {
    $output = json_encode(array('Error connecting to redis ' . $e->getMessage()), JSON_PRETTY_PRINT);
  }
  return $output;
}