use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_ic;
CREATE TABLE shli_ic (
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
	icwhat			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ictype			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	icdict			INTEGER UNSIGNED NOT NULL DEFAULT 0,
	param1			VARCHAR(250) NOT NULL DEFAULT '',
	param2			VARCHAR(250) NOT NULL DEFAULT '',
	graycomment		VARCHAR(250) NOT NULL DEFAULT '',

	jsvalidator		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	obligatory		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	obligatory_bo	TINYINT UNSIGNED NOT NULL DEFAULT 0,

	inbrief			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	sorting			TINYINT UNSIGNED NOT NULL DEFAULT 0,

	published_bo	TINYINT UNSIGNED NOT NULL DEFAULT 1,

	PRIMARY KEY(id)
);

#desc shli_ic;

insert into shli_ic(id, manorder, icwhose, ictype, ident) values(1, 1, 1, 1, 'Размеры: см');
insert into shli_ic(id, manorder, icwhose, ictype, ident) values(2, 2, 1, 2, 'Масса: кг');
insert into shli_ic(id, manorder, icwhose, ictype, icdict, inbrief, sorting, ident) values(3, 3, 1, 4, 1, 1, 1, 'Упаковка:');
insert into shli_ic(id, manorder, icwhose, ictype, inbrief, sorting, ident) values(4, 4, 1, 2, 1, 1, 'Доставка: дней');
insert into shli_ic(id, manorder, icwhose, ictype, inbrief, sorting, ident) values(5, 5, 1, 2, 1, 1, 'На складе: шт');

#select * from shli_ic;


#alter TABLE ic add graycomment		VARCHAR(250) NOT NULL DEFAULT '';

# added in richclub
#alter table shli_ic add obligatory_bo TINYINT UNSIGNED NOT NULL DEFAULT 0;
#alter table shli_ic add published_bo TINYINT UNSIGNED NOT NULL DEFAULT 1;

