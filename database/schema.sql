-- =========================================================
-- Freelance Marketplace Management System
-- Database Schema
-- =========================================================
-- Description:
--   This script creates the relational database structure for
--   a freelance marketplace platform.
--
-- Main Entities:
--   User, Client, Freelancer, Project, Proposal, Contract, Skill
--
-- Key Relationships:
--   - A User can be specialized as a Client or Freelancer.
--   - A Client can post many Projects.
--   - A Freelancer can submit many Proposals.
--   - A Project can receive many Proposals.
--   - An accepted Proposal can generate one Contract.
--   - Freelancers and Skills have a many-to-many relationship.
--
-- Notes:
--   - InnoDB is used to support foreign key constraints.
--   - utf8mb4 is used for broad character support.
--   - CHECK constraints are included for basic data validation.
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
-- Table: User
-- Purpose:
--   Stores common account information for all users.
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
-- Table: Client
-- Purpose:
--   Represents users who can post projects.
--
-- Relationship:
--   Client.client_id references User.user_id.
-- =========================================================

CREATE TABLE Client (
    client_id INT PRIMARY KEY,

    FOREIGN KEY (client_id) REFERENCES `User`(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Table: Freelancer
-- Purpose:
--   Represents users who can submit project proposals.
--
-- Relationship:
--   Freelancer.freelancer_id references User.user_id.
-- =========================================================

CREATE TABLE Freelancer (
    freelancer_id INT PRIMARY KEY,
    bio TEXT,

    FOREIGN KEY (freelancer_id) REFERENCES `User`(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Table: Project
-- Purpose:
--   Stores projects posted by clients.
--
-- Relationship:
--   Each project belongs to one client.
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

-- =========================================================
-- Table: Proposal
-- Purpose:
--   Stores proposals submitted by freelancers for projects.
--
-- Relationships:
--   - Each proposal belongs to one freelancer.
--   - Each proposal is submitted for one project.
-- =========================================================

CREATE TABLE Proposal (
    proposal_id INT PRIMARY KEY AUTO_INCREMENT,
    cover_letter TEXT,
    bid_amount DECIMAL(10,2) NOT NULL,
    date_submitted DATE NOT NULL,
    status VARCHAR(50) NOT NULL,
    freelancer_id INT NOT NULL,
    project_id INT NOT NULL,

    FOREIGN KEY (freelancer_id) REFERENCES Freelancer(freelancer_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    FOREIGN KEY (project_id) REFERENCES Project(project_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CHECK (bid_amount >= 0),
    CHECK (status IN ('Pending', 'Accepted', 'Rejected'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Table: Contract
-- Purpose:
--   Stores contracts generated from accepted proposals.
--
-- Relationship:
--   Each proposal can generate only one contract.
-- =========================================================

CREATE TABLE Contract (
    contract_id INT PRIMARY KEY AUTO_INCREMENT,
    start_date DATE NOT NULL,
    end_date DATE,
    status VARCHAR(50) NOT NULL,
    proposal_id INT NOT NULL UNIQUE,

    FOREIGN KEY (proposal_id) REFERENCES Proposal(proposal_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CHECK (end_date IS NULL OR end_date >= start_date),
    CHECK (status IN ('Active', 'Completed', 'Cancelled'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Table: Skill
-- Purpose:
--   Stores the available skills that can be assigned to freelancers.
-- =========================================================

CREATE TABLE Skill (
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Table: Freelancer_Skill
-- Purpose:
--   Junction table for the many-to-many relationship between
--   freelancers and skills.
--
-- Composite Primary Key:
--   freelancer_id + skill_id
-- =========================================================

CREATE TABLE Freelancer_Skill (
    freelancer_id INT NOT NULL,
    skill_id INT NOT NULL,
    proficiency_level VARCHAR(50) NOT NULL,

    PRIMARY KEY (freelancer_id, skill_id),

    FOREIGN KEY (freelancer_id) REFERENCES Freelancer(freelancer_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    FOREIGN KEY (skill_id) REFERENCES Skill(skill_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CHECK (proficiency_level IN ('Beginner', 'Intermediate', 'Advanced', 'Expert'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
