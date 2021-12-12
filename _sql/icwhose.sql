--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_icwhose;
CREATE TABLE shli_icwhose (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',

	brief			TEXT,
	jsv_debug		BOOLEAN NOT NULL DEFAULT false,
	bo_only			BOOLEAN NOT NULL DEFAULT false,

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

CREATE TRIGGER trg_shli_icwhose_update_date_updated
	BEFORE UPDATE ON shli_icwhose FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();



--\d shli_icwhose;

insert into shli_icwhose (id, manorder, ident, hashkey) values (1, 1, 'Cвойства продуктов', 'PRODUCT_PROPERTIES');

--select * from shli_icwhose;
