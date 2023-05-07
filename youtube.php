<?php

/* 
* This API handle for youtube search
* this script for grab the json format of youtube search result.
 */

// usge Client.
use GuzzleHttp\Client;

// require the autoload files.
require_once  __DIR__. '/vendor/autoload.php';

// create client object.
function client() {
    return new Client([
        'base_uri' => 'https://youtube-search-results.p.rapidapi.com',
        'headers'  => [
            'X-RapidAPI-Key' => '356b46ad09mshcf052c401cba91fp164641jsn95fce6399bac',
            'X-RapidAPI-Host' => 'youtube-search-results.p.rapidapi.com'
        ],
    ]);
}

// handle response.
function response(mixed $data, $code = 200) {

    // define headers.
    header('Content-Type: application/json');

    // send status code.
    http_response_code($code);

    // encoding the data.
    echo json_encode($data);
}



// handle search action.
function search(string $search) {


    // send request of youtube API.
    $response = client()->get('/youtube-search', [
        'query' => ['q' => $search],
    ]);

    // decoding the json content to object.
    $object = json_decode($response->getBody()->getContents());

    
    return [
        'search_text' => $object->originalQuery,
        'ok' => $object->status,
        'results_wount' => count($object->items),
        'results' => $object->items
    ];
}


$search  = $_GET['search'] ?? null;

if ($search) {
    // get data of youtube.
    $data = search($search);
    // usge echo for api.
    response($data);
}
else {
    response([
        'ok' => false,
        'messge' => 'expected search parameter.'
    ]);
}