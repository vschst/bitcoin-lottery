CREATE TABLE lottery (
  lottery_id int(11) NOT NULL AUTO_INCREMENT,
  timezone text NOT NULL,
  start_date datetime NOT NULL,
  fee_amount double NOT NULL,
  org_rate double NOT NULL,
  finish_date datetime NOT NULL
);
ALTER TABLE lottery ADD PRIMARY KEY (lottery_id);

CREATE TABLE winners (
  lottery_id int(11) NOT NULL,
  btc_address char(35) NOT NULL,
  transaction_hash char(64) NOT NULL,
  value double NOT NULL
)
ALTER TABLE winners ADD PRIMARY KEY (lottery_id, btc_address);

CREATE TABLE participants (
  btc_address char(35) NOT NULL,
  email varchar(255) NOT NULL,
  admitted tinyint(1) NOT NULL DEFAULT '0',
  invoice_id int(11) NOT NULL,
  login_token char(32) DEFAULT NULL,
  rdate datetime NOT NULL
);
ALTER TABLE participants ADD PRIMARY KEY (btc_address);

CREATE TABLE IF NOT EXISTS invoices (
  invoice_id int(11) NOT NULL AUTO_INCREMENT,
  invoice_code char(32) NOT NULL,
  payment_amount double NOT NULL,
  address char(35) DEFAULT NULL,
  receipt_secret char(32) DEFAULT NULL,
);
ALTER TABLE invoices ADD PRIMARY KEY (invoice_id);

CREATE TABLE invoice_payments (
  transaction_hash char(64) NOT NULL,
  value double NOT NULL,
  invoice_id int(11) NOT NULL,
  tdate datetime NOT NULL
);
ALTER TABLE invoice_payments ADD PRIMARY KEY (transaction_hash);

CREATE TABLE pending_invoice_payments (
  transaction_hash char(64) NOT NULL,
  value double NOT NULL,
  invoice_id int(11) NOT NULL,
  tdate datetime NOT NULL
);
ALTER TABLE pending_invoice_payments ADD PRIMARY KEY (transaction_hash);