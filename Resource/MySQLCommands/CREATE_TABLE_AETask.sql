CREATE TABLE `_AETask`
    (
  `_id` INT NOT NULL AUTO_INCREMENT,
  `_chat_id` VARCHAR(15) NULL,
  `_action_name` VARCHAR(45) NULL,
  `_execution_time` TIME NULL COMMENT 'Execution time on a server',
  PRIMARY KEY (`_id`)) COMMENT 'AE - Automation Execution';