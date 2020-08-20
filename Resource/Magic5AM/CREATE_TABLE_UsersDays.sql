CREATE TABLE `_UsersDays` (
  `_id` INT NOT NULL AUTO_INCREMENT,
  `_KeyToUsers` INT NULL,
  `_CurrentDay` INT NULL,
  `_DateOfLastUpdate` INT NULL COMMENT 'Epoch',
  PRIMARY KEY (`_id`),
  INDEX `_KeyToUsers_idx` (`_KeyToUsers`),
  CONSTRAINT `_KeyToUsers`
    FOREIGN KEY (`_KeyToUsers`)
    REFERENCES `_Users` (`_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
