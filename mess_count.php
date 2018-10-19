<?php
    $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
    $flag=0;
    $month=date('M').date('y');
    $month_check_obj = mysqli_query($con, "SELECT * FROM mess_count");
    $total_months=mysqli_num_rows($month_check_obj);

    for($i=0;$i<$total_months;$i++){

        $month_check_row=mysqli_fetch_assoc($month_check_obj);

        if($month==$month_check_row['Month']){
            $flag=1;
            break;
        }

    }

    if($flag==0){
        mysqli_query($con,"INSERT INTO mess_count VALUES('$month',0,0,0,0)");
    }

    $this_month_obj = mysqli_query($con, "SELECT * FROM mess_count WHERE Month='$month'");

    $this_month_row=mysqli_fetch_assoc($this_month_obj);

    if(isset($_POST['breakfast_check']))
    {
        $new_number=++$this_month_row['Breakfast'];
        mysqli_query($con,"UPDATE mess_count SET Breakfast=$new_number WHERE Month='$month'");
    }

    if(isset($_POST['lunch_check']))
    {
        $new_number=++$this_month_row['Lunch'];
        mysqli_query($con,"UPDATE mess_count SET Lunch=$new_number WHERE Month='$month'");
    }

    if(isset($_POST['dinner_check']))
    {
        $new_number=++$this_month_row['Dinner'];
        mysqli_query($con,"UPDATE mess_count SET Dinner=$new_number WHERE Month='$month'");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mess-Count</title>
        <link rel="icon" type="image/png" href="https://parthshah.xyz/favicon.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            label{
                margin-right: 25px;
                margin-left: 25px;
            }
            .total{
                margin-top: 50px;
            }
        </style>
        <script>
            function pay(month) {
                var newBill;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "mess_pay.php?month="+month, true);
                xmlhttp.send();
                $("#"+month).addClass("grey-text");
                $("#"+month+" button").addClass("disabled").html("Paid");
                newBill=parseInt($("#totalBill b").html()) - parseInt($("#"+month+"Bill").html());
                $("#totalBill b").html(newBill);
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col s12 l8 offset-l2">
                    <table class="centered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Breakfast</th>
                                <th>Lunch</th>
                                <th>Dinner</th>
                                <th>Bill</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                        
                                
                                $all_months_obj=mysqli_query($con,"SELECT * FROM mess_count");
                                $total_months=mysqli_num_rows($all_months_obj);                                
                                $total_bill=0;
                                for($i=0;$i<$total_months;$i++){

                                    $all_months_row=mysqli_fetch_assoc($all_months_obj);

                                    $bill=($all_months_row['Breakfast']*30)+($all_months_row['Lunch']*60)+($all_months_row['Dinner']*60);

                                    if(!$all_months_row['Status']){
                                        $disable="";
                                        $btnTxt="Pay";
                                        $greyTxt="";
                                        $total_bill+=$bill;
                                    }else{
                                        $disable=" disabled";
                                        $btnTxt="Paid";
                                        $greyTxt="class='grey-text'";
                                    }   
                                    echo "<tr ".$greyTxt." id='".$all_months_row['Month']."'>
                                        <td>".$all_months_row['Month']."</td>
                                        <td>".$all_months_row['Breakfast']."</td>
                                        <td>".$all_months_row['Lunch']."</td>
                                        <td>".$all_months_row['Dinner']."</td>
                                        <td id='".$all_months_row['Month']."Bill'>$bill</td>
                                        <td><button class='waves-effect waves-teal btn-flat".$disable."' onclick='pay(\"".$all_months_row['Month']."\")'>$btnTxt</button></td>
                                        </tr>\n";                            
                                }
                            ?>
                            <tr>
                                <td><b>Total</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="totalBill"><b><?php echo $total_bill; ?></b></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center-align">
                    <p><br></p>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="check_form">
                
                        <input type="checkbox" id="breakfast_check" name="breakfast_check" />
                        <label for="breakfast_check">Breakfast</label>                        
                        
                        <input type="checkbox" id="lunch_check" name="lunch_check" />
                        <label for="lunch_check">Lunch</label>
                        
                        <input type="checkbox" id="dinner_check" name="dinner_check"/>
                        <label for="dinner_check">Dinner</label>
                        
                        <br><br><br>
                        <button type="submit" form="check_form" value="Submit" class="teal accent-4 btn waves-effect waves-light">OK</button>
                        
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    </body>
</html>