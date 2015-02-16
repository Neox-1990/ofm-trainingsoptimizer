<html><head><link rel="stylesheet" type="text/css" href="style.css"></head><body>
<h1>OFM Trainingsoptimierer 1.0</h1>
<h6>optimiert für Firefox und Google Chrome</h6>
<hr>
<?php 
if(!isset($_POST['pass'])){?>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
<h4>Passwort:</h4>
<input name="pass" type="password"></input><br>
<input id="Button" type="submit" value="weiter">
</form>
<?php
}else{
if(md5($_POST['pass'])=="da4ede0e28f6bf0cb27938d21aebce31"||md5($_POST['pass'])=="2b8b55b178bf3ea28177f5783fde8de5"||md5($_POST['pass'])=="4e448f2f2a46a88bafad6a864f919f33"){
?>
<div id="formular">
<form action="optimizer.php" method="post">
<div id="inputs"><h4>Eingabe der Trainingsübersicht:</h4><textarea name="team" cols="50" rows="13"></textarea></div>
<div id="inputs"><h4>Letzter Spieltag?</h4><h6><input type="radio" name="last" value=0 checked>Nein</h6>
<h6><input type="radio" name="last" value=1>Ja</h6></div>
<input id="Button" type="submit" value="Berechne">
<br><br><br><br>
<?php if(md5($_POST['pass'])=="4e448f2f2a46a88bafad6a864f919f33"){?>
<h6><a href="awp-update.php">zum AWP-Update</a></h6>
<?php }?>
<h6><a href="transfermarkt.php">zum Transfermarktrechner</a></h6>
</form>
</div>
<div id="tut"><h4>How to:</h4><h6>Wie gezeigt kopieren und in Feld einfügen.</h6><img alt="tutorial" src="img/tutorial.png"></div>
<?php } else {?>
<h5>Falsches Passwort</h5>
<?php }
}?>
</body>
</html>