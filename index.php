<?php
    if(isset($_COOKIE["user"]) && $_COOKIE["user"]=="superAdmin"){
        header('Location:admin_section/index.php');
    }
    elseif(isset($_COOKIE["user"]) && $_COOKIE["user"]=="depttAdmin"){
        header('Location:admin_section/depttLogin.php');
    }
    else{
        header('Location:admin_section/index.php');
    }
    ?>
