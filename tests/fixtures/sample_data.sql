-- order type;
INSERT INTO `windsor_contracts`.`order_type` (`id`, `name`) VALUES (1, 'trial');
INSERT INTO `windsor_contracts`.`order_type` (`id`,`name`) VALUES (2, 'contract');

-- order stages;
INSERT INTO `windsor_contracts`.`order_stage` (`id`, `name`) VALUES (1,'created');
INSERT INTO `windsor_contracts`.`order_stage` (`id`, `name`) VALUES (2, 'approved');
INSERT INTO `windsor_contracts`.`order_stage` (`id`, `name`) VALUES (3, 'delivered');
INSERT INTO `windsor_contracts`.`order_stage` (`id`, `name`) VALUES (4, 'complete');
INSERT INTO `windsor_contracts`.`order_stage` (`id`, `name`) VALUES (5, 'signed');
INSERT INTO `windsor_contracts`.`order_stage` (`id`, `name`) VALUES (6, 'expired');

-- dummy client;
INSERT INTO `windsor_contracts`.`client` (`id`, `name`, `email`) VALUES (1, 'test', 'test@localhost');

-- order stages allowed for each order type;
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('1', '1');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('1', '2');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('1', '3');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('1', '4');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('2', '1');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('2', '2');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('2', '3');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('2', '4');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('2', '5');
INSERT INTO `windsor_contracts`.`allowed_stages_per_order_type` (`type`, `stage`) VALUES ('1', '6');
