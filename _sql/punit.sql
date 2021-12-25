--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_punit CASCADE;
CREATE TABLE shli_punit (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',
	brief			VARCHAR(250) NOT NULL DEFAULT '',
	fpoint			SMALLINT NOT NULL DEFAULT 0,

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

CREATE TRIGGER trg_shli_punit_update_date_updated
	BEFORE UPDATE ON shli_punit FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_punit;

insert into shli_punit
	(id, fpoint, ident, brief) values
	(1, 0, 'Штука', 'шт'),
	(2, 0, 'Упаковка', 'уп'),
	(3, 0, 'Коробка', 'кор'),
	(4, 0, 'Банка', 'бан'),
	(5, 0, 'Пачка', 'пач'),

	(20, 1, 'Килограмм', 'кг'),
	(21, 1, 'Грамм', 'г'),
	(22, 1, 'Литр', 'л'),
	(23, 1, 'Метр', 'м'),
	(24, 1, 'Миллиметр', 'см')
;

ALTER SEQUENCE shli_punit_id_seq RESTART WITH 30;

--select * from shli_punit;
