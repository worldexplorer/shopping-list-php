use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_icwhose;
CREATE TABLE shli_icwhose (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',

	brief			TEXT,
	jsv_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	bo_only			TINYINT UNSIGNED NOT NULL DEFAULT 0,

	PRIMARY KEY(id)
);

#desc shli_icwhose;

insert into shli_icwhose (id, manorder, ident, hashkey) values (1, 1, 'Cвойства продуктов', 'PRODUCT_PROPERTIES');

#select * from shli_icwhose;

#alter TABLE szd_icwhose	add brief TEXT;
#alter TABLE szd_icwhose	add jsv_debug TINYINT UNSIGNED NOT NULL DEFAULT 0;


#alter table shli_icwhose add bo_only TINYINT UNSIGNED NOT NULL DEFAULT 0;
