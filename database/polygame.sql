-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 15 ago, 2010 at 03:55 PM
-- Versione MySQL: 5.1.41
-- Versione PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `polygame`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `Game ID` int(11) NOT NULL AUTO_INCREMENT,
  `Organizer ID` varchar(40) NOT NULL,
  `Starting time` datetime NOT NULL,
  `Started` tinyint(1) NOT NULL DEFAULT '0',
  `Starting time Phase 2` datetime NOT NULL,
  `Started Phase 2` tinyint(1) NOT NULL DEFAULT '0',
  `Length 1a` int(11) NOT NULL,
  `Length 1b` int(11) NOT NULL,
  `Length 1c` int(11) NOT NULL,
  `Length 2` int(11) NOT NULL,
  PRIMARY KEY (`Game ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dump dei dati per la tabella `game`
--

INSERT INTO `game` (`Game ID`, `Organizer ID`, `Starting time`, `Started`, `Starting time Phase 2`, `Started Phase 2`, `Length 1a`, `Length 1b`, `Length 1c`, `Length 2`) VALUES
(82, 'tr', '2999-12-12 11:11:11', 0, '2999-12-12 11:11:11', 0, 1, 1, 1, 1),
(79, 'trive', '2999-12-12 11:11:11', 0, '2999-12-12 11:11:11', 0, 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `game players`
--

CREATE TABLE IF NOT EXISTS `game players` (
  `Game ID` int(11) NOT NULL,
  `Player ID` varchar(40) NOT NULL,
  `Associated Phases` enum('phaseOne','phaseTwo','allPhases') NOT NULL,
  PRIMARY KEY (`Game ID`,`Player ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `game players`
--

INSERT INTO `game players` (`Game ID`, `Player ID`, `Associated Phases`) VALUES
(82, 'mariuccio', 'allPhases'),
(82, 'pino', 'phaseOne');

-- --------------------------------------------------------

--
-- Struttura della tabella `game voters`
--

CREATE TABLE IF NOT EXISTS `game voters` (
  `Game ID` int(11) NOT NULL,
  `Voter ID` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `game voters`
--

INSERT INTO `game voters` (`Game ID`, `Voter ID`) VALUES
(82, 'voter');

-- --------------------------------------------------------

--
-- Struttura della tabella `game wedges`
--

CREATE TABLE IF NOT EXISTS `game wedges` (
  `Game ID` int(11) NOT NULL,
  `Wedge ID` int(11) NOT NULL,
  PRIMARY KEY (`Game ID`,`Wedge ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `game wedges`
--

INSERT INTO `game wedges` (`Game ID`, `Wedge ID`) VALUES
(82, 1),
(82, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `User ID` int(11) NOT NULL,
  `Group ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `groups`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
  `Game ID` int(11) NOT NULL,
  `Player ID` varchar(40) NOT NULL,
  `Wedge ID` int(11) NOT NULL,
  `Wedge Count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Game ID`,`Player ID`,`Wedge ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `plans`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `posters`
--

CREATE TABLE IF NOT EXISTS `posters` (
  `Player` varchar(40) NOT NULL,
  `Game ID` int(11) NOT NULL,
  `Wedge ID` int(11) NOT NULL,
  `Pros` text NOT NULL,
  `Cons` text NOT NULL,
  `Notes` text NOT NULL,
  PRIMARY KEY (`Player`,`Game ID`,`Wedge ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `posters`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('administrator','player','voter','organizer') CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`username`, `role`, `password`) VALUES
('mario', 'administrator', 'd6b861f58c7d4902ac3a5a15f85f3db50cc81b9e'),
('trive', 'organizer', 'd41aad011620b4804f1f2082f0741d4b4e03ac37'),
('organizer', 'organizer', 'b65951665f9a70dde41141a57721d88b19c1236e'),
('voter', 'voter', 'e1814e232a5b98b9b07523aee47512d5d435d035'),
('mariuccio', 'player', 'd6b861f58c7d4902ac3a5a15f85f3db50cc81b9e'),
('pino', 'player', '6d97bf2a6b714bca983dcd710313133ab2bf2ea0'),
('test', 'player', '26271470cf4a1c61fa93d99d126791d89928fd96'),
('tr', 'organizer', 'acba12ed4a6bc6599b72eeedca809a4237814b91'),
('prova', 'player', 'aa64584feac1278b97f6032abe2022bf9125e885'),
('nuovo', 'player', 'dbb13ffcf23b396b1fd029d7561be139d919bcc4'),
('nuovissimo', 'player', 'fdb673f12ef699b23429b26faa037d42c975f041'),
('martina', 'player', '7299a67470393cdcef9b365c0f4dba860e89e695'),
('sangria', 'player', '9bda53ac147a3c4625e58b484e5522313d63a571');

-- --------------------------------------------------------

--
-- Struttura della tabella `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `Voter` varchar(40) NOT NULL,
  `Game ID` int(11) NOT NULL,
  `Player` varchar(40) NOT NULL,
  PRIMARY KEY (`Voter`,`Game ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `votes`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `wedge players`
--

CREATE TABLE IF NOT EXISTS `wedge players` (
  `User ID` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Wedge ID` int(11) NOT NULL,
  `Game ID` int(11) NOT NULL,
  PRIMARY KEY (`User ID`,`Wedge ID`,`Game ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `wedge players`
--

INSERT INTO `wedge players` (`User ID`, `Wedge ID`, `Game ID`) VALUES
('mariuccio', 1, 82),
('pino', 2, 82);

-- --------------------------------------------------------

--
-- Struttura della tabella `wedges`
--

CREATE TABLE IF NOT EXISTS `wedges` (
  `Wedge ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Owner` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `Introduction` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Summary` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `History` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Present use` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `National situation` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Emission reduction` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `References` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Solution` float NOT NULL,
  `Error Tolerance` float NOT NULL,
  `Language` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Preferences` int(11) NOT NULL,
  `Image` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Wedge ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `wedges`
--

INSERT INTO `wedges` (`Wedge ID`, `Title`, `Owner`, `Introduction`, `Summary`, `History`, `Present use`, `National situation`, `Emission reduction`, `References`, `Solution`, `Error Tolerance`, `Language`, `Preferences`, `Image`) VALUES
(1, 'Bicycle', 'admin', 'A bicycle, whose basic parts are showed in figure (1), consists of two wheels attached to a frame; human power, utilized by pedalling a pair of pedals attached to the wheels, makes the bicycle move. Up to 99% of the energy spent by a cyclist in operating the pedals is successfully transferred to the wheels.\r\n<BR>\r\nBicycles have evolved over the years and have become more than just a means of transportation, but also a hobby or a sport. One major advantage of using bicycle is that it does not pollute the environment unlike motorized vehicles. Moreover riding bicycle provides good exercise allowing the mind to relax (The Bicycle, 2008).', 'A bicycle, whose basic parts are showed in figure (1), consists of two wheels attached to a frame; A bicycle, whose basic parts are showed in figure (1), consists of two wheels attached to a frame;', 'There are several early but unreliable claims for the invention of bicycle-like machines. The first documented is known as draisines, showed in figure (2), and it was invented by the German Baron Karl von Drais. It was introduced by Drais to the public in Mannheim in the summer of 1817: its rider sat astride a wooden frame supported by two in-line wheels and pushed the vehicle along with his/her feet. In the early 1860s Frenchmen Pierre Michaux and Pierre Lallement added a mechanical crank drive with pedals\r\n<BR>\r\non an enlarged front wheel. This design developed into the penny-farthing in 1870 (high-wheel bycicle), showed in figure (2): it featured a tubular steel frame on which were mounted wire spoked wheels with solid rubber tires. This bicycle was difficult to ride due to its very high seat and poor weight distribution, becoming very dangerous. So only young men could use it for sport (the macho bike), while women and elderly riders wanted to use bike for transport and they require more safety (the safe bike). The safety bicycle, showed in figure (2), emerged from a range of artefacts in 1880-1890: it had chain drive, wheels of equal size, air tyres, diamond frame and weight of the rider moved back over rear wheel (Pinch, 2009).', 'The use of bicycles (per capita distance travelled by bike) varies strongly between countries, as showed in figure (3).\r\nBicycle use depends on different factors (Rietveld and Daniel, 2004):\r\n<BR>\r\n1. Personal features such as income, age, gender and general activity patterns.\r\n<BR>\r\n2. Socio cultural factors: in some countries cycling is in the sphere of leisure activities and it is not considered only as a mode of transport.\r\n<BR>\r\n3. Generalized costs of cycling such as monetary cost, travel time, phys- ical needs, risk of injury, risk of theft, comfort and personal security.\r\n<BR>\r\n4. Generalized costs of other transport modes such as parking cots, tax on fuels, tolls, supply of public transport service.\r\n<BR>\r\nThe use of bicycle is also driven by the presence of adequate bicycle paths which make easier and safer riding bikes especially in cities with a lot of traffic. Bike-sharing could play an important role in enhancing the diffusion of bikes: it is very useful for short travels putting together the advantages of personal mobility, such as no timetable and the possibility to go everywhere, and of public transport, such as low prices and no parking problems.', 'As showed in figure (3) Italy is not the leader in the use of bicycle: only 154 km per person per year, much less than Denmark (936) and Netherland (848). The difference is due to several factors such as orography, climate, cultural tradition and infrastructure. First of all both Denmark and Nether- land are level countries while Italy has less plains and more mountains and hills: this discourages the use of bicycle. Second climate influences the use of bicycle: rain in the winter and very hot days in the summer are obstacles to a deep diffusion of bike’s use (but this does not discourage Danish and Dutch from cycling). Moreover only the habit of using bikes encourages this mode of transportation even in difficult conditions. Finally only if there are suitable bicycle paths, the use of bikes could considerably increase. For this reason the Italian bicycle paths grew from about 1000 km up to over 2400 km but it is lower than in other countries as showed in figure (4): in Helsinki there are 8.9 km of bicycle path per km2, only 0.2 in Rome and 0.5 in Milan.', 'We assume that one wedge corresponds to the reduction of 5 Mt/year (R) of CO2 emissions. The aim is to estimate by how much the distance travelled by bike needs to increase in Italy in order to meet one wedge reduction. We assume that people could avoid CO2 emissions using bikes instead of automobiles. From this idea and from the data in table (1) it is possible to compute the per capita distance travelled by bike needed for one wedge reduction and the corresponding percentage increase in Italy.', '[1] European	Environment	Agency.	Maps	and	graphs. http://dataservice.eea.europa.eu/atlas/, 2009.\r\n<BR>\r\n[2] The Bicycle. Bicycle history. http://www.thebicycle.org/, 2008.\r\n<BR>\r\n[3] T. Pinch. Users, consumers, or citizens? the role of users in shaping\r\ntechnology. ASP course “Innovation: why, and for whom?”, 2009.\r\n<BR>\r\n[4] P. Rietveld and V. Daniel. Determinants of bicycle use: do municipal\r\npolicies matter? Transportation Research Part A, 38:531–550, 2004.', 306, 10, 'en', 15, 'icons/bicycle.png'),
(2, 'Biomass', 'admin', 'Biomass is a generic organic material that stores sunlight energy in the form of chemical energy through the photosynthesis process. There are various types of biomass; we can simply divide them into: woody plants, herbaceous plants/grasses, aquatic plants, manures (McKendry, 2002a).\r\nTwo main processes are used to convert biomass into energy: thermo- chemical and bio-chemical/biological. Within thermo-chemical conversion four process options are available: combustion, pyrolysis, gasification and liquefaction. Bio-chemical conversion comprises two technologies: digestion (production of biogas, a mixture of mainly methane and carbon dioxide) and fermentation (production of ethanol). The choice of the conversion process depends on the type and quantity of biomass feedstock, the desired form of the energy, environmental standards, economic conditions and projects spe- cific factors. Figure (1) represents the different technologies of conversion related to feedstocks production and end-uses.\r\n<BR>\r\nHere we consider only the combustion of woody biomass in dedicated plants. Other conversion technologies are described in two wedges (ethanol in the fuel and high efficiency wood heating systems). Combustion process is feasible for biomasses preferable with a moisture content lower than 50%. Higher moisture requires pre-drying treatment or biological con- version processes. Combustion of biomass produces hot gases (800-1000°C) and the conversion efficiency is about 20-40% (McKendry, 2002b).', 'Biomass is a generic organic material that stores sunlight energy in the form of chemical energy thr', 'Since millennia man has exploited the energy stored in biomasses burn- ing them and eating plants for their nutritional content. Recently, much attention has been focused on identifying suitable biomass species, which can provide high-energy outputs, to replace conventional fossil fuel energy sources. There are other three main factors that have stimulated this inter- est in biomass (McKendry, 2002a):\r\n2\r\n<BR>\r\n1. Technological developments allow to convert biomass in ienergy at lower costs and with higher conversion efficiency.\r\n<BR>\r\n2. Food residues in the agricultural sector of developed countries which can be converted in energy and revitalizing rural communities creating jobs in developing countries.\r\n<BR>\r\n3. Greenhouse gas reduction potential contributes to mitigate climate change.', 'A fifth of the world energy demand is supplied by renewable resources: 13- 14% from biomass and 6% from hydro (Hall and Scrase, 1998). For people who live in developing countries (about three quarters of the world’s popu- lation) biomass is the most important source of energy, as showed in table (1). In the world’s poorest countries up to 90% of all energy is supplied by biomass. On the other hand Sweden and Finland detain the highest share of energy from biomass: 16% and 18%. For this reason biomass is often perceived as a low status fuel, associated with poverty; but this idea is con- trary to many forecasts which predict an expansion rather than a decline in global use of biomass energy in the next century (Hall and Scrase, 1998).\r\nThere is not an objective and shared idea about the advantages and disadvantages of biomass energy because the impacts of these technologies are site specific and also the development of modern biomass energy system is at a early stage. The most important factor that encourages the com- bustion of biomasses to produce energy is carbon neutrality: biomass emits roughly the same amount of CO2 during conversion as it is taken up dur- ing plant growth. However life-cycle assessments are needed to evaluate the net greenhouse gas emissions impact taking into account emissions related to biomass production, harvesting and transport. Moreover biomass is one of the most promising energy sources considered to be alternative to fossil fuels because it is a clean and renewable source of energy that produces less atmospheric pollutants. However biomass is a not refined fuel and its combustion produces a great amount of particulate matter.', 'Italian interest for biomass energy started in the 80s and a study by ENEA in 1984 counted 17 designed plants for a total power of 13.5 MWe. In the 1990s the biomass energy production increased from 116.1 GWh in 1995 up to 4531 GWh in 2008 (Terna, 2009). Today there are 27 plants (reported in table (2)) and national capacity is 257 MWe: they are scattered in the whole territory, but more concentrated in the North-West. The Italian pro- duction of biomasses is explained by ENEA in “Atlante Nazionale Biomasse” (ENEA, 2009).', 'We assume that one wedge corresponds to the reduction of 5 Mt/year (R) of CO2 emissions. The aim is to estimate how many plants need to be built to meet one wedge reduction in Italy. The assumed plant capacity is 1 MWel (c) and the assumed electrical efficiency of a wood fuelled biomass plant is 16% (d). From this hypotheses and from the data in table (3) it is possible to compute the number of plants that are needed in Italy in order to obtain one wedge reduction.', '[1] ENEA.	Atlante	nazionale	biomasse. http://atlantebiomasse.trisaia.enea.it/, 2009.\r\n<BR>\r\n[2] C. Gokcol and B. Dursun B. Alboyaci E. Sunan. Importance of biomass energy as alternative to other sources in Turkey. Energy Policy, 37:424– 431, 2009.\r\n<BR>\r\n[3] D. O. Hall and J. I. Scrase. Will biomass be the environmentally friendly fuel of the future? Biomass and Bioenergy, 15:357–367, 1998.\r\n<BR>\r\n[4] P. McKendry. Energy production from biomass (part 1): overview of biomass. Bioresource Technology, 83:37–46, 2002a.\r\n<BR>\r\n[5] P. McKendry. Energy production from biomass (part 1): conversion technologies. Bioresource Technology, 83:47–54, 2002b.\r\n<BR>\r\n[6] U.S.	Department	of	Energy.	Energy	effi- ciency	and	renewable	energy.	biomass	program. http://www1.eere.energy.gov/biomass/feedstocks types.html, 2009.\r\n<BR>\r\n[7] G. Riva. Impianti a biomassa di grandi dimensioni per la produzione di elettricit`a. http://www.agricoltura.regione.lombardia.it, 2004.\r\n<BR>\r\n[8] Terna. Dati statistici: Produzione. http://www.terna.it/, 2009.', 494, 1, 'en', 12, 'icons/biomass.png'),
(3, 'Nuclear Power', 'admin', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. \r\n\r\nA small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. \r\n\r\nA small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. \r\n\r\nA small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. \r\n\r\nA small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. \r\n\r\nA small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.', 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. \r\n\r\nA small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.', 401, 0, 'en', 2, 'icons/nuclear plants.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
