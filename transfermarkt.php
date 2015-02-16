<html><head><link rel="stylesheet" type="text/css" href="style.css"></head><body>
<h1>OFM Transfermarktrechner 1.0</h1>
<h6>optimiert für Firefox und Google Chrome</h6>
<hr>
<?php 
if(!isset($_POST['awp'])){
?>
<div id="formular">
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
<div id="inputs"><h4>Eingabe der Transferübersicht:</h4><textarea name="overview" cols="50" rows="13"></textarea></div>
<div id="inputs"><h4>AWP Treshold :</h4><h6><input type="text" name="awp" value="700"></div>
<div id="inputs"><h4>TP+ :</h4><h6><input type="text" name="tp" value="600"></div>
<div id="inputs"><h4>EP+ :</h4><h6><input type="text" name="ep" value="180"></div>
<input id="Button" type="submit" value="Berechne">
<br><br><br><br></form></div>
<?php


}else{
	$raw = explode("\n", $_POST['overview']);
	
	
	/*
	echo "Spieler :".(sizeof($raw))."<br>\n";
	foreach ($raw as $key => $line){
		echo "$key : $line <br>\n";
	}
	*/
	
	
	$table = array();
	
	if(strstr($_SERVER['HTTP_USER_AGENT'], "Firefox")){
		$spieler = sizeof($raw)/6;
		for($i=0;$i<$spieler;$i++){
			$key=explode("\t",$raw[$i*6+0]);
			$name=explode("\t",$raw[$i*6+1]);
			$eptp=explode("\t",$raw[$i*6+4]);
			$ep=explode("/", $eptp[3]);
			$tp=explode("/", $eptp[3]);
			$table[$key[0]] = array("name" => $name[1] , "ep" => $ep[0] , "tp" => $tp[1]);
		}
	}else{
		$spieler = sizeof($raw)/7;
		for($i=0;$i<$spieler;$i++){
			$key=explode("\t",$raw[$i*7+0]);
			$name=explode("\t",$raw[$i*7+2]);
			$eptp=explode("\t",$raw[$i*7+4]);
			$ep=explode("/", $eptp[2]);
			$tp=explode("/", $eptp[2]);
			$table[$key[0]] = array("name" => $name[0] , "ep" => $ep[0] , "tp" => $tp[1]);
		}
	}
	
	
	
	foreach ($table as $key => $line){
		$table[$key]["ep"]=$line["ep"]+$_POST["ep"];
		$table[$key]["tp"]=$line["tp"]+$_POST["tp"];
	}
	echo '<h4>Transfermarkt:</h4><table><tbody><tr><th id="light">Nummer</th><th id="light">Spieler</th><th id="light">EP</th><th id="light">TP</th><th id="light">AWP</th></tr>';
	
	foreach ($table as $key => $line){
		$awp = round(awp_calc($line["ep"], $line["tp"]));
		$color="#FAA";
		if($awp>=$_POST["awp"]) $color="#AFA";
		echo '<tr bgcolor="#AAA"><td style="background-color:'.$color.'">'.$key.'</td><td>'.$line["name"].'</td><td>'.$line["ep"].'</td><td>'.$line["tp"].'</td><td>'.$awp.'</td></tr>';
	}
	echo "</tbody></table>";
	
}

function awp_calc($ep,$tp){
	if($ep<$tp) return $ep*(1+($tp-$ep)/($tp+$ep));
	else return $tp*(1+($ep-$tp)/($ep+$tp));
}

?>
</body>
</html>