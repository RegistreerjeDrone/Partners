<?php
include("RegistreerDrone.php");

use RegistreerJeDrone;
$regDrone = new \RegistreerJeDrone\RegistreerDrone( "Voornaam", 
                                                    "TussenVoegsel", 
                                                    "Achternaam", 
                                                    "klant@email.nl", 
                                                    "+31 Telefoon", 
                                                    "Straat",
                                                    11, //Huisnummer
                                                    "1111", //Deel 1 van Nederlands postcode, of gehele deel van Belgische postcode
                                                    "AA", //Deel 2 van Nederlands postcode, of leeg voor Belgische klant
                                                    "Stad",
                                                    "Provincie",
                                                    "Land" //"Nederland", "Belgie", "NL", "BE"
                                                    );
$regDrone->addDrone("Merk", "Type", "Kleur");
$regDrone->addDrone("Merk2", "Type2", "Kleur2");
$response = $regDrone->sendRegistration();
if($response['code'] > 0){
    echo "Succesvol geregistreerd bij Registreer je Drone";
}
else{
    echo "Er is een fout opgetreden: ".$response['message'];
}

?>
