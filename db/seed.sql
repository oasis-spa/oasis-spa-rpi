INSERT INTO `config` (`id`, `version`, `raspberry_type`, `token`, `api`, `set_temp`, `set_temp_dev`, `save_temp`, `heater_control`, `heater_relay`, `heater_sensor`, `overheat_control`, `overheat_sensor`, `overheat_temp`, `pump_control`, `pump_relay`, `frost_protection`, `frost_temp`, `frost_sensor`, `cleaning_mode`, `left_column`, `mid_column`, `right_column`, `used_power_date`, `tablet_view`, `ip_check`, `ip_range`, `push_token`, `push_key`) VALUES
(1, '1.20', 'Model 3b', 'Gdw34^%FHYDe', 1, '98', '4', 1, 1, 22, 2, 1, 2, '105', 1, 21, 0, '37', 4, 0, 8, '28FFB1A88317041A', 22, '2018-03-06', 1, 1, '192.168.x.x', '', '');

INSERT INTO `users` (`id`, `username`, `password`, `email`, `ip`, `rank`) VALUES
(9, 'admin', 'b89749505e144b564adfe3ea8fc394aa', '', '', 2);