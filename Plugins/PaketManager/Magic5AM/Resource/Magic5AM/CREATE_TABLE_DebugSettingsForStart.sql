CREATE TABLE `_DebugSettingsForStart` (
  `_id` INT NOT NULL AUTO_INCREMENT,
  `_allow_incorrect_time` TINYINT NULL COMMENT 'You can start a dialogue with the bot at any time, and the bot will process it as this request was entered at the right time.',
  `_allow_duplicate` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'You can start a dialogue with the bot several times in one day',
  PRIMARY KEY (`_id`));

INSERT INTO `_DebugSettingsForStart`
(`_id`,
`_allow_incorrect_time`,
`_allow_duplicate`)
VALUES
(0,1,1);