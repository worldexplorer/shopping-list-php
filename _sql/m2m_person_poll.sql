use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_m2m_person_poll;
CREATE TABLE shli_m2m_person_poll (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) DEFAULT '',

	poll			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	person			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	voted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	changedvote		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	unsubscribed	TINYINT UNSIGNED NOT NULL DEFAULT 0,

	content			TEXT,
	
	PRIMARY KEY(id),
	unique key(person, poll)
);

#desc shli_m2m_person_poll;
#select * from shli_m2m_person_poll;

alter table shli_m2m_person_poll add column changedvote TINYINT UNSIGNED NOT NULL DEFAULT 0;
alter table shli_m2m_person_poll add column unsubscribed TINYINT UNSIGNED NOT NULL DEFAULT 0;
