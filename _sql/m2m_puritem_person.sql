--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_m2m_puritem_person;
CREATE TABLE shli_m2m_puritem_person (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),
	ident			VARCHAR(250) DEFAULT '',

	puritem			INTEGER NOT NULL DEFAULT 0,
	room			INTEGER NOT NULL DEFAULT 0, -- deduplication from puritem table
	purchase		INTEGER NOT NULL DEFAULT 0, -- deduplication from puritem table

	person_bought	INTEGER NOT NULL DEFAULT 0,

	-- I bough 2 kg of potatoes
	product			INTEGER NOT NULL DEFAULT 0,
	price			NUMERIC(7,2),
	qnty			NUMERIC(7,2),

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

CREATE TRIGGER trg_shli_m2m_puritem_person_update_date_updated
	BEFORE UPDATE ON shli_m2m_puritem_person FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_m2m_puritem_person;

insert into shli_m2m_puritem_person
	(id, puritem, room, purchase, person_bought, product, price, qnty, ident) values
	(1, 	1, 		1, 		1, 		1, 				1, 		65.22,	2.5, 	'НашЧат АшанНГ Бакалея Гречка 2.5 (кг)'),
	(2, 	2, 		1, 		1, 		1, 				2, 		90,		4.1, 	'НашЧат АшанНГ Бакалея Манка 4.1 (кг)'),
	(3, 	3, 		1, 		1, 		1, 				3, 		129, 	1, 		'НашЧат АшанНГ Выпечка Сочник 1 (шт)'),
	(4, 	4, 		1, 		1, 		1, 				4, 		0, 		0, 		'НашЧат АшанНГ Молочка Йогурт 0 (шт)'),
	(5, 	5, 		1, 		1, 		1, 				5, 		116.3,	2, 		'НашЧат АшанНГ Молочка Кефир 2 (л)'),
	(6, 	6, 		1, 		1, 		1, 				6, 		105,	3, 		'НашЧат АшанНГ Молочка Сгущёнка 3 (шт)')
;

--select * from shli_m2m_puritem_person;
