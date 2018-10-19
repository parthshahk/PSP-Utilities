<!DOCTYPE html>
<html>
    <head>
        <title>Sessional Tracker</title>
        <link rel="icon" type="image/png" href="https://parthshah.xyz/favicon.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>      
            #total{
                font-weight: 500;
            }

            .input-field input[type=number]:focus + label {
                color: #64b5f6 !important;
            }

            .input-field input[type=number]:focus {
                border-bottom: 1px solid #2196f3 !important;
                box-shadow: 0 1px 0 0 #2196f3 !important;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Sessional 1</th>
                                <th>Sessional 2</th>
                                <th>Sessional 3</th>
                                <th>Total</th>
                                <th>Due Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");

                                $result_obj=mysqli_query($con,"SELECT * From sessional_tracker");
                            
                                $total_aliases=mysqli_num_rows($result_obj);
                            
                                for($i=0;$i<$total_aliases;$i++){

                                    $row=mysqli_fetch_assoc($result_obj);

                                    $sess_total=$row['Sessional 1']+$row['Sessional 2']+$row['Sessional 3'];

                                    $due_total=$row['Safe_Total']-$sess_total;
                                    if($due_total<=0){
                                        $due_total_display="";
                                    }else{
                                        $due_total_display=$due_total;                                        
                                    }
                                
                                    if($due_total>0&&$row['Sessional 2']>0){
                                        echo "<tr class='red lighten-5' id='".$row['Alias']."'>";
                                    }else{
                                        echo "<tr id='".$row['Alias']."'>";
                                    }

                                    echo "<td>".$row['Name']."</td>";
                                    echo "<td id='".$row['Alias']."s1'><span class=''>".$row['Sessional 1']."</span></td>";                                    
                                    echo "<td id='".$row['Alias']."s2'><span class=''>".$row['Sessional 2']."</span></td>";                                    
                                    echo "<td id='".$row['Alias']."s3'><span class=''>".$row['Sessional 3']."</span></td>";
                                    echo "<td id='".$row['Alias']."tot'>".$sess_total."</td>";                                    
                                    echo "<td id='".$row['Alias']."due'>".$due_total_display."</td>";
                                    echo "<td class='hide' id='".$row['Alias']."safeTotal'>".$row['Safe_Total']."</td>";
                                    echo "</tr>";
                                }
                            ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m4">
                    <select id="subject">
                        <option value="" disabled selected>Select Subject</option>
                        <?php
                            $result_obj=mysqli_query($con,"SELECT * From sessional_tracker");                                 
                            $total_aliases=mysqli_num_rows($result_obj);                        
                            for($i=0;$i<$total_aliases;$i++){
                                $row=mysqli_fetch_assoc($result_obj);
                                echo "<option value='".$row['Alias']."'>".$row['Name']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="input-field col s12 m4">
                    <select id="sessional">
                        <option value="" disabled selected>Sessional</option>
                        <option value="s1">Sessional 1</option>
                        <option value="s2">Sessional 2</option>
                        <option value="s3">Sessional 3</option>
                    </select>
                </div>
                <div class="input-field col s12 m4">
                    <input id="marks" type="number">
                    <label for="marks">Marks</label>
                </div>
            </div>
            <div class="row center-align">
                <div class="col s12">
                    <button class="waves-effect waves-light btn blue" onclick="update()">Update</button>
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
                var subject,sessional,marks,newDue,newTotal;
                subject=$("#subject").val();
                sessional=$("#sessional").val();
                marks=$("#marks").val();
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "sessional_update.php?subject="+subject+"&sessional="+sessional+"&marks="+marks, true);
                xmlhttp.send();
                
                $("#"+subject+""+sessional+" span").html(marks);

                newTotal=parseInt($("#"+subject+"s1 span").html())+parseInt($("#"+subject+"s2 span").html())+parseInt($("#"+subject+"s3 span").html());
                $("#"+subject+"tot").html(newTotal);

                newDue=parseInt($("#"+subject+"safeTotal").html())-newTotal;
                
                if(newDue>0){
                    $("#"+subject+"due").html(newDue);
                    if(!$("#"+subject).hasClass("red")){
                        $("#"+subject).addClass("red lighten-5");
                    }
                }else{
                    $("#"+subject+"due").html("");
                    if($("#"+subject).hasClass("red")){
                        $("#"+subject).removeClass("red lighten-5");
                    }
                }
            }
        </script>
    </body>
</html>