-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2021 at 01:47 AM
-- Server version: 10.3.29-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videovoyager`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190318034909', '2019-03-22 16:30:33'),
('20190318152631', '2019-03-22 16:30:33'),
('20190318163235', '2019-03-22 17:34:00'),
('20190322230115', '2019-03-22 23:57:47'),
('20190322234053', '2019-03-22 23:57:47'),
('20190404235817', '2019-04-05 00:24:13'),
('20210511180324', '2021-05-11 18:04:38'),
('20210519162058', '2021-05-19 16:23:03'),
('20210520092409', '2021-05-20 09:25:31'),
('20210525173521', '2021-05-25 17:36:22'),
('20210623164017', '2021-06-23 16:54:20'),
('20210628194144', '2021-06-28 20:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shows_id` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `payment_date` datetime NOT NULL,
  `payment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmation_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_response` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_id`, `shows_id`, `amount`, `payment_date`, `payment_status`, `confirmation_code`, `payment_response`) VALUES
(1, 21, 7, 50, '2021-06-21 17:34:08', 'COMPLETED', '8KU08114GH3767418', '{\"id\":\"8KU08114GH3767418\",\"orderId\":\"8KU08114GH3767418\",\"facilitatorAccessToken\":\"A21AAKbYGXcpoOhrfd3Y0elacNZsfxFOM6dDHmPvzlt4XFkfvq6QzgjXnu4rFS4SCe5YTJHEdPb_X785gxEBjzCxUEjoX40Fg\",\"create_time\":\"2021-06-21T17:30:49Z\",\"update_time\":\"2021-06-21T17:34:08Z\",\"status\":\"COMPLETED\",\"amount\":\"50\",\"intent\":\"CAPTURE\"}');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `recorded_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `event_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`id`, `user_id`, `start`, `end`, `recorded_link`, `amount`, `event_name`) VALUES
(2, 18, '2021-06-21 22:49:00', '2021-06-22 01:34:00', 'https://www.youtube.com/watch?v=F5D6hfE3NnEKK', 6, 'Event 1'),
(3, 18, '2021-06-21 22:50:00', '2021-06-21 23:35:00', 'https://www.youtube.com/watch?v=F5D6hfE3NnE', 10, '2 event'),
(4, 18, '2021-06-21 22:50:00', '2021-06-21 23:35:00', 'https://www.youtube.com/watch?v=F5D6hfE3NnE', 10, '6 event'),
(5, 24, '2021-06-21 22:50:00', '2021-06-21 23:35:00', 'https://www.youtube.com/watch?v=F5D6hfE3NnE', 10, '6 event'),
(6, 24, '2021-06-21 22:59:00', '2021-06-22 01:44:00', 'https://www.youtube.com/watch?v=F5D6hfE3NnE', 15, '7 event'),
(7, 18, '2021-06-21 23:45:00', '2021-06-22 22:45:00', 'https://www.youtube.com/watch?v=F5D6hfE3NnE123', 50, 'Event 1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `streaming_key` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streaming_server` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type_id`, `is_admin`, `email`, `password`, `first_name`, `last_name`, `nickname`, `streaming_key`, `streaming_server`, `profile_image`, `category`, `bio`, `roles`) VALUES
(1, 2, NULL, 'jjudge.developer83@gmail.com', '$2y$10$QVpWClgiH00LSw5wkU6mkui09KSJkA95KSl1/X04evt.Gt9M8emcy', 'James', 'Judge', 'Administrator', '349895995933996181754002', NULL, '42251778_10156829037859924_6216672377334398976_o.jpg', NULL, NULL, ''),
(2, 3, NULL, 'developer@jamesjudge.info', '$2y$10$qRJaIkd/EcXBieoFptpuwOup0MBWF8IkHhETihb.Yomxxjfmvaggi', 'James', 'Judge', 'James Judge', NULL, NULL, NULL, NULL, NULL, ''),
(3, 2, NULL, 'club@beatdrop.xyz', '$2y$10$qbYwVN1LZATPi3DeIIwDh.Ppc3eQyixLofE4DPKZNWdgKp1cGhzxu', '_______', ' _________', 'ClubEd', '062257786956836106756708', 'xxxxxxxxxxxxx', '301874gangsta.jpg', 'DJ', 'Testing bio input/output', ''),
(4, 3, NULL, 'Bpc422@gmail.com', '$2y$10$.cBs4bWTWWVJ23ETuHTvp.k89lnOa.TTz9JSo7qdxt58ki4t7N.zO', 'B', 'C', 'BPC', NULL, NULL, NULL, NULL, NULL, ''),
(5, 3, NULL, 'Rachelellmore@gmail.com', '$2y$10$ikFrW/14LJBbqDt62QS2iuLQMLz0ql5PAU3GRPmjjqEFhNzGBIqta', 'Rachel', 'Ellmore', 'Serenity', NULL, NULL, NULL, NULL, NULL, ''),
(6, 3, NULL, 'Jennweldon@hotmail.com', '$2y$10$1nkOJNIFyLAS6vvHDoTNaeNE3XL75UiljE/5gANFEzZwjQ2gB/Ho.', 'Ennifer', 'Lopez', 'Jenni from the block', NULL, NULL, NULL, NULL, NULL, ''),
(7, 3, NULL, 'fucker@asshole.com', '$2y$10$z0iJUD8bGGgrlkboropDRujgopnS8YhZEI3J11GB/yka0JVGzMbAm', 'Fucker of', 'Many Assholes', 'AssholeFucker', NULL, NULL, NULL, NULL, NULL, ''),
(8, 3, NULL, 'metaldave08096@yahoo.com', '$2y$10$/HQIhPdIcXNuiVEqBXVzd.NOvInJfbQcWwcz7Oxl0c.iirhsO.gx.', 'David', 'Meyers', 'meyers85', NULL, NULL, NULL, NULL, NULL, ''),
(9, 3, NULL, 'sungoddesssher@gmail.com', '$2y$10$WLFXo5Q7b4zPIlqkTfltmO2qfewCckocL6XWSQnLlaLY2N22iq1GG', 'Sherry', 'Stafford-Loibl', 'Spirit', NULL, NULL, NULL, NULL, NULL, ''),
(10, 3, NULL, 'Suckit69times', '$2y$10$MxKBZa6bvz44Tn4MaAvFvO3Jcl1nXpA9l2EosLHdF2ibcwcTrqVGi', 'Base', 'Base', 'Suckit69times', NULL, NULL, NULL, NULL, NULL, ''),
(11, 3, NULL, 'Pieperbetsy@icloud.com', '$2y$10$bM6.tZ0I4HYBf5L8bdO0QeowLyGcPChcajgRwMmZ8mkCFFVfShrni', 'Meghan', 'Pieper', 'Meghan', NULL, NULL, NULL, NULL, NULL, ''),
(12, 3, NULL, 'Samanthag184@yahoo.com', '$2y$10$LixoUSXVCdw7pIxWNAT1ce4RK6krX7h2q0GK7YjBAzY.M.u77TQNS', 'Samantha', 'Genader', 'Sammyg89', NULL, NULL, NULL, NULL, NULL, ''),
(13, 3, NULL, 'Biggst@Biggst.com', '$2y$10$a8HYD6FwlK3v/mKcsfRCJeGHUomCdL3Ho6HZs8IEeUKATQCcAtf.u', 'Base1', 'Face', 'Fucker', NULL, NULL, '60ace94754fa0.jpg', NULL, 'testing', ''),
(14, 3, NULL, 'Robby', '$2y$10$BvyHsERDTvzalxCO9XWkMeF7HUePGPkwmkgmceU2ljuv4Smr2Qo/u', 'Robby', 'Robby', 'Fuckin', NULL, NULL, NULL, NULL, NULL, ''),
(15, 3, NULL, 'Ryan.h215@gmail.com', '$2y$10$t.j/E/wpEFIWSu5ZYXUfzOS0J3SEYu9R6qQjxceRg44QdujbBxHQO', 'Ryan', 'Henry', 'Scion6', NULL, NULL, NULL, NULL, NULL, ''),
(16, 3, NULL, 'Kyle.Mikhailov@gmail.com', '$2y$10$2eFYHUYKoOrHtoOgYnPB/et5.AA8sWyBgs59fCFT1.rBZugX5ZyDi', 'Kyle', 'Mikhailov', 'Kyle', NULL, NULL, NULL, NULL, NULL, ''),
(17, 3, NULL, 'tvjudge@gmail.com', '$2y$10$Wg2S2H3VCvulogYxLxzHzOBjcR/Z..Tz2B8a4Ph8E2eH2XetywLi6', 'Tom', 'Judge', 'The Video Voyager', NULL, NULL, NULL, NULL, NULL, ''),
(18, 2, 1, 'thejamroomonline@gmail.com', '$2y$10$0HPvk.eS5rZpBI0ia7vdHO9S3oK..iz8T42t0tKDPs4Udn1QWhn/i', 'Jam', 'Room', 'The Jam Room', 'sk_us-west-2_CV8E2j3eFcUQ_2BrxK9J11G5HGKsGPSNNvURwOoOp7L', NULL, '575217tjr18.png', 'Band', 'The Jam Room is the channel used by the touring video voyager for live streams.', ''),
(19, 3, NULL, 'tvjudge@videovoyager.org', '$2y$10$QaQ98PpjbtAIK5y8TyMJzu6gW/wffjKwACfRtA39CLQ4iG6AIGgQO', 'THomas', 'Judge', 'VVadmin', NULL, NULL, NULL, NULL, NULL, ''),
(20, 1, 1, 'dattesh.brahmkshatriya@viitor.cloud', '$2y$10$/9chQDlUrU9ufzu0MqRN2e2BnZVKgr03QP7Blzk4ulF2odQVm9Q3q', 'Dattesh', 'Brahmkshatriya1', 'DGB', '', '', '60998f4927641.jpeg', 'Band1', 'bio details', ''),
(21, 3, NULL, 'dettesh.vc@gmail.com', '$2y$10$UcqsNUXiG57emR2VFFE8jupfzULe9NrTx4ajN3U0.Ks7ijGA7SkIG', 'Dattesh', 'Brahmkshatriya', 'Dattesh.VC', NULL, NULL, NULL, NULL, NULL, ''),
(24, 2, NULL, 'abc@abc.com', '$2y$10$N9ci64SCzf1Vtb9QI7G6k.mxyeiY5mJBWKwJ8hqYQJ1OVWzPNadrm', 'AAA', 'BBB', 'AAABBBCCC', 'streamingKey', 'streamingServer', '60acefc84c289.jpg', 'category', 'bio', ''),
(25, 3, NULL, 'zzz@zzz.com', '$2y$10$DOpLRgevXS.mXrYA8/wGducldwBdzYt6kb7TxY2n7Koe3y1Jup5jS', 'ZZ', 'zz', 'zzz', '', '', NULL, '', '', ''),
(26, 3, NULL, 'aaa@gmail.com', '$2y$10$IyOwRWXYrDB5DyOoqTDp8u5T8FEnVjmtoOkBO751NiCEn465m1W2e', 'aaaa', 'bbbb', 'aaaa', '', '', NULL, '', '', ''),
(27, 3, NULL, 'bbb@gmail.com', '$2y$10$Q5MifvkdszDwMdjbZh3ZpuCUxPUY4Tl9Q9G21qCfYqq.EdjVKMFq6', 'bbb', 'ccc', 'bbb', NULL, NULL, NULL, NULL, NULL, ''),
(29, 3, NULL, 'xyz@gmail.com', '$2y$10$iHvzkbYu2wzOiB2lTX0kYOY3w1VadYs92Y5c1pSni2AWDTXcbbV3a', 'xyz', 'zxy', 'xyz', '', '', NULL, '', '', ''),
(30, 3, NULL, 'pqr@gmail.com', '$2y$10$TJQPUoESwxJUw6fw8b6zB.SK6tmaMFskEsZU5W0gK1QAmpgi.FHiS', 'pqr', 'rqp', 'PQR', NULL, NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type`, `name`) VALUES
(1, 'admin', 'Admin'),
(2, 'venue', 'Venue'),
(3, 'viewer', 'Viewer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`),
  ADD KEY `IDX_F5299398AD7ED998` (`shows_id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6C3BF144A76ED395` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D649A188FE64` (`nickname`),
  ADD KEY `IDX_8D93D6499D419299` (`user_type_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F5299398AD7ED998` FOREIGN KEY (`shows_id`) REFERENCES `shows` (`id`);

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `FK_6C3BF144A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6499D419299` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
