<?php
/* res
Array
(
    [data] => Array
        (
            [user] => Array
                (
                    [name] => 萩野　輝
                    [repositoriesContributedTo] => Array
                        (
                            [totalCount] => 7
                        )

                )

        )

)
*/




// クエリ構築
$query = <<<'GRAPHQL'
query GetUser($user: String!) {
   user (login: $user) {
    name
    repositoriesContributedTo {
      totalCount
    }
  }
}
GRAPHQL;

// リクエスト 
$res = graphql_query('https://api.github.com/graphql', $query, ['user' => 'AkiraHagino'], '{token}');

// 結果表示
echo print_r($res,true);


/*
 *
 * 指定ユーザの指定パラメータを取得する
 *
 */
function graphql_query(string $endpoint, string $query, array $variables = [], ?string $token = null): array
{
	// User-Agentは必須
    $headers = ['Content-Type: application/json', 'User-Agent: My User Agent'];
    if (null !== $token) {
        $headers[] = "Authorization: bearer $token";
    }
    if (false === $data = @file_get_contents($endpoint, false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => $headers,
            'content' => json_encode(['query' => $query, 'variables' => $variables]),
        ]
    ]))) {
        $error = error_get_last();
        throw new \ErrorException($error['message'], $error['type']);
    }
    return json_decode($data, true);
}
