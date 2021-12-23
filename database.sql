CREATE TABLE `trangg`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NULL,
  `name` VARCHAR(100) NULL,
  `password` VARCHAR(20) NULL,
  `phone` VARCHAR(20) NULL,
  `address` VARCHAR(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;