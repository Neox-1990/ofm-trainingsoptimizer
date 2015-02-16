<html><head><link rel="stylesheet" type="text/css" href="style.css"></head><body>
<h1>OFM Trainingsoptimierer 1.0</h1>
<h6>optimiert für Firefox und Google Chrome</h6>
<hr>
<?php
include 'player.php';
include 'helper.php';
include 'awpTable.php';
$rawTeam = explode("\t", $_POST['team']);
/*$n=0;
foreach($rawTeam as $line){
	echo "<p>$n ".$line."</p>\n";
	$n++;
}
echo "\n<p>Count: ".count($rawTeam)."</p>\n";*/
$players=0;
$browserDivisor=0;
$players = (count($rawTeam)+1)/10;
//echo $_SERVER['HTTP_USER_AGENT'];
if(strstr($_SERVER['HTTP_USER_AGENT'], "Firefox")){
	$players = (count($rawTeam)+2)/11;
	$browserDivisor=11;
} else {
	$players = (count($rawTeam)+1)/10;
	$browserDivisor=10;
}

$team = array(0=> new player($rawTeam[1], $rawTeam[2], correctDecimal($rawTeam[4]), correctDecimal($rawTeam[5]), $rawTeam[6], $rawTeam[3], $rawTeam[0]));
for($i=1;$i<$players;$i++){
	$team[$i]=new player($rawTeam[$i*$browserDivisor+1], $rawTeam[$i*$browserDivisor+2], correctDecimal($rawTeam[$i*$browserDivisor+4]), correctDecimal($rawTeam[$i*$browserDivisor+5]), $rawTeam[$i*$browserDivisor+6], $rawTeam[$i*$browserDivisor+3], str_replace(" ", "", $rawTeam[$i*$browserDivisor]));
}

if($_POST['last']){
	foreach ($team as $p){
		$p->setFrische(127);
		$p->setAlter(1+$p->getAlter());
	}
}

$beforeTeam=array();
foreach ($team as $key=>$player){
	$clonePlayer = clone $player;
	$beforeTeam[$key] = $clonePlayer;
}

//Clone Test
/*
foreach ($team as $i=>$p){
	if($team[$i]===$beforeTeam[$i]) echo "\nFehlclonung";
	else echo "\nDollytime!";
}
*/

$best=getBestTrain($team);

echo '<h4>Training:</h4><table><tbody><tr><th id="training">1</th><th id="training">2</th><th id="training">3</th><th id="training">4</th><th id="training">5</th><th id="training">6</th><th id="training">7</th><th id="training">8</th><th id="training">9</th><th id="training">10</th></tr><tr>';
foreach ($best as $trainUnit){
	echo '<td id="training"><img id="unit-image" src="img/'.$trainUnit.'.png"></td>';
}
echo "</tr><tr>";
foreach ($best as $trainUnit){
	echo '<td id="unit-name">'.$trainUnit.'</td>';
}
echo "</tr></tbody></table>";

$awps=new awpTable();

echo '<h4>Mannschaft:</h4><table><tbody><tr><th id="light">Position</th><th id="light">Spieler</th><th id="light">EP</th><th id="light">TP</th><th id="light">AWP</th><th id="light">Stärke</th></tr>';
foreach($team as $key => $player){
	$pos=$player->getBereich();
	$colorBereich="#CCC";
	if($pos=="verteidigung") $colorBereich="#AFA";
	else if($pos=="mittelfeld") $colorBereich="#FFA";
	else if($pos=="sturm") $colorBereich="#FAA";
	else if($pos=="tor") $colorBereich="#AAF";
	else $colorBereich ="#BBB";
	$awpDiff=$awps->getAWPtoST($player->getStarke()+1)-$player->getAWP();
	$awpDiffColor=getColor($awpDiff);
	
	echo '<tr bgcolor="'.$colorBereich.'">';
	
	echo "<td>".$player->getPosition()."</td>";
	echo "<td>".$player->getName()." (".$player->getAlter().")</td>";
	echo "<td>".$player->getEP()."</td>";
	echo "<td>".$player->getTP()." (+".($player->getTP()-$beforeTeam[$key]->getTP()).")</td>";
	echo "<td>".$player->getAWP()." (+".($player->getAWP()-$beforeTeam[$key]->getAWP()).")</td>";
	echo '<td style="background-color:'.$awpDiffColor.'">'.$player->getStarke()." (".(-1*$awpDiff).")</td>";
	echo "</tr>\n";
}
echo "</tbody></table>";

function getBestTrain($Team){
	$besttrain=array("erh","erh","erh","erh","erh","erh","erh","erh","erh","erh");
	for($unit=0;$unit<10;$unit++){
		$besttrain[$unit]=getBestUnitTrain($Team);
		foreach ($Team as $player){
			$player->doTraining($besttrain[$unit]);
		}
	}
	return $besttrain;
}
function getBestUnitTrain($team){
	$maxTP=0;
	$train="erh";
	$tempTP=0;
	foreach ($team as $player){
		$tempTP+=$player->getTpFromTrain("tak");
	}
	if($tempTP>$maxTP) {
		$train="tak";
		$maxTP=$tempTP;
	}
	
	$tempTP=0;
	foreach ($team as $player){
		$tempTP+=$player->getTpFromTrain("sch");
	}
	if($tempTP>$maxTP){
		$train="sch";
		$maxTP=$tempTP;
	}
	
	$tempTP=0;
	foreach ($team as $player){
		$tempTP+=$player->getTpFromTrain("tec");
	}
	if($tempTP>$maxTP){
		$train="tec";
		$maxTP=$tempTP;
	}
	
	$tempTP=0;
	foreach ($team as $player){
		$tempTP+=$player->getTpFromTrain("tor");
	}
	if($tempTP>$maxTP){
		$train="tor";
		$maxTP=$tempTP;
	}
	
	$tempTP=0;
	foreach ($team as $player){
		$tempTP+=$player->getTpFromTrain("tra");
	}
	if($tempTP>$maxTP){
		$train="tra";
		$maxTP=$tempTP;
	}
	
	$tempTP=0;
	foreach ($team as $player){
		$tempTP+=$player->getTpFromTrain("kon");
	}
	if($tempTP>$maxTP){
		$train="kon";
		$maxTP=$tempTP;
	}
	
	return $train;
}

?>
</body></html>