-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2018 at 06:07 AM
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
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `naziv` varchar(30) NOT NULL,
  `kategorija` varchar(30) NOT NULL,
  `opis` text NOT NULL,
  `dodao` varchar(15) NOT NULL,
  `datum` date NOT NULL,
  `slika` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `naziv`, `kategorija`, `opis`, `dodao`, `datum`, `slika`) VALUES
(1, 'Samsung Galaxy S9', 'Smartphone', 'Smartphone for hardcore users.', 'admin', '2018-06-24', 'https://vidi-vishe.com/wp-content/uploads/2018/02/Samsung-Galaxy-S9-beskrajni-zaslon-696x418.jpg'),
(5, 'Asus Vivo Book Max', 'Laptop', 'Laptop for serious users.', 'admin', '2018-06-24', 'https://cdn.vox-cdn.com/thumbor/Q9M-lKgA2QNLVAMgfBnrOe7RJhw=/0x0:1050x700/1200x800/filters:focal(441x266:609x434)/cdn.vox-cdn.com/uploads/chorus_image/image/56200239/unnamed.0.png'),
(6, 'Kogan 42\" Full HD LED TV', 'TV', 'The best TV ever!', 'admin', '2018-06-25', 'https://images.kogan.com/image/fetch/s--8kZ0_HcA--/b_white,c_pad,f_auto,h_400,q_auto:good,w_600/https://assets.kogan.com/files/product/KALED42XXXVA/KALED42XXXVA_2.jpg'),
(7, 'Samsung 55\" Curved TV', 'TV', 'Picture visible from every angle.', 'admin', '2018-06-25', 'https://images.samsung.com/is/image/samsung/levant-full-hd-k6500-ua55k6500arxtw-001-front-black?$PD_GALLERY_L_JPG$'),
(8, 'Skullcandy Hesh 2 Wireless ', 'Headphones', 'Headphones with sound in town!!', 'admin', '2018-06-25', 'https://hniesfp.imgix.net/8/images/detailed/59/S6HBGY-374.jpg?fit=fill'),
(9, 'HP Spectre Thin Laptop 13\"', 'Laptop', 'Perfect for casual users.', 'admin', '2018-06-25', 'https://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c05682022.png'),
(10, 'JBuddies Studio Bluetooth', 'Headphones', 'Headphones with perfect bass.', 'admin', '2018-06-25', 'https://cdn.shopify.com/s/files/1/0240/9337/products/Jbuddies_Studio-BT-Headphone-Blue_1.jpg?v=1494431258'),
(11, 'Sony Xperia Z5 Compact', 'Smartphone', 'Awesome Camera.', 'admin', '2018-06-25', 'http://img.dxcdn.com/productimages/sku_418013_1.jpg'),
(12, 'HP LaserJet P1108', 'Printer', 'Trololol printer.', 'admin', '2018-06-25', 'https://images-na.ssl-images-amazon.com/images/I/71kNJYvFEOL._SL1500_.jpg'),
(13, 'Samsung Galaxy S8', 'Smartphone', 'Perfect smartphone for trolls.', 'admin', '2018-06-28', 'https://cdn.x-kom.pl/i/setup/images/prod/big/product-large,samsung-galaxy-s8-g950f-orchid-grey-356433,2017/7/pr_2017_7_13_13_51_33_986.jpg'),
(15, 'Samasung Galaxy S7', 'Smartphone', 'Smartphone with great camera.', 'admin', '2018-06-28', 'http://images.samsung.com/is/image/samsung/in-galaxy-c7-pro-c710f-sm-c701fnbdins-61891142?$PD_GALLERY_JPG$'),
(16, 'Samasung Galaxy S6 edge', 'Smartphone', 'Smartphone with great design.', 'admin', '2018-06-28', 'https://s7d2.scene7.com/is/image/SamsungUS/Pdpkeyfeature-sm-g928rzkausc-600x600-C1-062016?$product-details-jpg$');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `admin`) VALUES
(1, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
