<?php

if (isset($_POST['submit'])) {

  $userName = $_POST['username'];
  $pwd = $_POST['pwd'];
  $repeatPwd = $_POST['repeatpwd'];
  $level = $_POST['level'];

  // Required field 
  if (!$userName || !$pwd || !$repeatPwd || !$level) {
    header("location: ../adduser.php?error=fieldrequired");
    exit();
  }

  require_once 'config.php';

  // Check User name
  $result = mysqli_query($db, "SELECT user_name FROM user WHERE user_name = '$userName'");

  // Same Username
  if (mysqli_num_rows($result)) {
    header("location: ../adduser.php?error=userexist");
    exit();
  }

  // Password do not match
  if ($pwd !== $repeatPwd) {
    header("location: ../adduser.php?error=pwdnotmatch");
    exit();
  }

  if (!mysqli_query($db, "INSERT INTO user (user_name, user_level, user_pass)
  VALUES ('$userName', '$level', '$pwd')")) {
    header('location: ../adduser.php?error=unknown');
    exit();
  }

  header('location: ../adduser.php?adduser=success');
  exit();
}
