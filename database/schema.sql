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

-- =========================================================
-- Freelancer Table
-- Represents freelancers who submit proposals.
-- freelancer_id is also a foreign key referencing User(user_id).
-- =========================================================

CREATE TABLE Freelancer (
    freelancer_id INT PRIMARY KEY,
    bio TEXT,
    FOREIGN KEY (freelancer_id) REFERENCES `User`(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Project Table
-- Stores projects posted by clients.
-- =========================================================

CREATE TABLE Project (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    budget DECIMAL(10,2),
    date_posted DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    client_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES Client(client_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CHECK (budget IS NULL OR budget >= 0),
    CHECK (status IN ('Open', 'In Progress', 'Completed', 'Cancelled'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
