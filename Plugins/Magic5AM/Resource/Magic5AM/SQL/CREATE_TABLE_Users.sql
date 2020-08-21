CREATE TABLE `_Users` (
  `_id` INT NOT NULL AUTO_INCREMENT,
  `_UserId` INT UNSIGNED NULL,
  `_Username` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT null,
  `_FirstName` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT null,
  `_LastName` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT null,
  PRIMARY KEY (`_id`),
  UNIQUE INDEX `_UserId_UNIQUE` (`_UserId`));
