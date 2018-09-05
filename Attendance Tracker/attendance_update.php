<?php
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");

    $alias=$_GET['subject'];
    $present=$_GET['present'];
    $outOf=$_GET['outOf'];

    $result_obj=mysqli_query($con,"SELECT * FROM attendance_tracker WHERE Alias='$alias'");
    $row=mysqli_fetch_assoc($result_obj);

    $current_present=$row['Present'];
    $current_outOf=$row['OutOf'];

    $present+=$current_present;
    $outOf+=$current_outOf;

    mysqli_query($con,"UPDATE attendance_tracker SET Present= $present, OutOf=$outOf WHERE Alias='$alias'");

    $date=date('l d M Y');
    mysqli_query($con,"UPDATE attendance_tracker_date SET LastEntry='$date'");

?>