use shli;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_constant;
CREATE TABLE shli_constant (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	content			TEXT,

	PRIMARY KEY(id)
	, UNIQUE (hashkey)
);

#desc shli_constant;

#insert into shli_constant (id, manorder, ident, hashkey, content) VALUES
#(1,1,'Счётчики в начале страниц','COUNTER_TOP',''),
#(2,2,'Счётчики в конце страниц','COUNTER_BOTTOM',''),
#(3,3,'Контент в шапке','CONTENT_TOP','Шапка сайта'),
#(4,4,'Контент в подвале','CONTENT_BOTTOM','Подвал сайта');

#select * from shli_constant;
