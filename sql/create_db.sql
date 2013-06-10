SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

USE `tns` ;

-- -----------------------------------------------------
-- Table `weather_station`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `weather_station` ;

CREATE  TABLE IF NOT EXISTS `weather_station` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `description` VARCHAR(200) NULL ,
  `loc_name` VARCHAR(45) NOT NULL ,
  `loc_coordinates` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `measurement_wind`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `measurement_wind` ;

CREATE  TABLE IF NOT EXISTS `measurement_wind` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `station_id` INT NOT NULL ,
  `speed` DOUBLE NOT NULL ,
  `gust` DOUBLE NOT NULL ,
  `direction` INT NOT NULL ,
  `measurement_time` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `station_fk_idx` (`station_id` ASC) ,
  CONSTRAINT `station_fk`
    FOREIGN KEY (`station_id` )
    REFERENCES `weather_station` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
