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
