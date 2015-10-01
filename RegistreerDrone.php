<?php
namespace RegistreerJeDrone;

class RegistreerDrone{
	const $partnerID = "";
	const $partnerPW = "";
	const $https_server = "https://registreerjedrone.nl/assets/php/formSubmit/partnerRegister.php";
	const $https_header = "Content-Type: application/x-www-form-urlencoded". PHP_EOL;

	public function __construct($voorNaam = "", 
								$tussenVoegsel = "",
								$achterNaam = "", 
								$email = "", 
								$telefoon = "", 
								$straat = "", 
								$huisnummer = 0, 
								$postcode1 = "", 
								$postcode2 = "", 
								$stad = "", 
								$provincie = "", 
								$land = ""
							   ){
		$this->voorNaam 		= $voorNaam;
		$this->tussenVoegsel 	= $tussenVoegsel;
		$this->achterNaam 		= $achterNaam;
		$this->email 			= $email;
		$this->telefoon 		= $telefoon;
		$this->straat 			= $straat;
		$this->huisNummer 		= $huisnummer;
		$this->postcode1 		= $postcode1;
		$this->stad 			= $stad;
		$this->provincie 		= $provincie;
		$this->land 			= $land;
		$this->postcode2 		= strtolower($this->land) == "belgie" || strtolower($this->land) == "be" ? "" : $postcode2;
		$this->drones 			= array();

	}
	public function addDrone($merk = "", $type = "", $kleur = ""){
		$this->drones[] = array("merk"=>$merk,"type"=>$type,"kleur"=>$kleur);
	}
	public function sendRegistration(){
		if(count($this->drones) == 0){
			return array("code" => -1, "message" => "You need to add a drone first");
		}

		$voorNaam 		= $this->voorNaam;
		$tussenVoegsel 	= $this->tussenVoegsel;
		$achterNaam 	= $this->achterNaam;
		$email 			= $this->email;
		$telefoonNummer = $this->telefoon;
		$straat 		= $this->straat;
		$huisnummer 	= $this->huisNummer;
		$postCode1	 	= $this->postcode1;
		$postCode2 		= $this->postcode2;
		$stad 			= $this->stad;
		$provincie 		= $this->provincie;
		$land 			= $this->land;
		$drones 		= json_encode($this->drones);
		$partnerID 		= self::partnerID;
		$partnerPW 		= self::partnerPW;
		$jsonData 		= <<<EOT
{"partner":{"id":"$partnerID","pass":"$partnerPW"},"name":{"first":"$voorNaam","middle":"$tussenVoegsel","last":"$achterNaam"},"email":"$email","phone":"$telefoonNummer","address":{"street":"$straat","number":"$huisnummer","zip":"$postCode1","zip2":"$postCode2","city":"$stad","province":"$provincie","country":"$land"},"drone":$drones}
EOT;
		$result 		= file_get_contents(self::https_server, false, stream_context_create(array('http'=>array('method'=>'POST','header'=>self::https_header,'content'=>http_build_query(array("json"=>$jsonData)),'timeout'=>60))));

		return array("code" => 1, "message" => "Registration has been sent");
	}
}
?>
