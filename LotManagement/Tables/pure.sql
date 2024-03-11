CREATE TABLE `land_titles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `lot_number` VARCHAR(255) NOT NULL,
  `application_number` VARCHAR(255),
  `date_filed` DATE,
  `applicant_name` VARCHAR(255),
  `area` VARCHAR(255),
  `location` VARCHAR(255),
  `remarks` VARCHAR(255),
  `approved_date` DATE,
  `status` VARCHAR(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `subdivided_titles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `land_title_id` INT,
  `lot_number` VARCHAR(255) NOT NULL,
  `application_number` VARCHAR(255),
  `date_filed` DATE,
  `applicant_name` VARCHAR(255),
  `area` VARCHAR(255),
  `location` VARCHAR(255),
  `approved_date` DATE,
  `remarks` VARCHAR(255),
  `status` VARCHAR(5) NOT NULL DEFAULT '0',
  `subdivided_to` VARCHAR(10),
  FOREIGN KEY (`land_title_id`) REFERENCES `land_titles`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
