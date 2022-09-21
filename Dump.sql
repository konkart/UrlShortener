-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema urlshortener
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema urlshortener
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `urlshortener` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `urlshortener` ;

-- -----------------------------------------------------
-- Table `urlshortener`.`urls`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `urlshortener`.`urls` (
  `slug` CHAR(7) NOT NULL,
  `expir` INT NOT NULL,
  `original` TEXT NOT NULL,
  `renew` TINYINT(1) NOT NULL DEFAULT '-1',
  `activeUrl` TINYINT(1) NOT NULL DEFAULT '0',
  `selection` CHAR(5) NOT NULL DEFAULT 'day',
  PRIMARY KEY (`slug`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
