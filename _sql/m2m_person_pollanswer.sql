use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_m2m_person_pollanswer;
CREATE TABLE shli_m2m_person_pollanswer (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) DEFAULT '',

	poll			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	pollanswer		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	person			INTEGER UNSIGNED NOT NULL DEFAULT 0,
#	correct			TINYINT UNSIGNED NOT NULL DEFAULT 0,

	ic				INTEGER UNSIGNED NOT NULL DEFAULT 0,
	icdictcontent	INTEGER UNSIGNED NOT NULL DEFAULT 0,
	iccontent		TEXT,

	remote_address	VARCHAR(250) NOT NULL DEFAULT '',
	
	PRIMARY KEY(id),
	unique key(person, pollanswer)
);

#desc shli_m2m_person_pollanswer;
#select * from shli_m2m_person_pollanswer;
