-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 01, 2021 at 05:20 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpoop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `load_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `shop_id`, `category_id`, `name`, `price`, `image`, `load_date`) VALUES
(5, 2, 1, 'Hope Rollins', 58, 'public/uploads/products/52befda1634cc763fb87d0cf34f0f503.jpg', '2021-08-10 06:14:41'),
(6, 2, 1, 'Rhoda Guerrero', 571, 'public/uploads/products/dd0fc6c3e4c88e6273eddc94b3b2c549.jpg', '2021-08-10 07:02:55'),
(8, 2, 1, 'Sara Stone', 745, 'public/uploads/products/4919d2dbd67ad79359ce1eb844940f0c.jpg', '2021-08-10 07:20:17'),
(9, 2, 2, 'Ulric Parker', 213, 'public/uploads/products/66437521b7171cadf40d33635cbd3c35.jpg', '2021-08-12 15:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `shop_id`, `category`, `add_date`) VALUES
(1, 1, 'T-Shart-change', '2021-08-05 09:34:38'),
(2, 2, 'Pent', '2021-08-07 16:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role_slug` varchar(100) NOT NULL,
  `priority` json NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `role_slug`, `priority`, `created_at`) VALUES
(1, 'Super Admin', 'super-admin', '1', '2021-08-29 11:52:32'),
(2, 'Admin', 'admin', '1', '2021-08-29 11:52:32'),
(3, 'Subscriber', 'subscriber', '1', '2021-08-29 11:52:32'),
(4, 'Client', 'client', '1', '2021-08-29 11:52:32');

-- --------------------------------------------------------

--
-- Table structure for table `shopp`
--

