CREATE DATABASE IF NOT EXISTS bitcoin_lottery;
USE bitcoin_lottery;

CREATE TABLE lottery (
  lottery_id int(11) NOT NULL AUTO_INCREMENT,
  timezone text NOT NULL,
  start_date datetime NOT NULL,
  fee_amount double NOT NULL,
  org_rate double NOT NULL,
  finish_date datetime NOT NULL,
  PRIMARY KEY (lottery_id)
);
INSERT INTO lottery (timezone, start_date, fee_amount, org_rate, finish_date) VALUES
('America/New_York', '2018-01-31 00:00:00', 0.0005, 0.05, '2018-05-20 00:00:00');

CREATE TABLE winners (
  lottery_id int(11) NOT NULL,
  btc_address char(35) NOT NULL,
  transaction_hash char(64) NOT NULL,
  value double NOT NULL,
  PRIMARY KEY (lottery_id, btc_address)
);

CREATE TABLE participants (
  btc_address char(35) NOT NULL,
  email varchar(255) NOT NULL,
  admitted tinyint(1) NOT NULL DEFAULT '0',
  invoice_id int(11) NOT NULL,
  login_token char(32) DEFAULT NULL,
  rdate datetime NOT NULL,
  PRIMARY KEY (btc_address)
);

CREATE TABLE IF NOT EXISTS invoices (
  invoice_id int(11) NOT NULL AUTO_INCREMENT,
  invoice_code char(32) NOT NULL,
  payment_amount double NOT NULL,
  address char(35) DEFAULT NULL,
  receipt_secret char(32) DEFAULT NULL,
  PRIMARY KEY (invoice_id)
);

CREATE TABLE invoice_payments (
  transaction_hash char(64) NOT NULL,
  value double NOT NULL,
  invoice_id int(11) NOT NULL,
  tdate datetime NOT NULL,
  PRIMARY KEY (transaction_hash)
);

CREATE TABLE pending_invoice_payments (
  transaction_hash char(64) NOT NULL,
  value double NOT NULL,
  invoice_id int(11) NOT NULL,
  tdate datetime NOT NULL,
  PRIMARY KEY (transaction_hash)
);