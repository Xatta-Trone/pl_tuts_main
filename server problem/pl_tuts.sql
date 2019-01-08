-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2018 at 10:39 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pl_tuts`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `causer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `causer_id` int(11) NOT NULL,
  `activity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_letter` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `student_id`, `email`, `password`, `user_letter`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Xatta', '1404143', 'xatta.trone@gmail.com', '$2y$10$.1n1akvI6eqryzfNXEOHoOk4ifMvmPDqyyLzaoF6FEnh8LvN1MMVe', 'X', 1, 'tzUNxYJot5gi7tvbwhfh7rWrDt6lfo9fS4afRJaznKey4Ij09vtBHKlxBqWw', '2018-06-09 15:34:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_term_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'book',
  `link` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `custom_message` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `author`, `department_slug`, `level_term_slug`, `course_id`, `user_id`, `user_type`, `post_type`, `link`, `image`, `status`, `custom_message`, `description`, `created_at`, `updated_at`) VALUES
(1, 'XattaTrone', 'xatta', 'ce', NULL, NULL, '1', 'admin', 'book', 'https://api.jquery.com/jquery.parsehtml/', 'single_XattaTrone_1_1528559061.jpg', 1, NULL, 'XattaTrone xatta ce  ', '2018-06-09 09:44:21', '2018-06-10 07:11:37'),
(2, 'Md. Monzurul Islam', 'xatta', 'arch', NULL, NULL, '1', 'admin', 'book', 'https://api.jquery.com/jquery.parsehtml/', '', 1, NULL, 'Md. Monzurul Islam xatta arch  ', '2018-06-10 00:57:59', '2018-06-10 00:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `replied` int(11) NOT NULL DEFAULT '0',
  `replied_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `level_term_id` int(10) UNSIGNED NOT NULL,
  `custom_message` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `slug`, `department_id`, `level_term_id`, `custom_message`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Course 1', 'ce101', 2, 1, NULL, 'Course 1 ce101 ', '2018-06-09 09:41:29', '2018-06-09 09:41:29'),
(2, 'Course 2', 'ce111', 2, 2, NULL, 'Course 2 ce111 ', '2018-06-09 09:41:43', '2018-06-09 09:41:43'),
(3, 'test course che', 'che101', 3, 4, NULL, 'test course che che101 ', '2018-06-10 06:14:47', '2018-06-10 06:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `dept_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_message` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dept_name`, `dept_code`, `slug`, `custom_message`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Architectuer', '01', 'arch', NULL, 'Architectuer 01 arch', 'arch_01.png', '2018-06-09 09:36:31', '2018-06-09 09:36:31'),
(2, 'Civil Engineering', '04', 'ce', NULL, 'Civil Engineering 04 ce', 'ce_04.png', '2018-06-09 09:37:20', '2018-06-09 09:37:20'),
(3, 'Chemical Engineering', '06', 'che', NULL, 'Chemical Engineering 06 che', 'Ch.E_06.png', '2018-06-09 09:37:37', '2018-06-10 02:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `exell_tests`
--

CREATE TABLE `exell_tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `merit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hall_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ইউনিকোড পোস্ট', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta dolorum beatae facilis et tempore recusandae nam perferendis aut molestiae expedita ex, laboriosam eos tenetur nobis iure sed illum. Quibusdam cum excepturi quos dicta quasi porro, sequi voluptatum unde adipisci rerum fuga explicabo nisi incidunt ratione quas, eveniet similique, inventore tempore quia dolorem doloremque. Neque porro nobis dolore fugiat aliquam consequuntur veritatis illum vitae, excepturi nisi blanditiis, eaque laborum corrupti, quos voluptates. Itaque cupiditate nulla fugiat repellat nostrum sunt quis earum debitis deleniti? Cum dignissimos a rem fuga, recusandae et deserunt nisi sit error repellat dolorum voluptates autem sed! Unde eos, eius autem tenetur quod rem sequi tempore vero possimus animi amet velit laboriosam soluta magni eum consectetur, harum vitae fuga necessitatibus voluptates quia. Maiores esse dolorem harum doloribus laudantium facilis, ipsa beatae neque molestias consectetur id voluptatem cumque, vero cum ducimus assumenda! Omnis quia sapiente aliquam rerum excepturi nihil illo amet, error, exercitationem, corporis, ratione sint architecto optio! Facere quos ratione nihil repudiandae odit inventore, ducimus impedit suscipit. Ipsum quidem sequi quos odio ab excepturi necessitatibus, distinctio praesentium debitis ipsam dicta aut vitae nostrum nemo quas similique! Maiores non obcaecati porro repudiandae vero, laboriosam deserunt, libero tempore suscipit unde aut.<br></p>', 1, '2018-06-09 09:44:57', '2018-06-10 07:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `level_terms`
--

CREATE TABLE `level_terms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `custom_message` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `level_terms`
--

INSERT INTO `level_terms` (`id`, `name`, `slug`, `department_id`, `custom_message`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Level 1 Term 1', '1-1', 2, NULL, 'Level 1 Term 1 1-1', '2018-06-09 09:37:55', '2018-06-09 09:37:55'),
(2, 'Level 1 Term 2', '1-2', 2, NULL, 'Level 1 Term 2 1-2', '2018-06-09 09:41:16', '2018-06-09 09:41:16'),
(3, 'Level 1 Term 1', '1-1', 1, NULL, 'Level 1 Term 1 1-1', '2018-06-10 00:59:43', '2018-06-10 00:59:43'),
(4, 'Level 1 Term 1', '1-1', 3, NULL, 'Level 1 Term 1 1-1', '2018-06-10 05:57:54', '2018-06-10 05:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_05_31_065625_create_departments_table', 1),
(4, '2018_06_01_043359_create_level_terms_table', 1),
(5, '2018_06_01_062010_create_courses_table', 1),
(6, '2018_06_02_040752_create_posts_table', 1),
(7, '2018_06_04_171654_create_exell_tests_table', 1),
(8, '2018_06_05_084939_create_userdatas_table', 1),
(9, '2018_06_07_063501_create_admins_table', 1),
(10, '2018_06_07_082437_create_roles_table', 1),
(11, '2018_06_07_085910_create_permissions_table', 1),
(12, '2018_06_07_113356_create_admin__roles_table', 1),
(13, '2018_06_08_051228_create_softwares_table', 1),
(14, '2018_06_08_072811_create_books_table', 1),
(15, '2018_06_08_075941_create_faqs_table', 1),
(16, '2018_06_08_083624_create_contacts_table', 1),
(17, '2018_06_08_101037_create_testimonials_table', 1),
(18, '2018_06_09_155430_create_activities_table', 2),
(19, '2018_06_10_044050_create_utilities_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('xatta.trone@gmail.com', '$2y$10$lAN4BxISoqch.OXFb3zJw.mXG6OSjl3iXN1u4kklJw7OilqGMPQ/u', '2018-06-10 10:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `for_w` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `for_w`, `created_at`, `updated_at`) VALUES
(1, 'create', 'user', '2018-06-09 09:49:29', '2018-06-09 09:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_term_slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `link` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `custom_message` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `author`, `department_slug`, `level_term_slug`, `course_id`, `user_id`, `user_type`, `post_type`, `link`, `image`, `status`, `custom_message`, `description`, `created_at`, `updated_at`) VALUES
(1, 'csi', NULL, 'ce', '1-1', 1, '1', 'admin', 'post', 'https://www.csiamerica.com/support/downloads', 'ce_1-1_1_1528611016.png', 1, NULL, 'csi  ce 1-1 ', '2018-06-10 00:10:16', '2018-06-10 06:13:37'),
(2, 'Post 33', 'aaa', 'arch', '1-1', 1, '1', 'admin', 'post', 'http://127.0.0.1:8000/admin/courses/getCoursessdsd', 'ce_1-1_1_1528611049.png', 2, '<pre><code class=\"hljs php\"><span class=\"hljs-keyword\">public</span> <span class=\"hljs-function\"><span class=\"hljs-keyword\">function</span> <span class=\"hljs-title\">index</span><span class=\"hljs-params\">(Request $request)</span>\r\n    </span>{\r\n        $query = $request-&gt;get(<span class=\"hljs-string\">\'q\'</span>);\r\n\r\n        $posts = $query\r\n            ? Post::search($query)-&gt;paginate(<span class=\"hljs-number\">15</span>)\r\n            : Post::paginate(<span class=\"hljs-number\">15</span>);\r\n\r\n        $tag = $request-&gt;get(<span class=\"hljs-string\">\'tag\'</span>);\r\n        $data = <span class=\"hljs-keyword\">$this</span>-&gt;dispatch(<span class=\"hljs-keyword\">new</span> BlogIndexData($tag));\r\n        $layout = $tag ? Tag::layout($tag) : <span class=\"hljs-string\">\'blog.layouts.index\'</span>;\r\n\r\n        <span class=\"hljs-keyword\">return</span> view($layout, $data)-&gt;withPosts($posts);\r\n    }</code></pre>', 'Post 33 aaa ce 1-1 <pre><code class=\"hljs php\"><span class=\"hljs-keyword\">public</span> <span class=\"hljs-function\"><span class=\"hljs-keyword\">function</span> <span class=\"hljs-title\">index</span><span class=\"hljs-params\">(Request $request)</span>\r\n    </span>{\r\n        $query = $request-&gt;get(<span class=\"hljs-string\">\'q\'</span>);\r\n\r\n        $posts = $query\r\n            ? Post::search($query)-&gt;paginate(<span class=\"hljs-number\">15</span>)\r\n            : Post::paginate(<span class=\"hljs-number\">15</span>);\r\n\r\n        $tag = $request-&gt;get(<span class=\"hljs-string\">\'tag\'</span>);\r\n        $data = <span class=\"hljs-keyword\">$this</span>-&gt;dispatch(<span class=\"hljs-keyword\">new</span> BlogIndexData($tag));\r\n        $layout = $tag ? Tag::layout($tag) : <span class=\"hljs-string\">\'blog.layouts.index\'</span>;\r\n\r\n        <span class=\"hljs-keyword\">return</span> view($layout, $data)-&gt;withPosts($posts);\r\n    }</code></pre>', '2018-06-10 00:10:49', '2018-06-10 00:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'monzurul', '2018-06-09 09:49:13', '2018-06-09 09:49:13');

-- --------------------------------------------------------

--
-- Table structure for table `softwares`
--

CREATE TABLE `softwares` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level_term_slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'software',
  `link` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `custom_message` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `softwares`
--

INSERT INTO `softwares` (`id`, `name`, `author`, `department_slug`, `level_term_slug`, `course_id`, `user_id`, `user_type`, `post_type`, `link`, `image`, `status`, `custom_message`, `description`, `created_at`, `updated_at`) VALUES
(2, 'CSI Etabs', 'CSI', 'ce', '1-2', 2, '1', 'admin', 'software', 'https://www.csiamerica.com/support/downloads', 'etbas_1_1528634208.jpg', 1, '<h1>Installation:</h1><p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/ps6VZX9z8Fg\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', 'CSI Etabs CSI ce 1-2 <h1>Installation:</h1><p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/ps6VZX9z8Fg\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2018-06-10 06:36:49', '2018-06-10 06:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_letter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_batch` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `user_letter`, `dept_batch`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'A', 'CE\'14', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero nihil est repellendus iure qui eos, laborum magnam doloribus doloremque inventore temporibus, itaque. Assumenda velit aperiam beatae magni nostrum similique maiores repellat. Delectus labore officia ratione at, unde eum, reiciendis adipisci, pariatur tempore fugit veritatis non est quibusdam doloremque culpa dolorum? to go \"there', 1, '2018-06-09 09:47:49', '2018-06-10 04:38:59'),
(2, 'Md. Monzurul Islam', 'M', 'CE\'14', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero nihil est repellendus iure qui eos, laborum magnam doloribus doloremque inventore temporibus, itaque. Assumenda velit aperiam beatae magni nostrum similique maiores repellat. Delectus labore officia ratione at, unde eum, reiciendis adipisci, pariatur tempore fugit veritatis non est quibusdam doloremque culpa dolorum?', 1, '2018-06-10 04:38:13', '2018-06-10 04:38:13'),
(3, 'XattaTrone', 'X', 'CE\'14', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero nihil est repellendus iure qui eos, laborum magnam doloribus doloremque inventore temporibus, itaque. Assumenda velit aperiam beatae magni nostrum similique maiores repellat. Delectus labore officia ratione at, unde eum, reiciendis adipisci, pariatur tempore fugit veritatis non est quibusdam doloremque culpa dolorum?', 1, '2018-06-10 04:38:24', '2018-06-10 04:38:24'),
(4, 'Syeda Marzia', 'S', 'CE\'14', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero nihil est repellendus iure qui eos, laborum magnam doloribus doloremque inventore temporibus, itaque. Assumenda velit aperiam beatae magni nostrum similique maiores repellat. Delectus labore officia ratione at, unde eum, reiciendis adipisci, pariatur tempore fugit veritatis non est quibusdam doloremque culpa dolorum?', 1, '2018-06-10 04:38:37', '2018-06-10 04:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `userdatas`
--

CREATE TABLE `userdatas` (
  `id` int(10) UNSIGNED NOT NULL,
  `merit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hall_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_letter` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `student_id`, `email`, `password`, `user_letter`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Md. Monzurul Islam', '1404143', 'monzurul.ce.buet@gmail.com', '$2y$10$mWuXvTt7felhWS26y8gtHuDyRTCLJ3YFbCt5jXkjkh.dm8f7GhJka', 'M', 1, 'xYPm0Um180nSHsQ9mKIJkzfI4qoKPUdTnxb9SwAdclvciZzgK9MrkOPpauG9', '2018-06-10 10:55:01', '2018-06-10 11:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `utilities`
--

CREATE TABLE `utilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messenger` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utilities`
--

INSERT INTO `utilities` (`id`, `title`, `date_time`, `facebook`, `youtube`, `email`, `messenger`, `custom_message`, `created_at`, `updated_at`) VALUES
(1, 'Next pl in', '2018-07-11 10:00:00', 'https://www.facebook.com/thepltutorials/', 'https://www.youtube.com/channel/UC-siMB02iGmejIPk83vRVxQ', 'pltutorialsbuet@gmail.com', 'https://www.facebook.com/thepltutorials/i', 'https://www.facebook.com/thepltutorials/ihttps://www.facebook.com/thepltutorials/ihttps://www.facebook.com/thepltutorials/i', NULL, '2018-06-10 04:45:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_student_id_unique` (`student_id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_course_id_foreign` (`course_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_department_id_foreign` (`department_id`),
  ADD KEY `courses_level_term_id_foreign` (`level_term_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exell_tests`
--
ALTER TABLE `exell_tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exell_tests_student_no_unique` (`student_no`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_terms`
--
ALTER TABLE `level_terms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_terms_department_id_foreign` (`department_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_course_id_foreign` (`course_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `softwares`
--
ALTER TABLE `softwares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `softwares_course_id_foreign` (`course_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdatas`
--
ALTER TABLE `userdatas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userdatas_student_id_unique` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_student_id_unique` (`student_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `utilities`
--
ALTER TABLE `utilities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exell_tests`
--
ALTER TABLE `exell_tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level_terms`
--
ALTER TABLE `level_terms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `softwares`
--
ALTER TABLE `softwares`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userdatas`
--
ALTER TABLE `userdatas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `utilities`
--
ALTER TABLE `utilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_level_term_id_foreign` FOREIGN KEY (`level_term_id`) REFERENCES `level_terms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `level_terms`
--
ALTER TABLE `level_terms`
  ADD CONSTRAINT `level_terms_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `softwares`
--
ALTER TABLE `softwares`
  ADD CONSTRAINT `softwares_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
