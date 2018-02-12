# Bitcoin Lottery
It's a Bitcoin-based virtual platform for organization and conduct a drawing of bitcoins.

URL: http://bitcoinlottery2018.com/

## Server requirements
PHP version 5.6 or newer; MySQL Server 5.7

## Installation instructions
### Preparation
Make sure that you have the following components installed:

* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [Bootstrap](https://github.com/twbs/bootstrap)
* [Popper.js](https://github.com/FezVrasta/popper.js/)
* [Font Awesome](https://github.com/FortAwesome/Font-Awesome)
* [jQuery](https://github.com/jquery/jquery)

Your folder structure (except for project files) should look like this:
```
public_html/
|── PHPMailer/
├── application/
|── system/
|── assets/
│   ├── bootstrap-*/
│   ├── popper.js-*/
│   ├── fontawesome-*/
│   ├── js/
|       ├── jquery-*.min.js
|── index.php
 ```
 ### Installing
 Copy project files to your site folder
 ```
 cd public_html
 git clone https://github.com/victor192/bitcoin-lottery
```
### Creating tables in a database
For initial creation of tables, run all queries from the file `setup.sql`.

### Settings
#### CodeIgniter
Make sure that you have properly configured database config and routes. For more information, see [here](https://codeigniter.com/user_guide/installation/index.html).

#### Blockchain API
Open the `application/config/blockchain_api.php` file and change the xpub and api keys:
```
$config['xpub_key'] = '';    // Your xpub key
$config['api_key'] = '';    // Your api key
 ```
 
 ### PHPMailer
 Open the `myphpmailer.php` file and change the server settings
 ```
//Server settings
$this->isSMTP();    // Set mailer to use SMTP
$this->Host = '';    // Specify main and backup SMTP servers
$this->SMTPAuth = true;    // Enable SMTP authentication
$this->Username = '';    // SMTP username
$this->Password = '';    // SMTP password
$this->SMTPSecure = '';    // Enable TLS encryption, `ssl` also accepted
$this->Port = 25;    // TCP port to connect to
 ```
