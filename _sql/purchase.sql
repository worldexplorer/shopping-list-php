--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_purchase CASCADE;
CREATE TABLE shli_purchase (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE, -- date_purchased
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	comment_above	TEXT,
	comment_below	TEXT,

	room			INTEGER NOT NULL,
	message			INTEGER NOT NULL,

	show_pgroup		BOOLEAN NOT NULL DEFAULT false,
	show_serno		BOOLEAN NOT NULL DEFAULT false,
	show_qnty		BOOLEAN NOT NULL DEFAULT false,
	show_price		BOOLEAN NOT NULL DEFAULT false,
	show_weight		BOOLEAN NOT NULL DEFAULT false,

	show_state_unknown	BOOLEAN NOT NULL DEFAULT false,
	show_state_stop		BOOLEAN NOT NULL DEFAULT false,

	copiedfrom_id		INTEGER,

	person_created		INTEGER NOT NULL,
	persons_can_edit	INTEGER[],
	persons_can_fill	INTEGER[],

	purchased			BOOLEAN NOT NULL DEFAULT false,
	person_purchased	INTEGER,

	price_total			NUMERIC(7,2),
	weight_total		NUMERIC(7,2),


	PRIMARY KEY(id)
	,FOREIGN KEY ("person_created") REFERENCES "shli_person"(id)
	,FOREIGN KEY ("person_purchased") REFERENCES "shli_person"(id)
	,FOREIGN KEY ("room") REFERENCES "shli_room"(id)
	-- 1) create without this FK: \i purchase.sql,
	-- 2) create messages: \i message.sql
	-- 3) re-create purchase WITH this FK: \i purchase.sql
	-- 4) prisma db pull; prisma generate; prisma format
	,FOREIGN KEY ("message") REFERENCES "shli_message"(id)
);



-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_purchase_update_date_updated
	BEFORE UPDATE ON shli_purchase FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_purchase;

insert into shli_purchase
	(id, room, message, show_pgroup, show_price, person_created, 	ident, persons_can_edit, persons_can_fill) values
	(1, 	1, 	2, 		true, 			true, 		1, 				'Фуд Сити',		'{1,2}',		'{1,2}')
;

ALTER SEQUENCE shli_purchase_id_seq RESTART WITH 2;

--select * from shli_purchase;

-- alter table shli_purchase add column show_serno BOOLEAN NOT NULL DEFAULT false;
-- alter table shli_purchase add column show_state_unknown	BOOLEAN NOT NULL DEFAULT false;


-- ALTER TABLE "shli_purchase"
-- 	RENAME COLUMN "show_threestate" TO "show_state_unknown";
-- ALTER TABLE "shli_purchase"
-- 	ALTER COLUMN "show_state_unknown" TYPE BOOLEAN,
-- 	ALTER COLUMN "show_state_unknown" SET NOT NULL,
-- 	ALTER COLUMN "show_state_unknown" SET DEFAULT 'false';
-- ALTER TABLE "shli_purchase"
-- 	ADD "show_state_stop" BOOLEAN NOT NULL DEFAULT 'false';
