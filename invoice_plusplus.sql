SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `invoice_plusplus` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `invoice_plusplus` ;

-- -----------------------------------------------------
-- Table `invoice_plusplus`.`ipp_user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `invoice_plusplus`.`ipp_user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `firstName` VARCHAR(30) NOT NULL ,
  `surname` VARCHAR(30) NOT NULL ,
  `address` VARCHAR(50) NULL ,
  `suburb` VARCHAR(20) NULL ,
  `state` VARCHAR(4) NULL ,
  `postcode` VARCHAR(4) NULL ,
  `country` VARCHAR(20) NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `ccNumber` VARCHAR(16) NULL ,
  `ccName` VARCHAR(60) NULL ,
  `ccv` VARCHAR(3) NULL ,
  `expiryOne` VARCHAR(2) NULL ,
  `expiryTwo` VARCHAR(2) NULL ,
  `alcaLogin` VARCHAR(45) NOT NULL ,
  `securityLevel` TINYINT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `invoice_plusplus`.`ipp_product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `invoice_plusplus`.`ipp_product` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(30) NOT NULL ,
  `price` FLOAT NOT NULL ,
  `qty` SMALLINT NOT NULL ,
  `description` TEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `invoice_plusplus`.`ipp_client`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `invoice_plusplus`.`ipp_client` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `firstName` VARCHAR(30) NOT NULL ,
  `surname` VARCHAR(30) NOT NULL ,
  `address` VARCHAR(50) NULL ,
  `suburb` VARCHAR(20) NULL ,
  `state` VARCHAR(4) NULL ,
  `postcode` VARCHAR(4) NULL ,
  `country` VARCHAR(20) NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `company` VARCHAR(50) NULL ,
  `phoneNumber` VARCHAR(15) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `invoice_plusplus`.`ipp_invoice`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `invoice_plusplus`.`ipp_invoice` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ipp_client_id` INT UNSIGNED NOT NULL ,
  `createDate` DATE NOT NULL ,
  `dueDate` DATE NULL ,
  `totalDue` FLOAT NOT NULL ,
  `paid` BINARY NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ipp_invoice_ipp_client` (`ipp_client_id` ASC) ,
  CONSTRAINT `fk_ipp_invoice_ipp_client`
    FOREIGN KEY (`ipp_client_id` )
    REFERENCES `invoice_plusplus`.`ipp_client` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `invoice_plusplus`.`ipp_product_has_ipp_invoice`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `invoice_plusplus`.`ipp_product_has_ipp_invoice` (
  `ipp_product_id` INT UNSIGNED NOT NULL ,
  `ipp_invoice_id` INT UNSIGNED NOT NULL ,
  `qty` SMALLINT NOT NULL ,
  PRIMARY KEY (`ipp_product_id`, `ipp_invoice_id`) ,
  INDEX `fk_ipp_product_has_ipp_invoice_ipp_invoice1` (`ipp_invoice_id` ASC) ,
  INDEX `fk_ipp_product_has_ipp_invoice_ipp_product1` (`ipp_product_id` ASC) ,
  CONSTRAINT `fk_ipp_product_has_ipp_invoice_ipp_product1`
    FOREIGN KEY (`ipp_product_id` )
    REFERENCES `invoice_plusplus`.`ipp_product` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ipp_product_has_ipp_invoice_ipp_invoice1`
    FOREIGN KEY (`ipp_invoice_id` )
    REFERENCES `invoice_plusplus`.`ipp_invoice` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `invoice_plusplus`.`ipp_business`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `invoice_plusplus`.`ipp_business` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `businessName` VARCHAR(45) NOT NULL ,
  `address` VARCHAR(50) NOT NULL ,
  `suburb` VARCHAR(20) NOT NULL ,
  `state` VARCHAR(4) NOT NULL ,
  `postcode` VARCHAR(4) NOT NULL ,
  `country` VARCHAR(20) NOT NULL ,
  `email` VARCHAR(50) NULL ,
  `phoneNumber` VARCHAR(10) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
