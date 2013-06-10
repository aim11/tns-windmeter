-- -----------------------------------------------------
-- Data for table `weather_station`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `weather_station` (`id`, `description`, `loc_name`, `loc_coordinates`) VALUES (1, 'Tuulimittari sijaitsee aallonmurtajalla olevan tolpan nokassa', 'Hawaii', '65.032669,25.407122');
INSERT INTO `weather_station` (`id`, `description`, `loc_name`, `loc_coordinates`) VALUES (2, 'Vessojen katolla oleva tuulimittari', 'Lauttaranta', '65.038393,25.062039');
INSERT INTO `weather_station` (`id`, `description`, `loc_name`, `loc_coordinates`) VALUES (3, 'Saunarakennuksessa oleva tuulimittari', 'Varessäikkä', '64.889935,24.809872');
INSERT INTO `weather_station` (`id`, `description`, `loc_name`, `loc_coordinates`) VALUES (4, 'Koppanan mittari', 'Koppana', '64.968103,25.201986');

COMMIT;

-- -----------------------------------------------------
-- Data for table `measurement_wind`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (1, 1, 6.5, 9.8, 275, '2013-06-07 14:42:20');
INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (2, 1, 5.5, 9.6, 278, '2013-06-07 14:43:20');
INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (9, 2, 7.5, 8.6, 180, '2013-06-07 14:43:20');
INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (10, 2, 7.1, 8.4, 180, '2013-06-07 14:42:20');
INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (11, 3, 3.2, 6.5, 90, '2013-06-07 14:42:20');
INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (12, 3, 2.5, 5.5, 85, '2013-06-07 14:43:20');
INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (13, 4, 9.8, 10.5, 110, '2013-06-07 14:42:20');
INSERT INTO `measurement_wind` (`id`, `station_id`, `speed`, `gust`, `direction`, `measurement_time`) VALUES (14, 4, 10.1, 11.6, 125, '2013-06-07 14:43:20');

COMMIT;
