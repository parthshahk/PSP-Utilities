<?php
    if(isset($_POST['diaryText'])){
        $data=$_POST['diaryText'];
        $date=date('Y').'-'.date('m').'-'.date('d');
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
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Write | My Diary</title>
        <link rel="icon" type="image/png" href="./diary.png"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="robots" content="noindex, nofollow" />
        <style>
            nav{
                margin-bottom: 25px;
            }
            .brand-logo{
                font-family: 'Gloria Hallelujah';
                margin-left: 10px;
            }
            .input-field textarea:focus {
                border-bottom: 1px solid #bdbdbd !important;
                box-shadow: 0 0 0 0 !important;
            }
        </style>
    </head>
    <body class="blue lighten-5">
        <nav class="red accent-3">
            <div class="nav-wrapper">
                <a href="index.php" class="brand-logo">myDiary</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li class="active"><a href="index.php">Write</a></li>
                    <li><a href="read.php">Read</a></li>
                    <li><a href="backup.html">Backup</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li class="active"><a href="index.php">Write</a></li>
                    <li><a href="read.php">Read</a></li>
                    <li><a href="backup.html">Backup</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <form action="index.php" method="post" id="form">
                <div class="row grey-text text-darken-3 right-align">
                    <div class="col s12 input-field">                    
                        <textarea name="diaryText" id="diaryText" class="materialize-textarea" autofocus></textarea>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".button-collapse").sideNav();
            });
            $('#diaryText').on('keydown', function(event){
                if(event.keyCode == 13){
                    $('#form').submit();
                }
            });
        </script>
    </body>
</html>