use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_poll;
CREATE TABLE shli_poll (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	tooltip				TEXT,
	comment_above		TEXT,
	comment_below		TEXT,
	save_button_label	TEXT,
	
	icwhose			INTEGER UNSIGNED NOT NULL DEFAULT 0,

	admins_csv					VARCHAR(250) NOT NULL DEFAULT '',
	admins_notify_after_votes	INTEGER UNSIGNED NOT NULL DEFAULT 0,

	gender_explicit	TINYINT UNSIGNED NOT NULL DEFAULT 0,

	PRIMARY KEY(id)
);

#desc shli_poll;
#select * from shli_poll;

alter table shli_poll ADD column save_button_label TEXT;

alter table shli_poll ADD column notify_admins VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_poll ADD column notify_after_votes INTEGER UNSIGNED NOT NULL DEFAULT 0;


alter table shli_poll CHANGE column notify_admins admins_csv VARCHAR(250) NOT NULL DEFAULT '';
alter table shli_poll CHANGE column notify_after_votes admins_notify_after_votes INTEGER UNSIGNED NOT NULL DEFAULT 0;
