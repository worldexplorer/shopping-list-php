use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_icsheet;
CREATE TABLE shli_icsheet (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	icwhose			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	content			TEXT,

	PRIMARY KEY(id)
);

#desc shli_icsheet;
#insert into shli_icsheet(id, ident) values(1, 'NONE');
#select * from shli_icsheet;
