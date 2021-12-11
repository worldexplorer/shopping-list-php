use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_img;
CREATE TABLE shli_img (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	img				VARCHAR(255) NOT NULL DEFAULT '',
	img_w			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	img_h			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	img_txt			VARCHAR(255) NOT NULL DEFAULT '',

	img_big			VARCHAR(255) NOT NULL DEFAULT '',
	img_big_w		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	img_big_h		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	img_big_txt		VARCHAR(255) NOT NULL DEFAULT '',

	owner_entity	VARCHAR(250) NOT NULL DEFAULT '',
	owner_entity_id	INTEGER UNSIGNED NOT NULL DEFAULT 1,
	imgtype			INTEGER UNSIGNED NOT NULL DEFAULT 1,

	img_src			VARCHAR(250) NOT NULL DEFAULT '',
	img_big_src		VARCHAR(250) NOT NULL DEFAULT '',

	img_main		TINYINT UNSIGNED NOT NULL DEFAULT 0,

	crc32			INTEGER UNSIGNED NOT NULL DEFAULT 0,

	date_faceted	TIMESTAMP,
	faceted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	faceting		TINYINT UNSIGNED NOT NULL DEFAULT 0,

	PRIMARY KEY(id)
	, key (owner_entity, owner_entity_id)
	, key (imgtype)
	, key (published, deleted)
	, key (img_txt)
	, key (img_big_txt)
	, key (faceted)
	, key (faceting)
);

#desc shli_img;
#select * from shli_img;

#ALTER TABLE shli_img COLLATE='utf8_general_ci' CONVERT TO CHARSET utf8;
