CREATE TABLE `Kayttaja` (
  `kayttaja_id` INTEGER NOT NULL AUTO_INCREMENT, 
  `etunimi` VARCHAR(255) NOT NULL, 
  `sukunimi` VARCHAR(255) NOT NULL, 
  `hetu` VARCHAR(255) NOT NULL,
  `puhnro` VARCHAR(255) NOT NULL, 
  `email` VARCHAR(255) NOT NULL,
  `salasana` VARCHAR(255) NOT NULL, 
  `admin` int(1) NOT NULL DEFAULT '0',
  UNIQUE (`hetu`),
  PRIMARY KEY (`kayttaja_id`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

CREATE TABLE `Pelaaja` (
  `pelaaja_id` INTEGER NOT NULL AUTO_INCREMENT, 
  `etunimi` VARCHAR(255) NOT NULL,
  `sukunimi` VARCHAR(255) NOT NULL,
  `syntymapaiva` DATE NOT NULL,
  `sukupuoli` VARCHAR(255) NOT NULL,
  `puhnro` VARCHAR(255) NOT NULL, 
  `email` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`pelaaja_id`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

CREATE TABLE `Suoritus` (
  `patteri_id` INTEGER NOT NULL AUTO_INCREMENT, 
  `pelaaja_id` INTEGER NOT NULL, 
  `testi_id` INTEGER NOT NULL, 
  `tulos` VARCHAR(255) NOT NULL,
  `pvm` DATE NOT NULL,
  INDEX (`patteri_id`), 
  INDEX (`pelaaja_id`), 
  INDEX (`testi_id`),
  PRIMARY KEY (`patteri_id`, `pelaaja_id`, `testi_id`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

CREATE TABLE `Testi` (
  `testi_id` INTEGER NOT NULL AUTO_INCREMENT, 
  `nimi` VARCHAR(255) NOT NULL, 
  `mittayksikko` VARCHAR(255) NOT NULL, 
  PRIMARY KEY (`testi_id`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;

CREATE TABLE `Testipatteri` (
  `patteri_id` INTEGER NOT NULL AUTO_INCREMENT, 
  `nimi` VARCHAR(255) NOT NULL,
  `pvm` DATETIME NOT NULL, 
  `kayttaja_id` INTEGER NOT NULL,
  PRIMARY KEY (`patteri_id`), 
  INDEX (`kayttaja_id`),
  UNIQUE (`patteri_id`)
) ENGINE=myisam DEFAULT CHARSET=utf8;

SET autocommit=1;