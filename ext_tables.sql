CREATE TABLE tx_filetransfer_domain_model_upload (
	subject VARCHAR(255) DEFAULT '' NOT NULL,
	message MEDIUMTEXT,
	token VARCHAR(80) DEFAULT '' NOT NULL,
	downloaded INT(11) DEFAULT '0' NOT NULL,
	asset INT(10) DEFAULT '0' NOT NULL,
	validity_date INT(10) DEFAULT '0' NOT NULL,

	KEY token(token)
);
