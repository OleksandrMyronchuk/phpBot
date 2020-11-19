CREATE TABLE `_ReceivedMessage` (
     `_id` INT NOT NULL AUTO_INCREMENT,
     `_message_id` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
     `_chat_id` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
     `_from_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
     `_date` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
     `_text` VARCHAR(4096) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
     `_command` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
     `_step` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
     PRIMARY KEY (`_id`)
 );