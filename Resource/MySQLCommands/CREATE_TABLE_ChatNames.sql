CREATE TABLE `_ChatNames` (
  `_id` INT NOT NULL AUTO_INCREMENT,
  `_chat_name` VARCHAR(45) NULL,
  `_chat_id` VARCHAR(15) NULL,
  PRIMARY KEY (`_id`),
  UNIQUE INDEX `_chat_id_UNIQUE` (`_chat_id` ASC) VISIBLE);