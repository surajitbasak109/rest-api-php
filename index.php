<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

date_default_timezone_set('Asia/Kolkata');

$method = $_SERVER['REQUEST_METHOD'];

// echo $method;

$request_uri = $_SERVER['REQUEST_URI'];
// echo $request_uri;

$tables = ['posts'];
$url = rtrim($request_uri, '/');
$url = filter_var($request_uri, FILTER_SANITIZE_URL);
$url = explode('/', $url);
// echo print_r($url);
$tableName = isset($url[2]) ? (string) $url[2] : null;
// print_r($tableName);
$id = isset($url[3]) ? (int) $url[3] : null;
// echo $id;

if (in_array($tableName, $tables)) {
  // Include that api route
  include_once './classes/Database.php';
  include_once './api/posts.php';
} else {
  echo "Table does not exists.";
}
