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

    return true;
  } catch (Exception $e) {
    return false;
  }
}