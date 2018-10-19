<?php
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
    $marks=$_GET['marks'];
    $alias=$_GET['subject'];
    if($_GET['sessional']=="s1"){
        $sessional="Sessional 1";
    }else if($_GET['sessional']=="s2"){
        $sessional="Sessional 2";
    }else if($_GET['sessional']=="s3"){
        $sessional="Sessional 3";
    }
    mysqli_query($con,"UPDATE sessional_tracker SET `$sessional`= $marks WHERE Alias='$alias'");
?>