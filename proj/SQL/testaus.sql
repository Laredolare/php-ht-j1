﻿SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `kayttaja` (`kayttaja_id`, `etunimi`, `sukunimi`, `hetu`, `puhnro`, `email`, `salasana`, `admin`) VALUES
(1, 'Testi', 'Valmentaja', '123456-1234', '04012345678', 'testi.valmentaja@sahkoposti.fi', '9627df7a4a5b849f67fce863e82adc71', 1);

INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(1, 'Antti', 'Jarvinen', '1989-02-01', 'Mies', '017 1231 239', 'antti.jarvinen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(2, 'Aarne', 'Korhonen', '1995-07-01', 'Mies', '020 9593 393', 'aarne.korhonen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(3, 'Kalle', 'Virtanen', '1999-03-15', 'Mies', '040 9513 473', 'kalle.virtanen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(4, 'Henna', 'Makinen', '1993-12-13', 'Nainen', '050 3273 698', 'henna.makinen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(5, 'Henri', 'Nieminen', '1997-11-17', 'Mies', '045 4802 275', 'henri.nieminen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(6, 'Kaija', 'Hamalainen', '1999-03-15', 'Nainen', '055 9172 393', 'kaija.hamalainen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(7, 'Pekka', 'Heikkinen', '1995-03-13', 'Mies', '050 9683 775', 'pekka.heikkinen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(8, 'Olli', 'Koskinen', '1990-09-05', 'Mies', '040 7821 453', 'olli.koskinen@esimerkki.fi');
INSERT INTO `PELAAJA` (`PELAAJA_ID`, `ETUNIMI`, `SUKUNIMI`, `SYNTYMAPAIVA`, `SUKUPUOLI`, `PUHNRO`, `EMAIL`) VALUES
(9, 'Oskari', 'Laine', '1994-03-12', 'Mies', '017 1233 123', 'oskari.laine@esimerkki.fi');

INSERT INTO `TESTIPATTERI` (`PATTERI_ID`, `PVM`, `NIMI`, `KAYTTAJA_ID`) VALUES
(1, '2014-02-05', '92-pojat', 1);
INSERT INTO `TESTIPATTERI` (`PATTERI_ID`, `PVM`, `NIMI`, `KAYTTAJA_ID`) VALUES
(2, '2014-02-11', '92-tytot', 1);

INSERT INTO `TESTI` (`TESTI_ID`, `NIMI`, `MITTAYKSIKKO`) VALUES
(1, 'Pallonheitto', 'metria');
INSERT INTO `TESTI` (`TESTI_ID`, `NIMI`, `MITTAYKSIKKO`) VALUES
(2, '100m juoksu', 'sekuntia');
INSERT INTO `TESTI` (`TESTI_ID`, `NIMI`, `MITTAYKSIKKO`) VALUES
(3, 'Vatsalihasliike', 'kpl/min');
INSERT INTO `TESTI` (`TESTI_ID`, `NIMI`, `MITTAYKSIKKO`) VALUES
(4, 'Punnerrukset', 'kpl/min');

INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(1, 2, 1, '80', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(1, 2, 2, '19,3', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(1, 2, 3, '41', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(1, 2, 4, '48', '2014-01-05');

INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(2, 6, 1, '45', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(1, 3, 2, '13,0', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(2, 4, 3, '41', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(1, 5, 4, '37', '2014-01-05');

INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(2, 4, 1, '28', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(2, 4, 2, '15,2', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(2, 6, 2, '14,8', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(2, 6, 3, '32', '2014-01-05');

INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(0, 7, 1, '27', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(0, 7, 2, '15,3', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(0, 7, 3, '35', '2014-01-05');
INSERT INTO `SUORITUS` (`PATTERI_ID`, `PELAAJA_ID`, `TESTI_ID`, `TULOS`, `PVM`) VALUES
(0, 7, 4, '28', '2014-01-05');