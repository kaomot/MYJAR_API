CREATE SCHEMA `myjar_clients_data` ;

CREATE TABLE `myjar_clients_data`.`clients`(
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(225) NOT NULL ,
  `phone` VARCHAR(225) NOT NULL ,
  `Metadata` JSON NULL ,
  PRIMARY KEY (`ID`))


