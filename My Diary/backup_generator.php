<?php
if(sha1($_POST['password'])=='e5e4fd7ee6bcbf54832e6f142eb74a8dd94e5ebd'){

    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
    
    $key=$_POST['password'];
    $key_n=setKeyN($key);
    
    $result_obj=mysqli_query($con,"SELECT * FROM mydiary_data");                                                                    
    $total_entries=mysqli_num_rows($result_obj);

    $zip = new ZipArchive();
    $zip->open('./backup.zip', ZipArchive::CREATE);

    mkdir("./backup_temp");

    for($i=0;$i<$total_entries;$i++){
        $row=mysqli_fetch_assoc($result_obj);
        $data=$row['Data'];
        $data=decodeString($data,$key_n);    
        fwrite(fopen('./backup_temp/'.$row['Date'].'.txt', 'w'), $data);
        $zip->addFile('./backup_temp/'.$row['Date'].'.txt', $row['Date'].'.txt');
    }
    $zip->close();
    array_map('unlink', glob("./backup_temp/*.txt"));
    rmdir('./backup_temp');
    header('Location: ./backup.zip');
}else{
    header('Location: ./backup.html');
}
function setKeyN($k){
    $k=str_split($k);
    $kn=0;
    foreach($k as $value){
        $kn+=ord($value);
    }
    return $kn;
}
function decodeString($string,$key_n){
    $string=explode("%",$string);
    $len=count($string);
    for($i=0;$i<$len;$i++){
        $string[$i]-=$key_n;
        $string[$i]=str_rot13(chr($string[$i]));
    }
    $string=implode("",$string);
    return $string;
}
?>