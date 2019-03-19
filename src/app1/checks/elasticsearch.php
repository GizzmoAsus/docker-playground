<?php
function test_elasticsearch_connection(array $config) {
  try{
    $client = Elasticsearch\ClientBuilder::create()
      ->setHosts($config)
      ->build();
    
    $params = [
        'index'   => 'my_index',
        'type'    => 'my_type',
        'id'      => 'my_id',
        'body'    => ['testField' => 'abc'],
        'client'  => [ 'ignore' => [400, 404] ]
    ];
    $response = $client->index($params);
    return true;
  } catch (Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost $cncth) {
    error_log("Couldn't connect to host: " . $cncth->getMessage());
    return false;
  } catch (Elasticsearch\Common\Exceptions\RuntimeException $rte) {
    error_log("Error connecting to host: " . $rte->getMessage());
    return false;
  } catch(Exception $ex){
    error_log("Something else went wrong: " . $ex->getMessage());
    return false;
  }
}