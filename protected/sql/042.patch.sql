﻿ALTER TABLE `spi_project` ADD COLUMN `is_manual` TINYINT(1) DEFAULT 0 NOT NULL AFTER `is_old`; 
ALTER TABLE `spi_project` ADD COLUMN `real_code` VARCHAR(5) AFTER `is_manual`;
UPDATE `spi_project` SET `real_code` = 'y' WHERE `id` = '34'; 
UPDATE `spi_project` SET `real_code` = 'y' WHERE `id` = '36'; 
UPDATE `spi_project` SET `real_code` = 'y' WHERE `id` = '37'; 
UPDATE `spi_project` SET `real_code` = 'g' WHERE `id` = '38'; 
UPDATE `spi_project` SET `real_code` = 'g' WHERE `id` = '39'; 
UPDATE `spi_project` SET `real_code` = 'b' WHERE `id` = '40'; 
UPDATE `spi_project` SET `real_code` = 'y' WHERE `id` = '41'; 
UPDATE `spi_project` SET `real_code` = 'y' WHERE `id` = '42'; 
UPDATE `spi_project` SET `real_code` = 'g' WHERE `id` = '44'; 
UPDATE `spi_project` SET `real_code` = 'y' WHERE `id` = '45'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '46'; 
UPDATE `spi_project` SET `real_code` = 'z' WHERE `id` = '48'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '52'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '54'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '55'; 
UPDATE `spi_project` SET `real_code` = 'k' WHERE `id` = '56'; 
UPDATE `spi_project` SET `real_code` = 'k' WHERE `id` = '57'; 
UPDATE `spi_project` SET `real_code` = 'y' WHERE `id` = '58'; 
UPDATE `spi_project` SET `real_code` = 'k' WHERE `id` = '60'; 
UPDATE `spi_project` SET `real_code` = 'z' WHERE `id` = '61'; 
UPDATE `spi_project` SET `real_code` = 'g' WHERE `id` = '62'; 
UPDATE `spi_project` SET `real_code` = 'g' WHERE `id` = '63'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '64'; 
UPDATE `spi_project` SET `real_code` = 'z' WHERE `id` = '66'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '67'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '68'; 
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '69';
UPDATE `spi_project` SET `real_code` = 's' WHERE `id` = '70'; 