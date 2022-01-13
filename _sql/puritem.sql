--\connect shli;
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_puritem;
CREATE TABLE shli_puritem (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE, -- date_purchased
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),
	ident			TEXT NOT NULL DEFAULT '',

	room			INTEGER NOT NULL,
	purchase		INTEGER NOT NULL,

	pgroup			INTEGER,	-- dragging is saved to pgroup:manorder(room=X)
	product			INTEGER,	-- dragging is saved to product:manorder(room=X)
	qnty			NUMERIC(7,2),
	--punit			INTEGER,

	bought			SMALLINT NOT NULL DEFAULT 0,
	bought_qnty		NUMERIC(7,2),
	bought_price	NUMERIC(7,2),
	bought_weight	NUMERIC(7,2),


	comment			TEXT,
	
	PRIMARY KEY(id)
	,FOREIGN KEY ("room") REFERENCES "shli_room"(id)
	,FOREIGN KEY ("purchase") REFERENCES "shli_purchase"(id)
	,FOREIGN KEY ("product") REFERENCES "shli_product"(id)
	,FOREIGN KEY ("pgroup") REFERENCES "shli_pgroup"(id)
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


ALTER SEQUENCE shli_puritem_id_seq RESTART WITH 8;

-- select * from shli_puritem;

-- alter table shli_puritem alter column ident TYPE TEXT

--ALTER TABLE "shli_puritem"
--	ALTER COLUMN "bought" TYPE BOOLEAN,show_serno

-- ERROR
-- ALTER TABLE "shli_puritem"
-- 	ALTER COLUMN "bought" TYPE SMALLINT,
-- 	ALTER COLUMN "bought" SET NOT NULL,
-- 	ALTER COLUMN "bought" SET DEFAULT 0;

alter table shli_puritem add column bought2 SMALLINT NOT NULL DEFAULT 0;
update shli_puritem set bought2=1 where bought=true;
update shli_puritem set bought2=2 where bought=NULL;
ALTER TABLE shli_puritem DROP COLUMN bought;
ALTER TABLE shli_puritem RENAME COLUMN bought2 TO bought;
