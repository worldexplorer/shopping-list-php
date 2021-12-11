use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_icdict;
CREATE TABLE shli_icdict (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',

	icwhose			INTEGER UNSIGNED NOT NULL DEFAULT 0,

	PRIMARY KEY(id)
);

#desc shli_icdict;

insert into shli_icdict(id, manorder, icwhose, ident) values(1, 1, 1, '”паковка');

#select * from shli_icdict;
