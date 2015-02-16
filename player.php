<?php
class player{
	private $Name;
	private $Alter;
	private $EP;
	private $TP;
	private $Frische;
	private $Starke;
	private $Position;
	private $Bereich;
	private $AWP;
	
	
	function __construct($n,$a,$e,$t,$f,$s,$p){
		$this->Name=$n;
		$this->Alter=$a;
		$this->EP=$e;
		$this->TP=$t;
		$this->Frische=$f;
		$this->Starke=$s;
		$this->Position=$p;
		$this->Bereich=$this->getArea($p);
		$this->AWP=$this->calcAWP($e, $t);
	}
	//Getter $ Setter
	public function getName(){
		return $this->Name;
	}
	public function setName($var){
		$this->Name=$var;
	}
	public function getAlter(){
		return $this->Alter;
	}
	public function setAlter($var){
		$this->Alter=$var;
	}
	public function getEP(){
		return $this->EP;
	}
	public function setEP($var){
		$this->EP=$var;
		$this->AWP=$this->calcAWP($this->EP,$this->TP);
	}	
	public function getTP(){
		return $this->TP;
	}
	public function setTP($var){
		$this->TP=$var;
		$this->AWP=$this->calcAWP($this->EP,$this->TP);
	}	
	public function getFrische(){
		return $this->Frische;
	}
	public function setFrische($var){
		$this->Frische=$var;
	}	
	public function getStarke(){
		return $this->Starke;
	}
	public function setStarke($var){
		$this->Starke=$var;
	}	
	public function getPosition(){
		return $this->Position;
	}
	public function setPosition($var){
		$this->Position=$var;
		$this->Bereich=$this->getBereich($var);
	}	
	public function getBereich(){
		return $this->Bereich;
	}
	public function setBereich($var){
		$this->Bereich=$var;
	}	
	public function getAWP(){
		return round($this->AWP);
	}
	public function setAWP($var){
		$this->AWP=$var;
	}
	//Trainings: erh,tor,tak,kon,tra,tec,sch
	public function getTpFromTrain($training){
		if($this->Frische<50) return 0;
		else{
			switch($training){
				case "tor":
					if($this->Alter>=35){
						return 1;
				}else{
					if($this->Bereich=="tor") return 5;
						else return 1;
				}
					break;
				case "tak":
					if($this->Alter>=33){
						return 1;
					}else{
						if($this->Bereich=="verteidigung") return 3;
						else return 1;
					}
					break;
				case "kon":
					if($this->Alter>=37){
						return 1;
					}else{
						if($this->Bereich=="mittelfeld") return 2;
						else return 1;
					}
					break;
				case "tra":
					if($this->Alter>=31){
						return 1;
					}else{
						return 2;
					}
					break;
				case "tec":
					if($this->Alter>=29){
						return 1;
					}else{
						if($this->Bereich=="mittelfeld") return 3;
						else if($this->Bereich=="sturm") return 2;
						else return 1;
					}
					break;
				case "sch":
					if($this->Alter>=27){
						return 1;
					}else{
						if($this->Bereich=="mittelfeld") return 3;
						else if($this->Bereich=="sturm") return 4;
						else return 2;
					}
					break;
				default: return 0;
				}	
			}
	}	
	public function doTraining($training){
		$tp = $this->getTpFromTrain($training);
		if($tp==0) $this->Frische+=5;
		else{
			if($training=="kon"||$training=="tra"||($training=="tor"&&$this->Alter>=35)||($training=="tak"&&$this->Alter>=33)||($training=="tec"&&$this->Alter>=29)||($training=="sch"&&$this->Alter>=27)){
				$this->Frische-=3;
			}else if($training=="tor"||$training=="tec"||$training=="sch") $this->Frische-=2;
			else if($training=="tak") $this->Frische-=1;			
		}
		$this->setTP($this->TP+$tp);
	}
	//helper
	private function getArea($p){
		
		if($p=="LS"||$p=="RS"||$p=="MS") return "sturm";
		else if($p=="LM"||$p=="DM"||$p=="RM"||$p=="ZM"||$p=="VS") return "mittelfeld";
		else if($p=="RV"||$p=="RMD"||$p=="LMD"||$p=="LV"||$p=="LIB") return "verteidigung";
		else return "tor";
	}	
	private function calcAWP($EP,$TP){
		if($EP>$TP){
			return ($TP*(1+(($EP-$TP)/($EP+$TP))));
		}else{
			return ($EP*(1+(($TP-$EP)/($TP+$EP))));
		}
	}
}