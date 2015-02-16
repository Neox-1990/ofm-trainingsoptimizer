<html><head><link rel="stylesheet" type="text/css" href="style.css"></head><body>
<h1>OFM Trainingsoptimierer 1.0</h1>
<h6>optimiert für Firefox und Google Chrome</h6>
<hr>
<?php
include 'helper.php';
include 'awpTable.php';
if (!isset($_POST['awp'])){
	echo '<h2>Update der Aufwertungspunktgrenzen</h2>
<form action="'.$_SERVER['PHP_SELF'].'" method="post">
<textarea name="awp"></textarea><br>
<input type="submit">
</form>';
} else {
	$awpraw=explode("\n",$_POST['awp']);
	$awplist=array(0=>0,1=>0);
	$awplist[15]=correctDecimal(explode("\t",$awpraw[9])[4]);
	for($i=2;$i<=13;$i++){
		$awplist[$i]=correctDecimal(explode("\t",$awpraw[$i+8])[1]);
		$awplist[$i+14]=correctDecimal(explode("\t",$awpraw[$i+8])[4]);
	}
	$awplist[14]=correctDecimal(explode("\t", $awpraw[22])[1]);
	
	$awps = new awpTable();
	$awps->setAWP($awplist);
	
	for($i=1;$i<=27;$i++){
		echo "Stärke $i = ".$awps->getAWPtoST($i)."<br>\n";
	}
}
?>
</body></html>