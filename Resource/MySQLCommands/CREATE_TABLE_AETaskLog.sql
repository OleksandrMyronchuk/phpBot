CREATE TABLE `_AETaskLog`(
  `_id` INT NOT NULL AUTO_INCREMENT,
   `_keyToAETask` INT NULL,
  `_time_of_last_execution` VARCHAR(45) NULL,
  UNIQUE INDEX  (`_keyToAETask`),
  PRIMARY KEY (`_id`),
  CONSTRAINT `_keyToAETask_fk`
    FOREIGN KEY (`_keyToAETask`)
    REFERENCES `_AETask` (`_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION) COMMENT 'AE - Automation Execution';
