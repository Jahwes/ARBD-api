--
-- Database: `test_cinemahd`
--

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `test_cinemahd` DEFAULT CHARACTER SET utf8 ;
USE `test_cinemahd` ;

-- -----------------------------------------------------
-- Table `test_cinemahd`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`User` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`User` (
  `id` INT NOT NULL,
  `lastname` VARCHAR(50) NULL,
  `firstname` VARCHAR(50) NULL,
  `date_of_birth` DATE NULL,
  `title` ENUM('Monsieur', 'Madame', 'Mademoiselle') NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Type` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Type` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Order` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Order` (
  `id` INT NOT NULL,
  `created_at` DATE NULL,
  `User_id` INT NOT NULL,
  PRIMARY KEY (`id`, `User_id`),
  INDEX `fk_Order_User_idx` (`User_id` ASC),
  CONSTRAINT `fk_Order_User`
    FOREIGN KEY (`User_id`)
    REFERENCES `test_cinemahd`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Movie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Movie` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Movie` (
  `id` INT NOT NULL,
  `title` VARCHAR(70) NULL,
  `duration` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Movie_has_Type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Movie_has_Type` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Movie_has_Type` (
  `Movie_id` INT NOT NULL,
  `Type_id` INT NOT NULL,
  PRIMARY KEY (`Movie_id`, `Type_id`),
  INDEX `fk_Movie_has_Type_Type1_idx` (`Type_id` ASC),
  INDEX `fk_Movie_has_Type_Movie1_idx` (`Movie_id` ASC),
  CONSTRAINT `fk_Movie_has_Type_Movie1`
    FOREIGN KEY (`Movie_id`)
    REFERENCES `test_cinemahd`.`Movie` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movie_has_Type_Type1`
    FOREIGN KEY (`Type_id`)
    REFERENCES `test_cinemahd`.`Type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Price`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Price` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Price` (
  `id` INT NOT NULL,
  `type_name` VARCHAR(100) NULL,
  `value` DOUBLE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Room`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Room` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Room` (
  `id` INT NOT NULL,
  `nb_places` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Showing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Showing` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Showing` (
  `id` INT NOT NULL,
  `date` DATETIME NULL,
  `3D` TINYINT(1) NULL,
  `Room_id` INT NOT NULL,
  `Movie_id` INT NOT NULL,
  PRIMARY KEY (`id`, `Room_id`, `Movie_id`),
  INDEX `fk_Showing_Room1_idx` (`Room_id` ASC),
  INDEX `fk_Showing_Movie1_idx` (`Movie_id` ASC),
  CONSTRAINT `fk_Showing_Room1`
    FOREIGN KEY (`Room_id`)
    REFERENCES `test_cinemahd`.`Room` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Showing_Movie1`
    FOREIGN KEY (`Movie_id`)
    REFERENCES `test_cinemahd`.`Movie` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Spectator`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Spectator` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Spectator` (
  `id` INT NOT NULL,
  `lastname` VARCHAR(50) NULL,
  `firstname` VARCHAR(50) NULL,
  `date_of_birth` DATE NULL,
  `title` ENUM('Monsieur', 'Madame', 'Mademoiselle') NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Ticket`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Ticket` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Ticket` (
  `id` INT NOT NULL,
  `Price_id` INT NOT NULL,
  `Showing_id` INT NOT NULL,
  `Spectator_id` INT NOT NULL,
  PRIMARY KEY (`id`, `Price_id`, `Showing_id`, `Spectator_id`),
  INDEX `fk_Ticket_Price1_idx` (`Price_id` ASC),
  INDEX `fk_Ticket_Showing1_idx` (`Showing_id` ASC),
  INDEX `fk_Ticket_Spectator1_idx` (`Spectator_id` ASC),
  CONSTRAINT `fk_Ticket_Price1`
    FOREIGN KEY (`Price_id`)
    REFERENCES `test_cinemahd`.`Price` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ticket_Showing1`
    FOREIGN KEY (`Showing_id`)
    REFERENCES `test_cinemahd`.`Showing` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ticket_Spectator1`
    FOREIGN KEY (`Spectator_id`)
    REFERENCES `test_cinemahd`.`Spectator` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Order_has_Ticket`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Order_has_Ticket` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Order_has_Ticket` (
  `Order_id` INT NOT NULL,
  `Order_User_id` INT NOT NULL,
  `Ticket_id` INT NOT NULL,
  `Ticket_Price_id` INT NOT NULL,
  `Ticket_Showing_id` INT NOT NULL,
  `Ticket_Spectator_id` INT NOT NULL,
  PRIMARY KEY (`Order_id`, `Order_User_id`, `Ticket_id`, `Ticket_Price_id`, `Ticket_Showing_id`, `Ticket_Spectator_id`),
  INDEX `fk_Order_has_Ticket_Ticket1_idx` (`Ticket_id` ASC, `Ticket_Price_id` ASC, `Ticket_Showing_id` ASC, `Ticket_Spectator_id` ASC),
  INDEX `fk_Order_has_Ticket_Order1_idx` (`Order_id` ASC, `Order_User_id` ASC),
  CONSTRAINT `fk_Order_has_Ticket_Order1`
    FOREIGN KEY (`Order_id` , `Order_User_id`)
    REFERENCES `test_cinemahd`.`Order` (`id` , `User_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_has_Ticket_Ticket1`
    FOREIGN KEY (`Ticket_id` , `Ticket_Price_id` , `Ticket_Showing_id` , `Ticket_Spectator_id`)
    REFERENCES `test_cinemahd`.`Ticket` (`id` , `Price_id` , `Showing_id` , `Spectator_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`People`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`People` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`People` (
  `id` INT NOT NULL,
  `firstname` VARCHAR(50) NULL,
  `lastname` VARCHAR(50) NULL,
  `date_of_birth` DATE NULL,
  `nationality` VARCHAR(50) NULL,
  `role` VARCHAR(50) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_cinemahd`.`Movie_has_People`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_cinemahd`.`Movie_has_People` ;

CREATE TABLE IF NOT EXISTS `test_cinemahd`.`Movie_has_People` (
  `Movie_id` INT NOT NULL,
  `People_id` INT NOT NULL,
  PRIMARY KEY (`Movie_id`, `People_id`),
  INDEX `fk_Movie_has_People_People1_idx` (`People_id` ASC),
  INDEX `fk_Movie_has_People_Movie1_idx` (`Movie_id` ASC),
  CONSTRAINT `fk_Movie_has_People_Movie1`
    FOREIGN KEY (`Movie_id`)
    REFERENCES `test_cinemahd`.`Movie` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movie_has_People_People1`
    FOREIGN KEY (`People_id`)
    REFERENCES `test_cinemahd`.`People` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
