-- =========================================================
-- Freelance Marketplace Management System
-- Database Schema
-- =========================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Freelancer_Skill;
DROP TABLE IF EXISTS Contract;
DROP TABLE IF EXISTS Proposal;
DROP TABLE IF EXISTS Project;
DROP TABLE IF EXISTS Skill;
DROP TABLE IF EXISTS Freelancer;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS `User`;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================================================
-- User Table
-- Stores common account information for all system users.
-- =========================================================

CREATE TABLE `User` (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    registration_date DATE NOT NULL,
    user_type VARCHAR(20) NOT NULL,
    CHECK (user_type IN ('Client', 'Freelancer'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Client Table
-- Represents clients who post projects.
-- client_id is also a foreign key referencing User(user_id).
-- =========================================================

CREATE TABLE Client (
    client_id INT PRIMARY KEY,
    FOREIGN KEY (client_id) REFERENCES `User`(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
