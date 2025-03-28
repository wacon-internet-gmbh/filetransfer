CREATE TABLE tx_filetransfer_domain_model_upload (
	sender_address VARCHAR(255) DEFAULT '' NOT NULL,
	receiver_address VARCHAR(255) DEFAULT '' NOT NULL,
	subject VARCHAR(255) DEFAULT '' NOT NULL,
	message MEDIUMTEXT,
	signature MEDIUMTEXT,
	token VARCHAR(80) DEFAULT '' NOT NULL,
	download_limit INT(11) DEFAULT '1' NOT NULL,
	asset INT(10) DEFAULT '0' NOT NULL,
	validity_date INT(10) DEFAULT '0' NOT NULL,
	validity_duration INT(11) DEFAULT '3' NOT NULL,

	KEY token(token),
	KEY download_limit(download_limit),
);

CREATE TABLE fe_users (
	mail_signature MEDIUMTEXT DEFAULT '' NOT NULL
);
