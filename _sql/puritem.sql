--\connect shli;
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_puritem;
CREATE TABLE shli_puritem (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE, -- date_purchased
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	room			INTEGER NOT NULL DEFAULT 0,
	purchase		INTEGER NOT NULL DEFAULT 0,
	"product" => array("", "cnt"),

	pgroup			INTEGER NOT NULL DEFAULT 0,	-- dragging is saved to pgroup:manorder(room=X)
	product			INTEGER NOT NULL DEFAULT 0,	-- dragging is saved to product:manorder(room=X)
	qnty			NUMERIC(7,2),
--	punit			INTEGER NOT NULL DEFAULT 0,

	comment			TEXT,
	
	PRIMARY KEY(id)
);

-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_puritem_update_date_updated
	BEFORE UPDATE ON shli_puritem FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();

-- \d shli_puritem;

insert into shli_puritem
	(id, room, purchase, pgroup, product, qnty, ident) values
	(1, 	1, 		1, 		2, 		1, 		2.5, 	'НашЧат АшанНГ Бакалея Гречка 2.5 (кг)'),
	(2, 	1, 		1, 		2,		2, 		4.1, 	'НашЧат АшанНГ Бакалея Манка 4.1 (кг)'),
	(3, 	1, 		1, 		3,		3, 		1, 		'НашЧат АшанНГ Выпечка Сочник 1 (шт)'),
	(4, 	1, 		1, 		4,		4, 		4, 		'НашЧат АшанНГ Молочка Йогурт 4 (шт)'),
	(5, 	1, 		1, 		4,		5, 		2, 		'НашЧат АшанНГ Молочка Кефир 2 (л)'),
	(6, 	1, 		1, 		4,		6, 		3, 		'НашЧат АшанНГ Молочка Сгущёнка 3 (шт)'),
	(7, 	1, 		1, 		4,		6, 		1, 		'НашЧат АшанНГ Молочка Сгущёнка 1 (шт)')
;


-- select * from shli_puritem;
