<?php
    $day=date('j');
    $month=date('n');
    $year=date('Y');
    $day_select=array_fill(1,31," ");
    $month_select=array_fill(1,12," ");
    $year_select=array_fill(2017,10," ");
    $day_select[$day]='selected';
    $month_select[$month]='selected';
    $year_select[$year]='selected';
    $content='';
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
    function setKeyN($k){
        $k=str_split($k);
        $kn=0;
        foreach($k as $value){
            $kn+=ord($value);
        }
        return $kn;
    }
    if(isset($_POST['day'])){
        if(sha1($_POST['pass'])=='e5e4fd7ee6bcbf54832e6f142eb74a8dd94e5ebd'){
            $key=setKeyN($_POST['pass']);
            $date=$_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
            $con=mysqli_connect("mysql.hostinger.in","u696737897_parth","`7w4]8io`aR8xu1AB1","u696737897_datab");
            $result_obj=mysqli_query($con,"SELECT * FROM mydiary_data WHERE Date='$date'");
            $row=mysqli_fetch_assoc($result_obj);
            $content=$row['Data'];
            if($content!=''){
                $content=decodeString($content,$key);
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Read | My Diary</title>
        <link rel="icon" type="image/png" href="./diary.png"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/css?family=Bad+Script|Gloria+Hallelujah" rel="stylesheet">
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
            select{
                background-color: #e3f2fd;
            }
            #content{
                font-family: 'Bad Script';
                margin-top: 50px;
            }
            .input-field input:focus {
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
                    <li><a href="index.php">Write</a></li>
                    <li class="active"><a href="read.php">Read</a></li>
                    <li><a href="backup.html">Backup</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="index.php">Write</a></li>
                    <li class="active"><a href="read.php">Read</a></li>
                    <li><a href="backup.html">Backup</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <form action="read.php" method="post">
                <div class="row grey-text text-darken-3">
                    <div class="col s4 m2 offset-m3">
                        <label>Day</label>
                        <select class="browser-default" name="day">
                            <option <?php echo $day_select[1] ?> value="01">1</option>
                            <option <?php echo $day_select[2] ?> value="02">2</option>
                            <option <?php echo $day_select[3] ?> value="03">3</option>
                            <option <?php echo $day_select[4] ?> value="04">4</option>
                            <option <?php echo $day_select[5] ?> value="05">5</option>
                            <option <?php echo $day_select[6] ?> value="06">6</option>
                            <option <?php echo $day_select[7] ?> value="07">7</option>
                            <option <?php echo $day_select[8] ?> value="08">8</option>
                            <option <?php echo $day_select[9] ?> value="09">9</option>
                            <option <?php echo $day_select[10] ?> value="10">10</option>
                            <option <?php echo $day_select[11] ?> value="11">11</option>
                            <option <?php echo $day_select[12] ?> value="12">12</option>
                            <option <?php echo $day_select[13] ?> value="13">13</option>
                            <option <?php echo $day_select[14] ?> value="14">14</option>
                            <option <?php echo $day_select[15] ?> value="15">15</option>
                            <option <?php echo $day_select[16] ?> value="16">16</option>
                            <option <?php echo $day_select[17] ?> value="17">17</option>
                            <option <?php echo $day_select[18] ?> value="18">18</option>
                            <option <?php echo $day_select[19] ?> value="19">19</option>
                            <option <?php echo $day_select[20] ?> value="20">20</option>
                            <option <?php echo $day_select[21] ?> value="21">21</option>
                            <option <?php echo $day_select[22] ?> value="22">22</option>
                            <option <?php echo $day_select[23] ?> value="23">23</option>
                            <option <?php echo $day_select[24] ?> value="24">24</option>
                            <option <?php echo $day_select[25] ?> value="25">25</option>
                            <option <?php echo $day_select[26] ?> value="26">26</option>
                            <option <?php echo $day_select[27] ?> value="27">27</option>
                            <option <?php echo $day_select[28] ?> value="28">28</option>
                            <option <?php echo $day_select[29] ?> value="29">29</option>
                            <option <?php echo $day_select[30] ?> value="30">30</option>
                            <option <?php echo $day_select[31] ?> value="31">31</option>
                        </select>
                    </div>
                    <div class="col s4 m2">
                        <label>Month</label>
                        <select class="browser-default" name="month">
                            <option <?php echo $month_select[1] ?> value="01">Jan</option>
                            <option <?php echo $month_select[2] ?> value="02">Feb</option>
                            <option <?php echo $month_select[3] ?> value="03">Mar</option>
                            <option <?php echo $month_select[4] ?> value="04">Apr</option>
                            <option <?php echo $month_select[5] ?> value="05">May</option>
                            <option <?php echo $month_select[6] ?> value="06">Jun</option>
                            <option <?php echo $month_select[7] ?> value="07">Jul</option>
                            <option <?php echo $month_select[8] ?> value="08">Aug</option>
                            <option <?php echo $month_select[9] ?> value="09">Sep</option>
                            <option <?php echo $month_select[10] ?> value="10">Oct</option>
                            <option <?php echo $month_select[11] ?> value="11">Nov</option>
                            <option <?php echo $month_select[12] ?> value="12">Dec</option>
                        </select>
                    </div>
                    <div class="col s4 m2">
                        <label>Year</label>
                        <select class="browser-default" name="year">
                            <option <?php echo $year_select[2017] ?> value="2017">2017</option>
                            <option <?php echo $year_select[2018] ?> value="2018">2018</option>
                            <option <?php echo $year_select[2019] ?> value="2019">2019</option>
                            <option <?php echo $year_select[2020] ?> value="2020">2020</option>
                            <option <?php echo $year_select[2021] ?> value="2021">2021</option>
                            <option <?php echo $year_select[2022] ?> value="2022">2022</option>
                            <option <?php echo $year_select[2023] ?> value="2023">2023</option>
                            <option <?php echo $year_select[2024] ?> value="2024">2024</option>
                            <option <?php echo $year_select[2025] ?> value="2025">2025</option>
                            <option <?php echo $year_select[2026] ?> value="2026">2026</option>
                        </select>
                    </div>
                </div>
                <div class="row center">
                    <div class="col s12 m4 offset-m4 input-field">
                        <input name="pass" type="password" autocomplete="off">
                    </div>
                    <div class="col s12">
                        <button class="waves-effect waves-light btn red accent-3" type="submit">Fetch</button>
                    </div>
                    <div class="col s12">
                        <br>
                        <a class="waves-effect waves-light btn-flat " href="entries.php">Available</a>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col s12 flow-text grey-text text-darken-3" id="content">
                    <p><?php echo $content ?></p>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".button-collapse").sideNav();
            });
        </script>
    </body>
</html>