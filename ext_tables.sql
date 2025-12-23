CREATE TABLE tx_filetransfer_domain_model_upload (
	download_limit INT(11) UNSIGNED DEFAULT '1' NOT NULL,
	validity_duration INT(11) UNSIGNED DEFAULT '3' NOT NULL,

	KEY token(token),
	KEY download_limit(download_limit),
);
