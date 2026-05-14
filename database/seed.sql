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
