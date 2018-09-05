<!DOCTYPE html>
<html>
    <head>
        <title>Attendance Tracker</title>
        <link rel="icon" type="image/png" href="https://www.parthshah.xyz/favicon_code.png"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="robots" content="noindex, nofollow" />
        <style>
            .input-field input[type=number]:focus + label {
                color: #00c853 !important;
            }

            .input-field input[type=number]:focus {
                border-bottom: 1px solid #00c853 !important;
                box-shadow: 0 1px 0 0 #00c853 !important;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <table class="striped responsive-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Attendance</th>
                                <th>Safe Days</th>
                            </tr>
                        </thead>                        
                        <tbody>
                            <?php
                                $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
                        
                                $result_obj=mysqli_query($con,"SELECT * FROM attendance_tracker");
                                                            
                                $total_aliases=mysqli_num_rows($result_obj);

                                $present_sum=0;
                                $outOf_sum=0;

                                for($i=0;$i<$total_aliases;$i++){

                                    $row=mysqli_fetch_assoc($result_obj);

                                    $present_sum+=$row['Present'];
                                    $outOf_sum+=$row['OutOf'];
                                    $attendance=0;
                                    $safe_days=0;

                                    if($row['OutOf']){
                                        $attendance=($row['Present']/$row['OutOf']);
                                    }
                                    
                                    if($attendance>0.8){
                                        $safe_days=floor($row['Present']/0.8)-$row['OutOf'];
                                    }

                                    echo "<tr id='".$row['Alias']."'>";
                                    echo "<td>".$row['Name']."</td>";
                                    echo "<td>".floor($attendance*100)."%</td>";
                                    echo "<td>".$safe_days."</td>";
                                    echo "</tr>";
                                }
                                $total=0;
                                if($outOf_sum){
                                    $total=($present_sum/$outOf_sum)*100;
                                    $total_safe_days=floor($present_sum/0.8)-$outOf_sum;
                                }
                                echo "<tr>";
                                echo "<td>Total</td>";
                                echo "<td>".floor($total)."%</td>";
                                echo "<td>".$total_safe_days."</td>";
                                echo "</tr>";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m4 offset-m2">
                    <select id="subject">
                        <option value="" disabled selected>Select Subject</option>
                        <?php
                            $result_obj=mysqli_query($con,"SELECT * From attendance_tracker");
                            
                            $total_aliases=mysqli_num_rows($result_obj);

                            for($i=0;$i<$total_aliases;$i++){

                                $row=mysqli_fetch_assoc($result_obj);

                                echo "<option value='".$row['Alias']."'>".$row['Name']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="input-field col s6 m2">
                    <input id="present" type="number">
                    <label for="present">Present</label>
                </div>
                <div class="input-field col s6 m2">
                    <input id="outOf" type="number">
                    <label for="outOf">Out Of</label>
                </div>
            </div>
            <div class="row center-align">
                <div class="col s12">
                    <h6><b>Last Entry: </b><span id="lastEntry">
                        <?php
                            $result_obj=mysqli_query($con,"SELECT * FROM attendance_tracker_date");
                            $row=mysqli_fetch_assoc($result_obj);
                            echo $row['LastEntry'];
                        ?>
                    </span></h6>
                </div>
            </div>
            <div class="row center-align">
                <div class="col s12">
                    <button class="btn waves-effect waves-light green accent-4" onclick="update()">Update</button>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script>
            $(document).ready(function() {
                $('select').material_select();
            });

            function update(){
                var subject,present,outOf;
                subject=$("#subject").val();
                present=$("#present").val();
                outOf=$("#outOf").val();
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "attendance_update.php?subject="+subject+"&present="+present+"&outOf="+outOf, true);
                xmlhttp.send();
                Materialize.toast('Updated!', 1000);

                $("#"+subject).addClass("grey-text");
                $("#lastEntry").addClass("grey-text");
            }
        </script>
    </body>
</html>