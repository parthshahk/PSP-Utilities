<?php
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
    $entity=$_GET['entity'];
    mysqli_query($con,"DELETE FROM balance_tracker WHERE Entity='$entity'");
?>