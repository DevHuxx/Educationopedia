-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2026 at 10:53 PM
-- Server version: 10.6.24-MariaDB-cll-lve
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `totp_secret` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `totp_secret`, `created_at`) VALUES
(1, 'eduakash', '$2a$12$3TM0SMXpvR92a6DWg1kNPuORdlwGmlpZhVfd3GiYKlhmkm76a5Kqq', 'VISLGPLXZGQ2VYM2ARY6FKIDQS4OZK5E', '2026-04-22 10:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `category` varchar(50) DEFAULT '',
  `read_time` varchar(20) DEFAULT '',
  `image_path` varchar(500) DEFAULT '',
  `published_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `excerpt`, `content`, `category`, `read_time`, `image_path`, `published_at`, `created_at`) VALUES
(1, 'Top 10 Countries for MBBS Abroad in 2025', 'Discover the most popular and affordable destinations for pursuing MBBS abroad with recognized degrees.', NULL, 'MBBS Abroad', '5 min read', '/blog-mbbs-abroad.jpg', '2026-03-28', '2026-04-22 10:04:25'),
(2, 'NEET Score Requirements for Studying MBBS Abroad', 'Complete guide on minimum NEET scores required for admission in different countries for Indian students.', NULL, 'Admissions', '4 min read', '/blog-neet-score.jpg', '2026-03-25', '2026-04-22 10:04:25'),
(3, 'Scholarship Opportunities for Indian Students Abroad', 'Explore various scholarship programs available for Indian students seeking international education.', NULL, 'Scholarships', '6 min read', '/blog-scholarship.jpg', '2026-03-20', '2026-04-22 10:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `exam_candidates`
--

CREATE TABLE `exam_candidates` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `father_phone` varchar(30) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `class_completed` varchar(100) DEFAULT NULL,
  `neet_status` varchar(100) DEFAULT NULL,
  `neet_score` varchar(20) DEFAULT NULL,
  `target_country` varchar(100) DEFAULT NULL,
  `target_course` varchar(100) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `status` enum('registered','started','completed') DEFAULT 'registered',
  `score` int(11) DEFAULT 0,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_candidates`
--

INSERT INTO `exam_candidates` (`id`, `name`, `email`, `phone`, `password`, `father_name`, `father_phone`, `dob`, `city`, `state`, `class_completed`, `neet_status`, `neet_score`, `target_country`, `target_course`, `photo_path`, `status`, `score`, `start_time`, `end_time`, `created_at`) VALUES
(5, 'Akash Tiwari', 'teamarraycore@gmail.com', '+918100273220', 'L5cD1RGo', 'Akash Tiwari', '3696582507', '2026-04-09', 'Kolkata', 'Wb', '12th (HSC) - Appearing', 'Appeared in NEET 2024', '670', 'Uzbekistan', 'Nursing', '/backend/uploads/exam_photos/candidate_1777016375_7356.jpg', 'registered', 0, NULL, NULL, '2026-04-24 07:39:35'),
(18, 'Akash Tiwari', 'akashtid445@gmail.com', '8100273220', 'YWjgtbqr', 'Akash Tiwari', '2585258525', '2026-04-10', 'Kolkata', 'Wb', '12th (HSC) - Appearing', 'Appeared in NEET 2023', '450', 'China', 'BDS (Dentistry)', '/backend/uploads/exam_photos/candidate_1777019114_8628.jpg', 'started', 0, '2026-04-24 01:26:59', NULL, '2026-04-24 08:25:14'),
(19, 'Akash Tiwari', 'akashtix445@gmail.com', '8100273220', '3G8gf1Vr', 'Th', '2585258525', '2026-04-16', 'Kolkata', 'West Bengal', '12th (HSC) - Appearing', 'Appeared in NEET 2023', '459', 'Kyrgyzstan', 'Pharmacy', '/backend/uploads/exam_photos/candidate_1777019280_2385.jpg', 'registered', 0, NULL, NULL, '2026-04-24 08:28:00'),
(20, 'rahulsharma', 'om1146434@gmail.com', '7710037606', '7H0W8eIg', 'hsgdgyhwhz hhgyujjk', '8877665544', '2000-11-22', 'delhi', 'delhi', '12th (HSC) - Appearing', 'Going to attempt NEET (First Timer)', '', 'Georgia', 'MBBS', '/backend/uploads/exam_photos/candidate_1777019526_9999.jpg', 'started', 0, '2026-04-24 01:34:25', NULL, '2026-04-24 08:32:06'),
(21, 'Ajay', 'shantanu1146432@gmail.com', '9821964939', 'ylNWFZqK', 'Vijay singh', '9911445566', '2019-04-24', 'Patna', 'Bihar', 'Graduate', 'Appearing in NEET 2025', '', 'Georgia', 'MBBS', '/backend/uploads/exam_photos/candidate_1777019600_5689.jpg', 'started', 0, '2026-04-27 04:23:48', NULL, '2026-04-24 08:33:20'),
(24, 'Sanjay', 'sanjana1146432@gmail.com', '9821964939', 'RxNuUm0e', 'Dharam', '982196493.', '2026-04-24', 'Gaya', 'Bihar', 'Graduate', 'Appeared in NEET 2024', '280', 'Not Decided Yet', 'MBBS', '/backend/uploads/exam_photos/candidate_1777019840_2195.jpg', 'completed', 9, '2026-04-24 01:39:00', '2026-04-24 01:40:32', '2026-04-24 08:37:20'),
(25, 'Naveen Jayaraj', 'naveenjayaraj13@gmail.com', '8220534743', 'NXsTFhCJ', 'Antony raj', '8220534743', '2013-07-17', 'Chennai', 'Tamil Nadu', '12th (HSC) - Passed', 'Appeared in NEET 2024', '480', 'Georgia', 'MBBS', '/backend/uploads/exam_photos/candidate_1777023365_8963.jpg', 'completed', 37, '2026-04-24 02:43:36', '2026-04-24 02:52:28', '2026-04-24 09:36:05'),
(26, 'Amir Ali beigh', 'amirbeighepc@gmail.com', '9541611235', 'diA6XE4Q', 'Mohammed maqbool beigh', '+919018341235', '1980-04-24', 'Srinagar', 'Jammu and Kashmir', '12th (HSC) - Passed', 'Going to attempt NEET (First Timer)', '', 'Russia', 'MBBS', '/backend/uploads/exam_photos/candidate_1777044177_8144.jpg', 'completed', 14, '2026-04-24 08:24:58', '2026-04-24 08:35:22', '2026-04-24 15:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `opt_a` varchar(255) NOT NULL,
  `opt_b` varchar(255) NOT NULL,
  `opt_c` varchar(255) NOT NULL,
  `opt_d` varchar(255) NOT NULL,
  `correct_opt` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `question_text`, `opt_a`, `opt_b`, `opt_c`, `opt_d`, `correct_opt`) VALUES
(42, 'The most abundant enzyme is:', 'Catalase', 'RuBisCo', 'Nitrogenase', 'Invertase', 'B'),
(43, 'Which of the following is a C4 plant?', 'Wheat', 'Rice', 'Maize', 'Potato', 'C'),
(44, 'Calvin cycle occurs in:', 'Grana', 'Thylakoid', 'Stroma', 'Matrix', 'C'),
(45, 'Photorespiration occurs in:', 'C3 plants only', 'C4 plants only', 'Both', 'None', 'A'),
(46, 'Which hormone promotes cell elongation?', 'Cytokinin', 'Auxin', 'ABA', 'Ethylene', 'B'),
(47, 'Which structure regulates transpiration?', 'Root hair', 'Stomata', 'Cuticle', 'Xylem', 'B'),
(48, 'Which part of neuron receives impulse?', 'Axon', 'Dendrite', 'Myelin', 'Synapse', 'B'),
(49, 'Which gas is released in photosynthesis?', 'CO₂', 'O₂', 'N₂', 'H₂', 'B'),
(50, 'Which is a non-reducing sugar?', 'Glucose', 'Fructose', 'Sucrose', 'Maltose', 'C'),
(51, 'Which blood cells help in clotting?', 'RBC', 'WBC', 'Platelets', 'Plasma', 'C'),
(52, 'Which hormone regulates metabolism?', 'Insulin', 'Thyroxine', 'ADH', 'Estrogen', 'B'),
(53, 'Which is longest bone?', 'Femur', 'Tibia', 'Humerus', 'Radius', 'A'),
(54, 'Which is smallest bone?', 'Femur', 'Stapes', 'Tibia', 'Ulna', 'B'),
(55, 'Which is respiratory pigment?', 'Chlorophyll', 'Hemoglobin', 'Melanin', 'Keratin', 'B'),
(56, 'Which organ produces urine?', 'Liver', 'Kidney', 'Heart', 'Lung', 'B'),
(57, 'Boyle’s law states:', 'P ∝ V', 'P ∝ 1/V', 'V ∝ T', 'None', 'B'),
(58, 'Strongest acid:', 'HF', 'HCl', 'HBr', 'HI', 'D'),
(59, 'Hybridization in CH₄:', 'sp', 'sp²', 'sp³', 'dsp²', 'C'),
(60, 'Which is amphoteric oxide?', 'Na₂O', 'CO₂', 'Al₂O₃', 'SO₂', 'C'),
(61, 'Oxidation number of S in H₂SO₄:', '+2', '+4', '+6', '-2', 'C'),
(62, 'Which is paramagnetic?', 'N₂', 'O₂', 'CO₂', 'CH₄', 'B'),
(63, 'Highest electronegativity:', 'O', 'N', 'F', 'Cl', 'C'),
(64, 'Volume ∝ temperature:', 'Boyle', 'Charles', 'Avogadro', 'Dalton', 'B'),
(65, 'Strong electrolyte:', 'Glucose', 'Acetic acid', 'NaCl', 'Urea', 'C'),
(66, 'Which is acid?', 'CH₃OH', 'CH₃COOH', 'CH₄', 'C₂H₆', 'B'),
(67, 'Work done in uniform circular motion is:', 'Positive', 'Negative', 'Zero', 'Infinite', 'C'),
(68, 'A body moves with constant speed in a circle. What changes?', 'Speed', 'Velocity', 'Mass', 'Energy', 'B'),
(69, 'Unit of power is:', 'Joule', 'Watt', 'Newton', 'Pascal', 'B'),
(70, 'Which is scalar quantity?', 'Velocity', 'Acceleration', 'Speed', 'Force', 'C'),
(71, 'Ohm’s law:', '1', 'sinθ', 'cosθ', 'tanθ', 'A'),
(72, '  Two identical capacitors in series → equivalent capacitance:', 'C', '2C', 'C/2', 'C²', 'C'),
(73, '  Work done in uniform circular motion is:', 'Positive', 'Negative', 'Zero', 'Infinite', 'C'),
(74, '  A body moves in a circle with constant speed. What remains constant?', 'Velocity', 'Acceleration', 'Speed', 'Momentum', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `exam_responses`
--

CREATE TABLE `exam_responses` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_opt` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `alt_text` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `image_path`, `alt_text`, `sort_order`, `created_at`) VALUES
(1, '/gallery/Untitled design (11).png', 'Gallery Image 11', 11, '2026-04-22 10:04:25'),
(2, '/gallery/Untitled design (12).png', 'Gallery Image 12', 12, '2026-04-22 10:04:25'),
(3, '/gallery/Untitled design (13).png', 'Gallery Image 13', 13, '2026-04-22 10:04:25'),
(4, '/gallery/Untitled design (14).png', 'Gallery Image 14', 14, '2026-04-22 10:04:25'),
(5, '/gallery/Untitled design (15).png', 'Gallery Image 15', 15, '2026-04-22 10:04:25'),
(6, '/gallery/Untitled design (16).png', 'Gallery Image 16', 16, '2026-04-22 10:04:25'),
(7, '/gallery/Untitled design (17).png', 'Gallery Image 17', 17, '2026-04-22 10:04:25'),
(8, '/gallery/Untitled design (18).png', 'Gallery Image 18', 18, '2026-04-22 10:04:25'),
(9, '/gallery/Untitled design (19).png', 'Gallery Image 19', 19, '2026-04-22 10:04:25'),
(10, '/gallery/Untitled design (20).png', 'Gallery Image 20', 20, '2026-04-22 10:04:25'),
(11, '/gallery/Untitled design (21).png', 'Gallery Image 21', 21, '2026-04-22 10:04:25'),
(12, '/gallery/Untitled design (22).png', 'Gallery Image 22', 22, '2026-04-22 10:04:25'),
(13, '/gallery/Untitled design (23).png', 'Gallery Image 23', 23, '2026-04-22 10:04:25'),
(14, '/gallery/Untitled design (24).png', 'Gallery Image 24', 24, '2026-04-22 10:04:25'),
(15, '/gallery/Untitled design (25).png', 'Gallery Image 25', 25, '2026-04-22 10:04:25'),
(16, '/gallery/Untitled design (26).png', 'Gallery Image 26', 26, '2026-04-22 10:04:25'),
(17, '/gallery/Untitled design (27).png', 'Gallery Image 27', 27, '2026-04-22 10:04:25'),
(18, '/gallery/Untitled design (28).png', 'Gallery Image 28', 28, '2026-04-22 10:04:25'),
(19, '/gallery/Untitled design (29).png', 'Gallery Image 29', 29, '2026-04-22 10:04:25'),
(20, '/gallery/Untitled design (30).png', 'Gallery Image 30', 30, '2026-04-22 10:04:25'),
(21, '/gallery/Untitled design (31).png', 'Gallery Image 31', 31, '2026-04-22 10:04:25'),
(22, '/gallery/Untitled design (32).png', 'Gallery Image 32', 32, '2026-04-22 10:04:25'),
(23, '/gallery/Untitled design (33).png', 'Gallery Image 33', 33, '2026-04-22 10:04:25'),
(24, '/gallery/Untitled design (34).png', 'Gallery Image 34', 34, '2026-04-22 10:04:25'),
(25, '/gallery/Untitled design (35).png', 'Gallery Image 35', 35, '2026-04-22 10:04:25'),
(26, '/gallery/Untitled design (36).png', 'Gallery Image 36', 36, '2026-04-22 10:04:25'),
(27, '/gallery/Untitled design (37).png', 'Gallery Image 37', 37, '2026-04-22 10:04:25'),
(28, '/gallery/Untitled design (38).png', 'Gallery Image 38', 38, '2026-04-22 10:04:25'),
(29, '/gallery/Untitled design (39).png', 'Gallery Image 39', 39, '2026-04-22 10:04:25'),
(30, '/gallery/Untitled design (40).png', 'Gallery Image 40', 40, '2026-04-22 10:04:25'),
(31, '/gallery/Untitled design (41).png', 'Gallery Image 41', 41, '2026-04-22 10:04:25'),
(32, '/gallery/Untitled design (42).png', 'Gallery Image 42', 42, '2026-04-22 10:04:25'),
(33, '/gallery/Untitled design (43).png', 'Gallery Image 43', 43, '2026-04-22 10:04:25'),
(34, '/gallery/Untitled design (44).png', 'Gallery Image 44', 44, '2026-04-22 10:04:25'),
(35, '/gallery/Untitled design (45).png', 'Gallery Image 45', 45, '2026-04-22 10:04:25'),
(36, '/gallery/Untitled design (46).png', 'Gallery Image 46', 46, '2026-04-22 10:04:25'),
(37, '/gallery/Untitled design (47).png', 'Gallery Image 47', 47, '2026-04-22 10:04:25'),
(38, '/gallery/Untitled design (48).png', 'Gallery Image 48', 48, '2026-04-22 10:04:25'),
(39, '/gallery/Untitled design (49).png', 'Gallery Image 49', 49, '2026-04-22 10:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `country` varchar(100) DEFAULT '',
  `course` varchar(100) DEFAULT '',
  `message` text DEFAULT '',
  `status` enum('new','processing','positive','negative') NOT NULL DEFAULT 'new',
  `assigned_to` int(11) DEFAULT NULL COMMENT 'mod_users.id',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `reminder_at` datetime DEFAULT NULL COMMENT 'Scheduled reminder datetime',
  `pinned` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = pinned to top'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `email`, `phone`, `country`, `course`, `message`, `status`, `assigned_to`, `created_at`, `reminder_at`, `pinned`) VALUES
(1, 'Akash Tiwari', 'ok@gmail.com', '9876567890', '', 'mbbs', 'ok', 'new', NULL, '2026-04-22 10:08:36', NULL, 0),
(2, 'Akash ok', 'kj@gmail.com', '9876543216', 'dubai', 'mbbs', 'ok', 'positive', 1, '2026-04-23 05:58:54', NULL, 0),
(3, 'Ilma', 'jahidahmed26265@gmail.com', '9650628526', '', 'mbbs', 'My budget is just 5L-8L about 3 months ago my father was pass away we are not good financially', 'new', NULL, '2026-04-26 05:48:31', NULL, 0),
(4, 'Akash Tiwari', 'ok@gmail.com', '9898989898', 'Russia (Legacy Universities)', '', 'Initial interest from LandingAds page.', 'new', NULL, '2026-04-27 08:36:20', NULL, 0),
(5, 'Akash Tiwari', 'ok@gmail.com', '9898989898', '', '', 'Merit Assessment: Goal - surgery, Motivation - ok', 'new', NULL, '2026-04-27 08:36:32', NULL, 0),
(6, 'kgfdz', 'jhgfx2@gmail.com', '9876598999', 'Russia (Legacy Universities)', '', 'Initial interest from LandingAds page.', 'new', NULL, '2026-04-27 10:43:04', NULL, 0),
(7, 'kgfdz', 'jhgfx2@gmail.com', '9876598999', '', '', 'Merit Assessment: Goal - oijh, Motivation - kjhb', 'new', NULL, '2026-04-27 10:43:13', NULL, 0),
(8, 'Akash Tiwari', 'ok@gmail.com', '8909876542', 'Russia (Legacy Universities)', '', 'Initial interest from LandingAds page.', 'new', NULL, '2026-04-28 10:41:02', NULL, 0),
(9, 'Chhotu Kumar', 'chhotukuma36389@gmail.com', '9355621347', '', '', '', 'new', NULL, '2026-04-28 17:46:16', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lead_academic`
--

CREATE TABLE `lead_academic` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `qualification` varchar(150) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `passing_year` varchar(10) NOT NULL,
  `percentage` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_details`
--

CREATE TABLE `lead_details` (
  `lead_id` int(11) NOT NULL,
  `father_name` varchar(150) DEFAULT '',
  `mother_name` varchar(150) DEFAULT '',
  `gender` enum('Male','Female','Other') DEFAULT 'Male',
  `alt_phone` varchar(30) DEFAULT '',
  `dob` date DEFAULT NULL,
  `nationality` varchar(50) DEFAULT 'India',
  `aadhar_number` varchar(30) DEFAULT '',
  `passport_number` varchar(50) DEFAULT '',
  `address` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT '',
  `selected_institute` varchar(150) DEFAULT '',
  `funding_type` varchar(50) DEFAULT 'Self Funded',
  `entrance_exam_name` varchar(100) DEFAULT 'NEET',
  `entrance_score` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_details`
--

INSERT INTO `lead_details` (`lead_id`, `father_name`, `mother_name`, `gender`, `alt_phone`, `dob`, `nationality`, `aadhar_number`, `passport_number`, `address`, `photo_path`, `selected_institute`, `funding_type`, `entrance_exam_name`, `entrance_score`) VALUES
(2, 'john doe', 'john doe', 'Male', '23454324324', NULL, 'India', '2345432343', '34543234543', 'Mandi Bagan\r\nMandi Bagan', '', 'harvards', '', '', ''),
(3, '', '', 'Male', '', NULL, 'India', '', '', NULL, '', '', 'Self Funded', 'NEET', '');

-- --------------------------------------------------------

--
-- Table structure for table `lead_documents`
--

CREATE TABLE `lead_documents` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `doc_name` varchar(150) NOT NULL,
  `doc_url` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_documents`
--

INSERT INTO `lead_documents` (`id`, `lead_id`, `doc_name`, `doc_url`, `uploaded_at`) VALUES
(1, 2, 'adhar card', '/backend/uploads/doc_2_1776928776_9731.png', '2026-04-23 07:19:36'),
(2, 2, 'adhar card', '/backend/uploads/doc_2_1776937058_9495.png', '2026-04-23 09:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `lead_payments`
--

CREATE TABLE `lead_payments` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `notes` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_payments`
--

INSERT INTO `lead_payments` (`id`, `lead_id`, `amount`, `payment_date`, `payment_mode`, `notes`, `created_at`) VALUES
(1, 2, 5000.00, '2026-04-23', 'Bank Transfer (NEFT/RTGS)', '987656789', '2026-04-23 09:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `lead_remarks`
--

CREATE TABLE `lead_remarks` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `mod_id` int(11) NOT NULL,
  `remark` text NOT NULL,
  `status_at_time` enum('new','processing','positive','negative') DEFAULT 'processing',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_remarks`
--

INSERT INTO `lead_remarks` (`id`, `lead_id`, `mod_id`, `remark`, `status_at_time`, `created_at`) VALUES
(1, 2, 1, 'ok', 'processing', '2026-04-23 06:00:45'),
(2, 2, 1, 'ok', 'negative', '2026-04-23 06:00:50'),
(3, 2, 1, 'done', 'positive', '2026-04-23 06:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `mod_users`
--

CREATE TABLE `mod_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `totp_secret` varchar(64) NOT NULL,
  `full_name` varchar(150) DEFAULT '',
  `email` varchar(150) DEFAULT '',
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mod_users`
--

INSERT INTO `mod_users` (`id`, `username`, `password_hash`, `totp_secret`, `full_name`, `email`, `active`, `created_at`) VALUES
(1, 'raga', '$2y$10$lqDgoJCxbFQHWhAVVd9pSORWPIk5G6G96QMrZFEaCOOGBiCar5Xqm', 'L2A27C6KUZOATYVA7QTULAKMQLPMX25X', 'raga', 'ok123@gmail.com', 1, '2026-04-23 05:59:33'),
(2, 'shantanu', '$2y$12$oVSFzyN6oiHdqMj1cM4TEug.JpZj4PUA/IjkqPwryjbf64pSABYI2', 'LSDB37EPX6Q73ODUTM6HCNP3PBYIBEKQ', 'shantanu singh', 'educationopediashantanu@gmail.com', 1, '2026-04-25 11:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `content_key` varchar(100) NOT NULL,
  `content_value` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`id`, `section`, `content_key`, `content_value`, `updated_at`) VALUES
(1, 'hero', 'badge_text', 'Trusted by parents, chosen by students worldwide.', '2026-04-22 12:56:00'),
(2, 'hero', 'title_line1', 'Experience Education', '2026-04-22 12:56:00'),
(3, 'hero', 'title_highlight', 'Across the globe', '2026-04-22 12:56:00'),
(4, 'hero', 'title_line3', 'through educationopedia', '2026-04-22 12:56:00'),
(5, 'hero', 'subtitle', 'Opening doors to globally recognized universities worldwide', '2026-04-22 12:56:00'),
(6, 'hero', 'cta_primary', 'Explore Universities', '2026-04-22 10:04:25'),
(7, 'hero', 'cta_secondary', 'Book Free Counselling', '2026-04-22 10:04:25'),
(8, 'hero', 'search_placeholder', 'Search universities, courses, countries...', '2026-04-22 10:04:25'),
(9, 'hero', 'tags', 'MBBS Abroad,Low Cost MBBS,Study in Russia,NMC Approved,NEET Counselling', '2026-04-22 10:04:25'),
(10, 'stats', 'stat_1_value', '10+', '2026-04-22 10:04:25'),
(11, 'stats', 'stat_1_label', 'Years Experience', '2026-04-22 10:04:25'),
(12, 'stats', 'stat_2_value', '1500+', '2026-04-22 10:04:25'),
(13, 'stats', 'stat_2_label', 'Students Placed', '2026-04-22 10:04:25'),
(14, 'stats', 'stat_3_value', '2000+', '2026-04-22 10:04:25'),
(15, 'stats', 'stat_3_label', 'Partner Universities', '2026-04-22 10:04:25'),
(16, 'stats', 'stat_4_value', '40+', '2026-04-22 10:04:25'),
(17, 'stats', 'stat_4_label', 'Countries', '2026-04-22 10:04:25'),
(18, 'why_us', 'title', 'We Don\'t Just Place Students We Fulfil Family Dreams', '2026-04-24 08:58:54'),
(19, 'why_us', 'subtitle', 'Every parent deserves to see their child in a white coat. We make that happen â€” honestly, affordably, and with care that feels personal because it is.', '2026-04-22 10:04:25'),
(20, 'why_us', 'points', 'Only NMC & WHO Approved Universities Zero Risk\r\nComplete Journey: Application â†’ Visa â†’ Hostel â†’ Graduation\r\nHonest Fees â€” No Hidden Charges, No Surprises\r\nScholarship Guidance That Actually Saves Lakhs\r\n24/7 Student Helpline Even After You Land Abroad\r\nPre-departure Orientation So You\'re Never Alone', '2026-04-24 08:59:05'),
(21, 'cta', 'title', 'Your Child Deserves a White Coat', '2026-04-22 10:04:25'),
(22, 'cta', 'subtitle', 'Don\'t let NEET scores or high fees end the dream. Talk to our experts who have already helped 5,000+ students become doctors abroad â€” 100% free, zero pressure.', '2026-04-22 10:04:25'),
(23, 'cta', 'phone', '+91 85913 42044', '2026-04-22 10:04:25'),
(24, 'footer', 'description', 'India\'s #1 MBBS Abroad Consultancy. Your trusted partner for studying medicine abroad with expert guidance and complete support from admission to graduation.', '2026-04-22 10:04:25'),
(25, 'footer', 'address', 'Office No- 1103, 11th Floor, GDITL Tower, B-08, Block- C, Netaji Subhash Place, Pitampura, New Delhi - 110034', '2026-04-22 10:04:25'),
(26, 'footer', 'phone_1', '+91 85913 42044', '2026-04-22 10:04:25'),
(27, 'footer', 'phone_2', '+91 91391 73733', '2026-04-22 10:04:25'),
(28, 'footer', 'phone_3', '+91 98219 64939', '2026-04-22 10:04:25'),
(29, 'footer', 'phone_4', '+91 95990 44332', '2026-04-22 10:04:25'),
(30, 'footer', 'email_1', 'admissions@educationopedia.com', '2026-04-22 10:04:25'),
(31, 'footer', 'email_2', 'contact@educationopedia.com', '2026-04-22 10:04:25'),
(32, 'footer', 'facebook', '#', '2026-04-22 10:04:25'),
(33, 'footer', 'instagram', '#', '2026-04-22 10:04:25'),
(34, 'footer', 'twitter', '#', '2026-04-22 10:04:25'),
(35, 'footer', 'linkedin', '#', '2026-04-22 10:04:25'),
(36, 'footer', 'youtube', '#', '2026-04-22 10:04:25'),
(37, 'about', 'title', 'About Educationopedia Your Trusted MBBS Abroad Consultancy', '2026-04-24 08:56:07'),
(38, 'about', 'subtitle', 'Helping Indian students achieve their dream of becoming doctors through affordable, transparent, and end-to-end study abroad guidance since 2015.', '2026-04-22 10:04:25'),
(39, 'about', 'story_title', 'Empowering Students to Study MBBS Abroad Since 2015', '2026-04-24 08:56:58'),
(40, 'about', 'story_p1', 'Educationopedia was founded with a simple yet powerful mission â€” to make quality international medical education accessible to every deserving Indian student. Over the past decade, we have guided thousands of families through the complex journey of studying MBBS abroad, turning NEET disappointments into white coat celebrations.', '2026-04-22 10:04:25'),
(41, 'about', 'story_p2', 'Our experienced education counsellors provide personalized, honest guidance at every step â€” from choosing the right NMC & WHO approved university to visa processing, hostel allotment, and post-arrival support in 45+ countries. We believe that geography and finances should never be a barrier to becoming a doctor.', '2026-04-22 10:04:25'),
(42, 'contact', 'title', 'Contact Us', '2026-04-22 10:04:25'),
(43, 'contact', 'subtitle', 'Get free expert counselling for your MBBS abroad journey', '2026-04-22 10:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `site_images`
--

CREATE TABLE `site_images` (
  `id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `image_key` varchar(100) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `alt_text` varchar(255) DEFAULT '',
  `label` varchar(255) DEFAULT '',
  `sort_order` int(11) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_images`
--

INSERT INTO `site_images` (`id`, `section`, `image_key`, `image_path`, `alt_text`, `label`, `sort_order`, `updated_at`) VALUES
(1, 'hero_slides', 'slide-1', '/clgs/slide-1.jpg', 'Students at a top university campus', 'World-Class Universities', 1, '2026-04-22 10:04:25'),
(2, 'hero_slides', 'slide-2', '/clgs/slide-2.jpg', 'Medical students in a lecture hall', 'MBBS Abroad Programs', 2, '2026-04-22 10:04:25'),
(3, 'hero_slides', 'slide-3', '/clgs/slide-3.jpg', 'University campus abroad', 'NMC & WHO Approved', 3, '2026-04-22 10:04:25'),
(4, 'hero_slides', 'slide-4', '/clgs/slide-4.jpg', 'Indian students studying abroad', '5,000+ Dreams Fulfilled', 4, '2026-04-22 10:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `course`, `text`, `rating`, `sort_order`, `created_at`) VALUES
(1, 'Priya Sharma', 'MBBS in Russia', 'My father sold his shop to fund my education. Educationopedia found me a university where the total cost was half of what private colleges in India charge. Today I\'m a practicing doctor â€” Papa\'s sacrifice was worth it.', 5, 1, '2026-04-22 10:04:25'),
(2, 'Rahul Verma', 'MBBS in Kazakhstan', 'I scored just 320 in NEET. Everyone said \'medical nahi hoga.\' Educationopedia showed me a path. Now I\'m in my final year at a WHO-approved university. Never give up on your dream.', 5, 2, '2026-04-22 10:04:25'),
(3, 'Anita Patel', 'MBBS in Georgia', 'As a girl from a small town, studying abroad felt impossible. The team handled everything â€” from documents to hostel. My mother cried happy tears at the airport. Thank you, Educationopedia.', 5, 3, '2026-04-22 10:04:25'),
(4, 'Vikram Singh', 'MBBS in China', 'I was confused between 10 consultancies. Educationopedia was the only one that didn\'t pressure me. They gave honest advice, helped me choose the right university, and even called my parents to reassure them.', 5, 4, '2026-04-22 10:04:25'),
(5, 'Sneha Reddy', 'MBBS in Kyrgyzstan', 'Coming from a middle-class family, the fees were my biggest worry. Educationopedia helped me get a scholarship that reduced my cost by 40%. My parents still can\'t believe it happened.', 5, 5, '2026-04-22 10:04:25'),
(6, 'Arjun Mehta', 'MBBS in Uzbekistan', 'The visa process scared me the most. But the Educationopedia team was with me at every step â€” they even helped me prepare for the embassy interview. I cleared it in one attempt!', 5, 6, '2026-04-22 10:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `rank` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `flag` varchar(10) DEFAULT '',
  `rating` decimal(2,1) DEFAULT 4.5,
  `ranking_text` varchar(255) DEFAULT '',
  `cutoff` varchar(100) DEFAULT '',
  `deadline` varchar(100) DEFAULT '',
  `fees` varchar(50) DEFAULT '',
  `tuition_usd` decimal(10,2) DEFAULT 0.00,
  `tuition_rub` int(11) DEFAULT 0,
  `hostel_usd` decimal(10,2) DEFAULT 0.00,
  `hostel_rub` int(11) DEFAULT 0,
  `medical_rub` int(11) DEFAULT 0,
  `food_rub` int(11) DEFAULT 0,
  `otc_rub` int(11) DEFAULT 0,
  `established_year` varchar(255) DEFAULT '',
  `affiliated_by` varchar(255) DEFAULT '',
  `university_type` varchar(255) DEFAULT '',
  `university_grade` varchar(255) DEFAULT '',
  `world_ranking` varchar(255) DEFAULT '',
  `country_ranking` varchar(255) DEFAULT '',
  `airport_distance` varchar(255) DEFAULT '',
  `who_faimer` varchar(255) DEFAULT '',
  `nmc_ecfmg` varchar(255) DEFAULT '',
  `erasmus` varchar(255) DEFAULT '',
  `wdoms` varchar(255) DEFAULT '',
  `ielts_pte_toefl` varchar(255) DEFAULT '',
  `neet_examination` varchar(255) DEFAULT '',
  `intake_sessions` varchar(255) DEFAULT '',
  `eligibility_criteria` varchar(255) DEFAULT '',
  `course_duration` varchar(255) DEFAULT '',
  `teaching_medium` varchar(255) DEFAULT '',
  `teaching_faculty` varchar(255) DEFAULT '',
  `global_students` varchar(255) DEFAULT '',
  `hostel_location` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `country`, `rank`, `name`, `short_name`, `city`, `flag`, `rating`, `ranking_text`, `cutoff`, `deadline`, `fees`, `tuition_usd`, `tuition_rub`, `hostel_usd`, `hostel_rub`, `medical_rub`, `food_rub`, `otc_rub`, `established_year`, `affiliated_by`, `university_type`, `university_grade`, `world_ranking`, `country_ranking`, `airport_distance`, `who_faimer`, `nmc_ecfmg`, `erasmus`, `wdoms`, `ielts_pte_toefl`, `neet_examination`, `intake_sessions`, `eligibility_criteria`, `course_duration`, `teaching_medium`, `teaching_faculty`, `global_students`, `hostel_location`) VALUES
(50, 'Georgia', 1, 'East West University', 'EWU', 'Tbilisi', '🇬🇪', 4.5, '#25+ in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹3.5L - ₹4.5L', 3900.00, 0, 1500.00, 0, 500, 1500, 2000, '2010', '', 'Private', 'B+', '8000+', '-', '15', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(51, 'Georgia', 2, 'Akaki Tsereteli State University', 'ATSU', 'Kutaisi', '🇬🇪', 4.6, '#11 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹3.5L - ₹4.5L', 4000.00, 0, 1500.00, 0, 500, 1500, 2000, '1930', '', 'Public', 'A', '5000+', 'Top 10', '20', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(52, 'Georgia', 3, 'Batumi Shota Rustaveli State University', 'BSU', 'Batumi', '🇬🇪', 4.7, '#5 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹4.5L - ₹5.5L', 5000.00, 0, 1500.00, 0, 500, 1500, 2000, '1923', '', 'Public', 'A', '4000+', 'Top 10', '7', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(53, 'Georgia', 4, 'Geomedi State University', 'GSU', 'Tbilisi', '🇬🇪', 4.4, '#37 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹4.5L - ₹5.5L', 5500.00, 0, 1500.00, 0, 500, 1500, 2000, '1998', '', 'Private', 'B+', '8000+', '-', '15', 'Yes', 'Yes', 'Limited', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(54, 'Georgia', 5, 'Grigol Robakidze University', 'GRU', 'Tbilisi', '🇬🇪', 4.5, '#16 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹4.5L - ₹5.5L', 5500.00, 0, 1500.00, 0, 500, 1500, 2000, '1992', '', 'Private', 'A', '6000+', 'Top 15', '20', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(55, 'Georgia', 6, 'East European University', 'EEU', 'Tbilisi', '🇬🇪', 4.5, '#28 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹4.5L - ₹5.5L', 5900.00, 0, 1500.00, 0, 500, 1500, 2000, '2012', '', 'Private', 'A', '6000+', 'Top 10', '15', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(56, 'Georgia', 7, 'Georgia National University (SEU)', 'SEU', 'Tbilisi', '🇬🇪', 4.8, '#15 in Georgia', 'NEET 50%+ Required', 'Sep – Oct 2026', '₹5L - ₹6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(57, 'Georgia', 8, 'European University', 'EU', 'Tbilisi', '🇬🇪', 4.7, '#20 in Georgia', 'NEET 50%+ Required', 'Sep – Oct 2026', '₹5L - ₹6L', 5900.00, 0, 1500.00, 0, 500, 1500, 2000, '2012', '', 'Private', 'A', '6000+', 'Top 10', '15', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(58, 'Georgia', 9, 'International Black Sea University', 'IBSU', 'Tbilisi', '🇬🇪', 4.6, '#7 in Georgia', 'NEET 50%+ Required', 'Sep – Oct 2026', '₹5L - ₹6L', 5900.00, 0, 1500.00, 0, 500, 1500, 2000, '1995', '', 'Private', 'A', '5000+', 'Top 10', '25', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(59, 'Georgia', 10, 'Alte University', 'Alte', 'Tbilisi', '🇬🇪', 4.7, '#24 in Georgia', 'NEET 50%+ Required', 'Sep – Oct 2026', '₹5L - ₹6L', 5950.00, 0, 1500.00, 0, 500, 1500, 2000, '2002', '', 'Private', 'A', '6000+', 'Top 10', '15', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(60, 'Georgia', 11, 'Caucasus University', 'CU', 'Tbilisi', '🇬🇪', 4.8, '#3 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹5L - ₹6L', 6000.00, 0, 1500.00, 0, 500, 1500, 2000, '1998', '', 'Private', 'A+', '4000+', 'Top 5', '20', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(61, 'Georgia', 12, 'The University of Georgia', 'UG', 'Tbilisi', '🇬🇪', 4.9, '#4 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹5L - ₹6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(62, 'Georgia', 13, 'Georgian American University', 'GAU', 'Tbilisi', '🇬🇪', 4.7, '#18 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹5L - ₹6L', 6000.00, 0, 1500.00, 0, 500, 1500, 2000, '2001', '', 'Private', 'B+', '7000+', '-', '18', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(63, 'Georgia', 14, 'Caucasus International University', 'CIU', 'Tbilisi', '🇬🇪', 4.6, '#22 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹5L - ₹6L', 6000.00, 0, 1500.00, 0, 500, 1500, 2000, '1995', '', 'Private', 'A', '6000+', 'Top 10', '10', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(64, 'Georgia', 15, 'Ilia State University', 'ISU', 'Tbilisi', '🇬🇪', 4.9, '#2 in Georgia', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹5.5L - ₹6.5L', 6200.00, 0, 1500.00, 0, 500, 1500, 2000, '2006', '', 'Public', 'A+', '3000+', 'Top 5', '15', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(65, 'Georgia', 16, 'New Vision University', 'NVU', 'Tbilisi', '🇬🇪', 4.7, '#14 in Georgia', 'NEET 50%+ Required', 'Sep 2026', '₹6L - ₹7L', 7000.00, 0, 1500.00, 0, 500, 1500, 2000, '2013', '', 'Private', 'A', '5000+', 'Top 10', '15', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(66, 'Georgia', 17, 'Petre Shotadze Tbilisi Medical Academy', 'TMA', 'Tbilisi', '🇬🇪', 4.8, '#19 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹6L - ₹7L', 8000.00, 0, 1500.00, 0, 500, 1500, 2600, '1918', '', 'Public', 'A+', '4000+', 'Top 5', '20', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(67, 'Georgia', 18, 'Tbilisi State Medical University', 'TSMU', 'Tbilisi', '🇬🇪', 5.0, '#1 in Georgia', 'NEET 50%+ Required', 'Jul – Oct 2026', '₹7L - ₹8L', 8000.00, 0, 1500.00, 0, 500, 1500, 2600, '1918', '', 'Public', 'A+', '4000+', 'Top 5', '20', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'High', 'Yes'),
(68, 'Georgia', 19, 'David Tvildiani Medical University', 'DTMU', 'Tbilisi', '🇬🇪', 4.9, '#10 in Georgia', 'NEET 50%+ Required', 'Aug – Oct 2026', '₹7L - ₹8L', 8000.00, 0, 1500.00, 0, 500, 1500, 2000, '1989', '', 'Private', 'A+', '4000+', 'Top 5', '25', 'Yes', 'Yes', 'Yes', '', 'No', 'Yes', 'Feb/Sep', '50% PCB', '6 Years', 'English', '', 'Moderate', 'Yes'),
(69, 'Kazakhstan', 1, 'Al-Farabi Kazakh National Univ', 'KazNU', 'Almaty', '🇰🇿', 4.9, '#1 in Kazakhstan', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(70, 'Kazakhstan', 2, 'Asfendiyarov National Medical Univ', 'KazNMU', 'Almaty', '🇰🇿', 4.8, '#5 in Kazakhstan', 'NEET 50%+ Required', 'Jul – Aug 2026', '₹5.5L - ₹6.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(71, 'Kazakhstan', 3, 'Semey Medical University', 'SMU', 'Semey', '🇰🇿', 4.7, '#12 in Kazakhstan', 'NEET 50%+ Required', 'Jul – Aug 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(72, 'Kazakhstan', 4, 'South Kazakh Medical Academy', 'SKMA', 'Shymkent', '🇰🇿', 4.6, '#18 in Kazakhstan', 'NEET 50%+ Required', 'Aug 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(73, 'Kazakhstan', 5, 'West Kazakh Marat Ospanov Univ', 'WKMU', 'Aktobe', '🇰🇿', 4.5, '#41 in Kazakhstan', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(74, 'Kyrgyzstan', 1, 'Osh State University', 'OshSU', 'Osh', '🇰🇬', 4.8, '#3 in Kyrgyzstan', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(75, 'Kyrgyzstan', 2, 'Jalal-Abad State University', 'JASU', 'Jalal-Abad', '🇰🇬', 4.6, '#21 in Kyrgyzstan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(76, 'Kyrgyzstan', 3, 'Central Asian Intl Medical Univ', 'CAIMU', 'Jalal-Abad', '🇰🇬', 4.5, '#23 in Kyrgyzstan', 'NEET 50%+ Required', 'Jul – Aug 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(77, 'Kyrgyzstan', 4, 'Osh Intl Medical University', 'OIMU', 'Osh', '🇰🇬', 4.5, '#10 (Medical) in Kyrgyzstan', 'NEET 50%+ Required', 'Jul – Aug 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(78, 'Kyrgyzstan', 5, 'Jalal-Abad Intl University', 'JAIU', 'Jalal-Abad', '🇰🇬', 4.4, '#37 in Kyrgyzstan', 'NEET 50%+ Required', 'Jul 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(79, 'Iran', 1, 'Tehran University of Medical Sciences', 'TUMS', 'Tehran', '🇮🇷', 4.9, '#2 in Iran', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(80, 'Iran', 2, 'Shahid Beheshti Univ of Med Sciences', 'SBMU', 'Tehran', '🇮🇷', 4.8, '#5 in Iran', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(81, 'Iran', 3, 'Shiraz University of Medical Sciences', 'SUMS', 'Shiraz', '🇮🇷', 4.7, '#13 in Iran', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(82, 'Iran', 4, 'Isfahan University of Medical Sciences', 'IUMS', 'Isfahan', '🇮🇷', 4.6, '#15 in Iran', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(83, 'Iran', 5, 'Islamic Azad University (Med Sci)', 'IAU', 'Tehran', '🇮🇷', 4.5, '#23 in Iran', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹2.5L - ₹3.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(84, 'Iran', 6, 'Iran University of Medical Sciences', 'IUMS', 'Tehran', '🇮🇷', 4.5, '#25 in Iran', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹2.5L - ₹3.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(85, 'Bangladesh', 1, 'Dhaka Medical College (Govt)', 'DMC', 'Dhaka', '🇧🇩', 4.9, '#1 in Bangladesh', 'NEET 50%+ Required', 'Nov – Dec 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(86, 'Bangladesh', 2, 'Jahurul Islam Medical College', 'JIMC', 'Kishoreganj', '🇧🇩', 4.8, '#2 (Private)', 'NEET 50%+ Required', 'Nov – Dec 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(87, 'Bangladesh', 3, 'Bangladesh Medical College', 'BMC', 'Dhaka', '🇧🇩', 4.7, '#3 in Bangladesh', 'NEET 50%+ Required', 'Nov – Dec 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(88, 'Bangladesh', 4, 'Enam Medical College', 'EMC', 'Savar', '🇧🇩', 4.6, '#10 (Private)', 'NEET 50%+ Required', 'Nov – Dec 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(89, 'Bangladesh', 5, 'Community Based Medical College', 'CBMC', 'Mymensingh', '🇧🇩', 4.5, '#16 in Bangladesh', 'NEET 50%+ Required', 'Nov – Dec 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(90, 'Bangladesh', 6, 'Dhaka National Medical College', 'DNMC', 'Dhaka', '🇧🇩', 4.4, '#49 in Bangladesh', 'NEET 50%+ Required', 'Nov – Dec 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(91, 'Bangladesh', 7, 'Anwer Khan Modern Medical College', 'AKMMC', 'Dhaka', '🇧🇩', 4.3, '#114 in Bangladesh', 'NEET 50%+ Required', 'Nov – Dec 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(92, 'Nepal', 1, 'Institute of Medicine (IOM)', 'IOM', 'Kathmandu', '🇳🇵', 5.0, '#1 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹11L - ₹12L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(93, 'Nepal', 2, 'Kathmandu Medical College (KMC)', 'KMC', 'Kathmandu', '🇳🇵', 4.8, '#3 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹10L - ₹11L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(94, 'Nepal', 3, 'B.P. Koirala Institute (BPKIHS)', 'BPKIHS', 'Dharan', '🇳🇵', 4.7, '#8 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹11L - ₹12L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(95, 'Nepal', 4, 'Manipal College of Medical Sciences', 'MCOMS', 'Pokhara', '🇳🇵', 4.6, '#9 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹11L - ₹13L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(96, 'Nepal', 5, 'Nepal Medical College (NMC)', 'NMC', 'Kathmandu', '🇳🇵', 4.6, '#10 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹10L - ₹11L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(97, 'Nepal', 6, 'College of Medical Sciences (CMS)', 'CMS', 'Bharatpur', '🇳🇵', 4.5, '#18 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹9L - ₹10L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(98, 'Nepal', 7, 'Lumbini Medical College', 'LMC', 'Palpa', '🇳🇵', 4.4, '#20 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹9L - ₹10L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(99, 'Nepal', 8, 'KIST Medical College', 'KIST', 'Lalitpur', '🇳🇵', 4.3, '#25 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹10L - ₹11L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(100, 'Nepal', 9, 'Birat Medical College', 'BMC', 'Biratnagar', '🇳🇵', 4.2, '#35 in Nepal', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹9L - ₹10L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(101, 'China', 1, 'Fudan University', 'Fudan', 'Shanghai', '🇨🇳', 4.9, '#3 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹8.5L - ₹9.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(102, 'China', 2, 'Zhejiang University', 'ZJU', 'Hangzhou', '🇨🇳', 4.8, '#4 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹5L - ₹6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(103, 'China', 3, 'Sun Yat-Sen University', 'SYSU', 'Guangzhou', '🇨🇳', 4.8, '#7 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹5.5L - ₹6.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(104, 'China', 4, 'Wuhan University', 'WHU', 'Wuhan', '🇨🇳', 4.7, '#9 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4.5L - ₹5.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(105, 'China', 5, 'Huazhong Univ of Sci & Tech', 'HUST', 'Wuhan', '🇨🇳', 4.7, '#10 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4.5L - ₹5.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(106, 'China', 6, 'Xi\'an Jiaotong University', 'XJTU', 'Xi\'an', '🇨🇳', 4.6, '#11 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4.5L - ₹5.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(107, 'China', 7, 'Tongji University', 'Tongji', 'Shanghai', '🇨🇳', 4.6, '#14 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹5L - ₹6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(108, 'China', 8, 'Sichuan University', 'SCU', 'Chengdu', '🇨🇳', 4.5, '#15 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(109, 'China', 9, 'Southeast University', 'SEU', 'Nanjing', '🇨🇳', 4.5, '#16 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(110, 'China', 10, 'Shandong University', 'SDU', 'Jinan', '🇨🇳', 4.5, '#20 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹5L - ₹6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(111, 'China', 11, 'Jilin University', 'JLU', 'Changchun', '🇨🇳', 4.4, '#21 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(112, 'China', 12, 'Xiamen University', 'XMU', 'Xiamen', '🇨🇳', 4.4, '#25 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(113, 'China', 13, 'Nanjing Medical University', 'NMU', 'Nanjing', '🇨🇳', 4.4, '#26 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(114, 'China', 14, 'Tianjin Medical University', 'TMU', 'Tianjin', '🇨🇳', 4.3, '#30 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹5.5L - ₹6.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(115, 'China', 15, 'Soochow University', 'SU', 'Suzhou', '🇨🇳', 4.3, '#32 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(116, 'China', 16, 'Capital Medical University', 'CMU', 'Beijing', '🇨🇳', 4.3, '#35 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4.5L - ₹5.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(117, 'China', 17, 'Zhengzhou University', 'ZZU', 'Zhengzhou', '🇨🇳', 4.2, '#42 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(118, 'China', 18, 'Jiangsu University', 'JSU', 'Zhenjiang', '🇨🇳', 4.2, '#45 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(119, 'China', 19, 'Jinan University', 'JNU', 'Guangzhou', '🇨🇳', 4.2, '#48 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(120, 'China', 20, 'Southern Medical University', 'SMU', 'Guangzhou', '🇨🇳', 4.2, '#65 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹5L - ₹6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(121, 'China', 21, 'Yangzhou University', 'YZU', 'Yangzhou', '🇨🇳', 4.1, '#70 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(122, 'China', 22, 'Wenzhou Medical University', 'WMU', 'Wenzhou', '🇨🇳', 4.1, '#72 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(123, 'China', 23, 'China Medical University', 'CMU', 'Shenyang', '🇨🇳', 4.1, '#75 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4.5L - ₹5.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(124, 'China', 24, 'Harbin Medical University', 'HMU', 'Harbin', '🇨🇳', 4.1, '#80 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(125, 'China', 25, 'Ningbo University', 'NBU', 'Ningbo', '🇨🇳', 4.0, '#84 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(126, 'China', 26, 'Qingdao University', 'QDU', 'Qingdao', '🇨🇳', 4.0, '#85 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(127, 'China', 27, 'Dalian Medical University', 'DMU', 'Dalian', '🇨🇳', 4.0, '#100+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹5L - ₹6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(128, 'China', 28, 'Fujian Medical University', 'FMU', 'Fuzhou', '🇨🇳', 4.0, '#100+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(129, 'China', 29, 'Nantong University', 'NTU', 'Nantong', '🇨🇳', 4.0, '#110+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(130, 'China', 30, 'Shantou University', 'STU', 'Shantou', '🇨🇳', 4.0, '#120 in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹7L - ₹8L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(131, 'China', 31, 'Chongqing Medical University', 'CQMU', 'Chongqing', '🇨🇳', 3.9, '#120+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(132, 'China', 32, 'Guangzhou Medical University', 'GMU', 'Guangzhou', '🇨🇳', 3.9, '#130+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(133, 'China', 33, 'Anhui Medical University', 'AHMU', 'Hefei', '🇨🇳', 3.9, '#140+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(134, 'China', 34, 'Guangxi Medical University', 'GXMU', 'Nanning', '🇨🇳', 3.9, '#150+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(135, 'China', 35, 'China Three Gorges University', 'CTGU', 'Yichang', '🇨🇳', 3.9, '#150+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹2.5L - ₹3.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(136, 'China', 36, 'Hebei Medical University', 'HEBMU', 'Shijiazhuang', '🇨🇳', 3.8, '#160+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(137, 'China', 37, 'Kunming Medical University', 'KMMU', 'Kunming', '🇨🇳', 3.8, '#170+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(138, 'China', 38, 'Shihezi University', 'SHZU', 'Shihezi', '🇨🇳', 3.8, '#180+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(139, 'China', 39, 'Xuzhou Medical University', 'XZMU', 'Xuzhou', '🇨🇳', 3.8, '#190+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(140, 'China', 40, 'Xinjiang Medical University', 'XJMU', 'Urumqi', '🇨🇳', 3.7, '#200+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(141, 'China', 41, 'Southwest Medical University', 'SWMU', 'Luzhou', '🇨🇳', 3.7, '#220+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(142, 'China', 42, 'Jinzhou Medical University', 'JZMU', 'Jinzhou', '🇨🇳', 3.7, '#250+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(143, 'China', 43, 'Ningxia Medical University', 'NXMU', 'Yinchuan', '🇨🇳', 3.7, '#280+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(144, 'China', 44, 'Beihua University', 'Beihua', 'Jilin', '🇨🇳', 3.6, '#300+ in China', 'NEET 50%+ Required', 'Mar – Jun 2026', '₹2.5L - ₹3.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(145, 'Uzbekistan', 1, 'Tashkent Medical Academy', 'TMA', 'Tashkent', '🇺🇿', 4.8, '#1 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(146, 'Uzbekistan', 2, 'Samarkand State Medical Univ', 'SSMU', 'Samarkand', '🇺🇿', 4.7, '#5 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(147, 'Uzbekistan', 3, 'Bukhara State Medical Institute', 'BSMI', 'Bukhara', '🇺🇿', 4.6, '#8 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(148, 'Uzbekistan', 4, 'Tashkent State Dental Institute', 'TSDI', 'Tashkent', '🇺🇿', 4.5, '#10 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3.5L - ₹4.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(149, 'Uzbekistan', 5, 'Andijan State Medical Institute', 'ASMI', 'Andijan', '🇺🇿', 4.4, '#14 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(150, 'Uzbekistan', 6, 'Tashkent Pediatric Med. Inst.', 'TPMI', 'Tashkent', '🇺🇿', 4.4, '#15 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(151, 'Uzbekistan', 7, 'Fergana Medical Institute', 'FMI', 'Fergana', '🇺🇿', 4.3, '#22 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(152, 'Uzbekistan', 8, 'Urgench Branch (TMA)', 'UBTMA', 'Urgench', '🇺🇿', 4.3, '#25 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹3L - ₹4L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(153, 'Uzbekistan', 9, 'Navoi State University', 'Navoi', 'Navoi', '🇺🇿', 4.2, '#54 in Uzbekistan', 'NEET 50%+ Required', 'Aug – Sep 2026', '₹2.5L - ₹3.5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(154, 'Lithuania', 1, 'Vilnius University', 'VU', 'Vilnius', '🇱🇹', 4.9, '#1 in Lithuania', 'No BD/NP/PK', 'Aug – Sep 2026', '₹5.4L - ₹5.6L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(155, 'Lithuania', 2, 'SMK College of Applied Sciences', 'SMK', 'Vilnius', '🇱🇹', 4.7, 'Top Applied Sci', '50%+ Required', 'Aug – Sep 2026', '₹3.9L - ₹4.1L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(156, 'Lithuania', 3, 'SMK College of Applied Sciences', 'SMK', 'Klaipeda', '🇱🇹', 4.6, 'Coastal Campus', '50%+ Required', 'Aug – Sep 2026', '₹3.6L - ₹3.8L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(157, 'UK', 1, 'Hull York Medical School', 'HYMS', 'Hull', '🇬🇧', 4.9, '#3 in UK', 'High Academics', 'Jan – Mar 2026', '₹52L - ₹53L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(158, 'UK', 2, 'Newcastle University', 'NCL', 'Newcastle', '🇬🇧', 4.8, '#29 in UK', 'Russell Group', 'Jan – Mar 2026', '₹49L - ₹50L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(159, 'UK', 3, 'University of East Anglia', 'UEA', 'Norwich', '🇬🇧', 4.8, '#16 in UK', 'High Academics', 'Jan – Mar 2026', '₹47L - ₹48L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(160, 'UK', 4, 'Brunel University London', 'Brunel', 'London', '🇬🇧', 4.7, 'Top 40 UK', 'High Academics', 'Jan – Mar 2026', '₹51L - ₹52L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(161, 'UK', 5, 'St. Mary\'s University Twickenham', 'St Mary\'s', 'London', '🇬🇧', 4.6, '#73 in UK', 'High Academics', 'Jan – Mar 2026', '₹50L - ₹51L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(162, 'UK', 6, 'University of Hertfordshire', 'Herts', 'Hatfield', '🇬🇧', 4.6, 'Top 50 UK', 'High Academics', 'Jan – Mar 2026', '₹44L - ₹45L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(163, 'UK', 7, 'University of Central Lancashire', 'UCLan', 'Preston', '🇬🇧', 4.5, '#36 in UK', 'High Acceptance', 'Jan – Mar 2026', '₹33L - ₹51L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(164, 'UK', 8, 'Ulster University', 'Ulster', 'Belfast', '🇬🇧', 4.5, '#49 in UK', 'Foundation', 'Jan – Mar 2026', '₹26L - ₹27L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(165, 'Russia', 1, 'Yaroslav-the-Wise Novgorod State University', 'NovSU', 'Veliky Novgorod', '🇷🇺', 4.6, '#62 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹3L - ₹4L', 3733.33, 280000, 666.67, 50000, 25000, 135000, 2000, '1993', 'Ministry of Education', 'Government', 'A', '~4000', '~120', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '3000+', 'Campus'),
(166, 'Russia', 2, 'Pskov State University', 'PskovSU', 'Pskov', '🇷🇺', 4.4, '#209 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹4L - ₹5L', 4500.00, 4500, 0.00, 0, 25000, 135000, 2000, '2010', 'Ministry of Education, Russia', 'Government', 'A', '~5000+', '~150', '5 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2000+', 'Campus'),
(167, 'Russia', 3, 'Voronezh State Medical University', 'VGMU', 'Voronezh', '🇷🇺', 4.5, '#212 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹4L - ₹5L', 5000.00, 5000, 0.00, 0, 25000, 135000, 2000, '1918', 'Ministry of Health', 'Government', 'A+', '~3000-4000', '~100', '18 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '3000+', 'Campus'),
(168, 'Russia', 4, 'Ingush State University', 'IngSU', 'Magas', '🇷🇺', 4.3, '#240+ in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹4L - ₹5L', 5700.00, 5700, 0.00, 0, 25000, 135000, 2000, '1994', 'Ministry of Education', 'Government', 'A', '~7000+', '~250', '20 km', 'Recognised', 'Approved', 'Limited', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Russian', '500+', 'Campus'),
(169, 'Russia', 5, 'Tula State University', 'TulSU', 'Tula', '🇷🇺', 4.4, '#134 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹4L - ₹5L', 5000.00, 5000, 0.00, 0, 25000, 135000, 2000, '1930', 'Ministry of Education', 'Government', 'A', '~4000-5000', '~120', '180 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '1500+', 'Campus'),
(170, 'Russia', 6, 'Perm State Medical University', 'PSMU', 'Perm', '🇷🇺', 4.5, '#180+ in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹4L - ₹5L', 6500.00, 6500, 0.00, 0, 25000, 135000, 2000, '1916', 'Ministry of Health', 'Government', 'A+', '~3000-4000', '~100', '20 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2000+', 'Campus'),
(171, 'Russia', 7, 'Chuvash State Medical University', 'ChSMU', 'Cheboksary', '🇷🇺', 4.5, '#150+ in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹5L - ₹6L', 6800.00, 6800, 0.00, 0, 25000, 135000, 2000, '1967', 'Ministry of Education', 'Government', 'A', '~5000+', '~150', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '1500+', 'Campus'),
(172, 'Russia', 8, 'Orenburg State Medical University', 'OrenSMU', 'Orenburg', '🇷🇺', 4.6, '#120+ in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹5L - ₹6L', 6500.00, 6500, 0.00, 0, 25000, 135000, 2000, '1944', 'Ministry of Health', 'Government', 'A+', '~3000-4000', '~100', '25 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2000+', 'Campus'),
(173, 'Russia', 9, 'Mari State University', 'MarSU', 'Yoshkar-Ola', '🇷🇺', 4.4, '#140+ in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹5L - ₹6L', 6500.00, 6500, 0.00, 0, 25000, 135000, 2000, '1972', 'Ministry of Education', 'Government', 'A', '~4000-5000', '~120', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2500+', 'Campus'),
(174, 'Russia', 10, 'Kursk State Medical University', 'KSMU', 'Kursk', '🇷🇺', 4.7, '#10 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹5L - ₹6L', 6280.00, 6280, 0.00, 0, 25000, 135000, 2000, '1935', 'Ministry of Health', 'Government', 'A+', '~2500-3500', '~80', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '4000+', 'Campus'),
(175, 'Russia', 11, 'Izhevsk State Medical Academy', 'IGMA', 'Izhevsk', '🇷🇺', 4.5, '#250+ in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹5L - ₹6L', 6400.00, 6400, 0.00, 0, 25000, 135000, 2000, '1933', 'Ministry of Health', 'Government', 'A', '~6000+', '~200', '15 km', 'Recognised', 'Approved', 'Limited', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '1200+', 'Campus'),
(176, 'Russia', 12, 'Synergy University (Moscow)', 'Synergy', 'Moscow', '🇷🇺', 4.5, '#110 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹6L - ₹7L', 7000.00, 7000, 2000.00, 150000, 25000, 135000, 2000, '1995', 'Ministry of Education', 'Private', 'A', '~6000+', '~200', '25 km', 'Recognised', 'Check', 'Limited', 'Listed', 'Not Required', 'Required', 'September/February', '50% PCB', '6 Years', 'English', 'Mixed', '5000+', 'Campus'),
(177, 'Russia', 26, 'St Petersburg State Pediatric Medical University', 'SPBPMU', 'St. Petersburg', '🇷🇺', 4.9, '#115 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹3L - ₹4L', 6826.67, 512000, 426.67, 32000, 25000, 135000, 2000, '1925', 'Ministry of Health', 'Government', 'A+', '~3000-4000', 'Top 100', '20 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '3000+', 'Campus'),
(178, 'Russia', 27, 'Ulyanovsk State University', 'USU', 'Ulyanovsk', '🇷🇺', 4.6, '#125 in Russia', 'NEET 50%+ Required', 'Jul 2026', '₹3L - ₹4L', 4826.67, 362000, 426.67, 32000, 25000, 135000, 2000, '1988', 'Ministry of Education', 'Government', 'A', '~4000-5000', '~120', '15 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2000+', 'Campus'),
(179, 'Russia', 28, 'Yaroslavl State Medical University', 'YSMU', 'Yaroslavl', '🇷🇺', 4.7, '#145 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹3L - ₹4L', 3733.33, 280000, 666.67, 50000, 25000, 135000, 2000, '1944', 'Ministry of Health', 'Government', 'A', '~6000+', '~200', '270 km', 'Recognised', 'Approved', 'Limited', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Russian', '1000+', 'Campus'),
(180, 'Russia', 29, 'Tyumen State Medical University', 'TSMU', 'Tyumen', '🇷🇺', 4.6, '#170 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 5720.00, 429000, 240.00, 18000, 25000, 135000, 2000, '1963', 'Ministry of Health', 'Government', 'A+', '~3000-4000', '~120', '13 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '5000+', 'Campus'),
(181, 'Russia', 30, 'Ryazan State Medical University', 'RZNSMU', 'Ryazan', '🇷🇺', 4.8, '#105 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 5520.00, 414000, 533.33, 40000, 25000, 135000, 2000, '1943', 'Ministry of Health', 'Government', 'A+', '~3000-4000', '~100', '200 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2500+', 'Campus'),
(182, 'Russia', 31, 'Siberian State Medical University', 'SSMU', 'Tomsk', '🇷🇺', 4.8, '#17 in Russia', 'NEET 50%+ Required', 'Jul 2026', '₹3L - ₹4L', 5133.33, 385000, 1066.67, 80000, 25000, 135000, 2000, '1888', 'Ministry of Health', 'Government', 'A++', '~2000-3000', 'Top 50', '20 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '5000+', 'Campus'),
(183, 'Russia', 32, 'Dagestan State Medical University', 'DSMU', 'Makhachkala', '🇷🇺', 4.4, '#190 in Russia', 'NEET 50%+ Required', 'Jul 2026', '₹4L - ₹5L', 5600.00, 420000, 400.00, 30000, 25000, 135000, 2000, '1932', 'Ministry of Health', 'Government', 'A', '~7000+', '~250', '20 km', 'Recognised', 'Approved', 'Limited', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Russian', '3000+', 'Campus'),
(184, 'Russia', 33, 'Kuban State Medical University', 'KSMA', 'Krasnodar', '🇷🇺', 4.7, '#118 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 6440.00, 483000, 213.33, 16000, 25000, 135000, 2000, '1920', 'Ministry of Health', 'Government', 'A+', '~6500', '~200', '15 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '3000+', 'Campus'),
(185, 'Russia', 34, 'Kadyrov Chechen State University', 'CHSU', 'Grozny', '🇷🇺', 4.4, '#165 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(186, 'Russia', 35, 'Bashkir State Medical University', 'BGMU', 'Ufa', '🇷🇺', 4.8, '#7 in Russia', 'NEET 50%+ Required', 'Jul 2026', '₹4L - ₹5L', 5320.00, 399000, 200.00, 15000, 25000, 135000, 2000, '1932', 'Ministry of Health', 'Government', 'A+', '~3000-4000', '~100', '25 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '8000+', 'Campus'),
(187, 'Russia', 36, 'Pacific State Medical University', 'PSMU', 'Vladivostok', '🇷🇺', 4.6, '#200+ in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 6400.00, 480000, 400.00, 30000, 30000, 135000, 2000, '1958', 'Ministry of Health', 'Government', 'A', '~5000+', '~150', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2000+', 'Campus'),
(188, 'Russia', 37, 'Tver State Medical University', 'TSMU', 'Tver', '🇷🇺', 4.8, '#95 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 5733.33, 430000, 1333.33, 100000, 25000, 135000, 2000, '1936', 'Ministry of Health', 'Government', 'A', '~6000+', '~200', '170 km', 'Recognised', 'Approved', 'Limited', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '1500+', 'Campus'),
(189, 'Russia', 38, 'Volgograd State Medical University', 'VolgSMU', 'Volgograd', '🇷🇺', 4.8, '#88 in Russia', 'NEET 50%+ Required', 'Jul 2026', '₹4L - ₹5L', 6466.67, 485000, 800.00, 60000, 30000, 135000, 2000, '1935', 'Ministry of Health', 'Government', 'A+', '~2500-3500', '~80', '15 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '3500+', 'Campus'),
(190, 'Russia', 39, 'North Western State Medical University', 'NWSMU', 'St. Petersburg', '🇷🇺', 4.9, '#45 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 7340.00, 550500, 613.33, 46000, 25000, 135000, 2000, '2011', 'Ministry of Health', 'Government', 'A+', '~3000-4000', 'Top 100', '20 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '4000+', 'Campus'),
(191, 'Russia', 40, 'Far Eastern Federal University', 'FEFU', 'Vladivostok', '🇷🇺', 4.9, '#25 in Russia', 'NEET 50%+ Required', 'Jul 2026', '₹4L - ₹5L', 6600.00, 495000, 533.33, 40000, 25000, 135000, 2000, '1899', 'Ministry of Education', 'Government', 'A++', '~1000', 'Top 10', '50 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '20000+', 'Campus'),
(192, 'Russia', 41, 'Privolzhsky Research Medical University', 'PRMU', 'Nizhny Novgorod', '🇷🇺', 4.8, '#68 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 6133.33, 460000, 1066.67, 80000, 25000, 135000, 2000, '1920', 'Ministry of Health', 'Government', 'A+', '~3000-4000', '~100', '25 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '3000+', 'Campus'),
(193, 'Russia', 42, 'MEPhI Obninsk', 'MEPhI', 'Obninsk', '🇷🇺', 4.9, '#5 (MEPhI Group)', 'NEET 50%+ Required', 'Sep 2026', '₹5L - ₹6L', 6800.00, 510000, 186.67, 14000, 25000, 135000, 2000, '1953', 'National Research Nuclear University', 'Government', 'A+', '~2000', 'Top 50', '110 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '1500+', 'Campus'),
(194, 'Russia', 43, 'NP Ogarev Mordovia State University', 'MSU', 'Saransk', '🇷🇺', 4.7, '#82 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹4L - ₹5L', 5480.00, 411000, 200.00, 15000, 25000, 135000, 2000, '1931', 'Ministry of Education', 'Government', 'A', '~4000-5000', '~120', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '3000+', 'Campus'),
(195, 'Russia', 44, 'Kazan Federal University', 'KFU', 'Kazan', '🇷🇺', 4.9, '#8 in Russia', 'NEET 50%+ Required', 'Jul 2026', '₹5L - ₹6L', 8800.00, 660000, 333.33, 25000, 25000, 135000, 2000, '1804', 'Ministry of Education', 'Government', 'A++', '~400-600', 'Top 10', '25 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '40000+', 'Campus'),
(196, 'Russia', 45, 'Novosibirsk State University', 'NSU', 'Novosibirsk', '🇷🇺', 5.0, '#12 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹6L - ₹7L', 8666.67, 650000, 266.67, 20000, 25000, 135000, 2000, '1959', 'Ministry of Education', 'Government', 'A++', '~300', 'Top 5', '20 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '8000+', 'Campus'),
(197, 'Russia', 46, 'Kazan State Medical University', 'KSMU', 'Kazan', '🇷🇺', 4.9, '#220 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹6L - ₹7L', 8000.00, 600000, 1333.33, 100000, 25000, 135000, 2000, '1814', 'Ministry of Health', 'Government', 'A+', '~3500', '~100', '25 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '6000+', 'Campus'),
(198, 'Russia', 47, 'MEPhI Moscow', 'MEPhI', 'Moscow', '🇷🇺', 5.0, '#5 in Russia', 'NEET 50%+ Required', 'Sep 2026', '₹6L - ₹7L', 8764.80, 657360, 266.67, 20000, 75000, 135000, 2000, '1942', 'National Research Nuclear University', 'Government', 'A++', '~300-500', 'Top 10', '30 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '7000+', 'Campus'),
(199, 'Russia', 48, 'Peoples Friendship RUDN', 'RUDN', 'Moscow', '🇷🇺', 4.9, '#9 in Russia', 'NEET 50%+ Required', 'Aug 2026', '₹7L - ₹8L', 10000.00, 750000, 1120.00, 84000, 25000, 135000, 2000, '1960', 'Ministry of Education', 'Government', 'A++', '~300-400', 'Top 10', '25 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '30000+', 'Campus'),
(200, 'Russia', 49, 'First Moscow State Medical University', 'Sechenov', 'Moscow', '🇷🇺', 5.0, '#11 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹13L - ₹14L', 17333.33, 1300000, 2666.67, 200000, 22500, 135000, 2000, '1758', 'Ministry of Health', 'Government', 'A++', '~500', 'Top 5', '30 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '20000+', 'Campus'),
(201, 'Russia', 50, 'Yaroslav-the-Wise Novgorod State University', 'NovSU', 'Veliky Novgorod', '🇷🇺', 4.6, '#62 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹3L - ₹4L', 3733.33, 280000, 666.67, 50000, 25000, 135000, 2000, '1993', 'Ministry of Education', 'Government', 'A', '~4000', '~120', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '3000+', 'Campus'),
(202, 'Russia', 51, 'Mari State University', 'MarSU', 'Yoshkar-Ola', '🇷🇺', 4.4, '#265 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹5L - ₹6L', 6500.00, 6500, 0.00, 0, 25000, 135000, 2000, '1972', 'Ministry of Education', 'Government', 'A', '~4000-5000', '~120', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'Mixed', '2500+', 'Campus'),
(203, 'Russia', 52, 'Kursk State Medical University', 'KSMU', 'Kursk', '🇷🇺', 4.7, '#141 in Russia', 'NEET 50%+ Required', 'Jul – Sep 2026', '₹5L - ₹6L', 6280.00, 6280, 0.00, 0, 25000, 135000, 2000, '1935', 'Ministry of Health', 'Government', 'A+', '~2500-3500', '~80', '10 km', 'Recognised', 'Approved', 'Yes', 'Listed', 'Not Required', 'Required', 'September', '50% PCB', '6 Years', 'English', 'International', '4000+', 'Campus'),
(204, 'Malaysia', 1, 'Taylor\'s University', 'Taylor', 'Subang Jaya', '🇲🇾', 4.9, '#1 in Malaysia', 'NEET 50%+ Required', 'Feb – Apr 2026', '₹21.7 L - ₹21.8 L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(205, 'Malta', 62, 'Queen Mary University of London, Malta', 'QMUL', 'Gozo', '🇲🇹', 4.9, '#62 in Malta', 'NEET 50%+ Required', 'Jan – Mar 2026', '₹35.5 L - ₹36 L', 0.00, 0, 0.00, 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_candidates`
--
ALTER TABLE `exam_candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_responses`
--
ALTER TABLE `exam_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_id` (`candidate_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_assigned` (`assigned_to`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_reminder` (`reminder_at`);

--
-- Indexes for table `lead_academic`
--
ALTER TABLE `lead_academic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `lead_details`
--
ALTER TABLE `lead_details`
  ADD PRIMARY KEY (`lead_id`);

--
-- Indexes for table `lead_documents`
--
ALTER TABLE `lead_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `lead_payments`
--
ALTER TABLE `lead_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Indexes for table `lead_remarks`
--
ALTER TABLE `lead_remarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lead` (`lead_id`);

--
-- Indexes for table `mod_users`
--
ALTER TABLE `mod_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section`,`content_key`);

--
-- Indexes for table `site_images`
--
ALTER TABLE `site_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_section` (`section`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_country` (`country`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_candidates`
--
ALTER TABLE `exam_candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `exam_responses`
--
ALTER TABLE `exam_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lead_academic`
--
ALTER TABLE `lead_academic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_documents`
--
ALTER TABLE `lead_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lead_payments`
--
ALTER TABLE `lead_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lead_remarks`
--
ALTER TABLE `lead_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mod_users`
--
ALTER TABLE `mod_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_content`
--
ALTER TABLE `site_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `site_images`
--
ALTER TABLE `site_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_responses`
--
ALTER TABLE `exam_responses`
  ADD CONSTRAINT `exam_responses_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `exam_candidates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `exam_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_academic`
--
ALTER TABLE `lead_academic`
  ADD CONSTRAINT `lead_academic_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_details`
--
ALTER TABLE `lead_details`
  ADD CONSTRAINT `lead_details_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_documents`
--
ALTER TABLE `lead_documents`
  ADD CONSTRAINT `lead_documents_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_payments`
--
ALTER TABLE `lead_payments`
  ADD CONSTRAINT `lead_payments_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
