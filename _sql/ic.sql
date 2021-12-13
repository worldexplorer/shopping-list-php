--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_ic;
CREATE TABLE shli_ic (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',

	icwhose			INTEGER NOT NULL DEFAULT 0,
	icwhat			INTEGER NOT NULL DEFAULT 0,
	ictype			INTEGER NOT NULL DEFAULT 0,
	icdict			INTEGER NOT NULL DEFAULT 0,
	param1			VARCHAR(250) NOT NULL DEFAULT '',
	param2			VARCHAR(250) NOT NULL DEFAULT '',
	graycomment		VARCHAR(250) NOT NULL DEFAULT '',

	jsvalidator		INTEGER NOT NULL DEFAULT 0,
	obligatory		SMALLINT NOT NULL DEFAULT 0,
	obligatory_bo	SMALLINT NOT NULL DEFAULT 0,

	inbrief			SMALLINT NOT NULL DEFAULT 0,
	sorting			SMALLINT NOT NULL DEFAULT 0,

	published_bo	SMALLINT NOT NULL DEFAULT 1,

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

CREATE TRIGGER trg_shli_ic_update_date_updated
	BEFORE UPDATE ON shli_ic FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();

--\d shli_ic;

insert into shli_ic(id, manorder, icwhose, ictype, ident) values(1, 1, 1, 1, 'Размеры: см');
insert into shli_ic(id, manorder, icwhose, ictype, ident) values(2, 2, 1, 2, 'Масса: кг');
insert into shli_ic(id, manorder, icwhose, ictype, icdict, inbrief, sorting, ident) values(3, 3, 1, 4, 1, 1, 1, 'Упаковка:');
insert into shli_ic(id, manorder, icwhose, ictype, inbrief, sorting, ident) values(4, 4, 1, 2, 1, 1, 'Доставка: дней');
insert into shli_ic(id, manorder, icwhose, ictype, inbrief, sorting, ident) values(5, 5, 1, 2, 1, 1, 'На складе: шт');

--select * from shli_ic;

