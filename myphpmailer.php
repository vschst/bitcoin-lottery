<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.0.2/src/Exception.php';
require 'PHPMailer-6.0.2/src/PHPMailer.php';
require 'PHPMailer-6.0.2/src/SMTP.php';

class MyPHPMailer extends PHPMailer {
  public function __construct() {
    parent::__construct();
	
	//Server settings
	$this->isSMTP();    // Set mailer to use SMTP
    $this->Host = '';    // Specify main and backup SMTP servers
    $this->SMTPAuth = true;    // Enable SMTP authentication
    $this->Username = '';    // SMTP username
    $this->Password = '';    // SMTP password
    $this->SMTPSecure = 'tls';    // Enable TLS encryption, `ssl` also accepted
    $this->Port = 587;    // TCP port to connect to
	
	//Recipients
    $this->setFrom($this->Username, 'Bitcoin Lottery 2018');
  }
}