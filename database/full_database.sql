-- =========================================================
-- Freelance Marketplace Management System
-- Full Database Import File
-- =========================================================
-- Description:
--   This file combines the database schema and demo seed data.
--   It is intended for one-step import using phpMyAdmin or MySQL tools.
-- =========================================================

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


-- =========================================================
-- Freelance Marketplace Management System
-- Seed Data
-- =========================================================
-- Description:
--   This file inserts demo-safe sample data for testing
--   the freelance marketplace database locally or on hosting.
--
-- Notes:
--   - All records are fictional demo data.
--   - No real credentials or private information are included.
--   - Import this file after database/schema.sql.
--   - This script does not include CREATE DATABASE or USE statements,
--     so it remains compatible with phpMyAdmin and InfinityFree.
-- =========================================================

-- =========================================================
-- Sample Users
-- =========================================================

INSERT INTO `User` (user_id, name, email, password, registration_date, user_type) VALUES
(1, 'Ahmed Hassan', 'ahmed.client@example.com', 'client123', '2026-03-01', 'Client'),
(2, 'Sara Ali', 'sara.client@example.com', 'client123', '2026-03-04', 'Client'),
(3, 'Omar Khaled', 'omar.freelancer@example.com', 'free123', '2026-03-05', 'Freelancer'),
(4, 'Laila Samir', 'laila.freelancer@example.com', 'free123', '2026-03-06', 'Freelancer'),
(5, 'Mona Adel', 'mona.freelancer@example.com', 'free123', '2026-03-08', 'Freelancer'),
(6, 'Karim Nabil', 'karim.client@example.com', 'client123', '2026-03-10', 'Client');
-- =========================================================
-- Sample Clients
-- =========================================================

INSERT INTO Client (client_id) VALUES
(1),
(2),
(6);
-- =========================================================
-- Sample Freelancers
-- =========================================================

INSERT INTO Freelancer (freelancer_id, bio) VALUES
(3, 'Full-stack web developer with experience in PHP, MySQL, and responsive website design.'),
(4, 'Graphic designer and front-end freelancer focused on branding, UI layouts, and landing pages.'),
(5, 'Content writer and virtual assistant with experience in product descriptions and admin support.');
-- =========================================================
-- Sample Projects
-- =========================================================
-- Project.status values must match the current schema:
-- Open, In Progress, Completed, Cancelled
-- =========================================================

INSERT INTO Project (project_id, title, description, budget, date_posted, status, client_id) VALUES
(1, 'Business Website Redesign', 'Need a clean redesign for a company website with updated pages and responsive layout.', 1200.00, '2026-04-01', 'Open', 1),
(2, 'Logo and Brand Kit', 'Looking for a freelancer to design a logo and simple brand identity package.', 450.00, '2026-04-03', 'In Progress', 2),
(3, 'Product Description Writing', 'Need engaging product descriptions for an online store with 50 items.', 300.00, '2026-04-04', 'Open', 6),
(4, 'Portfolio Website', 'Create a personal portfolio website for a photographer using simple PHP pages.', 700.00, '2026-04-06', 'Completed', 1);
-- =========================================================
-- Sample Proposals
-- =========================================================

INSERT INTO Proposal (proposal_id, cover_letter, bid_amount, date_submitted, status, freelancer_id, project_id) VALUES
(1, 'I can redesign your business website with a clean structure and responsive pages.', 1100.00, '2026-04-02', 'Accepted', 3, 1),
(2, 'I have strong experience in logo design and can deliver a full brand kit quickly.', 420.00, '2026-04-04', 'Pending', 4, 2),
(3, 'I can write clear and SEO-friendly product descriptions for your catalog.', 280.00, '2026-04-05', 'Pending', 5, 3),
(4, 'I can build a simple and elegant photographer portfolio with gallery sections.', 650.00, '2026-04-07', 'Rejected', 3, 4),
(5, 'I can create a modern portfolio layout with attention to design details.', 680.00, '2026-04-07', 'Pending', 4, 4);
-- =========================================================
-- Sample Contracts
-- =========================================================

INSERT INTO Contract (contract_id, start_date, end_date, status, proposal_id) VALUES
(1, '2026-04-08', '2026-04-25', 'Active', 1);
-- =========================================================
-- Sample Skills
-- =========================================================

INSERT INTO Skill (skill_id, skill_name) VALUES
(1, 'PHP'),
(2, 'MySQL'),
(3, 'HTML'),
(4, 'CSS'),
(5, 'Graphic Design'),
(6, 'Content Writing');
-- =========================================================
-- Sample Freelancer Skill Assignments
-- =========================================================

INSERT INTO Freelancer_Skill (freelancer_id, skill_id, proficiency_level) VALUES
(3, 1, 'Advanced'),
(3, 2, 'Advanced'),
(3, 3, 'Advanced'),
(3, 4, 'Intermediate'),
(4, 3, 'Intermediate'),
(4, 4, 'Advanced'),
(4, 5, 'Advanced'),
(5, 6, 'Advanced'),
(5, 3, 'Beginner');
