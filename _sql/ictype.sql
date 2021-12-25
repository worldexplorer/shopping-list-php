--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_ictype;
CREATE TABLE shli_ictype (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 0,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',

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

CREATE TRIGGER trg_shli_ictype_update_date_updated
	BEFORE UPDATE ON shli_ictype FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_ictype;
--insert into shli_ictype(id, ident) values(1, 'NONE');

INSERT INTO shli_ictype (id, manorder, ident, hashkey) VALUES
	(1,2,'текстовое поле','TEXTFIELD'),
	(2,3,'числовое поле','NUMBER'),
	(7,8,'дата и время','DATETIME'),
	(3,5,'чекбокс','CHECKBOX'),
	(4,11,'выбор из справочника','ICSELECT'),
	(5,6,'да / нет / не знаю','TRISTATE'),
	(6,7,'дата','DATE'),
	(8,9,'файл','UPLOAD'),
	(9,10,'картинка','ICIMAGE'),
	(11,13,'множественный выбор из справочника (multi#select)','ICMULTISELECT'),
	(10,1,'текстовая область','TEXTAREA'),
	(12,14,'множественный выбор из справочника (multicheckbox)','ICMULTICHECKBOX'),
	(13,15,'строка по шаблону','AHREF'),
	(14,12,'мягкий выбор из справочника (неопубликованные - серым)','SELECT'),
	(15,4,'цена с эталоным диапазоном','NUMBER_ETHALON'),
	(16,16,'радиобаттоны из справочника','ICRADIO'),
	(17,17,'сырой HTML','RAWHTML'),
	(18,18,'textarea WxH','TEXTAREA_SCROLL');



--select * from shli_ictype;

