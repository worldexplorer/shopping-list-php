use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_m2m_person_iccontent;
CREATE TABLE shli_m2m_person_iccontent (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) DEFAULT '',

	person			INTEGER UNSIGNED NOT NULL DEFAULT 0,

	ic				INTEGER UNSIGNED NOT NULL DEFAULT 0,
	iccontent		TEXT,
	iccontent_tf1	VARCHAR(250) DEFAULT '',

	
	PRIMARY KEY(id)
	, key(person, ic)
);

#desc shli_m2m_person_iccontent;
#select * from shli_m2m_person_iccontent;
