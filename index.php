<?php
session_start(); $username = $password = $userError = $passError = '';
echo "pls";
if(isset($_POST['sub'])){
  $username = $_POST['username']; $password = $_POST['password'];
  if($username === 'admin' && $password === 'password'){
    echo "GG WP"; die();
  }
  if($username !== 'admin')$userError = 'Invalid Username';
  if($password !== 'password')$passError = 'Invalid Password';
}
?>
