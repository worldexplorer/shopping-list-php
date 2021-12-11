use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_person;
CREATE TABLE shli_person (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	phone			VARCHAR(250) NOT NULL DEFAULT '',

	password		VARCHAR(250) NOT NULL DEFAULT '',
	auth			VARCHAR(250) NOT NULL DEFAULT '',
	
	female			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	unsubscribed	TINYINT UNSIGNED NOT NULL DEFAULT 0,

	date_lastclick	TIMESTAMP,
	lastip			VARCHAR(250) NOT NULL DEFAULT '',
	lastsid			VARCHAR(250) NOT NULL DEFAULT '',
	lastip_login	VARCHAR(250) NOT NULL DEFAULT '',
	lastip_auth		VARCHAR(250) NOT NULL DEFAULT '',
	user_agent		VARCHAR(250) NOT NULL DEFAULT '',
	
	PRIMARY KEY(id)
	, key (published), key (deleted)
	, key(ident)
);

insert into shli_person(id, manorder, ident) values
	(1, 1, 'Вася'),
	(2, 2, 'Маша'),
	(3, 3, 'Даша'),
	(4, 4, 'Коля'),
	(5, 5, 'Маруся'),
	(6, 6, 'Петрович');

#desc shli_person;


alter table shli_person change column cookie password VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_person change column guid auth VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_person change column cellphone phone VARCHAR(250) NOT NULL DEFAULT '';

alter table shli_person add column date_lastclick TIMESTAMP;
alter table shli_person add column lastip VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_person add column lastsid VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_person add column lastip_login VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_person add column lastip_auth VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_person add column user_agent VARCHAR(250) NOT NULL DEFAULT '';
