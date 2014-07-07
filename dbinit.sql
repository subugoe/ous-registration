# create database anmeldung;

USE anmeldung;

CREATE TABLE `address_types` (
  `id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lang` varchar(4) default NULL
) ;



INSERT INTO `address_types` VALUES (1, 'Semesteranschrift', 'de');
INSERT INTO `address_types` VALUES (2, 'Institutsanschrift', 'de');
INSERT INTO `address_types` VALUES (3, 'Dienstanschrift', 'de');
INSERT INTO `address_types` VALUES (4, 'Privatanschrift', 'de');
INSERT INTO `address_types` VALUES (5, 'Erster Wohnsitz', 'de');
INSERT INTO `address_types` VALUES (6, 'Weiterer Wohnsitz', 'de');
INSERT INTO `address_types` VALUES (1, 'Semester Address', 'en');
INSERT INTO `address_types` VALUES (2, 'Institute Address', 'en');
INSERT INTO `address_types` VALUES (3, 'Address at Work', 'en');
INSERT INTO `address_types` VALUES (4, 'Private Address', 'en');
INSERT INTO `address_types` VALUES (5, 'First Address', 'en');
INSERT INTO `address_types` VALUES (6, 'Second Address', 'en');
INSERT INTO `address_types` VALUES (7, 'Home Address', 'en');
INSERT INTO `address_types` VALUES (7, 'Heimatanschrift', 'de');



CREATE TABLE `addresses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `person_id` bigint(20) unsigned NOT NULL default '0',
  `carry_over` varchar(64) default NULL,
  `street` varchar(45) NOT NULL default '',
  `house` varchar(6) NOT NULL default '',
  `room` varchar(10) default NULL,
  `zip` varchar(15) NOT NULL default '',
  `town` varchar(64) NOT NULL default '',
  `phone` varchar(20) default NULL,
  `mobile_phone` varchar(20) default NULL,
  `is_primary` enum('true','false') NOT NULL default 'true',
  PRIMARY KEY  (`id`)
) ;



CREATE TABLE `id_offsets` (
  `year` char(2) NOT NULL default '',
  `offset` bigint(20) unsigned default NULL
) ;




CREATE TABLE `persons` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `last_name` varchar(64) NOT NULL default '',
  `first_name` varchar(15) NOT NULL default '',
  `title` varchar(32) default NULL,
  `sex` enum('m','w') NOT NULL default 'm',
  `birthday` date NOT NULL default '0000-00-00',
  `usertype_id` int(10) unsigned NOT NULL default '0',
  `email_checkbox` enum('f','t') NOT NULL default 'f',
  `email` varchar(64) default NULL,
  `email_confirm` varchar(64) default NULL,
  `student_id` varchar(15) default NULL,
  `status` enum('old','new') NOT NULL default 'old',
  `pica_id` varchar(15) default NULL,
  `pica_barcode` varchar(12) default NULL,
  `entry_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ;





CREATE TABLE `serial_number` (
  `time` date default NULL,
  `number` bigint(20) default NULL
) ;

INSERT INTO `serial_number` VALUES (CURDATE(),0);



