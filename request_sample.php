<?php
/* res
object(stdClass)#3 (1) {
  ["data"]=>
  object(stdClass)#2 (1) {
    ["viewer"]=>
    object(stdClass)#1 (2) {
      ["login"]=>
      string(11) "AkiraHagino"
      ["name"]=>
      string(12) "萩野　輝"
    }
  }
}
*/

$token = '';
$query = <<<'GRAPHQL'
query { 
	viewer { 
		login
		name
	}
}
GRAPHQL;

// User-Agentは必須
$options = [
	'http' => [
		'method' => 'POST',
		'header' => [
			'User-Agent: My User Agent',
			'Authorization: bearer '.$token,
			'Content-type: application/json; charset=UTF-8',
		],
		'content' => json_encode(['query' => $query]),
	],
];
$context = stream_context_create($options);
$contents = file_get_contents('https://api.github.com/graphql', false, $context);
var_dump(json_decode($contents));
