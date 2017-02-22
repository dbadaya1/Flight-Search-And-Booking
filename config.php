<?php


 


$host = '127.0.0.1';
$db   = 'airline';
$user = 'root';
$pass = 'badaya1234';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
//$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
//$stmt->execute(['email' => "email@dbadaya.com"]);
//$user = $stmt->fetch();
//var_dump($user);
defined("ROOT_DIR")
    or define("ROOT_DIR", $_SERVER['DOCUMENT_ROOT']."" );

defined("TEMPLATES_DIR")
    or define("TEMPLATES_DIR", ROOT_DIR . '/resources/templates');

defined("HOMEPAGE_URL")
    or define("HOMEPAGE_URL", '');



defined("JS_URL")
    or define("JS_URL", HOMEPAGE_URL.'/js');

defined("CSS_URL")
    or define("CSS_URL", HOMEPAGE_URL.'/css');


defined("LAYOUT_IMAGES_URL")
    or define("LAYOUT_IMAGES_URL", HOMEPAGE_URL.'/images/layout');


define("included","true");
    date_default_timezone_set("UTC"); 

require_once(__DIR__."/common.php");
   session_start();


?>