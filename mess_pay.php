<?php
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
    $payMonth=$_GET['month'];
    mysqli_query($con,"UPDATE mess_count SET Status='1' WHERE Month='$payMonth'");
?>