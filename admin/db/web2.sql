-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 05, 2025 lúc 06:35 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `status`) VALUES
(1, '1', '$2y$10$ss6gHk0A2BLHjUCqSt5Mt.bgaMl8ZZ5zXHrlx1ERKQcmKUE6Ev.DC', 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ad_orders`
--

CREATE TABLE `ad_orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ad_products`
--

CREATE TABLE `ad_products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ad_users`
--

CREATE TABLE `ad_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `payment_method` enum('cod','online') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `username`, `receiver_name`, `phone`, `address`, `email`, `note`, `payment_method`, `total_price`, `created_at`) VALUES
(1, '1', '1', '11', '11', '1@gmail.com', '', 'online', 4000000.00, '2025-05-03 15:41:25'),
(2, '1', '1', '111111', '111111', '1@gmail.com', '', 'cod', 4000000.00, '2025-05-03 15:43:36'),
(3, '1', '1', '111111', '111111', '1@gmail.com', '', 'cod', 17580000.00, '2025-05-05 03:07:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 4000000.00),
(2, 2, 1, 1, 4000000.00),
(3, 3, 1, 1, 4000000.00),
(4, 3, 2, 4, 3000000.00),
(5, 3, 4, 1, 1580000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_cards`
--

CREATE TABLE `payment_cards` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `card_holder` varchar(255) NOT NULL,
  `card_expiry` varchar(7) NOT NULL,
  `card_serial` varchar(19) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `detailed_description` text DEFAULT NULL,
  `highlights` text DEFAULT NULL,
  `usage_instructions` text DEFAULT NULL,
  `reviews` text DEFAULT NULL,
  `faqs` text DEFAULT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `promotions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `description`, `specifications`, `image`, `created_at`, `detailed_description`, `highlights`, `usage_instructions`, `reviews`, `faqs`, `product_code`, `brand`, `status`, `promotions`) VALUES
(1, 'Yonex Astrox 88D Pro', 4000000.00, 'Yonex Astrox 88D Pro là lựa chọn tuyệt vời cho người chơi tấn công mạnh mẽ.', '<ul>\r\n    <li><strong>Trọng lượng:</strong> 4U (Khoảng 83g)</li>\r\n    <li><strong>Độ cứng:</strong> Cứng</li>\r\n    <li><strong>Điểm cân bằng:</strong> Nặng đầu</li>\r\n    <li><strong>Khung vợt:</strong> Carbon Graphite</li>\r\n    <li><strong>Công nghệ:</strong> ASTROX, Rotational Generator System</li>\r\n  </ul>', '/user/image/88d.webp', '2025-04-28 16:56:20', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Yonex Astrox 88D Pro là dòng vợt cao cấp dành cho người chơi tấn công mạnh mẽ.</li>\n    <li>Thiết kế mới với công nghệ Rotational Generator System giúp tăng độ chính xác và sức mạnh.</li>\n    <li>Khung vợt được làm từ vật liệu Carbon Graphite cao cấp, mang lại độ bền và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Yonex Astrox 88D Pro 2024 là phiên bản nâng cấp với nhiều cải tiến vượt trội, phù hợp với người chơi chuyên nghiệp và bán chuyên.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Khung vợt được thiết kế với dạng hộp giúp cấu trúc...\n', 'Phù hợp cho người chơi chuyên nghiệp.', 'Đánh giá 4.9/5 từ người dùng.', 'Câu hỏi về công nghệ và bảo hành.', 'YN_88DP', 'Yonex', 'Còn hàng', 'Tặng dây cước khi mua sản phẩm.'),
(2, 'Yonex Nanoflare 800', 3000000.00, 'Yonex Nanoflare 800 là dòng vợt nhẹ, phù hợp với người chơi thiên về tốc độ và phản xạ nhanh.', '<ul>\r\n    <li><strong>Trọng lượng:</strong> 5U (Khoảng 78g)</li>\r\n    <li><strong>Độ cứng:</strong> Trung bình</li>\r\n    <li><strong>Điểm cân bằng:</strong> Hơi nặng đầu</li>\r\n    <li><strong>Khung vợt:</strong> High Modulus Graphite</li>\r\n    <li><strong>Công nghệ:</strong> Sonic Flare System</li>\r\n  </ul>', '/user/image/nnf800.jpg', '2025-04-28 17:16:45', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Yonex Nanoflare 800 là dòng vợt siêu nhẹ, phù hợp cho người chơi yêu thích tốc độ và sự linh hoạt.</li>\n    <li>Ứng dụng công nghệ Sonic Flare System giúp tăng tốc độ vung vợt và cải thiện khả năng kiểm soát cầu.</li>\n    <li>Khung vợt được làm từ vật liệu H.M. Graphite và M40X, mang lại độ bền cao và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Yonex Nanoflare 800 là lựa chọn lý tưởng cho người chơi phong trào và bán chuyên, với thiết kế khí động học giúp tăng tốc độ và sự chính xác trong từng cú đánh.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Thiết kế khí động học giúp tăng tốc độ vung vợt.', 'Phù hợp cho người chơi bán chuyên và chuyên nghiệp.', 'Đánh giá 4.7/5 từ người dùng.', 'Câu hỏi về công nghệ và bảo hành.', 'YN_NNF800', 'Yonex', 'Còn hàng', 'Giảm giá 5% khi mua kèm túi đựng.'),
(3, 'Yonex Arcsaber 11 Pro', 7000000.00, 'Yonex Arcsaber 11 Pro là dòng vợt cân bằng, phù hợp với người chơi kiểm soát và điều cầu chính xác.', '<ul>\n    <li><strong>Trọng lượng:</strong> 3U (Khoảng 88g)</li>\n    <li><strong>Độ cứng:</strong> Cứng</li>\n    <li><strong>Điểm cân bằng:</strong> Cân bằng</li>\n    <li><strong>Khung vợt:</strong> Ultra PE Fiber</li>\n    <li><strong>Công nghệ:</strong> Pocketing Booster</li>\n  </ul>', '/user/image/arc11pro.jpg', '2025-04-28 17:16:45', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Yonex Arcsaber 11 Pro là dòng vợt cân bằng, phù hợp cho cả tấn công và phòng thủ.</li>\n    <li>Ứng dụng công nghệ Pocketing Booster giúp tăng độ chính xác và kiểm soát cầu.</li>\n    <li>Khung vợt được làm từ vật liệu H.M. Graphite cao cấp, mang lại độ bền và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Yonex Arcsaber 11 Pro là phiên bản nâng cấp với thiết kế hiện đại, phù hợp cho người chơi chuyên nghiệp và bán chuyên, mang lại sự ổn định và chính xác trong từng cú đánh.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Khung vợt được thiết kế với dạng hộp giúp cấu trúc...\n', 'Phù hợp cho người chơi chuyên nghiệp.', 'Đánh giá 4.8/5 từ người dùng.', 'Câu hỏi về độ bền và hiệu suất.', 'YN_ARC11P', 'Yonex', 'Còn hàng', 'Tặng túi đựng vợt khi mua sản phẩm.'),
(4, 'Yonex Duora Z-Strike', 1580000.00, 'Yonex Duora Z-Strike là dòng vợt đa năng, phù hợp với người chơi công thủ toàn diện.', '<ul>\r\n    <li><strong>Trọng lượng:</strong> 3U (Khoảng 88g)</li>\r\n    <li><strong>Độ cứng:</strong> Cứng</li>\r\n    <li><strong>Điểm cân bằng:</strong> Nặng đầu</li>\r\n    <li><strong>Khung vợt:</strong> Nanometric DR</li>\r\n    <li><strong>Công nghệ:</strong> Dual Optimum System</li>\r\n  </ul>', '/user/image/duorazstrike.jpg', '2025-04-28 17:16:45', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Yonex Duora Z-Strike là dòng vợt cân bằng, phù hợp cho cả tấn công và phòng thủ.</li>\n    <li>Ứng dụng công nghệ Dual Optimum System giúp tăng cường hiệu suất trong cả cú đánh thuận tay và trái tay.</li>\n    <li>Khung vợt được làm từ vật liệu H.M. Graphite, Namd và Tungsten, mang lại độ bền cao và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Yonex Duora Z-Strike là lựa chọn lý tưởng cho người chơi chuyên nghiệp, với thiết kế hiện đại và công nghệ tiên tiến, giúp tăng độ chính xác và sức mạnh trong từng cú đánh.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Thiết kế khí động học giúp tăng tốc độ vung vợt.', 'Phù hợp cho người chơi chuyên nghiệp.', 'Đánh giá 4.6/5 từ người dùng.', 'Câu hỏi về độ bền và hiệu suất.', 'YN_DZS', 'Yonex', 'Còn hàng', 'Tặng bao vợt khi mua sản phẩm.'),
(5, 'Lining Bladex 900 Moon', 2500000.00, 'Vợt cầu lông Lining Bladex 900 Moon', 'Khung vợt: Military Grade Carbon Fiber', '/user/image/bladex900moon.jpg', '2025-05-01 16:30:14', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Lining Bladex 900 Moon là dòng vợt nhẹ, phù hợp cho người chơi yêu thích tốc độ và sự linh hoạt.</li>\n    <li>Thiết kế khí động học giúp tăng tốc độ vung vợt và cải thiện khả năng kiểm soát cầu.</li>\n    <li>Khung vợt được làm từ vật liệu Military Grade Carbon Fiber, mang lại độ bền cao và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Lining Bladex 900 Moon là lựa chọn lý tưởng cho người chơi phong trào và bán chuyên, với thiết kế hiện đại và công nghệ tiên tiến, giúp tăng tốc độ và sự chính xác trong từng cú đánh.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Thiết kế khí động học giúp tăng tốc độ vung vợt.', 'Thích hợp cho người chơi phong trào và bán chuyên.', 'Đánh giá 4.7/5 từ người dùng.', 'Câu hỏi về trọng lượng và độ cân bằng.', 'LN-BX900', 'Lining', 'Còn hàng', 'Tặng túi đựng vợt khi mua sản phẩm.'),
(6, 'Lining Axforce 100', 3200000.00, 'Vợt cầu lông Lining Axforce 100', 'Khung vợt: Military Grade Carbon Fiber, Dynamic Optimum Frame', '/user/image/axf100.jpg', '2025-05-01 16:30:14', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Lining Axforce 100 là dòng vợt cao cấp, hỗ trợ lực đánh mạnh và tốc độ vung vợt nhanh.</li>\n    <li>Ứng dụng công nghệ Turbo Charging giúp tăng cường sức mạnh và độ chính xác trong từng cú đánh.</li>\n    <li>Khung vợt được làm từ vật liệu Military Grade Carbon Fiber và Dynamic Optimum Frame, mang lại độ bền cao và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Lining Axforce 100 là lựa chọn hoàn hảo cho người chơi chuyên nghiệp, với thiết kế hiện đại và công nghệ tiên tiến, giúp tăng cường sức mạnh và sự ổn định trong từng cú đánh.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Khung vợt được thiết kế với dạng hộp giúp cấu trúc khung ổn định cải thiện được  tối đa độ chính xác cho các pha các xoay tuyệt vời.', 'Phù hợp cho người chơi chuyên nghiệp.', 'Đánh giá 4.8/5 từ người dùng.', 'Câu hỏi về công nghệ và bảo hành.', 'LN-AXF100', 'Lining', 'Còn hàng', 'Tặng dây cước khi mua sản phẩm.'),
(7, 'Lining 3D Calibar 900', 4800000.00, 'Vợt cầu lông Lining 3D Calibar 900', 'Khung vợt: Military Grade Carbon Fiber, Aerotec Beam System', '/user/image/clb900.jpg', '2025-05-01 16:30:14', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Lining 3D Calibar 900 là dòng vợt mạnh mẽ, phù hợp cho người chơi tấn công.</li>\n    <li>Ứng dụng công nghệ 3D Calibar giúp tăng cường độ chính xác và sức mạnh trong từng cú đánh.</li>\n    <li>Khung vợt được làm từ vật liệu Military Grade Carbon Fiber và Aerotec Beam System, mang lại độ bền cao và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Lining 3D Calibar 900 là lựa chọn lý tưởng cho người chơi chuyên nghiệp, với thiết kế hiện đại và công nghệ tiên tiến, giúp tăng cường sức mạnh và sự chính xác trong từng cú đánh.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Công nghệ 3D Calibar giúp tăng cường độ chính xác.', 'Thích hợp cho người chơi chuyên nghiệp.', 'Đánh giá 4.9/5 từ người dùng.', 'Câu hỏi về độ bền và hiệu suất.', 'LN-3DC900', 'Lining', 'Còn hàng', 'Giảm giá 5% khi mua kèm túi đựng.'),
(8, 'Lining Habertec 9000', 3900000.00, 'Vợt cầu lông Lining Habertec 9000', 'Khung vợt: Military Grade Carbon Fiber, Stabilized Torsion Angle', '/user/image/hbt9000.jpg', '2025-05-01 16:30:14', '<h3>Đặc điểm nổi bật</h3>\n<ul>\n    <li>Lining Habertec 9000 là dòng vợt cân bằng, phù hợp cho cả tấn công và phòng thủ.</li>\n    <li>Ứng dụng công nghệ Stabilized Torsion Angle giúp tăng độ ổn định và kiểm soát cầu.</li>\n    <li>Khung vợt được làm từ vật liệu Military Grade Carbon Fiber, mang lại độ bền cao và hiệu suất tối ưu.</li>\n</ul>\n<h3>Thông tin chi tiết</h3>\n<p>Vợt cầu lông Lining Habertec 9000 là lựa chọn lý tưởng cho người chơi bán chuyên và chuyên nghiệp, với thiết kế hiện đại và công nghệ tiên tiến, giúp tăng cường sự ổn định và chính xác trong từng cú đánh.</p>\n<h3>Hướng dẫn sử dụng</h3>\n<p>Để đạt hiệu quả tốt nhất, hãy căng lưới với mức căng phù hợp (khuyến nghị từ 20-28 lbs) và bảo quản vợt ở nơi khô ráo, tránh ánh nắng trực tiếp.</p>', 'Công nghệ Habertec giúp tăng độ ổn định.', 'Phù hợp cho người chơi bán chuyên và chuyên nghiệp.', 'Đánh giá 4.6/5 từ người dùng.', 'Câu hỏi về trọng lượng và độ cân bằng.', 'LN-HBT9000', 'Lining', 'Còn hàng', 'Tặng bao vợt khi mua sản phẩm.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('Nam','Nữ','Khác') DEFAULT 'Khác',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `address`, `birthdate`, `gender`, `created_at`, `updated_at`) VALUES
(5, '3', '$2y$10$fRhrIzWonN2HY3brPdqwOu5FqI995bHNgcq34Qr9Kgc6Bondhi.7W', '3@gmail.com', NULL, NULL, NULL, 'Khác', '2025-05-03 08:25:15', '2025-05-03 08:25:15'),
(6, '4', '$2y$10$fRKDtiGiGdmdkvrJOjRSEuJO4xh4pQ7OLKr3zdKVOTW0iBsCnP0iG', '4@gmail.com', NULL, NULL, NULL, 'Khác', '2025-05-03 08:28:46', '2025-05-03 08:28:46'),
(7, '1', '$2y$10$nfFsCs3boTV.eqk8l8BCTehrXJh8kBcNAV6VM8IOug6hmuoNmpKKy', '1@gmail.com', '111111', '111111', '1111-11-11', 'Nam', '2025-05-03 08:32:24', '2025-05-03 15:43:18');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `ad_orders`
--
ALTER TABLE `ad_orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ad_products`
--
ALTER TABLE `ad_products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ad_users`
--
ALTER TABLE `ad_users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `payment_cards`
--
ALTER TABLE `payment_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `ad_orders`
--
ALTER TABLE `ad_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ad_products`
--
ALTER TABLE `ad_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ad_users`
--
ALTER TABLE `ad_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `payment_cards`
--
ALTER TABLE `payment_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payment_cards`
--
ALTER TABLE `payment_cards`
  ADD CONSTRAINT `payment_cards_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
