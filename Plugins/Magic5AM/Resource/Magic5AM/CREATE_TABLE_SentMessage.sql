CREATE TABLE `_SentMessage` (
  `_id` INT NOT NULL AUTO_INCREMENT,
  `_chat_id` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `_message_id` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `_date` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `_to_user_id` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `_text_id` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `_command` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `_step` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`_id`));
