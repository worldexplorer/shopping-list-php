--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_product CASCADE;
CREATE TABLE shli_product (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	pgroup			INTEGER,
	room			INTEGER NOT NULL,

	purchase_origin	INTEGER NOT NULL, -- purchase in the room that first used this product

	punit			INTEGER,
	weight			NUMERIC(7,2) NOT NULL DEFAULT 0,
	price_avg		NUMERIC(7,2) NOT NULL DEFAULT 0, -- avg price per unit / kg / liter

	PRIMARY KEY(id)
	,FOREIGN KEY ("pgroup") REFERENCES "shli_pgroup"(id)
	,FOREIGN KEY ("room") REFERENCES "shli_room"(id)
	,FOREIGN KEY ("purchase_origin") REFERENCES "shli_purchase"(id)
	,FOREIGN KEY ("punit") REFERENCES "shli_punit"(id)
);


-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_product_update_date_updated
	BEFORE UPDATE ON shli_product FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_product;

insert into shli_product
	(id, room, pgroup, purchase_origin, punit, ident) values
	(1, 1, 2, 1, 20, 'Гречка'),
	(2, 1, 2, 1, 20, 'Манка'),
	(3, 1, 3, 1, 1, 'Сочник'),
	(4, 1, 4, 1, 1, 'Йогурт'),
	(5, 1, 4, 1, 22, 'Кефир'),
	(6, 1, 4, 1, 22, 'Сгущёнка')
;

--select * from shli_product;