CREATE TABLE `shopp` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` float DEFAULT NULL,
  `product_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(150) NOT NULL,
  `shop_details` varchar(250) NOT NULL,
  `shop_add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2',
  `l_name` varchar(50) DEFAULT NULL,
  `f_name` varchar(50) DEFAULT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(2000) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `uphoto` varchar(150) DEFAULT NULL,
  `unique_user` varchar(75) NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `l_name`, `f_name`, `username`, `email`, `password`, `city`, `address`, `uphoto`, `unique_user`, `add_date`, `update_date`) VALUES
(1, 2, 'Khan', 'Md. Shahadat', 'wdshahadat', 'wdshahadat@gmail.com', '10470c3b4b1fed12c3baac014be15fac67c6e815', NULL, NULL, NULL, '1b9ceb2e4fe5ee92820d2ef55ebbe651', '2021-08-07 15:14:22', NULL),
(2, 2, '', 'wd', 'wd', 'wd@s.s', 'adcd7048512e64b48da55b027577886ee5a36350', NULL, NULL, NULL, 'dd3ba2cca7da8526615be73d390527ac', '2021-08-09 06:53:50', NULL),
(3, 3, 'Forbes', 'Aidan ', 'natabeqiba', 'mena@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '029a0f5cfaf4fb5812f4af534065ceed', '2021-08-17 06:43:00', NULL),
(4, 2, 'Mathews', 'Jenna ', 'cuzamuto', 'zewas@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'fc17122c3ff01ba65cd49833c5194d0c', '2021-08-17 06:50:38', NULL),
(5, 1, 'Atkinson', 'Tyler ', 'guqyki', 'ryvaqynife@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '5d7f2da2247ad5e028ef717847c31e57', '2021-08-17 15:20:54', NULL),
(6, 2, 'Mays', 'Cally ', 'moloqyl', 'jefuwafuc@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '662fb5a2d1870802c82d01aea6ecbf8e', '2021-09-01 12:34:17', NULL),
(10, 2, 'Munoz', 'Ginger ', 'karetiw', 'wufuvici@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '65be14d3c572276b14c20a3d9deeb2fc', '2021-09-01 12:37:19', NULL),
(14, 2, 'Hooper', 'Ursula ', 'pywunykyk', 'keriky@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '7ccbd8ae755e7400e4ab82898f3317ff', '2021-09-01 13:26:47', NULL),
(15, 2, 'Stone', 'Emerald ', 'hotor', 'bevokugeh@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '1f02a2863dd49d1e7f4f073aef9095b7', '2021-09-01 13:27:46', NULL),
(16, 2, 'Porter', 'Aubrey ', 'zezaryt', 'nolyvugo@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '20f45618f5102cd971666c5073e86e9d', '2021-09-01 13:28:56', NULL),
(20, 2, 'Crosby', 'Azalia ', 'qehecita', 'cehyvyr@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'b14bda39e8379bde65b8c53e071206a0', '2021-09-01 13:30:57', NULL),
(22, 2, 'Harding', 'Ebony ', 'wumime', 'putuber@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '6ef038800d7f4b73c20aafab7c02ab11', '2021-09-01 13:32:12', NULL),
(23, 2, 'Acevedo', 'Donna ', 'puvof', 'samysen@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '63b5793bdf587fc1eca3b6a4e291444b', '2021-09-01 13:32:48', NULL),
(25, 2, 'Silva', 'Jescie ', 'lakos', 'nemuza@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '0137bc9a57dda948034af06fe536766c', '2021-09-01 13:35:32', NULL),
(26, 2, 'Dominguez', 'Hannah ', 'gehagysiha', 'jaqeb@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '0901ef1c1822a96cc960e527a673b83e', '2021-09-01 13:35:52', NULL),
(27, 2, 'Dunlap', 'Brynn ', 'vuvav', 'tyqadehel@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'd700c5c9a959bf622a541328cbcc4d2b', '2021-09-01 13:36:08', NULL),
(28, 2, 'Elliott', 'Kyra ', 'xicykiheto', 'pododin@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'f1af9edb913fb43b30f17bc58f1851e5', '2021-09-01 13:36:40', NULL),
(29, 2, 'Lancaster', 'Olympia ', 'qabul', 'rogoliky@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '77492174608b9f626046e8108712dc51', '2021-09-01 13:37:41', NULL),
(30, 2, 'Wade', 'Charde ', 'dutenosiso', 'pavujacu@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '5e936416a8a15f2c612bb7dc9261da1e', '2021-09-01 13:39:46', NULL),
(31, 2, 'Snyder', 'Ruby ', 'wysebicadu', 'hogacalaw@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'd0c6bf4945bfbf697dc5414e633766e3', '2021-09-01 13:55:03', NULL),
(32, 2, 'Cantu', 'Vivian ', 'mowepihe', 'cazaqanory@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'de086cedd48f27aced01c6b21b904a6b', '2021-09-01 14:00:25', NULL),
(33, 2, 'Franco', 'Plato ', 'manavow', 'zimiger@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '4377c4026900b6914e727c7c1cda6444', '2021-09-01 14:02:31', NULL),
(34, 2, 'Waller', 'Damian ', 'dejatevyh', 'ryhutuha@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '6f0fe46f5b012a9de683b98acb66da89', '2021-09-01 14:05:20', NULL),
(35, 2, 'Stevens', 'Neil ', 'vyzixuci', 'copinyhepi@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'd3c13a691d46d32c4c1e810d535ecdc7', '2021-09-01 14:06:10', NULL),
(36, 2, 'Meyers', 'Gannon ', 'lybovi', 'tiratijyde@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'b2efb87d15140cd4852a7c4137155b72', '2021-09-01 14:10:54', NULL),
(37, 2, 'Nguyen', 'Vernon ', 'vadyb', 'dyhi@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'd16e5096fe134fae4cfe6d215f9d50c1', '2021-09-01 14:14:04', NULL),
(39, 2, 'Tate', 'Gretchen ', 'revycon', 'mynatesufa@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '9a681ab9f8f558e1039f641b4ccf5fe8', '2021-09-01 14:22:09', NULL),
(40, 2, 'Mccoy', 'Hiram ', 'qahek', 'xeqibyti@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '32cdc9008f8bf2eb41ece0a645ed578c', '2021-09-01 14:22:30', NULL),
(41, 2, 'Spence', 'Stewart ', 'tezirureda', 'qaqoly@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'bbc1bb91bbb4cfe900cfb8f73d9f8fd4', '2021-09-01 14:22:57', NULL),
(42, 2, 'Acevedo', 'Gemma ', 'qyzyzobif', 'facec@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'dffc169be733ac1fcb3e8785a53a1ff3', '2021-09-01 14:23:36', NULL),
(43, 2, 'Sargent', 'Rhona ', 'nufiz', 'begekykiji@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '9c90f9d6ce67df6867828819b0d069f5', '2021-09-01 14:26:38', NULL),
(44, 2, 'Walker', 'Avye ', 'mylepegyhy', 'jali@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'b595550eaee49fa5da00b7f724f7afb8', '2021-09-01 14:29:13', NULL),
(45, 2, 'Britt', 'Ebony ', 'fazyxev', 'wysonycod@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'b30e1d65d7a7bc24ad5a65b22e7baf74', '2021-09-01 14:31:14', NULL),
(46, 2, 'Tucker', 'Winifred ', 'sajidamity', 'huwaw@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '80da8b6c30eb1c3ce02823a806f0656c', '2021-09-01 14:31:50', NULL),
(47, 2, 'Downs', 'Camilla ', 'pyrifov', 'zycunati@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '0a0cb14ba326eb2cd4eff08e871a88d6', '2021-09-01 14:32:22', NULL),
(48, 2, 'Kidd', 'Moana ', 'fujicisi', 'dejiloz@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '5302132b46c5e22e19ad799333025a44', '2021-09-01 14:41:18', NULL),
(49, 2, 'Garrett', 'Berk ', 'gepujowoj', 'zesyquvupo@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'd69551779678086839639b4221ba8d19', '2021-09-01 14:42:27', NULL),
(50, 2, 'Odonnell', 'Kirk ', 'qubofiwo', 'xydegegi@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '88476cb8bb46b4d83c5ac1b15fda4600', '2021-09-01 14:43:23', NULL),
(51, 2, 'Lester', 'Tanya ', 'qywexojimo', 'vacu@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'fde5b718c02dae6d576ff9b2f36f208b', '2021-09-01 14:43:46', NULL),
(52, 2, 'Howell', 'Brooke ', 'qycihi', 'vugij@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '7f888a05cf80515a1f8e9652399ce320', '2021-09-01 14:44:26', NULL),
(53, 2, 'Branch', 'Jenna ', 'ceniq', 'werar@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '714319be08ed8636e2120123edfd9f88', '2021-09-01 14:44:46', NULL),
(54, 2, 'Spears', 'Ramona ', 'suwito', 'facadokito@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '9c49f49aa76978ef2f400a5259380781', '2021-09-01 14:45:17', NULL),
(55, 2, 'Vazquez', 'Uriel ', 'vujoxafi', 'tibyvi@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '08baf6a740382fb47e660fbdcd988b9f', '2021-09-01 14:46:08', NULL),
(56, 2, 'Gallegos', 'Dana ', 'holek', 'rolovyni@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '6c7277233f37d81acd1b69eeb1ca870c', '2021-09-01 14:47:28', NULL),
(57, 2, 'Fleming', 'Quentin ', 'ribyg', 'buxigafo@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'b7b6d81d2cdd573793325f257211a6e6', '2021-09-01 14:47:59', NULL),
(58, 2, 'Humphrey', 'Emerson ', 'qypunig', 'mupah@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '8bec6b3cf8e6b5735ed6015299347bb9', '2021-09-01 14:52:28', NULL),
(59, 2, 'Snider', 'Edan ', 'cimetyd', 'zeqifetuzi@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '3e4768663f6cedefd8fc94721963ddc4', '2021-09-01 14:53:03', NULL),
(60, 2, 'Ballard', 'Dai ', 'rumyten', 'fagakowusi@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'de31d6a3b50e4a5546c20052ff44c2a7', '2021-09-01 14:53:40', NULL),
(61, 2, 'Lawrence', 'Keane ', 'cakejevehu', 'wikyzumo@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'de6cf5f4b7d06c4b8e9a6dfc8bad0caf', '2021-09-01 14:54:01', NULL),
(62, 2, 'Cabrera', 'Kamal ', 'tudufisex', 'dyjedyg@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '8db1a7ab71113e8123b0eec8283a08ea', '2021-09-01 14:56:18', NULL),
(63, 2, 'Oneill', 'Bradley ', 'mowepuc', 'potyl@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'a6756c7ff1865f92931a6654a42e1e46', '2021-09-01 14:56:29', NULL),
(64, 2, 'Sandoval', 'Wynter ', 'vejewyvy', 'helafil@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '54284a61b88c71b8b1fe43bc54c7a6bc', '2021-09-01 14:56:57', NULL),
(65, 2, 'Cain', 'Oliver ', 'rufyxefumy', 'siceqicy@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'c7f7da77797a8ddb9564cb7c08bfe351', '2021-09-01 14:57:50', NULL),
(66, 2, 'Burt', 'Evelyn ', 'dilam', 'dyrigepe@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '59bcd4711a420740d3a9ed0e71044ecf', '2021-09-01 14:58:24', NULL),
(67, 2, 'Albert', 'Sylvia ', 'doresapoby', 'fupitajij@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'a0bce449516067800d253deab8dbdf57', '2021-09-01 14:58:46', NULL),
(68, 2, 'Hudson', 'Dieter ', 'putogat', 'sakebituka@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'c8bacc2ba59c82ad4d9042710f81ada9', '2021-09-01 15:00:30', NULL),
(69, 2, 'Fernandez', 'Alma ', 'silumoqyd', 'tuven@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '09b275cc34e3512f1f36f0a72e886fe4', '2021-09-01 15:04:22', NULL),
(70, 2, 'Suarez', 'Irene ', 'zivola', 'liniv@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '674a7b08a1a6c1aed5c6ed587627fa4a', '2021-09-01 16:01:35', NULL),
(71, 2, 'Arnold', 'Colton ', 'disez', 'kociko@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'a2238e8135ee2e69c7b0907c9f44c373', '2021-09-01 16:02:29', NULL),
(72, 2, 'Peters', 'Orli ', 'pugus', 'lypahekiri@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '8256cf117f4bbc09f811d7b0bcd91a98', '2021-09-01 16:04:30', NULL),
(73, 2, 'Henderson', 'Shaeleigh ', 'tiwoxid', 'xedavor@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'dacad8e9cd4a949b583030699911c2e7', '2021-09-01 16:05:06', NULL),
(74, 2, 'Ewing', 'Kennedy ', 'xyvisi', 'fegox@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'cf628c59efab74f28e7dcc0cabb32b2a', '2021-09-01 16:06:14', NULL),
(75, 2, 'Middleton', 'Lucian ', 'rabuqiv', 'nylafugojo@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '671818ddb5167f206bb0fe58420f0a3f', '2021-09-01 16:06:44', NULL),
(76, 2, 'Hardy', 'Giselle ', 'zocofuneb', 'wuvyxypyp@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, 'cfbc4d9bbf56ccd2105d5a258debd307', '2021-09-01 16:07:37', NULL),
(77, 2, 'Price', 'Solomon ', 'vajikibuga', 'qinugex@mailinator.com', '92432e7c66519c4e404d347718ffe641a658ac7e', NULL, NULL, NULL, '57cfab2a4c5ff7af82accd2bb0e416e3', '2021-09-01 16:12:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE `user_category` (
  `uc_id` int(11) NOT NULL,
  `uc_name` varchar(50) NOT NULL,
  `uc_unique_key` varchar(80) NOT NULL,
  `uc_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shopp`
--
ALTER TABLE `shopp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user` (`unique_user`);

--
-- Indexes for table `user_category`
--
ALTER TABLE `user_category`
  ADD PRIMARY KEY (`uc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shopp`
--
ALTER TABLE `shopp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `user_category`
--
ALTER TABLE `user_category`
  MODIFY `uc_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
