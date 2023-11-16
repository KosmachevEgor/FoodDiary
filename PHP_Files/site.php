<?php
session_start();
$sql = new PDO('mysql:host=localhost; dbname=food_diary', "root", "*****");
$tName = $_SESSION['LogName'];
if (isset($_POST['site']))
{
    $foodName = $_POST['product'];
    $weight = $_POST['weight'];
    $dateValue = $_POST['dateInfo'];
    $query=$sql->prepare("SELECT * FROM food WHERE Namefood=:Namefood");
    $query->bindParam("Namefood",$foodName,PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        include_once('../HTML_Files/WebSite.html');
        echo '<label class="webTE">You enter unreal product!</label>';
    } else {
        if ($foodName === $result['Namefood']) {
            $calories = $result['Caloric_content'];
            $allCalories = $calories*$weight/100;
            $data= array('myDate'=>$dateValue, 'Calories'=>$allCalories);
            $query = $sql->prepare("INSERT INTO $tName (MyData,Calori) VALUES(:myDate,:Calories)");
            $query->execute($data);
            include_once('../HTML_Files/WebSite.html');
            echo '<label class="webTS">You meel have: '.$allCalories.' calories</label>';
        } else {
            echo '<label class="webTE">You enter unreal product!</label>';
        }
    }
}
if(isset($_POST['webtable'])){
    $conn = new mysqli("localhost","root","Egor_TV_mir_2003","food_diary");
    if($result = $conn->query("SELECT * FROM $tName")) {
        include_once('../HTML_Files/WebSiteTabel.html');
        echo '<table><th class="webT">YourDate </th><th class="webT">  |||</th><th class="webT">YourCalories</th>';
        foreach ($result as $row)
        {
            echo '<tr class="webT">';
            echo '<td class="webT">'.$row["MyData"].'    </td>';
            echo '<td class="webT">|||</td>';
            echo '<td class="webT">'.$row["Calori"].'</td>';
            echo '</tr>';
        }
        echo "</table>";
   }
}
if(isset($_POST['returnback']))
{
    echo '<meta http-equiv="refresh" content="0; url= ../HTML_Files/WebSite.html">';
}