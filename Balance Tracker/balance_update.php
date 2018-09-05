<?php
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");

    $today=date('d')." ".date('M').", ".date('Y');

    $entity=$_GET['entity'];
    $difference=$_GET['difference'];
    $differenceType=$_GET['differenceType'];

    $result_obj=mysqli_query($con,"SELECT * FROM balance_tracker");
    
    $total_entries=mysqli_num_rows($result_obj);

    $updated=0;

    for($i=0;$i<$total_entries;$i++){

        $row=mysqli_fetch_assoc($result_obj);

        if($entity==$row['Entity']){

            $updated=1;

            if($differenceType=="negative"){
                $difference=$difference-(2*$difference);
            }

            if($row['Type']=="negative"){
                $currentDifference=$row['Amount']-(2*$row['Amount']);
            }else{
                $currentDifference=$row['Amount'];
            }

            $newDifference=$currentDifference+$difference;

            if($newDifference<0){

                $newDifference=$newDifference-(2*$newDifference);
                mysqli_query($con,"UPDATE balance_tracker SET Amount=$newDifference, Type='negative', Date='$today' WHERE Entity='$entity'");
            }else if($newDifference==0){

                mysqli_query($con,"DELETE FROM balance_tracker WHERE Entity='$entity'");
            }else{

                mysqli_query($con,"UPDATE balance_tracker SET Amount=$newDifference, Type='positive', Date='$today' WHERE Entity='$entity'");
            }
            break;
        }

    }

    if(!$updated){
        mysqli_query($con,"INSERT INTO balance_tracker VALUES('$entity',$difference,'$differenceType','$today')");
    }
?>