CREATE TABLE `usertype_names` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `usertype_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `type` enum('m','w','u','short') default NULL,
  `lang` varchar(4) default NULL,
  PRIMARY KEY  (`id`)
) ;



INSERT INTO `usertype_names` VALUES (1, 1, 'Student an der TU BS', 'm', 'de');
INSERT INTO `usertype_names` VALUES (2, 1, 'Studentin an der TU BS', 'w', 'de');
INSERT INTO `usertype_names` VALUES (3, 1, 'Student/in an der TU BS', 'u', 'de');
INSERT INTO `usertype_names` VALUES (4, 1, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (5, 1, 'Student at TU BS', 'm', 'en');
INSERT INTO `usertype_names` VALUES (6, 1, 'Student at TU BS', 'w', 'en');
INSERT INTO `usertype_names` VALUES (7, 1, 'Student at TU BS', 'u', 'en');
INSERT INTO `usertype_names` VALUES (8, 1, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (9, 2, 'Student an der FH BS/WF', 'm', 'de');
INSERT INTO `usertype_names` VALUES (10, 2, 'Studentin an der FH BS/WF', 'w', 'de');
INSERT INTO `usertype_names` VALUES (11, 2, 'Student/in an der FH BS/WF', 'u', 'de');
INSERT INTO `usertype_names` VALUES (12, 2, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (13, 2, 'Student at FH BS/WF', 'm', 'en');
INSERT INTO `usertype_names` VALUES (14, 2, 'Student at FH BS/WF', 'w', 'en');
INSERT INTO `usertype_names` VALUES (15, 2, 'Student at FH BS/WF', 'u', 'en');
INSERT INTO `usertype_names` VALUES (16, 2, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (17, 3, 'Student an der HBK', 'm', 'de');
INSERT INTO `usertype_names` VALUES (18, 3, 'Studentin an der HBK', 'w', 'de');
INSERT INTO `usertype_names` VALUES (19, 3, 'Student/in an der HBK', 'u', 'de');
INSERT INTO `usertype_names` VALUES (20, 3, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (21, 3, 'Student at HBK', 'm', 'en');
INSERT INTO `usertype_names` VALUES (22, 3, 'Student at HBK', 'w', 'en');
INSERT INTO `usertype_names` VALUES (23, 3, 'Student at HBK', 'u', 'en');
INSERT INTO `usertype_names` VALUES (24, 3, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (25, 4, 'Prof. / Wiss. Mitarbeiter an der TU BS', 'm', 'de');
INSERT INTO `usertype_names` VALUES (26, 4, 'Prof. / Wiss. Mitarbeiterin an der TU BS', 'w', 'de');
INSERT INTO `usertype_names` VALUES (27, 4, 'Prof. / Wiss. Mitarbeiter/in an der TU BS', 'u', 'de');
INSERT INTO `usertype_names` VALUES (28, 4, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (29, 4, 'Member of the Faculty of TU BS', 'm', 'en');
INSERT INTO `usertype_names` VALUES (30, 4, 'Member of the Faculty of TU BS', 'w', 'en');
INSERT INTO `usertype_names` VALUES (31, 4, 'Member of the Faculty of TU BS', 'u', 'en');
INSERT INTO `usertype_names` VALUES (32, 4, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (33, 5, 'Gastwissenschaftler an der TU BS', 'm', 'de');
INSERT INTO `usertype_names` VALUES (34, 5, 'Gastwissenschaftlerin an der TU BS', 'w', 'de');
INSERT INTO `usertype_names` VALUES (35, 5, 'Gastwissenschaftler/in an der TU BS', 'u', 'de');
INSERT INTO `usertype_names` VALUES (36, 5, 'GAST', 'short', 'de');
INSERT INTO `usertype_names` VALUES (37, 5, 'Visiting scholar/scientist at TU BS', 'm', 'en');
INSERT INTO `usertype_names` VALUES (38, 5, 'Visiting scholar/scientist at TU BS', 'w', 'en');
INSERT INTO `usertype_names` VALUES (39, 5, 'Visiting scholar/scientist at TU BS', 'u', 'en');
INSERT INTO `usertype_names` VALUES (40, 5, 'GAST', 'short', 'en');
INSERT INTO `usertype_names` VALUES (41, 6, 'TU-Mitarbeiter aus Technik und Verwaltung', 'm', 'de');
INSERT INTO `usertype_names` VALUES (42, 6, 'TU-Mitarbeiterin aus Technik und Verwaltung', 'w', 'de');
INSERT INTO `usertype_names` VALUES (43, 6, 'TU-Mitarbeiter/in aus Technik und Verwaltung', 'u', 'de');
INSERT INTO `usertype_names` VALUES (44, 6, 'Member of technical/administrative staff of TU BS', 'm', 'en');
INSERT INTO `usertype_names` VALUES (45, 6, 'Member of technical/administrative staff of TU BS', 'w', 'en');
INSERT INTO `usertype_names` VALUES (46, 6, 'Member of technical/administrative staff of TU BS', 'u', 'en');
INSERT INTO `usertype_names` VALUES (47, 14, 'Mitarbeiter an der FH BS/WF', 'm', 'de');
INSERT INTO `usertype_names` VALUES (48, 14, 'Mitarbeiterin an der FH BS/WF', 'w', 'de');
INSERT INTO `usertype_names` VALUES (49, 14, 'Mitarbeiter/in an der FH BS/WF', 'u', 'de');
INSERT INTO `usertype_names` VALUES (50, 14, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (51, 14, 'Staff at FH BS/WF', 'm', 'en');
INSERT INTO `usertype_names` VALUES (52, 14, 'Staff at FH BS/WF', 'w', 'en');
INSERT INTO `usertype_names` VALUES (53, 14, 'Staff at FH BS/WF', 'u', 'en');
INSERT INTO `usertype_names` VALUES (54, 14, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (55, 15, 'Mitarbeiter an der HBK', 'm', 'de');
INSERT INTO `usertype_names` VALUES (56, 15, 'Mitarbeiterin an der HBK', 'w', 'de');
INSERT INTO `usertype_names` VALUES (57, 15, 'Mitarbeiter/in an der HBK', 'u', 'de');
INSERT INTO `usertype_names` VALUES (58, 15, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (59, 15, 'Staff at HBK', 'm', 'en');
INSERT INTO `usertype_names` VALUES (60, 15, 'Staff at HBK', 'w', 'en');
INSERT INTO `usertype_names` VALUES (61, 15, 'Staff at HBK', 'u', 'en');
INSERT INTO `usertype_names` VALUES (62, 15, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (63, 6, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (64, 7, 'Mitarbeiter des JKI', 'm', 'de');
INSERT INTO `usertype_names` VALUES (65, 7, 'Mitarbeiterin des JKI', 'w', 'de');
INSERT INTO `usertype_names` VALUES (66, 7, 'Mitarbeiter/in des JKI', 'u', 'de');
INSERT INTO `usertype_names` VALUES (67, 7, 'JKI', 'short', 'de');
INSERT INTO `usertype_names` VALUES (68, 7, 'JKI staff member', 'm', 'en');
INSERT INTO `usertype_names` VALUES (69, 7, 'JKI staff member', 'w', 'en');
INSERT INTO `usertype_names` VALUES (70, 7, 'JKI staff member', 'u', 'en');
INSERT INTO `usertype_names` VALUES (71, 7, 'JKI', 'short', 'en');
INSERT INTO `usertype_names` VALUES (72, 9, 'Mitarbeiter der DLR', 'm', 'de');
INSERT INTO `usertype_names` VALUES (73, 9, 'Mitarbeiterin der DLR', 'w', 'de');
INSERT INTO `usertype_names` VALUES (74, 9, 'Mitarbeiter/in der DLR', 'u', 'de');
INSERT INTO `usertype_names` VALUES (75, 9, 'DLR', 'short', 'de');
INSERT INTO `usertype_names` VALUES (76, 9, 'DLR staff member', 'm', 'en');
INSERT INTO `usertype_names` VALUES (77, 9, 'DLR staff member', 'w', 'en');
INSERT INTO `usertype_names` VALUES (78, 9, 'DLR staff member', 'u', 'en');
INSERT INTO `usertype_names` VALUES (79, 9, 'DLR', 'short', 'en');
INSERT INTO `usertype_names` VALUES (80, 10, 'Mitarbeiter des vTI oder FLI', 'm', 'de');
INSERT INTO `usertype_names` VALUES (81, 10, 'Mitarbeiterin des vTI oder FLI', 'w', 'de');
INSERT INTO `usertype_names` VALUES (82, 10, 'Mitarbeiter/in des vTI oder FLI', 'u', 'de');
INSERT INTO `usertype_names` VALUES (83, 10, 'vTI oder FLI', 'short', 'de');
INSERT INTO `usertype_names` VALUES (84, 10, 'vTI or FLI staff member', 'm', 'en');
INSERT INTO `usertype_names` VALUES (85, 10, 'vTI or FLI staff member', 'w', 'en');
INSERT INTO `usertype_names` VALUES (86, 10, 'vTI or FLI staff member', 'u', 'en');
INSERT INTO `usertype_names` VALUES (87, 10, 'vTI or FLI', 'short', 'en');
INSERT INTO `usertype_names` VALUES (88, 11, 'Mitarbeiter des HZI', 'm', 'de');
INSERT INTO `usertype_names` VALUES (89, 11, 'Mitarbeiterin des HZI', 'w', 'de');
INSERT INTO `usertype_names` VALUES (90, 11, 'Mitarbeiter/in des HZI', 'u', 'de');
INSERT INTO `usertype_names` VALUES (91, 11, 'HZI', 'short', 'de');
INSERT INTO `usertype_names` VALUES (92, 11, 'HZI staff member', 'm', 'en');
INSERT INTO `usertype_names` VALUES (93, 11, 'HZI staff member', 'w', 'en');
INSERT INTO `usertype_names` VALUES (94, 11, 'HZI staff member', 'u', 'en');
INSERT INTO `usertype_names` VALUES (95, 11, 'HZI', 'short', 'en');
INSERT INTO `usertype_names` VALUES (96, 12, 'Mitarbeiter der PTB', 'm', 'de');
INSERT INTO `usertype_names` VALUES (97, 12, 'Mitarbeiterin der PTB', 'w', 'de');
INSERT INTO `usertype_names` VALUES (98, 12, 'Mitarbeiter/in der PTB', 'u', 'de');
INSERT INTO `usertype_names` VALUES (99, 12, 'PTB', 'short', 'de');
INSERT INTO `usertype_names` VALUES (100, 12, 'PTB staff member', 'm', 'en');
INSERT INTO `usertype_names` VALUES (101, 12, 'PTB staff member', 'w', 'en');
INSERT INTO `usertype_names` VALUES (102, 12, 'PTB staff member', 'u', 'en');
INSERT INTO `usertype_names` VALUES (103, 12, 'PTB', 'short', 'en');
INSERT INTO `usertype_names` VALUES (104, 13, 'Sonstiger Nutzer', 'm', 'de');
INSERT INTO `usertype_names` VALUES (105, 13, 'Sonstige Nutzerin', 'w', 'de');
INSERT INTO `usertype_names` VALUES (106, 13, 'Sonstige/r Nutzer/in', 'u', 'de');
INSERT INTO `usertype_names` VALUES (107, 13, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (108, 13, 'Other', 'm', 'en');
INSERT INTO `usertype_names` VALUES (109, 13, 'Other', 'w', 'en');
INSERT INTO `usertype_names` VALUES (110, 13, 'Other', 'u', 'en');
INSERT INTO `usertype_names` VALUES (111, 13, '', 'short', 'en');
INSERT INTO `usertype_names` VALUES (112, 21, 'Student an der TU BS E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (113, 21, 'Studentin an der TU BS E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (114, 21, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (115, 22, 'Student an der FH BS/WF E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (116, 22, 'Studentin an der FH BS/WF E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (117, 22, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (118, 23, 'Student an der HBK E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (119, 23, 'Studentin an der HBK E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (120, 23, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (121, 24, 'Prof. / Wiss. Mitarbeiter an der TU BS E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (122, 24, 'Prof. / Wiss. Mitarbeiter an der TU BS E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (123, 24, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (124, 25, 'Gastwissenschaftler an der TU BS E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (125, 25, 'Gastwissenschaftlerin an der TU BS E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (126, 25, 'GAST', 'short', 'de');
INSERT INTO `usertype_names` VALUES (127, 26, 'TU-Mitarbeiter aus Technik und Verwaltung E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (128, 26, 'TU-Mitarbeiterin aus Technik und Verwaltung E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (129, 34, 'Mitarbeiter an der FH BS/WF E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (130, 34, 'Mitarbeiterin an der FH BS/WF E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (131, 34, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (132, 35, 'Mitarbeiter an der HBK E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (133, 35, 'Mitarbeiterin an der HBK E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (134, 35, '', 'short', 'de');
INSERT INTO `usertype_names` VALUES (135, 27, 'Mitarbeiter an der BBA E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (136, 27, 'Mitarbeiterin an der BBA E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (137, 27, 'BBA', 'short', 'de');
INSERT INTO `usertype_names` VALUES (138, 29, 'Mitarbeiter an der DLR E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (139, 29, 'Mitarbeiterin an der DLR E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (140, 29, 'DLR', 'short', 'de');
INSERT INTO `usertype_names` VALUES (141, 30, 'Mitarbeiter an der FAL E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (142, 30, 'Mitarbeiterin an der FAL E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (143, 30, 'FAL', 'short', 'de');
INSERT INTO `usertype_names` VALUES (144, 31, 'Mitarbeiter an der HZI E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (145, 31, 'Mitarbeiterin an der HZI E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (146, 31, 'HZI', 'short', 'de');
INSERT INTO `usertype_names` VALUES (147, 32, 'Mitarbeiter an der PTB E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (148, 32, 'Mitarbeiterin an der PTB E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (149, 32, 'PTB', 'short', 'de');
INSERT INTO `usertype_names` VALUES (150, 33, 'Sonstige Nutzer E-Mail', 'm', 'de');
INSERT INTO `usertype_names` VALUES (151, 33, 'Sonstige Nutzerin E-Mail', 'w', 'de');
INSERT INTO `usertype_names` VALUES (152, 33, '', 'short', 'de');



CREATE TABLE `usertypes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pica_user_group` int(10) unsigned NOT NULL default '0',
  `primary_address_type` int(10) unsigned NOT NULL default '0',
  `secondary_address_type` int(10) unsigned NOT NULL default '0',
  `expire_after` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ;



INSERT INTO `usertypes` VALUES (1, 2, 1, 7, 365);
INSERT INTO `usertypes` VALUES (2, 11, 1, 7, 365);
INSERT INTO `usertypes` VALUES (3, 10, 1, 7, 365);
INSERT INTO `usertypes` VALUES (4, 3, 2, 4, 1095);
INSERT INTO `usertypes` VALUES (5, 3, 2, 4, 365);
INSERT INTO `usertypes` VALUES (6, 7, 3, 4, 365);
INSERT INTO `usertypes` VALUES (7, 1, 5, 6, 365);
INSERT INTO `usertypes` VALUES (9, 1, 5, 6, 365);
INSERT INTO `usertypes` VALUES (10, 1, 5, 6, 365);
INSERT INTO `usertypes` VALUES (11, 1, 5, 6, 365);
INSERT INTO `usertypes` VALUES (12, 1, 5, 6, 365);
INSERT INTO `usertypes` VALUES (13, 1, 5, 6, 365);
INSERT INTO `usertypes` VALUES (14, 11, 1, 7, 365);
INSERT INTO `usertypes` VALUES (15, 10, 1, 7, 365);
INSERT INTO `usertypes` VALUES (21, 22, 1, 7, 365);
INSERT INTO `usertypes` VALUES (22, 31, 1, 7, 365);
INSERT INTO `usertypes` VALUES (35, 30, 1, 7, 365);
INSERT INTO `usertypes` VALUES (24, 23, 2, 4, 1095);
INSERT INTO `usertypes` VALUES (25, 23, 2, 4, 365);
INSERT INTO `usertypes` VALUES (26, 27, 3, 4, 365);
INSERT INTO `usertypes` VALUES (27, 21, 5, 6, 365);
INSERT INTO `usertypes` VALUES (29, 21, 5, 6, 365);
INSERT INTO `usertypes` VALUES (30, 21, 5, 6, 365);
INSERT INTO `usertypes` VALUES (31, 21, 5, 6, 365);
INSERT INTO `usertypes` VALUES (33, 21, 5, 6, 365);
INSERT INTO `usertypes` VALUES (32, 21, 5, 6, 365);
INSERT INTO `usertypes` VALUES (34, 31, 1, 7, 365);
INSERT INTO `usertypes` VALUES (23, 30, 1, 7, 365);
