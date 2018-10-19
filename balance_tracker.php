<!DOCTYPE html>
<html>
    <head>
        <title>Balance Tracker</title>
        <link rel="icon" type="image/png" href="https://parthshah.xyz/favicon.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>

            .input-field input[type=text]:focus+label,input[type=number]:focus + label {
                color: #2196f3  !important;   
            }

            .input-field input[type=text]:focus,input[type=number]:focus {
                border-bottom: 1px solid #2196f3  !important;
                box-shadow: 0 1px 0 0 #2196f3  !important;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Entity</th>
                            <th>Difference</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");                            
                                                            
                            $result_obj=mysqli_query($con,"SELECT * FROM balance_tracker");
                                                                                                
                            $total_entries=mysqli_num_rows($result_obj);

                            for($i=0;$i<$total_entries;$i++){
                                
                                $row=mysqli_fetch_assoc($result_obj);

                                if($row['Type']=='positive'){
                                    $type='green';
                                    $arrow='up';
                                }else if ($row['Type']=='negative'){
                                    $type='red';
                                    $arrow='down';
                                }

                                echo "<tr>";
                                echo "<td>".$row['Entity']."</td>";
                                echo "<td class='".$type."-text'>".$row['Amount']."<i class='material-icons tiny'>arrow_drop_".$arrow."</i></td>";
                                echo "<td>".$row['Date']."</td>";
                                echo "<td><button class='waves-effect waves-red btn-flat' onclick=remove('".$row['Entity']."')>Remove</button></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row center-align">
                <div class="input-field col s6 m3 offset-m3">
                    <input id="entity" type="text">
                    <label for="entity">Entity</label>
                </div>
                <div class="input-field col s6 m3">
                    <input id="difference" type="number">
                    <label for="difference">Difference</label>
                </div>
            </div>
            <div class="row center-align">
                <div class="col s12 m4 offset-m4">
                    <select class="browser-default" id="differenceType">
                      <option value="" disabled selected>Select Difference Type</option>
                      <option value="positive">Positive</option>
                      <option value="negative">Negative</option>
                    </select>
                </div>
            </div>
            <div class="row center-align">
                <button class="btn blue waves-effect waves-light" onclick="update()">Update</button>
            </div>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script>
        
            function update(){
                var entity,difference,differenceType;
                entity=$('#entity').val();
                difference=$('#difference').val();
                differenceType=$('#differenceType').val();
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "balance_update.php?entity="+entity+"&difference="+difference+"&differenceType="+differenceType, true);
                xmlhttp.send();
                Materialize.toast("Updated!",1000);
                setTimeout(function(){
                    location.reload(true);
                }, 1000);
            }

            function remove(entity){
                
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "balance_remove.php?entity="+entity, true);
                xmlhttp.send();
                Materialize.toast("Updated!",1000);
                setTimeout(function(){
                    location.reload(true);
                }, 1000);
            }
        </script>
    </body>
</html>