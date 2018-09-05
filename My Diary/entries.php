<?php
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
    $result_obj=mysqli_query($con,"SELECT * FROM mydiary_data");
    $total_entries=mysqli_num_rows($result_obj);
    for($i=0;$i<$total_entries;$i++){
        $row=mysqli_fetch_assoc($result_obj);
        echo $row['Date']."<br>";
    }
    echo "<a href=\"read.php\">Back</a>";
?>