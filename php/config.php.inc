<?
// error_reporting(0);
session_start();

$user = 'myworktime';
$pass = 'myworktime';
$dbname = 'myworktime';
$dbhost = '127.0.0.1';
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $user, $pass);

function refreshTo($new_page)
{
        header ("Location: $new_page");
        exit;
};
?>

