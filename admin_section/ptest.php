<?php
$password = '9858888875';
$hashed = password_hash($password, PASSWORD_BCRYPT);
echo $hashed;
echo '<br>';
$md = md5($password);
echo 'md5: '.$md.'<br>';
if (password_verify($password, $hashed)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}

?>