# Discord-Webhook-IP-Logger
This is a PHP IP logger I made that sends the IP of the visitor to Discord as an embed.
![Example picture](https://i.imgur.com/fzxgFPy.png)

# Features
- Grabs the IP of all page visitors (except for bots/crawlers).
- Gets some basic information about the visitor's IP and browser.
- Checks if the IP is a VPN (Not always 100% correct).
- Gets the Geo Location of the visitor.

# The Setup
Step 1: Go into the settings of your Discord server, where you want the embeds to come trough.<br>
Step 2: Click the 'Webhooks' tab and create a webhook for the channel of choice.<br>
Step 3: After the webhook is created, copy the webhook link.<br>
Step 4: Set the webhook url to the one you just copied.<br>
Step 5: Copy the code of the index.php and paste is somewhere in your code.<br>
