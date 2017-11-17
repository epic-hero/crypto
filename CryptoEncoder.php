<?php

class CryptoEncoder {
	
	// private $first;
	// private $second;
	// private $third;
	// private $reflektor;
	// private $first;
	// private $countFirst;
	// private $countSecond;
	// private $countThird;
	// private $count_char;
	
	function __construct() {
		
		//Вывести в константы
		$this->first =     ["E" => "A", "K" => "B", "M" => "C", "F" => "D", "L" => "E", "G" => "F", "D" => "G", "Q" => "H", "V" => "I", "Z" => "J", "N" => "K", "T" => "L", "O" => "M", "W" => "N", "Y" => "O", "H" => "P", "X" => "Q", "U" => "R", "S" => "S", "P" => "T", "A" => "U", "I" => "V", "B" => "W", "R" => "X", "C" => "Y", "J" => "Z"];
		$this->second =    ["A" => "A", "J" => "B", "D" => "C", "K" => "D", "S" => "E", "I" => "F", "R" => "G", "U" => "H", "X" => "I", "B" => "J", "L" => "K", "H" => "L", "W" => "M", "T" => "N", "M" => "O", "C" => "P", "Q" => "Q", "G" => "R", "Z" => "S", "N" => "T", "P" => "U", "Y" => "V", "F" => "W", "V" => "X", "O" => "Y", "E" => "Z"];
		$this->third =     ["B" => "A", "D" => "B", "F" => "C", "H" => "D", "J" => "E", "L" => "F", "C" => "G", "P" => "H", "R" => "I", "T" => "J", "X" => "K", "V" => "L", "Z" => "M", "N" => "N", "Y" => "O", "E" => "P", "I" => "Q", "W" => "R", "G" => "S", "A" => "T", "K" => "U", "M" => "V", "U" => "W", "S" => "X", "Q" => "Y", "O" => "Z"];
		$this->reflektor = ["Y" => "A", "R" => "B", "U" => "C", "H" => "D", "Q" => "E", "S" => "F", "L" => "G", "D" => "H", "P" => "I", "X" => "J", "N" => "K", "G" => "L", "O" => "M", "K" => "N", "M" => "O", "I" => "P", "E" => "Q", "B" => "R", "F" => "S", "Z" => "T", "C" => "U", "W" => "V", "V" => "W", "J" => "X", "A" => "Y", "T" => "Z"];

		$this->countFirst =  0; 
		$this->countSecond = 0; 
		$this->countThird =  0; 
		 
		$this->count_char = count($this->first);
	}
	
    function rotorStart($input_text)
	{
		
		if ($input_text == ' ' || $input_text == '_') {
			return ' ';
		}
		
		$this->countFirst++;
		
		//Первый ротор сделал один оборот
		if($this->countFirst == $this->count_char){
			$this->second = $this->upgradeArray($this->second);
			$this->countFirst = 0;
			++$this->countSecond; 
		}
		
		//Второй ротор сделал один оборот
		if($this->countSecond == $this->count_char){
			$this->third = $this->upgradeArray($this->third);
			$this->countFirst =  0;
			$this->countSecond = 0;
			$this->countThird++;
		}
		
		//Третий ротор сделал один оборот
		if($this->countThird == $this->count_char){
			$this->countFirst =  0;
			$this->countSecond = 0;
			$this->countThird =  0;
		}
		
		$rotorFirst = $this->rotorFirst($input_text);
		$rotorSecond = $this->rotorSecond($rotorFirst);
		$rotorThird = $this->rotorThird($rotorSecond); 
		
		$reflektor = $this->reflektor($rotorThird); 

		$rotorThird2 = $this->rotorThirdBack($reflektor); 
		$rotorSecond2 = $this->rotorSecondBack($rotorThird2); 
		$rotorFirst2 = $this->rotorFirstBack($rotorSecond2); 
		
		return $rotorFirst2;	
	}
	
	function rotorFirst($input_text) {
		$this->first = $this->upgradeArray($this->first);
		
		return $this->first[$input_text];
	}
	
	function rotorSecond($input_text) {
		return $this->second[$input_text];
	}
	
	function rotorThird($input_text) {
		return $this->third[$input_text];
	}
	
	function reflektor($input_text) {
		return $this->reflektor[$input_text];
	}
	
	function rotorFirstBack($input_text) {
		return array_search($input_text, $this->first);
	}
	
	function rotorSecondBack($input_text) {
		return array_search($input_text, $this->second);
	}
	
	function rotorThirdBack($input_text){
		return array_search($input_text, $this->third);
	}
	
	function upgradeArray($array)
	{
		end($array);
		$end_key = key($array);
		$begin_value = reset($array);
		$array_new = []; 
		foreach ($array as $key => $value) {
			$array_new[$key] = current($array);
			next($array);
		} 
		$array_new[$end_key] = $begin_value; 
		return $array_new;
	}
		
	function rotorSettings($settings){
		
		//Не очень хорошо реализовано, переделать позже
		for($i = 0; $i < (int) $settings['rotor_first']; $i++){
			$this->first = $this->upgradeArray($this->first);
		}
		
		for($i = 0; $i < (int) $settings['rotor_second']; $i++){
			$this->second = $this->upgradeArray($this->second);
		}
		
		for($i = 0; $i < (int) $settings['rotor_third']; $i++){
			$this->third = $this->upgradeArray($this->third);
		}
		
	}
}