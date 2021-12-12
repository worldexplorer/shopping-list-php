--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_jsvalidator;
CREATE TABLE shli_jsvalidator (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	content 		TEXT,

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

CREATE TRIGGER trg_shli_jsvalidator_update_date_updated
	BEFORE UPDATE ON shli_jsvalidator FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_jsvalidator;
--insert into shli_jsvalidator(id, ident) values(1, 'NONE');
INSERT INTO shli_jsvalidator (id, manorder, ident, hashkey, content) VALUES
	(1,2,'хотя бы один символ','JSV_TF_CHAR','/./'),
	(2,3,'одна цифра','JSV_TF_DIGIT','/^d$/'),
	(3,6,'слово из латинских букв','JSV_TF_ELETTERS','/[a-z]/i'),
	(4,8,'email [name@domain.com]','JSV_TF_EMAIL','/[a-z_0-9\.]+@[a-z_0-9\\.]+\.[a-z]{2,3}$/i'),
	(5,9,'короткий URL [domain@com]','JSV_TF_SHORTURL','/[a-z_0-9\.]+\.[a-z]{2,3}$/i'),
	(6,4,'число из одной или нескольких цифр','JSV_TF_DIGITS','/^d+$/'),
	(12,1,'без проверки','JSV_NONE',''),
	(7,7,'слово из русских букв','JSV_TF_RLETTERS','/[а-я]/i'),
	(8,5,'телефон','JSV_TF_PHONE','/./'),
	(9,10,'выбрано значение != 0','JSV_SELECT_SELECTED','/[1-9][0-9]*/'),
	(10,12,'выбран хоть один чекбокс из группы','JSV_MULTICHECKBOX_CHECKED',''),
	(11,11,'выбрано хоть одно значение из multi#select','JSV_MULTISELECT_SELECTED','позже');

--select * from shli_jsvalidator;
