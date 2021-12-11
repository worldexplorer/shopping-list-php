use shasholi;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shasholi_pollanswer;
CREATE TABLE shasholi_pollanswer (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	tooltip			TEXT,
	comment_above	TEXT,
	comment_below	TEXT,
	
	
	poll			INTEGER UNSIGNED NOT NULL DEFAULT 0,

	
#Ты придёшь на урок в "пнд 13е, группа Л"?
#- да:
#	-- приду на сальсу
#	-- приду на бачату
#- не приду
	parent_id		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	multicb			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	
	
	
	icdict			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	
	PRIMARY KEY(id)
);

#desc shasholi_pollanswer;
#select * from shasholi_pollanswer;
