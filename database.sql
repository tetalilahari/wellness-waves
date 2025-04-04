
-- EcoTrack Database Schema

-- Drop tables if they exist to prevent errors
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS users;

-- Create users table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create reports table for waste management complaints
CREATE TABLE `reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create collection_schedule table
CREATE TABLE `collection_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area` varchar(100) NOT NULL,
  `collection_day` varchar(20) NOT NULL,
  `collection_time` varchar(20) NOT NULL,
  `waste_type` varchar(50) NOT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create recycling_guidelines table
CREATE TABLE `recycling_guidelines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `recyclable` tinyint(1) NOT NULL DEFAULT '1',
  `instructions` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user
INSERT INTO `users` (`name`, `username`, `email`, `password`, `role`) VALUES
('Admin User', 'admin', 'admin@ecotrack.com', '$2y$10$8Hx75xDGXytKOITZE.9fSOVT3ABzozDkYw69TAEUcXvgEYHIVLGYi', 'admin');
-- Password: admin123 (hashed with bcrypt)

-- Insert default regular user
INSERT INTO `users` (`name`, `username`, `email`, `password`, `role`) VALUES
('Regular User', 'user', 'user@ecotrack.com', '$2y$10$cjJg2w2jGQShoaWNWg7Z7ODVPmeg0S3Mlx5UD4Vq.BYNx3eGzRbx6', 'user');
-- Password: password (hashed with bcrypt)

-- Insert sample collection schedules
INSERT INTO `collection_schedule` (`area`, `collection_day`, `collection_time`, `waste_type`, `notes`) VALUES
('North District', 'Monday', '08:00-12:00', 'General Waste', 'Place bins outside by 7:30 AM'),
('North District', 'Wednesday', '08:00-12:00', 'Recyclables', 'Clean containers before recycling'),
('South District', 'Tuesday', '08:00-12:00', 'General Waste', 'Place bins outside by 7:30 AM'),
('South District', 'Thursday', '08:00-12:00', 'Recyclables', 'Clean containers before recycling'),
('East District', 'Monday', '13:00-17:00', 'General Waste', 'Place bins outside by 12:30 PM'),
('East District', 'Wednesday', '13:00-17:00', 'Recyclables', 'Clean containers before recycling'),
('West District', 'Tuesday', '13:00-17:00', 'General Waste', 'Place bins outside by 12:30 PM'),
('West District', 'Thursday', '13:00-17:00', 'Recyclables', 'Clean containers before recycling'),
('Central District', 'Friday', '08:00-15:00', 'All Waste Types', 'Combined collection for general waste and recyclables');

-- Insert recycling guidelines
INSERT INTO `recycling_guidelines` (`material`, `description`, `recyclable`, `instructions`) VALUES
('Paper', 'Newspapers, magazines, office paper, cardboard', 1, 'Keep dry and clean. Remove tape and staples.'),
('Plastic Bottles', 'Beverage bottles, cleaning product containers', 1, 'Rinse containers. Remove caps and place them in recycling separately.'),
('Glass', 'Bottles and jars', 1, 'Rinse containers. Remove lids and corks.'),
('Metal Cans', 'Food cans, beverage cans, aerosol cans', 1, 'Rinse containers. Labels can remain on.'),
('Food Waste', 'Leftovers, fruit and vegetable scraps', 0, 'Place in compost or general waste. Not recyclable.'),
('Electronics', 'Phones, computers, TVs, batteries', 1, 'Take to designated e-waste collection points.'),
('Styrofoam', 'Packaging material, food containers', 0, 'Place in general waste. Not recyclable in most areas.');
