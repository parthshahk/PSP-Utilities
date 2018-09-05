<?php
    $data=$_POST['diaryText'];
    $date=$_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
    function encodeString($string,$key_n=806){
        $len=strlen($string);
        $string=str_rot13($string);
        $string=str_split($string);
        for($i=0;$i<$len;$i++){
            $string[$i]=ord($string[$i])+$key_n;
        }
        $string=implode("%",$string);
        return $string;
    }
    $data=encodeString($data);
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
    $result_obj=mysqli_query($con,"SELECT * FROM mydiary_data");
    $total_entries=mysqli_num_rows($result_obj);
    $exists=0;
    for($i=0;$i<$total_entries;$i++){
        $row=mysqli_fetch_assoc($result_obj);
        if($row['Date']==$date){
           $exists=1; 
           break;
        }else{
            continue;
        }
    }
    if(!$exists){
        mysqli_query($con,"INSERT INTO mydiary_data VALUES('$date','$data')");
    }else{
        mysqli_query($con,"UPDATE mydiary_data SET Data=CONCAT(Data,'%838%','$data') WHERE Date='$date'");
    }
    header('Location: ./index.php');
?>