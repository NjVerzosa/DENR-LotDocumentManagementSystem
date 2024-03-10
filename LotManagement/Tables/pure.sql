CREATE TABLE `land_titles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `lot_number` VARCHAR(255) NOT NULL,
  `date_filed` DATE,
  `applicant_name` VARCHAR(255),
  `location` VARCHAR(255),
  `remarks` TEXT,
  `position` VARCHAR(255),
  `status` VARCHAR(5) NOT NULL DEFAULT '0' COMMENT '0 = no action, 1 = subdivided, 2 = titled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `subdivided_titles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `lot_number` VARCHAR(255) NOT NULL,
  `date_filed` DATE,
  `applicant_name` VARCHAR(255),
  `location` VARCHAR(255),
  `remarks` TEXT,
  `position` VARCHAR(10),
  `status` VARCHAR(5) NOT NULL DEFAULT '0' COMMENT '0 = no action, 1 = subdivided, 2 = titled',
  `land_title_id` INT,
  `subdivided_to` VARCHAR(10) COMMENT 'null = not subdivided, put the subdivided address if subdivided',
  FOREIGN KEY (`land_title_id`) REFERENCES `land_titles`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
