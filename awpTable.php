<?php
class awpTable{
	private $awps=array();
	
	public function __construct(){
		$file = fopen("awp.txt", "r");
		$raw = explode("\t",fread($file, filesize("awp.txt")));
		for($i=1;$i<=27;$i++){
			$this->awps[$i]=$raw[$i-1];
		}
		fclose($file);
	}
	
	public function getAWPtoST($st){
		return $this->awps[$st];
	}
	
	public function setAWP($awpArray){
		$file = fopen("awp.txt","w");
		for($i=1;$i<=27;$i++){
			fwrite($file, $awpArray[$i]);
			if($i!=27) fwrite($file, "\t");
		}
		fclose($file);
		$this->awps=$awpArray;
	}
}