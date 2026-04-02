-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2026 at 10:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eav_cs`
--

-- --------------------------------------------------------

--
-- Table structure for table `entities`
--

CREATE TABLE `entities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entities`
--

INSERT INTO `entities` (`id`, `name`, `entity_type_id`, `created_at`) VALUES
(1, 'this-is-a-blog', 1, '2025-04-06 14:48:15'),
(2, 'another-blog-here', 1, '2025-04-08 14:59:11'),
(3, 'alternating-70-30-content-layout', 12, '2025-04-09 17:45:27'),
(4, 'two-columns--image-left-----text-right', 12, '2025-04-09 17:47:33'),
(5, 'two-columns--text-left-----image-right', 12, '2025-04-09 17:50:17'),
(6, 'two-columns--both-text-blocks--no-image-', 12, '2025-04-09 17:50:45'),
(7, 'centered-text---buttons-in-two-columns', 12, '2025-04-09 17:51:19'),
(8, 'two-side-by-side-cards', 12, '2025-04-09 17:51:48'),
(9, 'three-column-feature-grid', 12, '2025-04-09 17:56:15'),
(10, 'full-width-hero-section-with-centered-text', 12, '2025-04-09 17:56:49'),
(11, 'image-card-trio--modern-portfolio-style-', 12, '2025-04-09 17:58:46'),
(12, 'call-to-action-with-icon---tagline', 12, '2025-04-09 17:59:20'),
(13, 'feature-columns-with-icons--modern-landing-style-', 12, '2025-04-09 18:00:10'),
(14, 'simple-single-testimonial--centered-', 12, '2025-04-09 18:01:06'),
(15, 'three-testimonials-in-columns', 12, '2025-04-09 18:04:08'),
(16, 'testimonial-slider--materialize-carousel-', 12, '2025-04-09 18:04:44'),
(17, 'full-width-hero-testimonial', 12, '2025-04-09 18:41:43'),
(18, 'simple-three-tier-pricing-table', 12, '2025-04-09 18:46:06'),
(19, 'feature-comparison-table', 12, '2025-04-10 06:09:03'),
(20, 'minimal-flat-pricing-cards--modern-look-', 12, '2025-04-10 06:09:29'),
(21, 'bold-call-to-action-banner', 12, '2025-04-10 06:11:45'),
(22, 'cta-with-side-image', 12, '2025-04-10 06:12:10'),
(23, 'minimal-centered-cta', 12, '2025-04-10 06:56:14'),
(24, 'simple-faq-section--collapsible-', 12, '2025-04-10 06:56:48'),
(25, 'faq-grid--modern-styled', 12, '2025-04-10 06:57:15'),
(26, 'contact-us-simple-form-section', 12, '2025-04-10 07:13:59'),
(27, 'feature-highlights-with-icons', 12, '2025-04-10 07:14:27'),
(28, 'modern-stats-block', 12, '2025-04-10 07:21:04'),
(29, 'product-group-tabs', 12, '2025-04-11 12:38:32'),
(30, 'left-aligned-caption-over-dark-background-image', 12, '2025-04-11 12:54:34'),
(31, 'left-aligned-caption-over-light-background-image', 12, '2025-04-11 12:54:53'),
(32, 'right-aligned-dark-background-with-white-text', 12, '2025-04-11 13:21:34'),
(33, 'right-aligned-light-background-with-dark-text', 12, '2025-04-11 13:22:02'),
(36, 'greaseproof-paper-bags-banner', 14, '2025-04-12 17:18:14'),
(41, 'home', 16, '2025-04-15 09:44:26'),
(43, 'product-page-features', 15, '2025-04-15 14:46:24'),
(44, 'trusted-by-thousands-block', 12, '2025-04-15 15:21:56'),
(45, 'why-choose-us-block', 12, '2025-04-15 15:22:18'),
(46, 'vertical-our-promise', 12, '2025-04-15 15:25:40'),
(47, 'vertical-your-perfect-packaging-partner', 12, '2025-04-15 15:26:04'),
(48, 'visit-us', 8, '2025-04-15 18:40:31'),
(49, 'about-us', 8, '2025-04-16 17:20:22'),
(99, 'americano', 13, '2025-04-18 18:14:35'),
(100, 'double-espresso', 13, '2025-04-18 18:26:19'),
(101, 'espresso', 13, '2025-04-18 18:29:40'),
(102, 'cold-brew-bottle', 17, '2025-04-19 17:58:07'),
(103, 'house-blend', 17, '2025-04-19 18:35:28'),
(104, 'ethiopian-yirgacheffe', 17, '2025-04-19 18:47:02'),
(107, 'home-page-captions', 15, '2026-03-14 07:08:41'),
(108, 'home-page-slideshow', 15, '2026-03-15 09:56:42'),
(109, 'reservation-request-form', 15, '2026-03-15 12:47:42'),
(110, 'events-grid', 12, '2026-03-15 13:16:39'),
(111, 'event-grid', 15, '2026-03-15 13:22:50'),
(112, 'daniel-r-testimonial', 23, '2026-03-19 08:14:29'),
(113, 'emily-s-testimonial', 23, '2026-03-19 08:15:39'),
(114, 'marcus-l-testimonial', 23, '2026-03-19 08:16:28'),
(115, 'live-acoustic-night', 24, '2026-03-20 07:57:09'),
(116, 'jam-session', 24, '2026-03-20 07:58:34'),
(117, 'coffee-tasting', 24, '2026-03-20 08:00:41'),
(118, 'cappuccino', 18, '2026-03-20 12:42:35'),
(119, 'iced-latte', 19, '2026-03-22 10:15:26'),
(120, 'iced-americano', 19, '2026-03-22 10:23:55'),
(121, 'iced-caramel-latte', 19, '2026-03-22 10:46:09'),
(122, 'latte', 18, '2026-03-22 12:40:07'),
(123, 'flat-white', 18, '2026-03-22 12:45:48'),
(124, 'cold-brew-classic', 20, '2026-03-23 05:59:09'),
(125, 'vanilla-sweet-cream', 20, '2026-03-23 06:00:03'),
(126, 'caramel-latte', 21, '2026-03-23 07:07:04'),
(127, 'mocha', 21, '2026-03-23 07:08:30'),
(128, 'hazelnut-latte', 21, '2026-03-23 07:21:16'),
(129, 'masala-chai-latte', 22, '2026-03-23 07:23:32'),
(130, 'green-tea', 22, '2026-03-23 07:25:31'),
(131, 'light--refreshing--and-gently-energizing-', 22, '2026-03-23 07:28:54'),
(133, 'home-two', 16, '2026-03-26 08:22:30'),
(134, 'white-home-page-slideshow', 15, '2026-03-27 14:27:25'),
(135, 'white-reservation-request-form', 15, '2026-03-27 15:15:49'),
(137, 'checkout', 8, '2026-03-29 17:36:36'),
(138, 'table-5-order-20260330-200058', 25, '2026-03-30 18:00:15'),
(139, 'table-5-order-20260401-095308', 25, '2026-04-01 05:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `entity_attributes`
--

CREATE TABLE `entity_attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_attributes`
--

INSERT INTO `entity_attributes` (`id`, `name`) VALUES
(41, 'author'),
(42, 'company'),
(3, 'content'),
(10, 'Content_Editable_Template'),
(7, 'custom_style'),
(34, 'customer_name'),
(35, 'customer_photo'),
(37, 'event_date'),
(36, 'event_description'),
(38, 'event_time'),
(40, 'is_current_home'),
(32, 'is_featured'),
(6, 'json+ld'),
(8, 'lead_image'),
(11, 'lead_Image_Title'),
(17, 'Material'),
(24, 'Minimum_Order_Quantity'),
(39, 'net_quantity'),
(48, 'order_close_time'),
(47, 'order_closed'),
(49, 'order_closed_and_paid'),
(43, 'order_id'),
(44, 'order_items'),
(45, 'order_total'),
(52, 'ordered_by'),
(51, 'ordered_from_phone'),
(29, 'pack_quantity'),
(16, 'Paper_Type'),
(26, 'Price'),
(25, 'Product_Icon'),
(14, 'product_photo'),
(15, 'product_photo_gallery_photo_1'),
(19, 'product_photo_gallery_photo_2'),
(20, 'product_photo_gallery_photo_3'),
(21, 'product_photo_gallery_photo_4'),
(22, 'product_photo_gallery_photo_5'),
(33, 'rating'),
(4, 'short_description'),
(18, 'Size_Formats'),
(23, 'Sizes'),
(31, 'sku'),
(30, 'stock_status'),
(2, 'sub_title'),
(46, 'table'),
(1, 'title'),
(28, 'unit_quantity'),
(27, 'vat'),
(9, 'Video'),
(12, 'Video_Caption'),
(13, 'Video_Description');

-- --------------------------------------------------------

--
-- Table structure for table `entity_attribute_data`
--

CREATE TABLE `entity_attribute_data` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_attribute_data`
--

INSERT INTO `entity_attribute_data` (`id`, `entity_id`, `attribute_id`, `value`) VALUES
(85, 1, 8, 'media/67f532d503854_487357831_10232280389945855_1797887203142469934_n.jpg'),
(86, 2, 3, '<div><b><u>test here </u></b><br></div>'),
(87, 2, 4, '<h2>test here&nbsp; fdsfdsfdsf&nbsp; asas asdas</h2>'),
(88, 2, 2, 'test second'),
(89, 2, 1, 'test second line'),
(90, 2, 8, 'media/67f539bf536d2_bright_daisies_and_similar_flowers_arranged_sparingly_with_gaps_on_a_white_background.jpg'),
(96, 1, 1, 'test'),
(97, 1, 2, 'test'),
(98, 1, 4, '<h2>test here</h2>'),
(99, 1, 3, '<h1>test</h1>'),
(100, 1, 9, 'media/67f6308b403cd_breathe.mp4'),
(103, 4, 1, 'Two Columns, Image Left – Text Right'),
(104, 4, 10, '<div class=\"section\">\r\n  <div class=\"row valign-wrapper\">\r\n    <div class=\"col s12 m6\">\r\n      <img src=\"https://via.placeholder.com/500x300\" alt=\"Placeholder\" class=\"responsive-img\">\r\n    </div>\r\n    <div class=\"col s12 m6\">\r\n      <h2 class=\"header\">Balanced Presentation</h2>\r\n      <p>Fusce dapibus tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\r\n    </div>\r\n  </div>\r\n</div>\r\n'),
(105, 5, 1, 'Two Columns, Text Left – Image Right'),
(106, 5, 10, '<div class=\"section\">\r\n  <div class=\"row valign-wrapper\">\r\n    <div class=\"col s12 m6\">\r\n      <h2 class=\"header\">Sleek and Simple</h2>\r\n      <p>Cras mattis consectetur purus sit amet fermentum. Donec ullamcorper nulla non metus auctor fringilla.</p>\r\n    </div>\r\n    <div class=\"col s12 m6\">\r\n      <img src=\"https://via.placeholder.com/500x300\" alt=\"Placeholder\" class=\"responsive-img\">\r\n    </div>\r\n  </div>\r\n</div>\r\n'),
(107, 6, 1, 'Two Columns, Both Text Blocks (No Image)'),
(108, 6, 10, '<div class=\"section\">\r\n  <div class=\"row\">\r\n    <div class=\"col s12 m6\">\r\n      <h5>Why Choose Us?</h5>\r\n      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>\r\n    </div>\r\n    <div class=\"col s12 m6\">\r\n      <h5>Our Mission</h5>\r\n      <p>Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur.</p>\r\n    </div>\r\n  </div>\r\n</div>'),
(109, 7, 1, 'Centered Text + Buttons in Two Columns'),
(110, 7, 10, '<div class=\"section\">\r\n  <div class=\"row center-align\">\r\n    <div class=\"col s12 m6\">\r\n      <h5>Explore Our Services</h5>\r\n      <a class=\"btn waves-effect teal\">Learn More</a>\r\n    </div>\r\n    <div class=\"col s12 m6\">\r\n      <h5>Join the Community</h5>\r\n      <a class=\"btn waves-effect purple\">Get Started</a>\r\n    </div>\r\n  </div>\r\n</div>\r\n'),
(111, 8, 1, 'Two Side-by-Side Cards'),
(112, 8, 10, '<div class=\"section\">\r\n  <div class=\"row\">\r\n    <div class=\"col s12 m6\">\r\n      <div class=\"card\">\r\n        <div class=\"card-image\">\r\n          <img src=\"https://via.placeholder.com/600x300\">\r\n        </div>\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title\">Card Title One</span>\r\n          <p>Some quick example text to build on the card content.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n    <div class=\"col s12 m6\">\r\n      <div class=\"card\">\r\n        <div class=\"card-image\">\r\n          <img src=\"https://via.placeholder.com/600x300\">\r\n        </div>\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title\">Card Title Two</span>\r\n          <p>Additional supporting content goes here.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>\r\n'),
(113, 9, 1, 'Three-Column Feature Grid'),
(114, 9, 10, '<div class=\"section\">\r\n  <div class=\"row center-align\">\r\n    <div class=\"col s12 m4\">\r\n      <i class=\"material-icons large\">flash_on</i>\r\n      <h5>Fast Performance</h5>\r\n      <p>We use the latest tech to deliver blazing-fast load times.</p>\r\n    </div>\r\n    <div class=\"col s12 m4\">\r\n      <i class=\"material-icons large\">group</i>\r\n      <h5>User Focused</h5>\r\n      <p>Designed with real users in mind for a seamless experience.</p>\r\n    </div>\r\n    <div class=\"col s12 m4\">\r\n      <i class=\"material-icons large\">settings</i>\r\n      <h5>Fully Customizable</h5>\r\n      <p>Tweak it your way with simple controls and flexibility.</p>\r\n    </div>\r\n  </div>\r\n</div>\r\n'),
(115, 10, 1, 'Full-Width Hero Section with Centered Text'),
(116, 10, 10, '<div class=\"section teal lighten-2 white-text center-align\" style=\"padding: 60px 20px;\">\r\n  <h2>Build Something Amazing</h2>\r\n  <p class=\"flow-text\">Start your journey with our intuitive and powerful platform.</p>\r\n  <a class=\"btn-large white teal-text text-lighten-2\" style=\"margin-top: 20px;\">Get Started</a>\r\n</div>\r\n'),
(117, 11, 1, 'Image Card Trio (Modern Portfolio Style)'),
(118, 11, 10, '<div class=\"section\">\r\n  <div class=\"row\">\r\n    <div class=\"col s12 m4\">\r\n      <div class=\"card hoverable\">\r\n        <div class=\"card-image\">\r\n          <img src=\"https://via.placeholder.com/400x250\" alt=\"Project\">\r\n        </div>\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title\">Project One</span>\r\n          <p>A short description of your awesome project or service.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n    <div class=\"col s12 m4\">\r\n      <div class=\"card hoverable\">\r\n        <div class=\"card-image\">\r\n          <img src=\"https://via.placeholder.com/400x250\" alt=\"Project\">\r\n        </div>\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title\">Project Two</span>\r\n          <p>Another brief description to showcase your work.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n    <div class=\"col s12 m4\">\r\n      <div class=\"card hoverable\">\r\n        <div class=\"card-image\">\r\n          <img src=\"https://via.placeholder.com/400x250\" alt=\"Project\">\r\n        </div>\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title\">Project Three</span>\r\n          <p>Let the visuals do the talking with clean card layouts.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>\r\n'),
(119, 12, 1, 'Call to Action with Icon & Tagline'),
(120, 12, 10, '<div class=\"section grey lighten-4 center-align\" style=\"padding: 40px 20px;\">\r\n  <i class=\"material-icons large teal-text\">explore</i>\r\n  <h4>Ready to Explore?</h4>\r\n  <p class=\"flow-text\">Sign up today and see what you’ve been missing.</p>\r\n  <a class=\"btn waves-effect teal lighten-1\">Join Now</a>\r\n</div>\r\n'),
(121, 13, 1, 'Feature Columns with Icons (Modern Landing Style)'),
(122, 13, 10, '<div class=\"section\">\r\n  <div class=\"row\">\r\n    <div class=\"col s12 m4 center-align\">\r\n      <i class=\"material-icons medium\">security</i>\r\n      <h6>Secure</h6>\r\n      <p>Top-tier protection for peace of mind.</p>\r\n    </div>\r\n    <div class=\"col s12 m4 center-align\">\r\n      <i class=\"material-icons medium\">autorenew</i>\r\n      <h6>Seamless Updates</h6>\r\n      <p>Always evolving with continuous improvements.</p>\r\n    </div>\r\n    <div class=\"col s12 m4 center-align\">\r\n      <i class=\"material-icons medium\">star</i>\r\n      <h6>Top Rated</h6>\r\n      <p>Trusted by thousands of happy users.</p>\r\n    </div>\r\n  </div>\r\n</div>\r\n'),
(123, 14, 1, 'Simple Single Testimonial (Centered)'),
(124, 14, 10, '<div class=\"section center-align\">\r\n  <img src=\"https://via.placeholder.com/100\" alt=\"Client Photo\" class=\"circle responsive-img z-depth-1\" style=\"margin-bottom: 20px;\">\r\n  <h5>\"This service completely transformed our workflow. Highly recommended!\"</h5>\r\n  <p class=\"grey-text text-darken-1\">— Jane Doe, Marketing Director</p>\r\n</div>\r\n'),
(155, 16, 1, 'Testimonial Slider (Materialize Carousel)'),
(156, 16, 10, '<div class=\"section\">\n  <div class=\"carousel carousel-slider center\" data-indicators=\"true\">\n    <div class=\"carousel-item white-text teal lighten-1\" href=\"#one!\">\n      <h5>\"Smooth onboarding and beautiful design!\"</h5>\n      <p>- Emily F., Tech Lead</p>\n    </div>\n    <div class=\"carousel-item white-text teal lighten-2\" href=\"#two!\">\n      <h5>\"We saw a 50% boost in productivity.\"</h5>\n      <p>- Carlos M., Project Manager</p>\n    </div>\n    <div class=\"carousel-item white-text teal lighten-3\" href=\"#three!\">\n      <h5>\"The support team is amazing!\"</h5>\n      <p>- Fatima N., Business Owner</p>\n    </div>\n  </div>\n</div>\n\n<script>\n  document.addEventListener(\'DOMContentLoaded\', function() {\n    var elems = document.querySelectorAll(\'.carousel\');\n    M.Carousel.init(elems, { fullWidth: true, indicators: true });\n  });\n</script>'),
(157, 3, 1, 'Alternating 70-30 Content Layout'),
(158, 3, 10, '<div class=\"section\">\n  <!-- Row 1: Image Left (30%), Text Right (70%) -->\n  <div class=\"row valign-wrapper\">\n    <div class=\"col s12 m4\">\n      <img src=\"https://via.placeholder.com/300x200\" alt=\"Placeholder Image\" class=\"responsive-img\">\n    </div>\n    <div class=\"col s12 m8\">\n      <h2 class=\"header\">Engaging Headline One</h2>\n      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\n    </div>\n  </div>\n\n  <!-- Row 2: Text Left (70%), Image Right (30%) -->\n  <div class=\"row valign-wrapper\">\n    <div class=\"col s12 m8\">\n      <h2 class=\"header\">Captivating Headline Two</h2>\n      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\n    </div>\n    <div class=\"col s12 m4\">\n      <img src=\"https://via.placeholder.com/300x200\" alt=\"Placeholder Image\" class=\"responsive-img\">\n    </div>\n  </div>\n</div>\n'),
(159, 17, 1, 'Full-Width Hero Testimonial'),
(160, 17, 10, '<div class=\"section teal lighten-5\" style=\"padding: 60px 20px;\">\n  <div class=\"row\">\n    <div class=\"col s12 m4 center-align\">\n      <img src=\"https://via.placeholder.com/120\" alt=\"Client\" class=\"circle responsive-img z-depth-1\">\n    </div>\n    <div class=\"col s12 m8\">\n      <h5>\"Their platform helped us launch faster and smarter. Can\'t imagine working without it now.\"</h5>\n      <p class=\"grey-text text-darken-2\">— Olivia B., Creative Director</p>\n    </div>\n  </div>\n</div>'),
(161, 18, 1, 'Simple Three-Tier Pricing Table'),
(162, 18, 10, '<div class=\"section\">\n  <div class=\"row\">\n    <div class=\"col s12 m4\">\n      <div class=\"card\">\n        <div class=\"card-content center-align\">\n          <h5>Basic</h5>\n          <h4>$9<span class=\"grey-text text-darken-1\">/mo</span></h4>\n          <ul class=\"collection\">\n            <li class=\"collection-item\">1 User</li>\n            <li class=\"collection-item\">Basic Support</li>\n            <li class=\"collection-item\">5 Projects</li>\n          </ul>\n          <a href=\"#\" class=\"btn waves-effect teal\">Choose</a>\n        </div>\n      </div>\n    </div>\n    <div class=\"col s12 m4\">\n      <div class=\"card teal lighten-4 z-depth-2\">\n        <div class=\"card-content center-align\">\n          <h5>Pro</h5>\n          <h4>$29<span class=\"grey-text text-darken-1\">/mo</span></h4>\n          <ul class=\"collection\">\n            <li class=\"collection-item\">5 Users</li>\n            <li class=\"collection-item\">Priority Support</li>\n            <li class=\"collection-item\">Unlimited Projects</li>\n          </ul>\n          <a href=\"#\" class=\"btn waves-effect teal darken-1\">Most Popular</a>\n        </div>\n      </div>\n    </div>\n    <div class=\"col s12 m4\">\n      <div class=\"card\">\n        <div class=\"card-content center-align\">\n          <h5>Enterprise</h5>\n          <h4>$99<span class=\"grey-text text-darken-1\">/mo</span></h4>\n          <ul class=\"collection\">\n            <li class=\"collection-item\">Unlimited Users</li>\n            <li class=\"collection-item\">Dedicated Support</li>\n            <li class=\"collection-item\">Custom Solutions</li>\n          </ul>\n          <a href=\"#\" class=\"btn waves-effect teal\">Contact Us</a>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n'),
(163, 19, 1, 'Feature Comparison Table'),
(164, 19, 10, '<div class=\"section\">\n  <table class=\"striped responsive-table\">\n    <thead>\n      <tr>\n        <th>Features</th>\n        <th>Basic</th>\n        <th>Pro</th>\n        <th>Enterprise</th>\n      </tr>\n    </thead>\n    <tbody>\n      <tr>\n        <td>Users</td>\n        <td>1</td>\n        <td>5</td>\n        <td>Unlimited</td>\n      </tr>\n      <tr>\n        <td>Storage</td>\n        <td>10GB</td>\n        <td>100GB</td>\n        <td>1TB</td>\n      </tr>\n      <tr>\n        <td>Support</td>\n        <td>Basic</td>\n        <td>Priority</td>\n        <td>Dedicated</td>\n      </tr>\n      <tr>\n        <td>API Access</td>\n        <td><i class=\"material-icons red-text\">close</i></td>\n        <td><i class=\"material-icons green-text\">check</i></td>\n        <td><i class=\"material-icons green-text\">check</i></td>\n      </tr>\n      <tr>\n        <td></td>\n        <td><a href=\"#\" class=\"btn-flat\">Choose</a></td>\n        <td><a href=\"#\" class=\"btn teal lighten-1\">Choose</a></td>\n        <td><a href=\"#\" class=\"btn-flat\">Contact Us</a></td>\n      </tr>\n    </tbody>\n  </table>\n</div>\n'),
(165, 20, 1, 'Minimal Flat Pricing Cards (Modern Look)'),
(166, 20, 10, '<div class=\"section\">\n  <div class=\"row\">\n    <div class=\"col s12 m6 l4\">\n      <div class=\"card-panel center-align\">\n        <h6>Starter</h6>\n        <h4 class=\"teal-text\">$0</h4>\n        <p class=\"grey-text\">For personal use</p>\n        <a href=\"#\" class=\"btn-flat\">Get Started</a>\n      </div>\n    </div>\n    <div class=\"col s12 m6 l4\">\n      <div class=\"card-panel center-align teal lighten-4\">\n        <h6>Team</h6>\n        <h4 class=\"teal-text\">$49</h4>\n        <p class=\"grey-text\">Up to 10 users</p>\n        <a href=\"#\" class=\"btn teal\">Buy Now</a>\n      </div>\n    </div>\n    <div class=\"col s12 m6 l4\">\n      <div class=\"card-panel center-align\">\n        <h6>Agency</h6>\n        <h4 class=\"teal-text\">$99</h4>\n        <p class=\"grey-text\">Unlimited users</p>\n        <a href=\"#\" class=\"btn-flat\">Contact</a>\n      </div>\n    </div>\n  </div>\n</div>\n'),
(167, 21, 1, 'Bold Call-To-Action Banner'),
(168, 21, 10, '<div class=\"section teal lighten-2 white-text center-align\" style=\"padding: 40px 20px;\">\n  <h4>Ready to Start Your Journey?</h4>\n  <p class=\"flow-text\">Sign up today and transform the way you work.</p>\n  <a class=\"btn-large white teal-text text-lighten-2\">Get Started</a>\n</div>\n'),
(169, 22, 1, 'CTA with Side Image'),
(170, 22, 10, '<div class=\"section\">\n  <div class=\"row valign-wrapper\">\n    <div class=\"col s12 m6\">\n      <img src=\"https://via.placeholder.com/500x300\" alt=\"CTA Image\" class=\"responsive-img z-depth-1\" />\n    </div>\n    <div class=\"col s12 m6\">\n      <h5>Take the Leap</h5>\n      <p>Join thousands who have already discovered the benefits of our platform. Don’t miss out!</p>\n      <a class=\"btn teal\">Join Now</a>\n    </div>\n  </div>\n</div>\n'),
(171, 23, 1, 'Minimal Centered CTA'),
(172, 23, 10, '<div class=\"section center-align\">\n  <h5 class=\"grey-text text-darken-3\">Need a Custom Solution?</h5>\n  <p>Our experts are ready to build a solution that fits your needs.</p>\n  <a href=\"#\" class=\"btn-flat teal-text text-darken-2\">Talk to Sales</a>\n</div>\n'),
(173, 24, 1, 'Simple FAQ Section (Collapsible)'),
(174, 24, 10, '<div class=\"section\">\n  <h5>Frequently Asked Questions</h5>\n  <ul class=\"collapsible\">\n    <li>\n      <div class=\"collapsible-header\"><i class=\"material-icons\">help_outline</i>How do I sign up?</div>\n      <div class=\"collapsible-body\"><span>You can sign up using our registration form located at the top right of the page.</span></div>\n    </li>\n    <li>\n      <div class=\"collapsible-header\"><i class=\"material-icons\">lock</i>Is my data secure?</div>\n      <div class=\"collapsible-body\"><span>Yes, we use industry-standard encryption to keep your data safe and private.</span></div>\n    </li>\n    <li>\n      <div class=\"collapsible-header\"><i class=\"material-icons\">attach_money</i>What payment methods are accepted?</div>\n      <div class=\"collapsible-body\"><span>We accept Visa, Mastercard, PayPal, and more.</span></div>\n    </li>\n  </ul>\n</div>\n'),
(177, 25, 1, 'FAQ Grid (Modern Styled)'),
(178, 25, 10, '<div class=\"section\">\n  <h5 class=\"center-align\">Got Questions?</h5>\n  <div class=\"row\">\n    <div class=\"col s12 m6\">\n      <h6>How long is the free trial?</h6>\n      <p>You get 14 days of full access to all features. No credit card required.</p>\n    </div>\n    <div class=\"col s12 m6\">\n      <h6>Can I change my plan later?</h6>\n      <p>Yes, you can upgrade, downgrade, or cancel at any time from your dashboard.</p>\n    </div>\n    <div class=\"col s12 m6\">\n      <h6>Do you offer support?</h6>\n      <p>Absolutely. We have a support team available 24/7 via chat and email.</p>\n    </div>\n    <div class=\"col s12 m6\">\n      <h6>Is there a refund policy?</h6>\n      <p>Yes, we offer a 7-day money-back guarantee on all paid plans.</p>\n    </div>\n  </div>\n</div>'),
(179, 26, 1, 'Contact Us Simple Form Section'),
(180, 26, 10, '<div class=\"section grey lighten-4\">\n  <div class=\"row\">\n    <div class=\"col s12 m8 offset-m2\">\n      <h5 class=\"center-align\">Get in Touch</h5>\n      <form>\n        <div class=\"input-field\">\n          <input type=\"text\" id=\"name\" required>\n          <label for=\"name\">Your Name</label>\n        </div>\n        <div class=\"input-field\">\n          <input type=\"email\" id=\"email\" required>\n          <label for=\"email\">Your Email</label>\n        </div>\n        <div class=\"input-field\">\n          <textarea class=\"materialize-textarea\" id=\"message\" required></textarea>\n          <label for=\"message\">Your Message</label>\n        </div>\n        <div class=\"center-align\">\n          <button class=\"btn teal\">Send Message</button>\n        </div>\n      </form>\n    </div>\n  </div>\n</div>\n'),
(181, 27, 1, 'Feature Highlights with Icons'),
(182, 27, 10, '<div class=\"section\">\n  <h5 class=\"center-align\">Why Choose Us?</h5>\n  <div class=\"row center\">\n    <div class=\"col s12 m4\">\n      <i class=\"material-icons large teal-text\">speed</i>\n      <h6>Fast Performance</h6>\n      <p>Optimized for speed with lightning-fast load times and responsive design.</p>\n    </div>\n    <div class=\"col s12 m4\">\n      <i class=\"material-icons large teal-text\">security</i>\n      <h6>Secure by Design</h6>\n      <p>Your data is protected with advanced encryption and secure protocols.</p>\n    </div>\n    <div class=\"col s12 m4\">\n      <i class=\"material-icons large teal-text\">support_agent</i>\n      <h6>24/7 Support</h6>\n      <p>Get help anytime from our expert team via chat or email.</p>\n    </div>\n  </div>\n</div>\n'),
(183, 28, 1, 'Modern Stats Block'),
(184, 28, 10, '<div class=\"section center-align grey lighten-4\">\n  <div class=\"row\">\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">120K </h4>\n      <p>Happy Users</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">340 </h4>\n      <p>Projects Completed</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">98%</h4>\n      <p>Satisfaction Rate</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">24/7</h4>\n      <p>Customer Support</p>\n    </div>\n  </div>\n</div>\n'),
(185, 15, 1, 'Three Testimonials in Columns'),
(186, 15, 10, '<div class=\"section\">\n  <div class=\"row\">\n    <div class=\"col s12 m4 center-align\">\n      <img src=\"https://via.placeholder.com/80\" alt=\"Client\" class=\"circle responsive-img\">\n      <p class=\"grey-text text-darken-2\"><i>\"Incredible support and top-tier features. Couldn\'t be happier.\"</i></p>\n      <p><strong>Alex R.</strong><br><small>Product Manager</small></p>\n    </div>\n    <div class=\"col s12 m4 center-align\">\n      <img src=\"https://via.placeholder.com/80\" alt=\"Client\" class=\"circle responsive-img\">\n      <p class=\"grey-text text-darken-2\"><i>\"An absolute game changer for our team.\"</i></p>\n      <p><strong>Samantha K.</strong><br><small>UX Designer</small></p>\n    </div>\n    <div class=\"col s12 m4 center-align\">\n      <img src=\"https://via.placeholder.com/80\" alt=\"Client\" class=\"circle responsive-img\">\n      <p class=\"grey-text text-darken-2\"><i>\"Professional, clean, and easy to use.\"</i></p>\n      <p><strong>Jordan T.</strong><br><small>Freelancer</small></p>\n    </div>\n  </div>\n</div>\n'),
(187, 29, 1, 'Product Group Tabs'),
(188, 29, 10, '<div class=\"product-group-tabs\">\n  <!-- Tab Navigation -->\n  <div class=\"row\">\n    <div class=\"col s12\">\n      <ul class=\"tabs\">\n        <li class=\"tab col s3\"><a class=\"active\" href=\"#bags\">Bags</a></li>\n        <li class=\"tab col s3\"><a href=\"#boxes\">Boxes</a></li>\n        <li class=\"tab col s3\"><a href=\"#cups\">Cups & Bowls</a></li>\n        <li class=\"tab col s3\"><a href=\"#trays\">Trays & Scoops</a></li>\n        <li class=\"tab col s3\"><a href=\"#wraps\">Wrapsheets</a></li>\n      </ul>\n    </div>\n  </div>\n\n  <!-- Tab: Bags -->\n  <div id=\"bags\" class=\"col s12\">\n    <!-- Add bag products here -->\n  </div>\n\n  <!-- Tab: Boxes -->\n  <div id=\"boxes\" class=\"col s12\">\n    <!-- Add box products here -->\n  </div>\n  <!-- Tab: Cups-->\n  <div id=\"cups\" class=\"col s12\">\n    <!-- Add tray products here -->\n  </div>\n  <!-- Tab: Trays -->\n  <div id=\"trays\" class=\"col s12\">\n    <!-- Add tray products here -->\n  </div>\n\n  <!-- Tab: Wrap Sheets-->\n  <div id=\"wraps\" class=\"col s12\">\n    <!-- Add cone products here -->\n  </div>\n</div>\n'),
(195, 30, 1, 'Left-Aligned Caption Over Dark Background Image'),
(196, 30, 10, '<div class=\"section no-pad\" style=\"position: relative; height: 400px; background-color: #0D1B2A;\">\n  <img src=\"https://images.pexels.com/photos/1533720/pexels-photo-1533720.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=400&w=1200\" \n       alt=\"Creative Workspace\" \n       style=\"position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.3;\">\n  \n  <div class=\"container\" style=\"position: relative; z-index: 2; height: 100%; display: flex; align-items: center;\">\n    <div style=\"max-width: 600px; color: white;\">\n      <h3 style=\"margin-bottom: 10px;\">Transform Your Brand Experience</h3>\n      <p class=\"flow-text\" style=\"margin-bottom: 20px;\">Explore our range of premium custom packaging that leaves a lasting impression.</p>\n      <a href=\"#explore\" class=\"btn white black-text\">Explore Now</a>\n    </div>\n  </div>\n</div>\n'),
(197, 31, 1, 'Right-Aligned Caption Over Light Background Image'),
(198, 31, 10, '<div class=\"section no-pad\" style=\"position: relative; height: 400px; background-color: #f4f4f4;\">\n  <img src=\"https://images.pexels.com/photos/1004014/pexels-photo-1004014.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=400&w=1200\" \n       alt=\"Packaging Mockup\" \n       style=\"position: absolute; top: 0; right: 0; width: 50%; height: 100%; object-fit: cover;\">\n\n  <div class=\"container\" style=\"position: relative; z-index: 2; height: 100%; display: flex; align-items: center;\">\n    <div style=\"max-width: 600px; color: #333;\">\n      <h3 style=\"margin-bottom: 10px;\">Bold Designs, Better Branding</h3>\n      <p class=\"flow-text\" style=\"margin-bottom: 20px;\">Discover thoughtfully crafted clamshell boxes, trays, and packaging solutions for every need.</p>\n      <a href=\"#discover\" class=\"btn blue lighten-1 white-text\">Discover More</a>\n    </div>\n  </div>\n</div>\n'),
(199, 32, 1, 'Right-Aligned Dark Background with White Text'),
(200, 32, 10, '<div class=\"section no-pad\" style=\"position: relative; height: 400px; background-color: #0D1B2A;\">\n  <img src=\"https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=400&w=1200\"\n       alt=\"Team Collaboration\"\n       style=\"position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.3;\">\n\n  <div class=\"container\" style=\"position: relative; z-index: 2; height: 100%; display: flex; align-items: center; justify-content: flex-end;\">\n    <div style=\"max-width: 600px; color: white; text-align: right;\">\n      <h3 style=\"margin-bottom: 10px;\">Elevate Everyday Packaging</h3>\n      <p class=\"flow-text\" style=\"margin-bottom: 20px;\">Premium clamshell boxes and trays designed to tell your brand\'s story, beautifully.</p>\n      <a href=\"#shop\" class=\"btn white black-text\">Shop Now</a>\n    </div>\n  </div>\n</div>\n'),
(201, 33, 1, 'Right-Aligned Light Background with Dark Text'),
(202, 33, 10, '<div class=\"section no-pad\" style=\"position: relative; height: 400px; background-color: #ffffff;\">\n  <img src=\"https://images.pexels.com/photos/3747034/pexels-photo-3747034.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=400&w=1200\"\n       alt=\"Eco Packaging\"\n       style=\"position: absolute; top: 0; right: 0; width: 50%; height: 100%; object-fit: cover;\">\n\n  <div class=\"container\" style=\"position: relative; z-index: 2; height: 100%; display: flex; align-items: center; justify-content: flex-end;\">\n    <div style=\"max-width: 600px; color: #333; text-align: right;\">\n      <h3 style=\"margin-bottom: 10px;\">Eco-Friendly & Elegant</h3>\n      <p class=\"flow-text\" style=\"margin-bottom: 20px;\">Discover sustainable packaging solutions that align with your values and aesthetics.</p>\n      <a href=\"#learn\" class=\"btn blue lighten-1 white-text\">Learn More</a>\n    </div>\n  </div>\n</div>\n'),
(420, 36, 3, '<div style=\"transform: scale(1); transform-origin: left top 0px; width: 100%; pointer-events: auto;\"><div class=\"section no-pad\" style=\"position: relative; height: 400px; background-color: #0D1B2A;\">\r\n  <img src=\"https://scyphusdesignstudio.co.uk/paylesspackaging/dev/media/branded greaseproof paper bags in hands of happy people.jpg\" alt=\"Greaseproof Paper Bags\" style=\"position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.3;\">\r\n\r\n  <div class=\"container\" style=\"position: relative; z-index: 2; height: 100%; display: flex; align-items: center; justify-content: flex-end;\">\r\n    <div style=\"max-width: 600px; color: white; text-align: right;\">\r\n      <h3 style=\"margin-bottom: 10px;\">Greaseproof Paper Bags<br>Pack Fresh, Serve Smart</h3>\r\n      <p class=\"flow-text\" style=\"margin-bottom: 20px;\">Keep your food looking great and grease-free with customizable, windowed bags designed for sandwiches, fries, pastries &amp; more.</p>\r\n      <a href=\"#shop\" class=\"btn white black-text\">BRANDED PRODUCTS</a>\r\n    </div>\r\n  </div>\r\n</div>\r\n</div>'),
(430, 44, 1, 'Trusted By Thousands Block'),
(431, 44, 10, '<div class=\"section center-align grey lighten-4\">\n  <div class=\"row\">\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">50 </h4>\n      <p>Industries Served</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">99.9%</h4>\n      <p>On-Time Delivery</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">500K </h4>\n      <p>Custom Orders Shipped</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">100%</h4>\n      <p>Eco-Friendly Packaging Options</p>\n    </div>\n  </div>\n</div>\n'),
(432, 45, 1, 'Why Choose Us Block'),
(433, 45, 10, '<div class=\"section center-align grey lighten-4\">\n  <div class=\"row\">\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">Fast</h4>\n      <p>Lightning-Quick Turnarounds</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">Flexible</h4>\n      <p>Small or Bulk — You Decide</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">Precise</h4>\n      <p>Exact Custom Sizing</p>\n    </div>\n    <div class=\"col s6 m3\">\n      <h4 class=\"teal-text\">Secure</h4>\n      <p>Robust Packaging Quality</p>\n    </div>\n  </div>\n</div>\n'),
(434, 46, 1, 'Vertical Our Promise'),
(435, 46, 10, '<div class=\"section grey lighten-4 center-align\">\n  <h5 class=\"teal-text\">Why Choose Payless Packaging?</h5>\n  <ul class=\"collection z-depth-1\">\n    <li class=\"collection-item\">✅ Premium Quality Materials</li>\n    <li class=\"collection-item\">🚚 Fast & Reliable Worldwide Shipping</li>\n    <li class=\"collection-item\">🌱 Eco-Friendly Options Available</li>\n    <li class=\"collection-item\">🎨 Fully Customizable Designs</li>\n    <li class=\"collection-item\">📞 Dedicated Customer Support</li>\n  </ul>\n</div>\n'),
(436, 47, 1, 'Vertical Your Perfect Packaging Partner'),
(437, 47, 10, '<div class=\"section grey lighten-4 center-align\">\n  <h5 class=\"teal-text\">Your Perfect Packaging Partner</h5>\n  <ul class=\"collection z-depth-1\">\n    <li class=\"collection-item\">🔒 Safe & Secure Packaging Solutions</li>\n    <li class=\"collection-item\">💡 Expert Design Consultation</li>\n    <li class=\"collection-item\">💼 Trusted by Leading Brands</li>\n    <li class=\"collection-item\">📦 No Minimum Order Quantity</li>\n    <li class=\"collection-item\">💸 Competitive Pricing Guaranteed</li>\n  </ul>\n</div>\n'),
(445, 48, 8, 'media/69ca1cad1f8331.16821714_coffee-shop-sketch-ambience.png'),
(450, 48, 1, 'Visit Us and Sip the Warmth'),
(451, 48, 2, 'Visit Us and Sip the Warmth'),
(452, 48, 11, 'Visit Us and Sip the Warmth'),
(453, 48, 3, '<!-- HERO SECTION -->\r\n<div class=\"section brown darken-2 white-text center-align\">\r\n  <h1 class=\"header\">Visit Willow Cup Coffee</h1>\r\n  <h5>Your Neighborhood Spot for Great Coffee & Warm Moments</h5>\r\n</div>\r\n\r\n<!-- INTRODUCTION -->\r\n<div class=\"container section\">\r\n  <div class=\"row\">\r\n    <div class=\"col s12\">\r\n      <p class=\"flow-text\">At <b>Willow Cup Coffee</b>, every visit is more than just a quick stop for coffee. It’s a place to slow down, connect, and enjoy thoughtfully crafted drinks in a warm, welcoming space. Whether you\'re starting your morning, meeting friends, or taking a quiet break, we’re here to make every cup count.</p>\r\n    </div>\r\n  </div>\r\n</div>\r\n\r\n<!-- VISIT DETAILS -->\r\n<div class=\"container section\">\r\n  <div class=\"row\">\r\n\r\n    <div class=\"col s12 m6\">\r\n      <div class=\"card small\">\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title brown-text\"><i class=\"material-icons left\">place</i>Find Us</span>\r\n          <p>1427 Maple Avenue, Brooklyn, NY 11215<br>\r\n          Located in the heart of the neighborhood, just a short walk from local parks and shops.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n\r\n    <div class=\"col s12 m6\">\r\n      <div class=\"card small\">\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title brown-text\"><i class=\"material-icons left\">schedule</i>Opening Hours</span>\r\n          <p>Monday – Friday: 7:30 AM – 8:00 PM<br>\r\n          Saturday – Sunday: 8:00 AM – 9:00 PM<br>\r\n          Fresh coffee served all day.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n\r\n    <div class=\"col s12 m6\">\r\n      <div class=\"card small\">\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title brown-text\"><i class=\"material-icons left\">wifi</i>Work & Relax</span>\r\n          <p>Enjoy a comfortable space with free WiFi, cozy seating, and a calm atmosphere — perfect for working, reading, or simply unwinding with your favorite drink.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n\r\n    <div class=\"col s12 m6\">\r\n      <div class=\"card small\">\r\n        <div class=\"card-content\">\r\n          <span class=\"card-title brown-text\"><i class=\"material-icons left\">local_cafe</i>What We Serve</span>\r\n          <p>From rich espresso and creamy lattes to refreshing cold brews and fresh bakes — everything is crafted with care using quality ingredients and a passion for great coffee.</p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n\r\n  </div>\r\n</div>\r\n\r\n<!-- WHY VISIT US -->\r\n<div class=\"section\">\r\n  <div class=\"container\">\r\n    <h4 class=\"center brown-text\">Why Visit Willow Cup Coffee?</h4>\r\n    <ul class=\"collection z-depth-1\">\r\n      <li class=\"collection-item\"><i class=\"material-icons left brown-text\">coffee</i>Freshly Brewed Coffee — Made from carefully selected beans for rich, balanced flavor.</li>\r\n      <li class=\"collection-item\"><i class=\"material-icons left brown-text\">people</i>Welcoming Atmosphere — A place to meet, work, or simply relax.</li>\r\n      <li class=\"collection-item\"><i class=\"material-icons left brown-text\">bakery_dining</i>Fresh Bakes Daily — Light bites and pastries to complement your drink.</li>\r\n      <li class=\"collection-item\"><i class=\"material-icons left brown-text\">favorite</i>Loved by Locals — A neighborhood favorite for everyday coffee moments.</li>\r\n    </ul>\r\n  </div>\r\n</div>\r\n\r\n<!-- CTA SECTION -->\r\n<div class=\"section center-align\">\r\n  <h5>Stop By Today</h5>\r\n  <p>Great coffee, friendly faces, and a space to unwind — we look forward to welcoming you to Willow Cup Coffee.</p>\r\n  <a class=\"btn-large brown darken-2\" href=\"/contact\">Get Directions</a>\r\n</div>'),
(458, 49, 8, 'media/69ca20d99bf5b5.44303172_willow-cup-coffee-team.png'),
(1265, 99, 16, 'kraft'),
(1266, 99, 18, 'dimension_mm'),
(1267, 99, 23, '160x50x40mm, 180x60x45mm, 200x70x50mm'),
(1268, 99, 17, 'cardboard'),
(1269, 99, 24, '1000'),
(1271, 99, 25, 'media/6802968bcf460_Paper_Board_Hot_Dog_Tray_black_ink_outline_vector_drawing.jpg'),
(1273, 99, 19, 'media/6802968bd2cc3_Paper_Board_Hot_Dog_Trays_.jpg'),
(1274, 99, 20, 'media/6802968bd5e8f_Hot_Dog_Trays_.jpg'),
(1275, 99, 21, 'media/6802968bd7ad9_Paper_Board_Hot_Dog_Trays___2_.jpg'),
(1293, 101, 16, 'kraft'),
(1294, 101, 18, 'mixed'),
(1295, 101, 23, '30mm x 30mm, 50mm x 50mm, 75mm x 75mm ( Custom Sizes Available )'),
(1296, 101, 17, 'paper'),
(1297, 101, 24, '500'),
(1299, 101, 25, 'media/68029a145a89d_paper_sticker__black_ink_outline_vector_drawing.jpg'),
(1301, 101, 19, 'media/68029a1461aaa_paper_stickers__2_.jpg'),
(1302, 101, 20, 'media/68029a146a0a5_paper_stickers__1_.jpg'),
(1303, 101, 21, 'media/68029a146bbfe_paper_stickers.jpg'),
(1308, 100, 16, 'white_kraft'),
(1309, 100, 18, 'mixed'),
(1310, 100, 23, ''),
(1311, 100, 17, 'duplex_board'),
(1312, 100, 24, '500'),
(1314, 100, 25, 'media/68029ae5c4bac_wrap_around_paper_sleeve_for_paper_boxes__black_ink_outline_vector_drawing.jpg'),
(1316, 100, 19, 'media/68029ae5ca0fe_wrap_around_paper_sleeve_for_paper_boxes.jpg'),
(1327, 102, 19, 'media/6803e42fd6b79_white_paper_cup.jpg'),
(1328, 102, 20, 'media/6803e42fd83f4_single_wall_plain_white_paper_cup__1_.jpg'),
(1329, 102, 21, 'media/6803e42fdb834_single_wall_plain_white_paper_cup__2_.jpg'),
(1517, 107, 3, '<ul class=\"captions hidden\" id=\"captions\">\r\n  <li>\r\n    Coffee Worth Slowing Down For\r\n    <br><small>Freshly brewed coffee, warm pastries, and a moment of calm.</small>\r\n  </li>\r\n\r\n  <li>\r\n    Your Daily Cup, Done Right\r\n    <br><small>Expertly brewed coffee served with warmth and care.</small>\r\n  </li>\r\n\r\n  <li>\r\n    Where Coffee Meets Comfort\r\n    <br><small>Cozy corners, rich aromas, and handcrafted brews.</small>\r\n  </li>\r\n\r\n  <li>\r\n    Brewed Fresh. Served Warm.\r\n    <br><small>Every cup prepared with carefully selected beans.</small>\r\n  </li>\r\n\r\n  <li>\r\n    Small Moments, Great Coffee\r\n    <br><small>Pause, sip, and enjoy the simple pleasures.</small>\r\n  </li>\r\n\r\n  <li>\r\n    Crafted Coffee Experiences\r\n    <br><small>From espresso to latte — made just the way you like it.</small>\r\n  </li>\r\n\r\n  <li>\r\n    Your Neighborhood Coffee Spot\r\n    <br><small>A welcoming place for coffee, conversation, and calm.</small>\r\n  </li>\r\n\r\n  <li>\r\n    More Than Just Coffee\r\n    <br><small>Fresh brews, baked treats, and a place to unwind.</small>\r\n  </li>\r\n\r\n  <li>\r\n    Coffee. Comfort. Community.\r\n    <br><small>A cup that brings people together.</small>\r\n  </li>\r\n</ul>'),
(1542, 110, 1, 'Events Grid'),
(1543, 110, 10, '<div class=\"section grey lighten-4\">\n  <h5 class=\"teal-text center-align\">Upcoming Events</h5>\n\n  <ul class=\"collection z-depth-1\">\n\n    <li class=\"collection-item valign-wrapper\" style=\"min-height:60px;\">\n      <img src=\"https://placehold.co/60\" alt=\"Live Music\"\n           style=\"width:60px;height:60px;object-fit:cover;margin-right:12px;border-radius:4px;\">\n      <div>\n        <span class=\"title teal-text\"><strong>Live Acoustic Night</strong></span><br>\n        <small>Friday evenings with local acoustic artists.</small>\n      </div>\n    </li>\n\n    <li class=\"collection-item valign-wrapper\" style=\"min-height:60px;\">\n      <img src=\"https://placehold.co/60\" alt=\"Jam Session\"\n           style=\"width:60px;height:60px;object-fit:cover;margin-right:12px;border-radius:4px;\">\n      <div>\n        <span class=\"title teal-text\"><strong>Open Jam Session</strong></span><br>\n        <small>Bring your instrument and join the vibe.</small>\n      </div>\n    </li>\n\n    <li class=\"collection-item valign-wrapper\" style=\"min-height:60px;\">\n      <img src=\"https://placehold.co/60\" alt=\"Coffee Tasting\"\n           style=\"width:60px;height:60px;object-fit:cover;margin-right:12px;border-radius:4px;\">\n      <div>\n        <span class=\"title teal-text\"><strong>Coffee Tasting</strong></span><br>\n        <small>Sample our seasonal roasts with the barista.</small>\n      </div>\n    </li>\n\n  </ul>\n</div>'),
(1588, 111, 3, '<div class=\"section\">\r\n  <h2 class=\"sublogo\">UPCOMING EVENTS</h2>\r\n\r\n  <ul class=\"row\">\r\n\r\n    <li class=\"col s12 row\" style=\"min-height:60px;\">\r\n     <div class=\"col s2\">\r\n      <img src=\"https://placehold.co/80\" alt=\"Live Music\" style=\"width:80px;height:80px;object-fit:cover;margin-right:12px;border-radius:4px;\">\r\n     </div>\r\n      <div class=\"col s10\">\r\n        <span class=\"title white-text flow-text\"><strong>Live Acoustic Night</strong></span><br>\r\n        <small class=\"title white-text flow-text\" \"=\"\">Friday evenings with local acoustic artists.</small>\r\n      </div>\r\n    </li>\r\n\r\n    <li class=\"col s12 row\" style=\"min-height:60px;\">\r\n     <div class=\"col s2\">\r\n      <img src=\"https://placehold.co/80\" alt=\"Jam Session\" style=\"width:80px;height:80px;object-fit:cover;margin-right:12px;border-radius:4px;\">\r\n     </div>\r\n      <div class=\"col s10\">\r\n        <span class=\"title white-text flow-text\" \"=\"\"><strong>Jam Session</strong></span><br>\r\n        <small class=\"title white-text flow-text\" \"=\"\">Bring your instrument and join the vibe.</small>\r\n      </div>\r\n    \r\n    </li><li class=\"col s12 row\" style=\"min-height:60px;\">\r\n     <div class=\"col s2\">\r\n      <img src=\"https://placehold.co/80\" alt=\"Coffee Tasting\" style=\"width:80px;height:80px;object-fit:cover;margin-right:12px;border-radius:4px;\">\r\n     </div>\r\n      <div class=\"col s10\">\r\n        <span class=\"title white-text flow-text\" \"=\"\"><strong>Coffee Tasting</strong></span><br>\r\n        <small class=\"title white-text flow-text\" \"=\"\">Sample our seasonal roasts with the barista.</small>\r\n      </div>\r\n    </li>\r\n\r\n\r\n  \r\n  </ul>\r\n</div>\r\n'),
(1591, 108, 3, '<ul>\r\n               <li>\r\n<div class=\"slider-div\">\r\n  <video autoplay=\"\" muted=\"\" loop=\"\" playsinline=\"\" style=\"width: 100%; \">\r\n    <source src=\"images/coffee-cup-smoke-tilt.mp4\" type=\"video/mp4\">\r\n  </video>\r\n</div>\r\n  <h2 class=\"sublogo\">COFFEE . CULTURE . CURATION </h2>\r\n  <img src=\"images/30-off.png\" alt=\"30% Off\" style=\"position: absolute; width: 55%; right: 0; bottom:0;\">\r\n</li>\r\n<li>\r\n  <div class=\"slider-div\">\r\n  <img src=\"images/coffee-shop-jamming.png\" alt=\"Take Away to Remember\" style=\"width:100%;\">\r\n  </div>\r\n<h2 class=\"sublogo\">WIND DOWN . JAM .  FLOW</h2>\r\n  <img src=\"images/girl-band-logo.png\" alt=\"Pacific Girls\" style=\"position: absolute; width: 55%; right: 0; bottom:0;\">\r\n</li>\r\n            </ul>'),
(1640, 104, 3, '<p><strong>8oz Black Ripple Wall Paper Cups</strong> are designed for businesses that want to combine functional heat protection with a sharp, modern aesthetic. The ripple-wall structure provides triple-layer insulation to keep drinks hot and hands cool, while the matte black finish adds a premium, professional look.</p>\r\n\r\n<ul class=\"browser-default\">\r\n  <li><strong>Ripple Wall Insulation:</strong> No extra sleeves needed — the textured triple wall keeps heat inside and hands safe.</li>\r\n  <li><strong>Bold Black Finish:</strong> Minimalist and elegant, perfectly complementing modern café branding or event styling.</li>\r\n  <li><strong>Leak-Resistant Build:</strong> Crafted to securely handle hot drinks without warping or leaks.</li>\r\n  <li><strong>Standard Lid Fit:</strong> Compatible with most 80mm sip lids (sold separately) for a reliable seal on the go.</li>\r\n</ul>\r\n\r\n<p>Whether you’re serving premium coffees or hot chocolates, these black ripple cups combine style and practicality for both independent cafés and event vendors.</p>\r\n'),
(1643, 104, 29, '250'),
(1651, 103, 3, '<p><strong>8oz Kraft Ripple Wall Paper Cups</strong> are the perfect upgrade for businesses serving hot beverages on the go. The ripple-walled design offers natural heat insulation, meaning your customers won’t need separate sleeves, and the textured outer layer provides a comfortable, slip-resistant grip.</p>\r\n\r\n<ul class=\"browser-default\">\r\n  <li><strong>Triple Layer Ripple Wall:</strong> Superior insulation keeps drinks hot and hands comfortable, no sleeves required.</li>\r\n  <li><strong>Natural Kraft Look:</strong> A rustic, eco-friendly appearance that fits both modern and traditional brand aesthetics.</li>\r\n  <li><strong>Durable &amp; Leak-Resistant:</strong> Built to hold hot drinks securely without softening or warping.</li>\r\n  <li><strong>Standard Sizing:</strong> Compatible with most 80mm sip lids (sold separately) for a tight, secure fit.</li>\r\n</ul>\r\n\r\n<p>Whether you’re serving espresso, americanos, or specialty teas, these ripple cups are designed to enhance the drinking experience while maintaining a professional and eco-conscious presentation.</p>\r\n'),
(1654, 103, 29, '250'),
(1655, 103, 28, '1'),
(1662, 102, 3, '<p><strong>12oz Single Wall White Paper Cup</strong> is the go-to disposable option for cafes, food stalls, takeaways, and office beverage stations. Crafted from premium food-grade paper, these cups offer a smooth, neutral white finish that suits any brand or setting.</p>\r\n\r\n<ul class=\"browser-default\">\r\n  <li><strong>Sturdy Single Wall Construction:</strong> Ideal for serving both hot and cold drinks without quick seepage or warping.</li>\r\n  <li><strong>Neutral Design:</strong> Clean white finish complements every brand and occasion — perfect for private events and bulk service too.</li>\r\n  <li><strong>Recyclable Material:</strong> Manufactured from responsibly sourced paper, helping your business meet its eco-friendly goals.</li>\r\n  <li><strong>Industry Standard Sizing:</strong> Compatible with most standard 80mm diameter sip lids (sold separately).</li>\r\n</ul>\r\n\r\n<p>Whether you\'re pouring fresh coffee, refreshing iced drinks, or seasonal hot chocolate, this 12oz single wall paper cup delivers consistency, hygiene, and visual simplicity at a competitive price.</p>\r\n'),
(1665, 102, 29, '250'),
(1666, 102, 28, '1'),
(1678, 113, 35, 'media/69bbb0ab3bff1_a_young_caucasian_woman_in_nice_formal_outfit_looking_at_the_camera_with_a_warm_professional_smile.jpg'),
(1683, 41, 34, 'home '),
(1687, 114, 32, 'on'),
(1697, 112, 32, 'on'),
(1706, 112, 4, '<span>The coffee here is consistently excellent — rich, smooth, and never bitter.</span><br><span>It’s become part of my daily routine, and honestly, I look forward to it every morning.</span>'),
(1707, 112, 33, '5'),
(1708, 112, 34, 'Daniel R'),
(1709, 113, 4, '<span>A beautiful space with such a calm, welcoming feel.<br></span><br><span>Their lattes are perfectly balanced, and it’s my favorite spot to unwind or catch up with friends.</span>'),
(1710, 113, 32, 'on'),
(1711, 113, 33, '5'),
(1712, 113, 34, 'Emily S'),
(1713, 114, 4, '<span>Great coffee, friendly staff, and a really relaxed atmosphere.<br></span><br><span>Whether I’m working or just stopping by, it always feels like the right place to be.</span>'),
(1714, 114, 33, '4.5'),
(1715, 114, 34, 'Marcus L'),
(1719, 101, 4, '<div>Custom printed stickers — perfect for branding, sealing, and decorating your packaging with a professional touch.</div>'),
(1720, 101, 3, '<p><strong>Custom Stickers</strong> are one of the easiest and most versatile ways to brand your packaging, seal boxes, or add a stylish finishing touch to your product presentation.</p>\r\n\r\n<ul>\r\n  <li><strong>Versatile Applications:</strong> Perfect for packaging seals, branding labels, promotional giveaways, and decorative accents.</li>\r\n  <li><strong>Custom Shapes &amp; Sizes:</strong> Circles, squares, rectangles, ovals, or custom die-cut shapes to match your logo or product design.</li>\r\n  <li><strong>High-Quality Printing:</strong> Vivid colors and crisp graphics with various finishes like matte, gloss, or transparent vinyl.</li>\r\n  <li><strong>Durable &amp; Adhesive:</strong> Long-lasting stickers that adhere securely to paper, plastic, glass, or cardboard surfaces.</li>\r\n</ul>\r\n\r\n<p>Whether you’re sealing a paper bag, branding a takeaway cup, or handing out logo stickers at an event, custom stickers leave a lasting impression without breaking the bank.</p>\r\n'),
(1725, 100, 4, '<div>Upgrade your packaging with custom printed Box Sleeves — the perfect finishing touch for boxes, trays, and containers!</div>'),
(1726, 100, 3, '<p><strong>Box Sleeves</strong> are an elegant and practical way to enhance your packaging without changing the core structure of your box or container. Whether you\'re packaging baked goods, ready meals, cosmetics, or gifts — sleeves instantly elevate presentation and reinforce your brand identity.</p>\r\n\r\n<ul>\r\n  <li><strong>Brand Visibility:</strong> Add logos, designs, product information, or promotional offers for high-impact shelf appeal.</li>\r\n  <li><strong>Flexible Sizing:</strong> Custom-fit for any box or container, from small confectionery to large meal packs.</li>\r\n  <li><strong>Eco-Friendly Options:</strong> Available in recyclable, biodegradable, and compostable paperboards and materials.</li>\r\n  <li><strong>Cost-Effective:</strong> Achieve premium presentation without the expense of fully custom packaging.</li>\r\n</ul>\r\n\r\n<p>Box sleeves offer a professional, sleek look while keeping packaging practical, lightweight, and affordable. Ideal for bakeries, delis, gift shops, meal services, and more!</p>\r\n'),
(1731, 99, 4, '<div>Perfectly sized, sturdy trays designed to cradle hot dogs for easy, mess-free serving at events, diners, and takeaway counters.</div>'),
(1732, 99, 3, '<p><strong>Hot Dog Trays</strong> offer the perfect balance of function and presentation for one of the world’s favorite snacks. These trays are designed to comfortably hold hot dogs of various sizes, keeping toppings intact and hands clean.</p>\r\n\r\n<ul>\r\n  <li><strong>Tailored Fit:</strong> Designed to cradle hot dogs snugly, preventing slippage and messes during serving and eating.</li>\r\n  <li><strong>Grease-Resistant &amp; Leak-Proof:</strong> Special coatings and sturdy paperboard prevent sogginess even with loaded toppings.</li>\r\n  <li><strong>Eco-Friendly Options:</strong> Choose from recyclable, compostable, and biodegradable materials to support sustainable service.</li>\r\n  <li><strong>Fully Customisable:</strong> Print your logo, brand message, or promotional artwork for a professional finish.</li>\r\n</ul>\r\n\r\n<p>Whether it’s for food trucks, stadium vendors, street food stalls, or cafés — our hot dog trays deliver the right combination of durability, hygiene, and visual appeal.</p>\r\n'),
(1738, 115, 8, 'media/69bcfdd5c44e7_bright_daisies_and_similar_flowers_on_a_white_background.jpg'),
(1743, 116, 8, 'media/69bcfe2a64029_The_B-52_s_cover.jpg'),
(1748, 117, 8, 'media/69bcfea9a6f46_coffee-liqueur.jpeg'),
(1757, 116, 1, 'Jam Session'),
(1758, 116, 32, 'on'),
(1759, 116, 36, 'Bring your instrument and join the vibe.'),
(1760, 116, 37, ''),
(1761, 116, 38, ''),
(1762, 115, 1, 'Live Acoustic Night'),
(1763, 115, 32, 'on'),
(1764, 115, 36, 'Friday evenings with local acoustic artists.'),
(1765, 115, 37, ''),
(1766, 115, 38, ''),
(1767, 117, 1, 'Coffee Tasting'),
(1768, 117, 32, 'on'),
(1769, 117, 36, 'Sample our seasonal roasts with the barista.'),
(1770, 117, 37, '2026-03-20'),
(1771, 117, 38, '18:30'),
(1774, 118, 4, '<div>test</div>'),
(1775, 118, 3, '<div>test</div>'),
(1778, 118, 19, 'media/69bd40bb01d8b_black-red-martini-lime-sambuca-widow.jpg');
INSERT INTO `entity_attribute_data` (`id`, `entity_id`, `attribute_id`, `value`) VALUES
(1780, 41, 3, '<!-- Main Content -->\r\n<div class=\"row block-first\">\r\n   <div class=\"container\">\r\n      \r\n      <!-- Left Column (Main Content) -->\r\n      <div class=\"col s12 m12 l7 left\">\r\n         <div class=\"htmlslider\">\r\n            {{entity type=\"snippets\" name=\"home-page-slideshow\" template-type=\"html_template\"}}\r\n          </div>\r\n          <div class=\"events\">\r\n            ##CAFE-EVENTS##   \r\n           </div>\r\n         \r\n         \r\n      </div>\r\n      <div class=\"col s12 m12 l5 right quote\">\r\n         <!--<div class=\"vertical-spacer\"></div>-->\r\n         {{entity type=\"snippets\" name=\"reservation-request-form\" template-type=\"html_template\"}}\r\n      </div>\r\n   </div>\r\n\r\n<div class=\"row block coffee-banner\">\r\n   <div class=\"container \">\r\n      <div class=\"col s12 m12 l5 left\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <a class=\"transparent-image\" href=\"#\"><img loading=\"lazy\" src=\"images/a-coffee-cup-beans.png\" alt=\"The Neighborhood Cafe\"></a>\r\n         <a class=\"link-text\" href=\"/\">Visit the Coffee Bar</a>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right banner\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h3>A NEIGHBORHOOD FAVORITE</h3>\r\n         <div class=\"image\"><img src=\"images/yourdailycup.png\" alt=\"Your Daily Cup\" loading=\"lazy\"></div>\r\n         <p class=\"flow-text white-text col s11 offset-s1\">Step into Willow Cup Coffee and enjoy the warmth of freshly brewed coffee, handcrafted drinks, and a space designed for conversation, creativity,and slow mornings.</p>\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block coffee homevideo\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 m12 l5 left\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>DISCOVER</h2>\r\n         <h1 class=\"logo\"><img loading=\"lazy\" src=\"images/willow-cup-coffee-white.svg\" alt=\"Willow Cup Coffee\"></h1>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"video\"><img loading=\"lazy\" src=\"images/willow-cup-coffee-team.png\" alt=\"The Willow Cup Coffee Team\"></div>\r\n         <h3>OUR COFFEE STORY</h3>\r\n         <h3><strong>Brewing Community, One Cup at a Time</strong></h3>\r\n         <p>At Willow Cup Coffee, every cup begins with carefully sourced beans and a passion for great coffee. Our baristas craft each drink with care — from rich espresso to creamy lattes — creating a place where friends meet, ideas flow, and mornings start right.</p>\r\n         <a class=\"waves-effect waves-light btn-large black white-text\">OUR STORY</a>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block black-coffee products\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 full\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>Our Signature Drinks</h2>\r\n         ##MENU-PRODUCT##\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block dark-coffee customers\">\r\n   <section class=\"section white-text\">\r\n      <div class=\"container\">\r\n         <div class=\"row\">\r\n            <!-- Left Side: Audience Icons + Text -->\r\n            <div class=\"col s12 m6 l6\">\r\n               <h3 class=\"white-text\">More Than Just Coffee</h3>\r\n               <ul class=\"customers-promo collection with-header black-coffee white-text\" style=\"border:none;\">\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">local_cafe</i>Specialty Coffee &amp; Signature Brews</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">fastfood</i>Comfortable Spaces to Work &amp; Unwind</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">store</i>Expertly Crafted Espresso Drinks</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">event</i>Fresh Pastries &amp; Seasonal Treats</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">emoji_objects</i>A Café Built Around Community</li>\r\n               </ul>\r\n            </div>\r\n            <!-- Right Side: SEO-friendly Write-Up -->\r\n            <div class=\"col s12 m6 l6\">\r\n               <h3 class=\"white-text\">Your Daily Coffee Ritual</h3>\r\n               <p class=\"flow-text white-text\">\r\n                 At Willow Cup Coffee, every visit is more than just a quick stop. It’s a moment to pause, reset, and enjoy something made with care.\r\nFrom your first morning espresso to a slow afternoon latte, we create coffee experiences you’ll look forward to every day.\r\n               </p>\r\n               <p class=\"white-text\">\r\n                  We focus on what matters most — great beans, careful brewing, and attention to every detail. Each cup is crafted to bring out rich, balanced flavors that make every sip memorable.\r\n               </p>\r\n            </div>\r\n         </div>\r\n      </div>\r\n   </section>\r\n</div>\r\n<div class=\"row block dark-coffee shop\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 m12 l5 left caption\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>SHOP</h2>\r\n         <h3>PRODUCTS</h3>\r\n         <div class=\"shopmessage dark-coffee\"><a href=\"#\"><img src=\"images/willow-cup-coffee-white.svg\" alt=\"Willow Cup Coffee\"></a></div>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right home-shop\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n                  ##SHOP-PRODUCT##\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block dark-coffee reviews\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 full\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>Straight from our Customers</h2>\r\n         <div class=\"row \">\r\n            ##TESTIMONIALS##\r\n         </div>\r\n      </div>\r\n   </div>\r\n</div></div>'),
(1785, 101, 15, 'media/69bfb148314a6_espresso.png'),
(1786, 100, 32, 'on'),
(1787, 100, 1, 'Double Espresso'),
(1788, 100, 2, 'Two shots for a stronger, fuller-bodied experience.'),
(1789, 100, 26, '3.75'),
(1790, 100, 15, 'media/69bfb18c6c64c_double-espressp.png'),
(1794, 99, 32, 'on'),
(1803, 99, 1, 'Americano'),
(1804, 99, 2, 'Espresso diluted with hot water for a smooth, long coffee.'),
(1805, 99, 26, '3.50'),
(1806, 99, 15, 'media/69bfc04e857d7_americano.png'),
(1807, 119, 1, 'Iced Latte'),
(1808, 119, 2, 'Espresso with chilled milk over ice, smooth and refreshing.'),
(1809, 119, 26, '4.75'),
(1810, 119, 32, 'on'),
(1811, 119, 15, 'media/69bfc13ecfd1b_iced-latte.png'),
(1812, 120, 1, 'Iced Americano'),
(1813, 120, 2, 'Bold espresso poured over ice with cold water.'),
(1814, 120, 26, '4.25'),
(1815, 120, 32, 'on'),
(1816, 120, 15, 'media/69bfc33b7dc73_iced-americano.png'),
(1820, 121, 32, 'on'),
(1821, 121, 15, 'media/69bfc8714c718_iced-caramel-latte.png'),
(1822, 118, 1, 'Cappuccino'),
(1823, 118, 2, 'Espresso with steamed milk and a thick layer of foam.'),
(1824, 118, 26, '4.50'),
(1825, 118, 32, 'on'),
(1826, 118, 15, 'media/69bfe266b4d2c_cappuccino.png'),
(1827, 122, 1, 'Latte'),
(1828, 122, 2, 'Smooth espresso blended with creamy steamed milk.'),
(1829, 122, 26, '4.75'),
(1830, 122, 32, 'on'),
(1831, 122, 15, 'media/69bfe327229c5_latte.png'),
(1832, 123, 1, 'Flat White'),
(1833, 123, 2, 'Rich espresso with silky microfoam milk.'),
(1834, 123, 26, '4.75'),
(1835, 123, 15, 'media/69bfe47c67f51_latte.png'),
(1836, 124, 1, 'Cold Brew Classic'),
(1837, 124, 2, 'Slow-steeped for 18 hours, smooth and low acidity.'),
(1838, 124, 26, '4.5'),
(1839, 124, 32, 'on'),
(1840, 124, 15, 'media/69c0d6add1230_cappuccino.png'),
(1844, 125, 32, 'on'),
(1845, 125, 15, 'media/69c0d6e371388_iced-latte.png'),
(1846, 126, 1, 'Caramel Latte'),
(1847, 126, 2, 'A classic latte with smooth caramel notes.'),
(1848, 126, 26, '5.25'),
(1849, 126, 15, 'media/69c0e69893271_caramel-latte.png'),
(1854, 127, 1, 'Mocha'),
(1855, 127, 2, 'Espresso with chocolate and steamed milk.'),
(1856, 127, 26, '5.50'),
(1857, 127, 15, 'media/69c0e97b65ac5_iced-latte.png'),
(1858, 128, 1, 'Hazelnut Latte'),
(1859, 128, 2, 'Nutty, aromatic twist on a traditional latte.'),
(1860, 128, 26, '5.25'),
(1861, 128, 15, 'media/69c0e9ec30e51_iced-americano.png'),
(1862, 129, 1, 'Masala Chai Latte'),
(1863, 129, 2, 'Spiced tea blended with steamed milk.'),
(1864, 129, 26, '4.50'),
(1865, 129, 15, 'media/69c0ea74be424_double-espressp.png'),
(1866, 130, 1, 'Green Tea'),
(1867, 130, 2, 'Light, refreshing, and gently energizing.'),
(1868, 130, 26, '3.50'),
(1869, 130, 15, 'media/69c0eaebdc824_green-tea.png'),
(1870, 131, 1, 'Iced Peach Tea'),
(1871, 131, 2, 'Chilled black tea with a hint of peach.'),
(1872, 131, 26, '4.25'),
(1873, 131, 15, 'media/69c0ebb6688ba_iced-tea.png'),
(1874, 43, 3, '<div class=\"feature-list\">\r\n  <div class=\"section center-align\">\r\n    <h5 class=\"white-text\">Your Neighborhood Coffee Experience</h5>\r\n    \r\n    <ul class=\"collection z-depth-1\">\r\n      <li class=\"collection-item white-text\">\r\n        <i class=\"material-icons\">local_cafe</i> Freshly Brewed Coffee &amp; Espresso\r\n      </li>\r\n      \r\n      <li class=\"collection-item white-text\">\r\n        <i class=\"material-icons\">emoji_food_beverage</i> Handcrafted Drinks Made by Baristas\r\n      </li>\r\n      \r\n      <li class=\"collection-item white-text\">\r\n        <i class=\"material-icons\">people</i> A Space to Relax, Work &amp; Connect\r\n      </li>\r\n      \r\n      <li class=\"collection-item white-text\">\r\n        <i class=\"material-icons\">bakery_dining</i> Fresh Bakes &amp; Light Bites Daily\r\n      </li>\r\n      \r\n      <li class=\"collection-item white-text\">\r\n        <i class=\"material-icons\">favorite</i> Loved by Our Local Community\r\n      </li>\r\n    </ul>\r\n    \r\n  </div>\r\n</div>'),
(1875, 125, 1, 'Vanilla Sweet Cream'),
(1876, 125, 2, 'Cold brew topped with lightly sweet vanilla cream.'),
(1877, 125, 26, '5.25'),
(1885, 104, 28, '250'),
(1887, 104, 15, 'media/69c23efe3f54b_ethiopian-y.png'),
(1889, 104, 32, 'on'),
(1898, 103, 32, 'on'),
(1906, 103, 15, 'media/69c24078aedf3_house-blend.png'),
(1916, 102, 15, 'media/69c24d3e05d4b_cold-brew-coffee.png'),
(1926, 102, 31, 'COLD-BREW-01'),
(1927, 102, 32, 'on'),
(1928, 102, 39, '650 ml.'),
(1929, 102, 1, 'Cold Brew Bottle'),
(1930, 102, 2, 'Smooth, low-acidity cold brew — refreshing and ready to drink.'),
(1931, 102, 4, '<div>Slow-steeped for over 18 hours, this cold brew delivers a smooth, rich flavor with low acidity and a naturally sweet finish. Crafted using carefully selected&nbsp;beans, it’s refreshing, balanced, and ready to enjoy straight from the bottle.</div><br><div>Perfect for warm days or whenever you want a clean, bold coffee without the bitterness.</div>'),
(1932, 102, 27, '20'),
(1933, 102, 26, '6.50'),
(1934, 102, 30, '1'),
(1935, 103, 31, 'COF-HO-BL-001'),
(1936, 103, 39, '250 gm.'),
(1937, 103, 1, 'House Blend'),
(1938, 103, 2, 'A rich, full-bodied blend crafted for everyday coffee.'),
(1939, 103, 4, '<div>Our signature blend, crafted for everyday coffee lovers. This medium roast delivers a balanced profile with notes of chocolate,&nbsp;toasted nuts, and a smooth, lingering finish.</div><br>Versatile and comforting — ideal for espresso machines, French press, or your daily morning brew.'),
(1940, 103, 27, '20'),
(1941, 103, 26, '12.99'),
(1942, 103, 30, '1'),
(1943, 104, 31, 'COF-ETH-YIR-001'),
(1944, 104, 39, '250 gm.'),
(1945, 104, 1, 'Ethiopian Yirgacheffe'),
(1946, 104, 2, 'Floral, citrusy, and bright with a clean finish.'),
(1947, 104, 4, '<div>A bright, floral coffee with delicate citrus notes and a clean, tea-like finish. Grown at high altitudes in Ethiopia, this light roast brings out vibrant acidity&nbsp;and complex aromatics — perfect for pour-over or slow brewing.</div><br><div>Smooth, expressive, and crafted for those who enjoy a refined cup.</div>'),
(1948, 104, 27, '20'),
(1949, 104, 26, '14.99'),
(1950, 104, 30, '1'),
(1975, 101, 1, 'Espresso'),
(1976, 101, 2, 'A bold single shot with rich crema and intense flavor.'),
(1977, 101, 32, 'on'),
(1978, 101, 26, '3'),
(1979, 41, 1, 'First Home Page'),
(1980, 41, 40, ''),
(1981, 41, 3, '<!-- Main Content -->\r\n<div class=\"row block-first\">\r\n   <div class=\"container\">\r\n      \r\n      <!-- Left Column (Main Content) -->\r\n      <div class=\"col s12 m12 l7 left\">\r\n         <div class=\"htmlslider\">\r\n            {{entity type=\"snippets\" name=\"home-page-slideshow\" template-type=\"html_template\"}}\r\n          </div>\r\n          <div class=\"events\">\r\n            ##CAFE-EVENTS##   \r\n           </div>\r\n         \r\n         \r\n      </div>\r\n      <div class=\"col s12 m12 l5 right quote\">\r\n         <!--<div class=\"vertical-spacer\"></div>-->\r\n         {{entity type=\"snippets\" name=\"reservation-request-form\" template-type=\"html_template\"}}\r\n      </div>\r\n   </div>\r\n\r\n<div class=\"row block coffee-banner\">\r\n   <div class=\"container \">\r\n      <div class=\"col s12 m12 l5 left\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <a class=\"transparent-image\" href=\"#\"><img loading=\"lazy\" src=\"images/a-coffee-cup-beans.png\" alt=\"The Neighborhood Cafe\"></a>\r\n         <a class=\"link-text\" href=\"/\">Visit the Coffee Bar</a>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right banner\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h3>A NEIGHBORHOOD FAVORITE</h3>\r\n         <div class=\"image\"><img src=\"images/yourdailycup.png\" alt=\"Your Daily Cup\" loading=\"lazy\"></div>\r\n         <p class=\"flow-text white-text col s11 offset-s1\">Step into Willow Cup Coffee and enjoy the warmth of freshly brewed coffee, handcrafted drinks, and a space designed for conversation, creativity,and slow mornings.</p>\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block coffee homevideo\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 m12 l5 left\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>DISCOVER</h2>\r\n         <h1 class=\"logo\"><img loading=\"lazy\" src=\"images/willow-cup-coffee-white.svg\" alt=\"Willow Cup Coffee\"></h1>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"video\"><img loading=\"lazy\" src=\"images/willow-cup-coffee-team.png\" alt=\"The Willow Cup Coffee Team\"></div>\r\n         <h3>OUR COFFEE STORY</h3>\r\n         <h3><strong>Brewing Community, One Cup at a Time</strong></h3>\r\n         <p>At Willow Cup Coffee, every cup begins with carefully sourced beans and a passion for great coffee. Our baristas craft each drink with care — from rich espresso to creamy lattes — creating a place where friends meet, ideas flow, and mornings start right.</p>\r\n         <a class=\"waves-effect waves-light btn-large black white-text\">OUR STORY</a>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block black-coffee products\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 full\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>Our Signature Drinks</h2>\r\n         ##MENU-PRODUCT##\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block dark-coffee customers\">\r\n   <section class=\"section white-text\">\r\n      <div class=\"container\">\r\n         <div class=\"row\">\r\n            <!-- Left Side: Audience Icons + Text -->\r\n            <div class=\"col s12 m6 l6\">\r\n               <h3 class=\"white-text\">More Than Just Coffee</h3>\r\n               <ul class=\"customers-promo collection with-header black-coffee white-text\" style=\"border:none;\">\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">local_cafe</i>Specialty Coffee &amp; Signature Brews</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">fastfood</i>Comfortable Spaces to Work &amp; Unwind</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">store</i>Expertly Crafted Espresso Drinks</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">event</i>Fresh Pastries &amp; Seasonal Treats</li>\r\n                  <li class=\"collection-item white-text\"><i class=\"material-icons left\">emoji_objects</i>A Café Built Around Community</li>\r\n               </ul>\r\n            </div>\r\n            <!-- Right Side: SEO-friendly Write-Up -->\r\n            <div class=\"col s12 m6 l6\">\r\n               <h3 class=\"white-text\">Your Daily Coffee Ritual</h3>\r\n               <p class=\"flow-text white-text\">\r\n                 At Willow Cup Coffee, every visit is more than just a quick stop. It’s a moment to pause, reset, and enjoy something made with care.\r\nFrom your first morning espresso to a slow afternoon latte, we create coffee experiences you’ll look forward to every day.\r\n               </p>\r\n               <p class=\"white-text\">\r\n                  We focus on what matters most — great beans, careful brewing, and attention to every detail. Each cup is crafted to bring out rich, balanced flavors that make every sip memorable.\r\n               </p>\r\n            </div>\r\n         </div>\r\n      </div>\r\n   </section>\r\n</div>\r\n<div class=\"row block dark-coffee shop\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 m12 l5 left caption\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>SHOP</h2>\r\n         <h3>PRODUCTS</h3>\r\n         <div class=\"shopmessage dark-coffee\"><a href=\"#\"><img src=\"images/willow-cup-coffee-white.svg\" alt=\"Willow Cup Coffee\"></a></div>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right home-shop\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n                  ##SHOP-PRODUCT##\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block dark-coffee reviews\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 full\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>Straight from our Customers</h2>\r\n         <div class=\"row \">\r\n            ##TESTIMONIALS##\r\n         </div>\r\n      </div>\r\n   </div>\r\n</div></div>'),
(1982, 133, 1, 'Second Home Page for White Theme'),
(1983, 133, 40, 'on'),
(1984, 133, 3, '<!-- Main Content -->\r\n<div class=\"white-layer-background\"> </div>\r\n<div class=\"row block-first\">\r\n   <div class=\"container\">\r\n      \r\n      <!-- Left Column (Main Content) -->\r\n      <div class=\"col s12 m12 l7 left\">\r\n         <div class=\"htmlslider\">\r\n            {{entity type=\"snippets\" name=\"white-home-page-slideshow\" template-type=\"html_template\"}}\r\n          </div>\r\n          <div class=\"events\">\r\n            ##CAFE-EVENTS##   \r\n           </div>\r\n         \r\n         \r\n      </div>\r\n      <div class=\"col s12 m12 l5 right quote\">\r\n         <!--<div class=\"vertical-spacer\"></div>-->\r\n         {{entity type=\"snippets\" name=\"white-reservation-request-form\" template-type=\"html_template\"}}\r\n      </div>\r\n   </div>\r\n\r\n<div class=\"row block coffee-banner\">\r\n   <div class=\"container \">\r\n      <div class=\"col s12 m12 l5 left\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <a class=\"transparent-image\" href=\"#\"><img loading=\"lazy\" src=\"images/a-coffee-cup-beans.png\" alt=\"The Neighborhood Cafe\"></a>\r\n         <a class=\"link-text white-text\" href=\"/\">Visit the Coffee Bar</a>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right banner\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h3 class=\"black-text\">A NEIGHBORHOOD FAVORITE</h3>\r\n         <div class=\"image\"><img src=\"images/yourdailycup.png\" alt=\"Your Daily Cup\" loading=\"lazy\"></div>\r\n         <p class=\"flow-text black-text col s11 offset-s1\">Step into Willow Cup Coffee and enjoy the warmth of freshly brewed coffee, handcrafted drinks, and a space designed for conversation, creativity,and slow mornings.</p>\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block homevideo\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 m12 l5 left\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2 class=\"black-text\">DISCOVER</h2>\r\n         <h1 class=\"logo\"><img loading=\"lazy\" src=\"images/willow-cup-coffee-black.svg\" alt=\"Willow Cup Coffee\"></h1>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"video\"><img loading=\"lazy\" src=\"images/willow-cup-coffee-team.png\" alt=\"The Willow Cup Coffee Team\"></div>\r\n         <h3 class=\"black-text\">OUR COFFEE STORY</h3>\r\n         <h3 class=\"black-text\"><strong>Brewing Community, One Cup at a Time</strong></h3>\r\n         <p class=\"black-text\">At Willow Cup Coffee, every cup begins with carefully sourced beans and a passion for great coffee. Our baristas craft each drink with care — from rich espresso to creamy lattes — creating a place where friends meet, ideas flow, and mornings start right.</p>\r\n         <a class=\"waves-effect waves-light btn-large grey black-text\">OUR STORY</a>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block black-coffee products\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 full\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>Our Signature Drinks</h2>\r\n         ##MENU-PRODUCT##\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block dark-coffee customers\">\r\n   <section class=\"section white-text\">\r\n      <div class=\"container\">\r\n         <div class=\"row valign-wrapper\">\r\n            <!-- Left Side: Audience Icons + Text -->\r\n            <div class=\"col s12 m6 l6\">\r\n               <h3 class=\"black-text\">More Than Just Coffee</h3>\r\n               <ul class=\"customers-promo collection with-header black-coffee black-text\" style=\"border:none;\">\r\n                  <li class=\"collection-item black-text\"><i class=\"material-icons left\">local_cafe</i>Specialty Coffee &amp; Signature Brews</li>\r\n                  <li class=\"collection-item black-text\"><i class=\"material-icons left\">fastfood</i>Comfortable Spaces to Work &amp; Unwind</li>\r\n                  <li class=\"collection-item black-text\"><i class=\"material-icons left\">store</i>Expertly Crafted Espresso Drinks</li>\r\n                  <li class=\"collection-item black-text\"><i class=\"material-icons left\">event</i>Fresh Pastries &amp; Seasonal Treats</li>\r\n                  <li class=\"collection-item black-text\"><i class=\"material-icons left\">emoji_objects</i>A Café Built Around Community</li>\r\n               </ul>\r\n            </div>\r\n            <!-- Right Side: SEO-friendly Write-Up -->\r\n            <div class=\"col s12 m6 l6\">\r\n               <h3 class=\"black-text\">Your Daily Coffee Ritual</h3>\r\n               <p class=\"flow-text black-text\">\r\n                 At Willow Cup Coffee, every visit is more than just a quick stop. It’s a moment to pause, reset, and enjoy something made with care.\r\nFrom your first morning espresso to a slow afternoon latte, we create coffee experiences you’ll look forward to every day.\r\n               </p>\r\n               <p class=\"black-text\">\r\n                  We focus on what matters most — great beans, careful brewing, and attention to every detail. Each cup is crafted to bring out rich, balanced flavors that make every sip memorable.</p><p class=\"white-text\"></p><div class=\"section white-text center-align\" style=\"padding: 60px 20px;\">\r\n  <h2 class=\"black-text\">Brew Something Amazing</h2>\r\n  <p class=\"flow-text black-text\">Professional or Private Discussions are best done in the open.</p>\r\n  <a class=\"btn-large white black-text\" style=\"margin-top: 20px;\">Reserve Tables</a>\r\n</div>\r\n<br><p></p>\r\n            </div>\r\n         </div>\r\n      </div>\r\n   </section>\r\n</div>\r\n<div class=\"row block dark-coffee shop\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 m12 l5 left caption\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>SHOP</h2>\r\n         <h3>PRODUCTS</h3>\r\n         <div class=\"shopmessage dark-coffee\"><a href=\"#\"><img src=\"images/willow-cup-coffee-black.svg\" alt=\"Willow Cup Coffee\"></a></div>\r\n      </div>\r\n      <div class=\"col s12 m12 l7 right home-shop\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n                  ##SHOP-PRODUCT##\r\n      </div>\r\n   </div>\r\n</div>\r\n<div class=\"row block dark-coffee reviews\">\r\n   <div class=\"container\">\r\n      <div class=\"col s12 full\">\r\n         <div class=\"vertical-spacer\"></div>\r\n         <div class=\"vertical-spacer\"></div>\r\n         <h2>Straight from our Customers</h2>\r\n         <div class=\"row \">\r\n            ##TESTIMONIALS##\r\n         </div>\r\n      </div>\r\n   </div>\r\n</div></div>'),
(1985, 49, 11, 'About Willow Cup Coffee'),
(1986, 49, 1, 'About the Team - the people behind the idea'),
(1987, 49, 2, ' Coffee Worth Slowing Down For Freshly brewed coffee, warm pastries, and a moment of calm.'),
(1988, 49, 3, '<!-- HERO SECTION -->\r\n<div class=\"container\">\r\n  <div class=\"section center-align\">\r\n    <h1 class=\"white-text\">About Willow Cup Coffee</h1>\r\n    <p class=\"flow-text\">Crafting Coffee, Creating Community</p>\r\n    <p class=\"white-text\">A neighborhood café built on simple values — great coffee, warm spaces, and meaningful moments shared over every cup.</p>\r\n  </div>\r\n\r\n  <div class=\"divider\"></div>\r\n\r\n  <!-- OUR STORY -->\r\n  <div class=\"section\">\r\n    <h4 class=\"white-text\">Our Story</h4>\r\n\r\n    <div class=\"row\">\r\n      <div class=\"col s12 m6\">\r\n        <div class=\"card hoverable\">\r\n          <div class=\"card-content brown lighten-3\">\r\n            <span class=\"card-title white-text\">☕ Where It Began</span>\r\n            <p>Willow Cup Coffee started with a simple idea — to create a space where people could slow down and enjoy coffee the way it’s meant to be. What began as a small neighborhood café has grown into a daily ritual for many.</p>\r\n            <ul class=\"browser-default white-text\">\r\n              <li>A passion for quality coffee</li>\r\n              <li>A love for simple, honest spaces</li>\r\n              <li>A focus on everyday moments</li>\r\n            </ul>\r\n          </div>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col s12 m6\">\r\n        <div class=\"card hoverable\">\r\n          <div class=\"card-content brown lighten-2\">\r\n            <span class=\"card-title white-text\">🌿 Our Philosophy</span>\r\n            <p>We believe great coffee is about more than taste — it’s about how it’s made and how it makes you feel.</p>\r\n            <ul class=\"browser-default white-text\">\r\n              <li>Carefully sourced beans</li>\r\n              <li>Thoughtful brewing methods</li>\r\n              <li>Consistency in every cup</li>\r\n              <li>A calm, welcoming environment</li>\r\n            </ul>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- WHAT WE DO -->\r\n    <div class=\"row\">\r\n      <div class=\"col s12 m6\">\r\n        <div class=\"card hoverable\">\r\n          <div class=\"card-content brown lighten-1\">\r\n            <span class=\"card-title white-text\">🥤 What We Serve</span>\r\n            <p>From bold espresso to smooth lattes and refreshing cold brews, our menu is crafted to suit every moment of the day.</p>\r\n            <ul class=\"browser-default white-text\">\r\n              <li>Espresso & classic coffee drinks</li>\r\n              <li>Signature lattes & seasonal specials</li>\r\n              <li>Cold brew & iced coffee</li>\r\n              <li>Fresh bakes & light bites</li>\r\n            </ul>\r\n          </div>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col s12 m6\">\r\n        <div class=\"card hoverable\">\r\n          <div class=\"card-content brown\">\r\n            <span class=\"card-title white-text\">👥 Our Space</span>\r\n            <p>Designed for comfort and connection, Willow Cup Coffee is a place where you can relax, work, or meet friends.</p>\r\n            <ul class=\"browser-default white-text\">\r\n              <li>Cozy seating & warm interiors</li>\r\n              <li>Free WiFi for work and study</li>\r\n              <li>Friendly, welcoming atmosphere</li>\r\n              <li>A true neighborhood café experience</li>\r\n            </ul>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n\r\n    <!-- COMMUNITY -->\r\n    <div class=\"row\">\r\n      <div class=\"col s12 m6\">\r\n        <div class=\"card hoverable\">\r\n          <div class=\"card-content brown darken-1\">\r\n            <span class=\"card-title white-text\">🤝 Community First</span>\r\n            <p>We’re proud to be part of the neighborhood — a place where people come together, share conversations, and create everyday memories.</p>\r\n            <ul class=\"browser-default white-text\">\r\n              <li>Local events & gatherings</li>\r\n              <li>Friendly, familiar faces</li>\r\n              <li>A space that feels like home</li>\r\n            </ul>\r\n          </div>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col s12 m6\">\r\n        <div class=\"card hoverable\">\r\n          <div class=\"card-content brown darken-2\">\r\n            <span class=\"card-title white-text\">🌍 Thoughtful Choices</span>\r\n            <p>We aim to make responsible choices wherever possible — from sourcing to serving.</p>\r\n            <ul class=\"browser-default white-text\">\r\n              <li>Carefully selected ingredients</li>\r\n              <li>Simple, mindful processes</li>\r\n              <li>Focus on quality over quantity</li>\r\n            </ul>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </div>\r\n\r\n  <div class=\"divider\"></div>\r\n\r\n  <!-- WHY CHOOSE US -->\r\n  <div class=\"section\">\r\n    <h4 class=\"white-text\">Why People Love Willow Cup Coffee</h4>\r\n    <div class=\"row\">\r\n      <div class=\"col s12 m6\">\r\n        <ul class=\"collection brown lighten-2\">\r\n          <li class=\"collection-item\">✔️ Consistently great coffee</li>\r\n          <li class=\"collection-item\">✔️ Warm and welcoming space</li>\r\n          <li class=\"collection-item\">✔️ Crafted drinks made with care</li>\r\n        </ul>\r\n      </div>\r\n      <div class=\"col s12 m6\">\r\n        <ul class=\"collection brown lighten-3\">\r\n          <li class=\"collection-item\">✔️ A true neighborhood café</li>\r\n          <li class=\"collection-item\">✔️ Comfortable for work or relaxation</li>\r\n          <li class=\"collection-item\">✔️ Friendly, attentive service</li>\r\n        </ul>\r\n      </div>\r\n    </div>\r\n  </div>\r\n\r\n  <div class=\"divider\"></div>\r\n\r\n  <!-- CTA SECTION -->\r\n  <div class=\"section center-align\">\r\n    <h4 class=\"white-text\">Come Say Hello</h4>\r\n    <p class=\"flow-text\">We’d love to welcome you to Willow Cup Coffee.</p>\r\n    <a class=\"btn-large waves-effect waves-light brown darken-1\" href=\"/visit\">Visit Us</a>\r\n    <p class=\"white-text\">Or reach out anytime at <a href=\"mailto:hello@willowcupcoffee.com\">hello@willowcupcoffee.com</a></p>\r\n  </div>\r\n</div>'),
(1989, 48, 41, 'Lisa Hilton'),
(1990, 48, 42, 'Willow Cup Coffee'),
(1991, 49, 41, 'Mat Murdoch'),
(1992, 49, 42, 'Willow Cup Coffee'),
(1993, 134, 3, '<ul>\r\n               <li>\r\n<div class=\"slider-div\">\r\n  <video autoplay=\"\" muted=\"\" loop=\"\" playsinline=\"\" style=\"width: 100%; \">\r\n    <source src=\"images/coffee-cup-sketch-2.mp4\" type=\"video/mp4\">\r\n  </video>\r\n</div>\r\n  <h2 class=\"sublogo\">COFFEE . CULTURE . CURATION </h2>\r\n  <img src=\"images/fly-withus.png\" alt=\"Fly with Us\" style=\"position: absolute; width: 55%; right: 0; bottom:0;\">\r\n</li>\r\n<li>\r\n  <div class=\"slider-div\">\r\n  <img src=\"images/coffee-shop-jamming-sketch.png\" alt=\"Coffee &amp; Jam\" style=\"top:-80px;\">\r\n  </div>\r\n<h2 class=\"sublogo\">WIND DOWN . JAM .  FLOW</h2>\r\n  <img src=\"images/girl-band-logo.png\" alt=\"Pacific Girls\" style=\"position: absolute; width: 55%; right: 0; bottom:0;\">\r\n</li>\r\n            </ul>'),
(1994, 135, 3, '<a id=\"quote\"></a>\r\n<h2>Request Reservation</h2>\r\n                <div class=\"row\">\r\n                    <div class=\"input-field col s6\">\r\n                      <i class=\"material-icons prefix black-text\">account_circle</i>\r\n                      <input id=\"icon_name\" type=\"text\" class=\"validate white-text\" required=\"\">\r\n                      <label for=\"icon_name\">Name *</label>\r\n                    </div>\r\n                    <div class=\"input-field col s6\">\r\n                      <i class=\"material-icons prefix black-text\">phone</i>\r\n                      <input id=\"icon_telephone\" type=\"tel\" class=\"validate white-text\" pattern=\"^\\+44\\s?\\d{2,4}\\s?\\d{3,4}\\s?\\d{3,4}$|^0\\d{2,4}\\s?\\d{3,4}\\s?\\d{3,4}$\">\r\n                      <label class=\"active\" for=\"icon_telephone\">Telephone</label>\r\n                      <span class=\"helper-text black-text\" data-error=\"Phone number is wrong\" data-success=\"✔\"> </span>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <div class=\"input-field col s6\">\r\n                      <i class=\"material-icons prefix black-text\">local_convenience_store</i>\r\n                      <input id=\"icon_company\" type=\"text\" class=\"validate white-text\">\r\n                      <label for=\"icon_company\">Company <em>* For Corporate Events</em></label>\r\n                    </div>\r\n                    <div class=\"input-field col s6\">\r\n                      <i class=\"material-icons prefix black-text\">email</i>\r\n                      <input id=\"icon_email\" type=\"email\" class=\"validate white-text\" required=\"\">\r\n                      <label class=\"active\" for=\"icon_email\">Email *</label>\r\n                      <span class=\"helper-text black-text\" data-error=\"Email is wrong\" data-success=\"✔\"> </span>\r\n                    </div>\r\n                </div>\r\n                                <div class=\"row\">\r\n                    <div class=\"input-field col s6 homepagequoteformselect\">\r\n                        <input type=\"text\" class=\"datepicker\">\r\n                        <label>Day</label>\r\n                    </div>\r\n                    <div class=\"input-field col s6 homepagequoteformselect\">\r\n                         <input type=\"text\" class=\"timepicker\">\r\n                        <label>Time</label>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <div class=\"input-field col s6 homepagequoteformselect\">\r\n                        <select multiple=\"\">\r\n                          <option value=\"Less than 4\">Less than 4</option>\r\n                          <option value=\"Between\" 4=\"\" and=\"\" 6\"=\"\">Between 4 and 6</option>\r\n                          <option value=\"Between 6 and 10\">\"Between 6 and 10</option>\r\n                          <option value=\"About a Dozen\">About a Dozen</option>\r\n                          <option value=\"Between 12 and 18\">Between 12 and 18</option>\r\n                        </select>\r\n                        <label>Number of Guests</label>\r\n                    </div>\r\n                    <div class=\"input-field col s6 homepagequoteformselect\">\r\n                        <select multiple=\"\">\r\n                          <option value=\"Willow Cup Pearl\">\"Willow Cup Pearl</option>\r\n                          <option value=\"Willow Cup Hawthorne\">Willow Cup Hawthorne</option>\r\n                          <option value=\"Willow Cup Downtown\">Willow Cup Downtown</option>\r\n                          <option value=\"Willow Cup Alberta Arts\">Willow Cup Alberta Arts</option>\r\n                          <option value=\"Willow Cup Sellwood\">Willow Cup Sellwood</option>\r\n                        </select>\r\n                        <label>Preferred Location</label>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                  <div class=\"input-field col s12 homepagequoteformselect\">\r\n                    <textarea id=\"specifics\" class=\"materialize-textarea\" data-length=\"1000\"></textarea>\r\n                    <label for=\"specifics\">Specific Requirements</label>\r\n                  </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                  <div class=\"input-field col s12 homepagequoteformselect\">\r\n                    <button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"action\">Submit\r\n                        <i class=\"material-icons right\">send</i>\r\n                    </button>\r\n                  </div>\r\n                </div>'),
(1996, 121, 1, 'Iced Caramel Latte'),
(1997, 121, 2, 'Cold latte with a touch of caramel sweetness.'),
(1998, 121, 26, '5.25'),
(1999, 109, 3, '<a id=\"quote\"></a>\r\n<h2>Request Reservation</h2>\r\n                <div class=\"row\">\r\n                    <div class=\"input-field col l6 m6 s12\">\r\n                      <i class=\"material-icons prefix white-text\">account_circle</i>\r\n                      <input id=\"icon_name\" type=\"text\" class=\"validate white-text\" required=\"\">\r\n                      <label for=\"icon_name\">Name *</label>\r\n                    </div>\r\n                    <div class=\"input-field col l6 m6 s12\">\r\n                      <i class=\"material-icons prefix white-text\">phone</i>\r\n                      <input id=\"icon_telephone\" type=\"tel\" class=\"validate white-text\" pattern=\"^\\+44\\s?\\d{2,4}\\s?\\d{3,4}\\s?\\d{3,4}$|^0\\d{2,4}\\s?\\d{3,4}\\s?\\d{3,4}$\">\r\n                      <label class=\"active\" for=\"icon_telephone\">Telephone</label>\r\n                      <span class=\"helper-text white-text\" data-error=\"Phone number is wrong\" data-success=\"✔\"> </span>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <div class=\"input-field col l6 m6 s12\">\r\n                      <i class=\"material-icons prefix white-text\">local_convenience_store</i>\r\n                      <input id=\"icon_company\" type=\"text\" class=\"validate white-text\">\r\n                      <label for=\"icon_company\">Company <em>* For Corporate Events</em></label>\r\n                    </div>\r\n                    <div class=\"input-field col l6 m6 s12\">\r\n                      <i class=\"material-icons prefix white-text\">email</i>\r\n                      <input id=\"icon_email\" type=\"email\" class=\"validate white-text\" required=\"\">\r\n                      <label class=\"active\" for=\"icon_email\">Email *</label>\r\n                      <span class=\"helper-text white-text\" data-error=\"Email is wrong\" data-success=\"✔\"> </span>\r\n                    </div>\r\n                </div>\r\n                                <div class=\"row\">\r\n                    <div class=\"input-field col l6 m6 s12 homepagequoteformselect\">\r\n                        <input type=\"text\" class=\"datepicker\">\r\n                        <label>Day</label>\r\n                    </div>\r\n                    <div class=\"input-field col l6 m6 s12 homepagequoteformselect\">\r\n                         <input type=\"text\" class=\"timepicker\">\r\n                        <label>Time</label>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                    <div class=\"input-field col l6 m6 s12 homepagequoteformselect\">\r\n                        <select multiple=\"\">\r\n                          <option value=\"Less than 4\">Less than 4</option>\r\n                          <option value=\"Between\" 4=\"\" and=\"\" 6\"=\"\">Between 4 and 6</option>\r\n                          <option value=\"Between 6 and 10\">\"Between 6 and 10</option>\r\n                          <option value=\"About a Dozen\">About a Dozen</option>\r\n                          <option value=\"Between 12 and 18\">Between 12 and 18</option>\r\n                        </select>\r\n                        <label>Number of Guests</label>\r\n                    </div>\r\n                    <div class=\"input-field col l6 m6 s12 homepagequoteformselect\">\r\n                        <select multiple=\"\">\r\n                          <option value=\"Willow Cup Pearl\">\"Willow Cup Pearl</option>\r\n                          <option value=\"Willow Cup Hawthorne\">Willow Cup Hawthorne</option>\r\n                          <option value=\"Willow Cup Downtown\">Willow Cup Downtown</option>\r\n                          <option value=\"Willow Cup Alberta Arts\">Willow Cup Alberta Arts</option>\r\n                          <option value=\"Willow Cup Sellwood\">Willow Cup Sellwood</option>\r\n                        </select>\r\n                        <label>Preferred Location</label>\r\n                    </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                  <div class=\"input-field col s12 homepagequoteformselect\">\r\n                    <textarea id=\"specifics\" class=\"materialize-textarea\" data-length=\"1000\"></textarea>\r\n                    <label for=\"specifics\">Specific Requirements</label>\r\n                  </div>\r\n                </div>\r\n                <div class=\"row\">\r\n                  <div class=\"input-field col s12 homepagequoteformselect\">\r\n                    <button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"action\">Submit\r\n                        <i class=\"material-icons right\">send</i>\r\n                    </button>\r\n                  </div>\r\n                </div>'),
(2000, 137, 11, 'Do Not Delete This Page'),
(2001, 137, 1, 'Checkout'),
(2002, 137, 2, 'One Step Shopping Experience'),
(2003, 137, 3, '<div class=\"container checkout-page\">\r\n   <ul id=\"checkout-tabs\" class=\"tabs tabs-fixed-width\">\r\n      <li class=\"tab col l3 m3 s12\"><a class=\"active\" href=\"#cart-step\"><i class=\"material-icons\">shopping_cart</i><br>Cart</a></li>\r\n      <li class=\"tab col l3 m3 s12\"><a href=\"#address-step\"><i class=\"material-icons\">home</i><br>Address</a></li>\r\n      <li class=\"tab col l3 m3 s12\"><a href=\"#payment-step\"><i class=\"material-icons\">payment</i><br>Payment</a></li>\r\n      <li class=\"tab col l3 m3 s12\"><a href=\"#confirmation-step\"><i class=\"material-icons\">check_circle</i><br>Confirmation</a></li>\r\n   </ul>\r\n   <div id=\"cart-step\" class=\"col s12\">\r\n      <div class=\"card-panel green lighten-4\">\r\n         <strong>Available Offers:</strong><br>\r\n         - 10% Instant Discount on Bank of America Debit/Credit Cards<br>\r\n         - 25% Cashback Voucher on your first PayPal transaction.\r\n      </div>\r\n      <ul class=\"collection with-header products-list-checkout\"></ul>\r\n      <div class=\"card grey lighten-4\">\r\n         <div class=\"card-content price-total\">\r\n         </div>\r\n         <div class=\"card-action center\">\r\n            <a id=\"go-to-address\" href=\"#address-step\" class=\"waves-effect waves-light btn  brown darken-3 large\">Place Order</a>\r\n         </div>\r\n      </div>\r\n   </div>\r\n   <div id=\"address-step\" class=\"col s12\">\r\n      <!--    Address Step -->\r\n      <h5 class=\"deep-purple-text\">Shipping &amp; Billing Address</h5>\r\n      <!-- Address Selection Section -->\r\n      <div class=\"row\" id=\"address-selection\">\r\n         <div class=\"col s12 m6\">\r\n            <h6>Choose Shipping Address</h6>\r\n            <div id=\"shipping-address-list\" class=\"collection with-header\"></div>\r\n         </div>\r\n         <div class=\"col s12 m6\">\r\n            <h6>Choose Billing Address</h6>\r\n            <label>\r\n            <input type=\"checkbox\" id=\"same-as-shipping\">\r\n            <span>Same as shipping address</span>\r\n            </label>\r\n            <div id=\"billing-address-list\" class=\"collection with-header\"></div>\r\n         </div>\r\n      </div>\r\n      <!--<div class=\"divider\"></div>-->\r\n      <!-- Add New Address Section -->\r\n      <div class=\"row new-address blue lighten-5\">\r\n         <div class=\"col s12\">\r\n            <h6>Add New Address</h6>\r\n            <div class=\"input-field\">\r\n               <input type=\"text\" id=\"new-name\">\r\n               <label for=\"new-name\">Full Name</label>\r\n            </div>\r\n            <div class=\"input-field\">\r\n               <input type=\"text\" id=\"new-line1\">\r\n               <label for=\"new-line1\">Address Line 1</label>\r\n            </div>\r\n            <div class=\"input-field\">\r\n               <input type=\"text\" id=\"new-line2\">\r\n               <label for=\"new-line2\">Address Line 2 (Optional)</label>\r\n            </div>\r\n            <div class=\"input-field\">\r\n               <input type=\"text\" id=\"new-city\">\r\n               <label for=\"new-city\">City</label>\r\n            </div>\r\n            <div class=\"input-field\">\r\n               <input type=\"text\" id=\"new-postcode\">\r\n               <label for=\"new-postcode\">Postcode</label>\r\n            </div>\r\n            <input type=\"hidden\" id=\"new-country\" value=\"UK\">\r\n            <div class=\"input-field\">\r\n               <input type=\"text\" id=\"new-label\">\r\n               <label for=\"new-label\">Label (e.g., Home, Office)</label>\r\n            </div>\r\n            <button class=\"btn waves-effect brown\" id=\"save-new-address\">Save Address</button>\r\n         </div>\r\n      </div>\r\n      <div class=\"divider\"></div>\r\n      <!-- Continue Button -->\r\n      <div class=\"row\">\r\n         <div class=\"col s12 right-align\">\r\n            <a href=\"#review-step\" class=\"btn brown darken-2\" id=\"continue-to-review\">Continue</a>\r\n         </div>\r\n      </div>\r\n   </div>\r\n</div>\r\n<script>\r\n   document.addEventListener(\'DOMContentLoaded\', function() {\r\n       paintCheckoutPage();\r\n   });\r\n</script>'),
(2004, 137, 41, ''),
(2005, 137, 42, ''),
(2006, 137, 8, 'media/69c96dd8c0e5d9.95383946_do-not-delete.webp'),
(2007, 138, 43, '138'),
(2009, 138, 45, '17.00'),
(2010, 138, 46, '5'),
(2015, 139, 44, '<li data-item-id=\"99\"><span class=\"item-title\">Americano</span> <span class=\"item-qty\">x 2</span> <span class=\"item-total\">$7.00</span></li><li data-item-id=\"123\"><span class=\"item-title\">Flat White</span> <span class=\"item-qty\">x 2</span> <span class=\"item-total\">$9.50</span></li>'),
(2016, 139, 52, 'Neelanjan B'),
(2017, 139, 43, '139'),
(2018, 139, 45, '16.50'),
(2019, 139, 46, '5'),
(2020, 139, 51, '9830090233'),
(2021, 139, 48, ''),
(2022, 138, 44, ''),
(2023, 139, 47, 'off'),
(2024, 139, 49, 'off');

-- --------------------------------------------------------

--
-- Table structure for table `entity_attribute_input_map`
--

CREATE TABLE `entity_attribute_input_map` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `input_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_attribute_input_map`
--

INSERT INTO `entity_attribute_input_map` (`id`, `attribute_id`, `input_type_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(20, 6, 28),
(22, 3, 14),
(26, 8, 21),
(27, 7, 12),
(28, 9, 22),
(29, 10, 12),
(31, 12, 1),
(32, 13, 12),
(33, 14, 21),
(37, 18, 15),
(43, 23, 1),
(44, 17, 59),
(45, 16, 58),
(46, 24, 60),
(47, 25, 21),
(48, 22, 21),
(49, 21, 21),
(50, 20, 21),
(51, 19, 21),
(52, 15, 21),
(53, 26, 2),
(54, 11, 1),
(56, 28, 2),
(60, 30, 62),
(61, 27, 61),
(62, 31, 1),
(63, 29, 2),
(65, 32, 17),
(66, 33, 2),
(69, 35, 21),
(71, 4, 14),
(72, 34, 1),
(73, 36, 12),
(74, 37, 7),
(75, 38, 8),
(77, 39, 1),
(79, 40, 17),
(80, 41, 1),
(81, 42, 1),
(82, 43, 2),
(83, 44, 1),
(84, 45, 2),
(85, 46, 2),
(86, 47, 17),
(87, 48, 8),
(88, 49, 17),
(89, 51, 5),
(90, 52, 1);

-- --------------------------------------------------------

--
-- Table structure for table `entity_attribute_map`
--

CREATE TABLE `entity_attribute_map` (
  `id` int(11) NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_attribute_map`
--

INSERT INTO `entity_attribute_map` (`id`, `entity_type_id`, `attribute_id`, `attribute_order`) VALUES
(93, 11, 3, 4),
(94, 11, 4, 0),
(95, 11, 2, 0),
(96, 11, 1, 0),
(133, 12, 1, 0),
(134, 12, 10, 0),
(142, 1, 12, 8),
(143, 1, 13, 9),
(144, 1, 1, 1),
(145, 1, 2, 2),
(146, 1, 4, 3),
(147, 1, 3, 4),
(148, 1, 8, 5),
(149, 1, 11, 6),
(150, 1, 9, 7),
(257, 2, 4, 4),
(258, 2, 1, 1),
(259, 2, 2, 2),
(260, 2, 3, 3),
(335, 14, 3, 0),
(337, 15, 3, 0),
(740, 23, 4, 0),
(741, 23, 32, 0),
(742, 23, 33, 0),
(743, 23, 34, 0),
(744, 23, 35, 0),
(750, 24, 1, 0),
(751, 24, 8, 0),
(752, 24, 32, 0),
(753, 24, 36, 0),
(754, 24, 37, 0),
(755, 24, 38, 0),
(796, 17, 31, 0),
(797, 17, 32, 0),
(798, 17, 39, 0),
(799, 17, 1, 1),
(800, 17, 2, 2),
(801, 17, 4, 3),
(802, 17, 27, 5),
(803, 17, 26, 6),
(804, 17, 15, 9),
(805, 17, 30, 14),
(806, 13, 32, 3),
(807, 13, 1, 1),
(808, 13, 2, 2),
(809, 13, 15, 4),
(810, 13, 26, 5),
(811, 18, 1, 1),
(812, 18, 2, 2),
(813, 18, 15, 4),
(814, 18, 26, 5),
(815, 18, 32, 3),
(816, 19, 1, 1),
(817, 19, 2, 2),
(818, 19, 15, 4),
(819, 19, 26, 5),
(820, 19, 32, 3),
(821, 20, 1, 1),
(822, 20, 2, 2),
(823, 20, 15, 4),
(824, 20, 26, 5),
(825, 20, 32, 3),
(826, 21, 1, 1),
(827, 21, 2, 2),
(828, 21, 15, 4),
(829, 21, 26, 5),
(830, 21, 32, 3),
(831, 22, 1, 1),
(832, 22, 2, 2),
(833, 22, 15, 4),
(834, 22, 26, 5),
(835, 22, 32, 3),
(841, 16, 1, 1),
(842, 16, 3, 3),
(843, 16, 40, 2),
(844, 8, 41, 6),
(845, 8, 42, 7),
(846, 8, 8, 1),
(847, 8, 11, 2),
(848, 8, 1, 3),
(849, 8, 2, 4),
(850, 8, 3, 5),
(864, 25, 44, 0),
(865, 25, 52, 0),
(866, 25, 43, 0),
(867, 25, 45, 0),
(868, 25, 46, 0),
(869, 25, 51, 0),
(870, 25, 48, 0),
(871, 25, 47, 0),
(872, 25, 49, 0);

-- --------------------------------------------------------

--
-- Table structure for table `entity_relations`
--

CREATE TABLE `entity_relations` (
  `id` int(11) NOT NULL,
  `parent_entity_id` int(11) NOT NULL,
  `child_entity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_states`
--

CREATE TABLE `entity_states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_states`
--

INSERT INTO `entity_states` (`id`, `state_name`) VALUES
(3, 'draft'),
(1, 'publish'),
(4, 'trash'),
(2, 'unpublish');

-- --------------------------------------------------------

--
-- Table structure for table `entity_state_map`
--

CREATE TABLE `entity_state_map` (
  `id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_state_map`
--

INSERT INTO `entity_state_map` (`id`, `entity_id`, `state_id`) VALUES
(1, 1, 3),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `entity_templates`
--

CREATE TABLE `entity_templates` (
  `id` int(11) NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `template_html` text NOT NULL,
  `preview_template_html` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_templates`
--

INSERT INTO `entity_templates` (`id`, `template_name`, `template_html`, `preview_template_html`) VALUES
(1, 'Blog Template', '<article itemscope itemtype=\"https://schema.org/Article\" class=\"blog-article\">\r\n  <header>\r\n    <h1 itemprop=\"headline\">{title}</h1>\r\n    <h2 class=\"subtitle\" itemprop=\"alternativeHeadline\">{sub_title}</h2>\r\n\r\n    <div class=\"meta\">\r\n      <time itemprop=\"datePublished\" datetime=\"{date_published}\">{created_at}</time>\r\n      <span itemprop=\"author\" itemscope itemtype=\"https://schema.org/Person\">\r\n        by <span itemprop=\"name\">{author_name}</span>\r\n      </span>\r\n    </div>\r\n\r\n   <figure>\r\n    <img src=\"{lead_image}\" alt=\"{lead_image_caption}\" itemprop=\"image\" />\r\n    <figcaption>{lead_image_caption}</figcaption>\r\n   </figure>\r\n\r\n    <p class=\"short-description\" itemprop=\"description\">\r\n      {short_description}\r\n    </p>\r\n  </header>\r\n\r\n  <section class=\"main-content\" itemprop=\"articleBody\">\r\n    {content}\r\n  </section>\r\n\r\n  <section class=\"video-block\" itemprop=\"video\" itemscope itemtype=\"https://schema.org/VideoObject\">\r\n   <video controls width=\"100%\">\r\n     <source src=\"{video}\" type=\"video/mp4\">\r\n     Your browser does not support the video tag.\r\n   </video>\r\n  </section>\r\n</article>\r\n\r\n<script type=\"application/ld+json\">\r\n{\r\n  \"@context\": \"https://schema.org\",\r\n  \"@type\": \"Article\",\r\n  \"headline\": \"{title}\",\r\n  \"alternativeHeadline\": \"{sub_title}\",\r\n  \"image\": \"{lead_image_url}\",\r\n  \"author\": {\r\n    \"@type\": \"Person\",\r\n    \"name\": \"{author_name}\"\r\n  },\r\n  \"publisher\": {\r\n    \"@type\": \"Organization\",\r\n    \"name\": \"{publisher_name}\",\r\n    \"logo\": {\r\n      \"@type\": \"ImageObject\",\r\n      \"url\": \"{publisher_logo}\"\r\n    }\r\n  },\r\n  \"datePublished\": \"{created_at}\",\r\n  \"description\": \"{short_description}\",\r\n  \"mainEntityOfPage\": {\r\n    \"@type\": \"WebPage\",\r\n    \"@id\": \"{canonical_url}\"\r\n  }\r\n}\r\n</script>', '<a href=\"{article_url}\" class=\"article-card\" itemscope itemtype=\"https://schema.org/Article\">\r\n  <div class=\"card-image\">\r\n    <img src=\"{lead_image}\" alt=\"{lead_image_caption}\" itemprop=\"image\">\r\n  </div>\r\n  <div class=\"card-content\">\r\n    <h2 class=\"card-title\" itemprop=\"headline\">{title}</h2>\r\n  </div>\r\n</a>'),
(4, 'News Template', '<div class=\"container news-article\">\n  {{entity type=\"snippets\" name=\"home-page-captions\" template-type=\"html_template\"}}\n  <div class=\"row\">\n    <div class=\"col s12\">\n      <h1 class=\"article-title\">{title}</h1>\n      <h5 class=\"grey-text text-darken-2\">{sub_title}</h5>\n    </div>\n  </div>\n\n  <div class=\"row\">\n    <div class=\"col s12\">\n      <img src=\"{lead_image}\" alt=\"{title}\" class=\"responsive-img z-depth-1\" style=\"margin: 20px 0;\">\n    </div>\n  </div>\n\n  <div class=\"row\">\n    <div class=\"col s12\">\n      <p class=\"flow-text\">{short_description}</p>\n    </div>\n  </div>\n\n  <div class=\"row\">\n    <div class=\"col s12 article-content\">\n      {content}\n    </div>\n  </div>\n</div>\n\n<!-- JSON-LD Structured Data for NewsArticle -->\n<script type=\"application/ld json\">\n{\n  \"@context\": \"https://schema.org\",\n  \"@type\": \"NewsArticle\",\n  \"headline\": \"{title}\",\n  \"alternativeHeadline\": \"{sub_title}\",\n  \"image\": \"{lead_image}\",\n  \"datePublished\": \"{created_at}\",\n  \"dateModified\": \"{created_at}\",\n  \"author\": {\n    \"@type\": \"Person\",\n    \"name\": \"{author_name}\"\n  },\n  \"publisher\": {\n    \"@type\": \"Organization\",\n    \"name\": \"YourSiteName\",\n    \"logo\": {\n      \"@type\": \"ImageObject\",\n      \"url\": \"https://example.com/logo.png\"\n    }\n  },\n  \"description\": \"{short_description}\",\n  \"articleBody\": \"{content}\"\n}\n</script>\n', '<div class=\"col s12 m6 l4\">\n  <a href=\"{article_url}\" class=\"news-card-link\">\n    <div class=\"card hoverable\">\n      <div class=\"card-image\">\n        <img src=\"{lead_image}\" alt=\"{title}\">\n        <span class=\"card-title\">{title}</span>\n      </div>\n      <div class=\"card-content\">\n        <p class=\"grey-text text-darken-1\">{short_description}</p>\n      </div>\n    </div>\n  </a>\n</div>\n'),
(5, 'Product Template', '<div class=\"row block navy product\">\n<script type=\"application/ld json\">\n{\n  \"@context\": \"https://schema.org/\",\n  \"@type\": \"Product\",\n  \"name\": \"{title}\",\n  \"description\": \"{short_description}\",\n  \"image\": [\"##SITE##{product_photo_gallery_photo_1}\"],\n  \"brand\": {\n    \"@type\": \"Brand\",\n    \"name\": \"Willow Cup Coffee\"\n  },\n  \"offers\": {\n    \"@type\": \"Offer\",\n    \"url\": \"{current_page_url}\",\n    \"priceCurrency\": \"USD\",\n    \"price\": \"{Price}\",\n    \"availability\": \"https://schema.org/InStock\"\n  }\n}\n</script>\n<div class=\"container product-page\">\n  <div class=\"row\">\n     <div class=\"col s12\">\n        {{entity type=\"product-page-hero-banner\" name=\"greaseproof-paper-bags-banner\" template-type=\"template_html\"}}\n     </div>\n  </div>\n   <div class=\"navy vertical-spacer\"></div>\n  <div class=\"row\">\n    <!-- Left Side: Gallery and Product Specs -->\n    <div class=\"col s12 m5\">\n      <div class=\"carousel carousel-slider\" style=\"margin-bottom: 20px;\">\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_1}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_2}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_3}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_4}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_5}\" alt=\"{title}\"></a>\n      </div>\n\n       <ul class=\"collection z-depth-1 specifications\">\n    <li class=\"collection-item avatar\">\n      <i class=\"medium material-icons circle orange\">book</i>\n      <span class=\"title\">Paper Type</span>\n      <p>{Paper_Type}</p>\n     \n    </li>\n    <li class=\"collection-item avatar\">\n      <i class=\"material-icons circle blue\">texture</i>\n      <span class=\"title\">Material</span>\n      <p> {Material}</p>\n     \n    </li>\n    <li class=\"collection-item avatar\">\n      <i class=\"material-icons circle green\">filter_none</i>\n      <span class=\"title\">Available Sizes</span>\n      <p>{Sizes}</p>\n      \n    </li>\n    <li class=\"collection-item avatar\">\n      <i class=\"material-icons circle red\">local_drink</i>\n      <span class=\"title\">Minimum Order</span>\n      <p>{Minimum_Order_Quantity}</p>\n     \n    </li>\n </ul>\n    </div>\n\n    <!-- Right Side: Title, Description, and Content -->\n    <div class=\"col s12 m7\">\n      <h4 class=\"product-title\">{title}</h4>\n      <h6 class=\"product-subtitle\">{sub_title}</h6>\n      <!--<div class=\"divider\" style=\"margin: 10px 0 20px;\"></div>-->\n      \n      <div class=\"product-short-description\">\n        {short_description}\n      </div>\n\n      <div class=\"product-full-content\" style=\"margin-top: 30px;\">\n        {content}\n      </div>\n    </div>\n  </div>\n<div class=\"row\">\n    	{{entity type=\"snippets\" name=\"quote-request-form\" template-type=\"html_template\"}}\n </div>\n</div>\n</div>\n<div class=\"row block cyan lighten-1 \">\n     <div class=\"col s12\">\n      {{entity type=\"snippets\" name=\"products-call-for-action\" template-type=\"html_template\"}}\n    </div>\n</div>\n<div class=\"row block blue darken-3 product-tabs\">\n <div class=\"vertical-spacer\"></div>\n\n   <div class=\"col s12\">\n<div class=\"vertical-spacer\"></div>\n<div class=\"container\">\n  <h2 class=\"white-text center-align\">Branded Packaging</h2>\n   ##BRANDED-PRODUCT##\n</div>\n<div class=\"vertical-spacer\"></div>\n   </div>\n</div>', '<li data-entity-type=\"{entity_type}\">\n\n<script type=\"application/ld+json\">\n{\n  \"@context\": \"https://schema.org/\",\n  \"@type\": \"Product\",\n  \"name\": \"{title}\",\n  \"description\": \"{short_description}\",\n  \"image\": [\"##SITE##{product_photo_gallery_photo_1}\"],\n  \"brand\": {\n    \"@type\": \"Brand\",\n    \"name\": \"Willow Cup Coffee\"\n  },\n  \"offers\": {\n    \"@type\": \"Offer\",\n     \"priceCurrency\": \"USD\",\n    \"price\": \"{Price}\",\n    \"availability\": \"https://schema.org/InStock\"\n  }\n}\n</script>\n\n<a href=\"\" data-id=\"{id}\">\n  <div>\n    <img loading=\"lazy\" src=\"##SITE##{product_photo_gallery_photo_1}\" alt=\"{title}\">\n  </div>\n  <h3>{title}</h3>\n  <h5>{sub_title}</h5>\n  <h5 class=\"price\"> ${Price}  <small>excl. VAT</small></h5>\n</a>\n\n</li>'),
(6, 'Page Template', '<div class=\"row block spiralreverse coffee\">\n  <div class=\"col s12\">\n      <div class=\"container\">\n<article itemscope itemtype=\"https://schema.org/Article\" class=\"content-article\">\n\n  <header>\n    <h1 itemprop=\"headline\">{title}</h1>\n    <h2 class=\"subtitle\" itemprop=\"alternativeHeadline\">{sub_title}</h2>\n\n    <div class=\"meta\">\n      <time itemprop=\"datePublished\" datetime=\"{date_published}\">{created_at}</time>\n      <span itemprop=\"author\" itemscope itemtype=\"https://schema.org/Person\">\n        by <span itemprop=\"name\">{author}</span>\n      </span>\n    </div>\n\n    <figure>\n      <img src=\"{lead_image}\" alt=\"{lead_Image_Title}\" title=\"{lead_Image_Title}\"  itemprop=\"image\" />\n      <figcaption>{lead_Image_Title}</figcaption>\n    </figure>\n\n   \n  </header>\n\n  <section class=\"main-content\" itemprop=\"articleBody\">\n    {content}\n  </section>\n</article>\n<div class=\"vertical-spacer\"></div>\n<div class=\"vertical-spacer\"></div>\n<script type=\"application/ld+json\">\n{\n  \"@context\": \"https://schema.org\",\n  \"@type\": \"Article\",\n  \"headline\": \"{title}\",\n  \"alternativeHeadline\": \"{sub_title}\",\n  \"image\": \"{lead_image}\",\n  \"author\": {\n    \"@type\": \"Person\",\n    \"name\": \"{author}\"\n  },\n  \"publisher\": {\n    \"@type\": \"Organization\",\n    \"name\": \"{company}\",\n    \"logo\": {\n      \"@type\": \"ImageObject\",\n      \"url\": \"##SITE##images/willow-cup-coffee-white.svg\"\n    }\n  },\n  \"datePublished\": \"{created_at}\",\n  \"description\": \"{short_description}\",\n  \"mainEntityOfPage\": {\n    \"@type\": \"WebPage\",\n    \"@id\": \"{current_page_url}\"\n  }\n}\n</script>\n</div></div></div>\n', '<a href=\"{page_url}\" class=\"card hoverable\" style=\"display: block;\">\n  <div class=\"card-image\">\n    <img src=\"{lead_image}\" alt=\"{title}\" style=\"height: 200px; object-fit: cover;\">\n  </div>\n  <div class=\"card-content\">\n    <span class=\"card-title\">{title}</span>\n    <p class=\"grey-text text-darken-1\" style=\"font-size: 0.9em;\">{sub_title}</p>\n  </div>\n</a>\n'),
(7, 'Product Page Hero Banner Template', '<div class=container\">\n{content}\n</div>', ''),
(8, 'Snippet Template', '<div class=\"snippet-container\">{content}</div>', ''),
(9, 'Home Page Template', '{content}', '<a href=\"{page_url}\" class=\"card hoverable\" style=\"display: block;\">\n  <div class=\"card-image\">\n    <img src=\"{lead_image}\" alt=\"{title}\" style=\"height: 200px; object-fit: cover;\">\n  </div>\n  <div class=\"card-content\">\n    <span class=\"card-title\">{title}</span>\n    <p class=\"grey-text text-darken-1\" style=\"font-size: 0.9em;\">{sub_title}</p>\n  </div>\n</a>\n'),
(10, 'Shop Product Template', '<div class=\"row block dark-coffee product\">\n {{entity type=\"snippets\" name=\"home-page-captions\" template-type=\"html_template\"}}\n<script type=\"application/ld json\">\n{\n  \"@context\": \"https://schema.org/\",\n  \"@type\": \"Product\",\n  \"name\": \"{title}\",\n  \"description\": \"{short_description}\",\n  \"image\": [\n    \"##SITE##{product_photo_gallery_photo_1}\"\n  ],\n  \"brand\": {\n    \"@type\": \"Brand\",\n    \"name\": \"Willow Cup Coffee\"\n  },\n  \"sku\": \"{sku}\",\n  \"offers\": {\n    \"@type\": \"Offer\",\n    \"url\": \"{current_page_url}\",\n    \"priceCurrency\": \"USD\",\n    \"price\": \"{Price}\",\n    \"availability\": \"https://schema.org/InStock\"\n  },\n  \"additionalProperty\": [\n    {\n      \"@type\": \"PropertyValue\",\n      \"name\": \"VAT\",\n      \"value\": \"{vat}\"\n    },\n    {\n      \"@type\": \"PropertyValue\",\n      \"name\": \"Unit Quantity\",\n      \"value\": \"{unit_quantity} pieces per pack\"\n    },\n    {\n      \"@type\": \"PropertyValue\",\n      \"name\": \"Minimum Pack Quantity\",\n      \"value\": \"{pack_quantity} packs\"\n    }\n  ]\n}\n</script>\n<div class=\"container product-page\">\n  <div class=\"row\">\n     <div class=\"col s12\">\n        {{entity type=\"product-page-hero-banner\" name=\"greaseproof-paper-bags-banner\" template-type=\"template_html\"}}\n     </div>\n  </div>\n  <div class=\"navy vertical-spacer\"></div>\n  <div class=\"row\">\n\n    <!-- Left Side: Gallery -->\n    <div class=\"col s12 m5\">\n      <div class=\"carousel carousel-slider\" style=\"margin-bottom: 20px;\">\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_1}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_2}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_3}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_4}\" alt=\"{title}\"></a>\n        <a class=\"carousel-item\"><img src=\"{product_photo_gallery_photo_5}\" alt=\"{title}\"></a>\n      </div>\n\n      <ul class=\"collection z-depth-1 specifications\">\n        <li class=\"collection-item avatar\">\n          <i class=\"material-icons circle red\">local_drink</i>\n          <span class=\"title\">Items per Pack</span>\n          <p>{pack_quantity}</p>\n        </li>\n        <li class=\"collection-item avatar\">\n          <i class=\"material-icons circle teal\">shopping_cart</i>\n          <span class=\"title\">Minimum Order</span>\n          <p>{unit_quantity}</p>\n        </li>\n      </ul>\n    </div>\n\n    <!-- Right Side: Title, Description, and Pricing -->\n    <div class=\"col s12 m7\">\n      <h4 class=\"product-title\">{title}</h4>\n      <h6 class=\"product-subtitle\">{sub_title}</h6>\n      <h6 id=\"sku\">{sku}</h6>\n      <div class=\"product-short-description\">\n        {short_description}\n      </div>\n\n      <!-- Price Section -->\n      <div class=\"product-price-box\" style=\"margin:20px 0;\">\n        <h5>\n           £<span id=\"product-price\">{Price}</span> <small>excl. VAT</small>\n        </h5>\n        <input type=\"hidden\" id=\"vat-rate\" value=\"{vat}\">\n        <div id=\"price-including-vat\" style=\"margin-top:10px;\">\n          <strong>£<span id=\"calculated-vat-price\"></span><small>incl. VAT</small>\n        </div>\n      </div>\n\n      <!-- Full Description Content -->\n      <div class=\"product-full-content\" style=\"margin-top: 30px;\">\n        {content}\n      </div>\n\n      <!-- Add To Cart Button -->\n      <div class=\"add-to-cart\" style=\"margin-top:30px;\">\n        <!--added qty -->\n        <div class=\"quantity-selector\" style=\"display: flex; align-items: center; margin: 10px 0;\">\n  <button class=\"quantity-btn\" onclick=\"adjustQuantity(this, -1)\" style=\"padding:5px 10px;\">−</button>\n  <input type=\"number\" min=\"1\" value=\"1\" class=\"quantity-input\" style=\"width:50px; text-align:center; margin: 0 5px;\">\n  <button class=\"quantity-btn\" onclick=\"adjustQuantity(this, 1)\" style=\"padding:5px 10px;\">  </button>\n</div>\n      <!-- -------------- -->\n        <button class=\"addtocart btn waves-effect waves-light\" onclick=\"addToCartFromPage()\">\n          Add to Cart\n        </button>\n      </div>\n    </div>\n  </div>\n\n  <div class=\"row\">\n    {{entity type=\"snippets\" name=\"reservation-request-form\" template-type=\"html_template\"}}\n  </div>\n</div>\n\n<div class=\"row block coffee\">\n  <div class=\"col s12\">\n    {{entity type=\"snippets\" name=\"products-call-for-action\" template-type=\"html_template\"}}\n  </div>\n</div>\n\n', '<li class=\"unbranded-product-item\">\n<script type=\"application/ld+json\">\n{\n  \"@context\": \"https://schema.org/\",\n  \"@type\": \"Product\",\n  \"name\": \"{title}\",\n  \"description\": \"{short_description}\",\n  \"image\": [\n    \"##SITE##{product_photo_gallery_photo_1}\"\n  ],\n  \"brand\": {\n    \"@type\": \"Brand\",\n    \"name\": \"Willow Cup Coffee\"\n  },\n  \"sku\": \"{sku}\",\n  \"offers\": {\n    \"@type\": \"Offer\",\n    \"priceCurrency\": \"USD\",\n    \"price\": \"{Price}\",\n    \"availability\": \"https://schema.org/InStock\"\n  },\n  \"additionalProperty\": [\n    {\n      \"@type\": \"PropertyValue\",\n      \"name\": \"VAT\",\n      \"value\": \"{vat}\"\n    },\n    {\n      \"@type\": \"PropertyValue\",\n      \"name\": \"Unit Quantity\",\n      \"value\": \"{unit_quantity} pieces per pack\"\n    },\n    {\n      \"@type\": \"PropertyValue\",\n      \"name\": \"Minimum Pack Quantity\",\n      \"value\": \"{pack_quantity} packs\"\n    }\n  ]\n}\n</script>\n<a href=\"{unbranded_product_url}\" data-id=\"{id}\"> <div><img loading=\"lazy\" src=\"##SITE##{product_photo_gallery_photo_1}\" alt=\"\"></div><h3 class=\"flow-text\" >{title}</h3><h5 class=\"flow-text\" >{sub_title}</h5></a><input type=\"hidden\" class=\"sku\" value=\"{sku}\"><input type=\"hidden\" class=\"vat\" value=\"{vat}\"><h5 class=\"net_quantity flow-text\">{net_quantity} </h5><h5 class=\"price flow-text\"> ${Price} <small>excl. VAT</small></h5>\n<h5 class=\"vprice\">{Price}</h5>\n<div class=\"quantity-selector\" style=\"display: flex; align-items: center; margin: 10px 0;\">\n  <button class=\"quantity-btn\" onclick=\"adjustQuantity(this, -1)\" style=\"padding:5px 10px;\">−</button>\n  <input type=\"number\" min=\"1\" value=\"1\" class=\"quantity-input\" style=\"width:50px; text-align:center; margin: 0 5px;\">\n  <button class=\"quantity-btn\" onclick=\"adjustQuantity(this, 1)\" style=\"padding:5px 10px;\"> </button>\n</div>\n\n\n\n    <button class=\"btn waves-effect waves-light add-to-cart-btn\" onclick=\"addToCart(this)\">\n      Add to Cart\n    </button>\n</li>'),
(11, 'Customer Testimonial', '<div class=\"col s4 review\">\n               <a class=\"rating\"><!--<i class=\"small material-icons\">star</i><i class=\"small material-icons\">star</i><i class=\"small material-icons\">star</i><i class=\"small material-icons\">star</i><i class=\"small material-icons\">star</i>-->{rating}</a>\n               <p>{short_description}</p>\n               <div class=\"photo\"><img loading=\"lazy\" src=\"{customer_photo}\" alt=\"{customer_name}\"></div>\n               <strong>{customer_name}</strong>\n            </div>', '<script type=\"application/ld json\">\n{\n  \"@context\": \"https://schema.org\",\n  \"@type\": \"Review\",\n  \"author\": {\n    \"@type\": \"Person\",\n    \"name\": \"{{customer_name}}\"\n  },\n  \"reviewBody\": \"{short_description}\",\n  \"reviewRating\": {\n    \"@type\": \"Rating\",\n    \"ratingValue\": \"{rating}\",\n    \"bestRating\": \"5\"\n  },\n  \"itemReviewed\": {\n    \"@type\": \"LocalBusiness\",\n    \"name\": \"Willow Cup Coffee\"\n  }\n}\n</script>\n<div class=\"col l4 m4 s12 review\">\n     <a class=\"rating\">{rating}</a>\n     <p>{short_description}</p>\n     <div class=\"photo\"><img loading=\"lazy\" src=\"{customer_photo}\" alt=\"{customer_name}\"></div>\n     <strong>{customer_name}</strong>\n</div>'),
(12, 'Events Template', '<!-- no detail page developed yet -->\n<!-- in preview template we have event schema with single location, for multi location schema need to update the event entity itself -->', '<li class=\"col s12 row\" style=\"min-height:60px;\">\n<script type=\"application/ld json\">\n{\n  \"@context\": \"https://schema.org\",\n  \"@type\": \"Event\",\n  \"name\": \"{title}\",\n   \"description\": \"{event_description}\",\n  \"image\": [\"##SITE##{lead_image}\"],\n  \"eventStatus\": \"https://schema.org/EventScheduled\",\n  \"eventAttendanceMode\": \"https://schema.org/OfflineEventAttendanceMode\",\n  \"location\": {\n    \"@type\": \"Place\",\n    \"name\": \"Willow Cup Coffee\",\n    \"address\": {\n      \"@type\": \"PostalAddress\",\n      \"streetAddress\": \"1427 Maple Avenue\",\n      \"addressLocality\": \"Brooklyn\",\n      \"addressRegion\": \"NY\",\n      \"postalCode\": \"11215\",\n      \"addressCountry\": \"US\"\n    }\n  }\n}\n</script>\n     <div class=\"col l2 m2 s4\">\n      <img src=\"##SITE##{lead_image}\" alt=\"{title}\" style=\"width:80px;height:80px;object-fit:cover;margin-right:12px;border-radius:4px;\">\n     </div>\n      <div class=\"col l10 m10 s8\">\n        <span class=\"title flow-text\"><strong>{title}</strong></span><br>\n        <small>{event_description}</small>\n      </div>\n</li>'),
(13, 'Orders Template', '<!-- no page template -->', '<li class=\"admin-order\" order-id=\"{order-id}\">\n<h5 class=\"table-no\">TABLE #{table}</h5>\n<ol class=\"items\">\n{items}\n</ol>\n<h5 class=\"total\">{total}</h5>\n</li>');

-- --------------------------------------------------------

--
-- Table structure for table `entity_types`
--

CREATE TABLE `entity_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(500) NOT NULL,
  `template_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entity_types`
--

INSERT INTO `entity_types` (`id`, `name`, `title`, `template_id`) VALUES
(1, 'blog', 'Blog', 1),
(2, 'news', 'News', 4),
(8, 'pages', 'Pages', 6),
(11, 'white-papers', 'White Papers', 4),
(12, 'admin-content-editable-template', 'Admin Content Editable Template', 0),
(13, 'menu-espresso-drink', 'Espresso', 5),
(14, 'product-page-hero-banner', 'Product Page Hero Banner', 7),
(15, 'snippets', 'Snippets', 8),
(16, 'home-page', 'Home Page', 9),
(17, 'shop-product-sell', 'Shop Product', 10),
(18, 'menu-milk-coffee-drink', 'Milk Coffee', 5),
(19, 'menu-iced-coffee-drink', 'Iced Coffee', 5),
(20, 'menu-cold-brew-drink', 'Cold Brew', 5),
(21, 'menu-speciality-drink', 'Speciality', 5),
(22, 'menu-tea-drink', 'Tea', 5),
(23, 'customer-testimonial-grid', 'Customer Testimonial', 11),
(24, 'cafe-event-list', 'Cafe Event', 12),
(25, 'orders', 'orders', 13);

-- --------------------------------------------------------

--
-- Table structure for table `entity_updates`
--

CREATE TABLE `entity_updates` (
  `entity_id` int(11) NOT NULL,
  `last_updated` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `input_field_types`
--

CREATE TABLE `input_field_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `type_type` enum('string','integer','float','boolean','null') NOT NULL,
  `type_input` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `input_field_types`
--

INSERT INTO `input_field_types` (`id`, `type_name`, `type_type`, `type_input`) VALUES
(1, 'text', 'string', '<input type=\"text\" name=\"{name}\" id=\"{name}\" value=\"{value}\">'),
(2, 'number', 'integer', '<input type=\"number\" name=\"{name}\" id=\"{name}\" value=\"{value}\">'),
(3, 'email', 'string', '<input type=\"email\" name=\"{name}\" id=\"{name}\">'),
(4, 'password', 'string', '<input type=\"password\" name=\"{name}\" id=\"{name}\">'),
(5, 'tel', 'string', '<input type=\"tel\" name=\"{name}\" id=\"{name}\">'),
(6, 'url', 'string', '<input type=\"url\" name=\"{name}\" id=\"{name}\">'),
(7, 'date', 'string', '<input type=\"date\" name=\"{name}\" id=\"{name}\">'),
(8, 'time', 'string', '<input type=\"time\" name=\"{name}\" id=\"{name}\">'),
(9, 'datetime-local', 'string', '<input type=\"datetime-local\" name=\"{name}\" id=\"{name}\">'),
(10, 'month', 'string', '<input type=\"month\" name=\"{name}\" id=\"{name}\">'),
(11, 'week', 'string', '<input type=\"week\" name=\"{name}\" id=\"{name}\">'),
(12, 'textarea', 'string', '<textarea name=\"{name}\" id=\"{name}\">{value}</textarea>'),
(13, 'contenteditable', 'string', '<div contenteditable=\"true\" name=\"{name}\" id=\"{name}\">{value}</div>'),
(14, 'wysiwyg-pell', 'string', '<div id=\"editor-{name}\" class=\"pell {name}\"><input type=\"hidden\" class=\"edit-content\" value=\"{value}\"></div>'),
(15, 'size formats', 'string', '<select name=\"{name}\" id=\"{name}\">\n  <option value=\"\">-- Select Size Format --</option>\n  <option value=\"standard_label\">Standard Labels (e.g. Small, Medium, Large)</option>\n  <option value=\"dimension_mm\">Dimensions in mm (e.g. 180x120x40mm)</option>\n  <option value=\"mixed\">Mixed Labels   Dimension (e.g. Large 65mm)</option>\n</select>\n'),
(16, 'multiselect', 'null', '<select name=\"{name}[]\" id=\"{name}\" multiple></select>'),
(17, 'checkbox', 'boolean', '<input name=\"{name}\" type=\"checkbox\" />\n \n'),
(19, 'radio', 'null', '<input type=\"radio\" name=\"{name}\" id=\"{name}\">'),
(20, 'file', 'null', '<input type=\"file\" name=\"{name}\" id=\"{name}\">'),
(21, 'image', 'string', '<input type=\"file\" accept=\"image/*\" name=\"{name}\" id=\"{name}\">\r\n<div class=\"image-preview\">\r\n  <img src=\"{value}\" alt=\"Current image\" style=\"max-width: 200px;\">\r\n</div><br>\r\n<small>Leave blank to keep the current image.</small>'),
(22, 'video', 'string', '<input type=\"file\" accept=\"video/mp4\" name=\"{name}\" id=\"{name}\">\n<div class=\"video-preview\">\n     <video controls style=\"max-width: 300px;\">\n      <source src=\"{value}\" type=\"video/mp4\">\n      Your browser does not support the video tag.\n    </video>\n </div>\n<small>Leave blank to keep the current video.</small>\n'),
(23, 'color', 'string', '<input type=\"color\" name=\"{name}\" id=\"{name}\">'),
(24, 'range', 'integer', '<input type=\"range\" name=\"{name}\" id=\"{name}\" value=\"{value}\">'),
(25, 'hidden', 'null', '<input type=\"hidden\" name=\"{name}\" id=\"{name}\">'),
(26, 'search', 'string', '<input type=\"search\" name=\"{name}\" id=\"{name}\">'),
(28, 'json', 'string', '<textarea name=\"{name}\" id=\"{name}\" class=\"json-editor\"></textarea>'),
(29, 'tags', 'string', '<input type=\"text\" name=\"{name}\" id=\"{name}\" class=\"tag-input\">'),
(51, 'Script', 'string', '<textarea name=\"{name}\" id=\"{name}\" class=\"script-editor\">{value}</textarea>'),
(52, 'Vanilla Script', 'string', '<textarea>{value}</textarea>'),
(53, 'Photo Gallery Photo', 'string', '<input type=\"file\" accept=\"image/*\" name=\"{name}\" id=\"{name}\"> <div class=\"image-preview\"> <img src=\"{value}\" alt=\"Current image\" style=\"max-width: 200px;\"> </div><br> <small>Leave blank to keep the current image.</small>'),
(58, 'Paper Types', 'string', '<select name=\"{name}\" id=\"paper_type\">\n  <option value=\"\">Select Paper Type</option>\n  <option value=\"kraft\">Kraft Paper</option>\n  <option value=\"white_kraft\">White Kraft Paper</option>\n  <option value=\"coated_board\">Coated Board</option>\n  <option value=\"sbs_board\">SBS Board (Solid Bleached Sulfate)</option>\n  <option value=\"fbb_board\">FBB Board (Folding Box Board)</option>\n  <option value=\"corrugated\">Corrugated Paper</option>\n  <option value=\"micro_corrugated\">Micro Corrugated Paper</option>\n  <option value=\"duplex_board\">Duplex Board</option>\n  <option value=\"triplex_board\">Triplex Board</option>\n  <option value=\"recycled_board\">Recycled Paperboard</option>\n  <option value=\"virgin_fiber_board\">Virgin Fiber Board</option>\n  <option value=\"foil_laminated\">Foil Laminated Paper</option>\n  <option value=\"wax_coated\">Wax Coated Paper</option>\n  <option value=\"pe_coated\">PE Coated Paper</option>\n  <option value=\"greaseproof\">Greaseproof Paper</option>\n  <option value=\"butter_paper\">Butter Paper</option>\n  <option value=\"glassine\">Glassine Paper</option>\n  <option value=\"parchment\">Parchment Paper</option>\n  <option value=\"metalized\">Metalized Paper</option>\n  <option value=\"bio_coated\">Biodegradable Coated Paper</option>\n  <option value=\"compostable_board\">Compostable Board</option>\n  <option value=\"pla_laminated\">PLA (Plant-Based) Laminated Paper</option>\n  <option value=\"cardboard\">Standard Cardboard</option>\n<option value=\"pet\">PET (Polyethylene Terephthalate)</option>\n  <option value=\"pla-bioplastic\">PLA (Polylactic Acid – Bioplastic)</option>\n  <option value=\"recycled-pet\">Recycled PET (rPET)</option>\n</select>\n\n'),
(59, 'Material', 'string', '<select name=\"{name}\" id=\"material\">\n  <option value=\"\">Select Material</option>\n\n  <!-- Paper-Based -->\n  <option value=\"paper\">Paper</option>\n  <option value=\"kraft_paper\">Kraft Paper</option>\n  <option value=\"white_kraft_paper\">White Kraft Paper</option>\n  <option value=\"cardboard\">Cardboard</option>\n<option value=\"pet\">PET (Polyethylene Terephthalate)</option>\n  <option value=\"pla-bioplastic\">PLA (Polylactic Acid – Bioplastic)</option>\n  <option value=\"recycled-pet\">Recycled PET (rPET)</option>\n\n  <option value=\"corrugated_fiberboard\">Corrugated Fiberboard</option>\n  <option value=\"duplex_board\">Duplex Board</option>\n  <option value=\"triplex_board\">Triplex Board</option>\n  <option value=\"recycled_board\">Recycled Paperboard</option>\n  <option value=\"fbb_board\">Folding Box Board (FBB)</option>\n  <option value=\"sbs_board\">Solid Bleached Sulfate Board (SBS)</option>\n  <option value=\"glassine\">Glassine</option>\n  <option value=\"greaseproof_paper\">Greaseproof Paper</option>\n  <option value=\"parchment_paper\">Parchment Paper</option>\n  <option value=\"butter_paper\">Butter Paper</option>\n\n  <!-- Plastic-Based -->\n  <option value=\"plastic\">Plastic</option>\n  <option value=\"pp\">Polypropylene (PP)</option>\n  <option value=\"pet\">Polyethylene Terephthalate (PET)</option>\n  <option value=\"hdpe\">High-Density Polyethylene (HDPE)</option>\n  <option value=\"ldpe\">Low-Density Polyethylene (LDPE)</option>\n  <option value=\"ps\">Polystyrene (PS)</option>\n  <option value=\"pla\">Polylactic Acid (PLA - Bioplastic)</option>\n\n  <!-- Plant-Based / Biodegradable -->\n  <option value=\"bagasse\">Bagasse (Sugarcane Pulp)</option>\n  <option value=\"pulp\">Molded Pulp</option>\n  <option value=\"palm_leaf\">Palm Leaf</option>\n  <option value=\"bamboo\">Bamboo</option>\n  <option value=\"hemp_fiber\">Hemp Fiber</option>\n  <option value=\"cotton\">Cotton (Reusable Bags)</option>\n  <option value=\"jute\">Jute (Eco Bags)</option>\n\n  <!-- Foils & Laminates -->\n  <option value=\"foil\">Aluminium Foil</option>\n  <option value=\"foil_laminated\">Foil Laminated Paper</option>\n  <option value=\"wax_coated\">Wax-Coated Paper</option>\n  <option value=\"pe_coated\">PE Coated Paper</option>\n  <option value=\"pla_laminated\">PLA Laminated Paper</option>\n\n  <!-- Specialty Eco Materials -->\n  <option value=\"bio_coated\">Biodegradable Coated Paper</option>\n  <option value=\"compostable_board\">Compostable Board</option>\n  <option value=\"metalized_paper\">Metalized Paper</option>\n</select>\n'),
(60, 'Minimum Order Quantity', 'string', '<select name=\"{name}\" id=\"min_order\">\n  <option value=\"\">Select Minimum Order</option>\n  <option value=\"50\">50</option>\n  <option value=\"100\">100</option>\n  <option value=\"500\">500</option>\n  <option value=\"1000\">1,000</option>\n  <option value=\"5000\">5,000</option>\n</select>\n'),
(61, 'vat', 'float', '<input type=\"number\" name=\"{name}\" id=\"{name}\" value=\"{value}\">'),
(62, 'stock_status', 'integer', '<select name=\"{name}\" id=\"stock_status\">  <option value=\"1\">In Stock</option> <option value=\"2\">Out of Stock</option> </select> ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entities`
--
ALTER TABLE `entities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_type_id` (`entity_type_id`);

--
-- Indexes for table `entity_attributes`
--
ALTER TABLE `entity_attributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `entity_attribute_data`
--
ALTER TABLE `entity_attribute_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `entity_attribute_input_map`
--
ALTER TABLE `entity_attribute_input_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD KEY `input_type_id` (`input_type_id`);

--
-- Indexes for table `entity_attribute_map`
--
ALTER TABLE `entity_attribute_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_type_id` (`entity_type_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `entity_relations`
--
ALTER TABLE `entity_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_entity_id` (`parent_entity_id`),
  ADD KEY `child_entity_id` (`child_entity_id`);

--
-- Indexes for table `entity_states`
--
ALTER TABLE `entity_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `state_name` (`state_name`);

--
-- Indexes for table `entity_state_map`
--
ALTER TABLE `entity_state_map`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `entity_templates`
--
ALTER TABLE `entity_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `template_name` (`template_name`);

--
-- Indexes for table `entity_types`
--
ALTER TABLE `entity_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `entity_updates`
--
ALTER TABLE `entity_updates`
  ADD PRIMARY KEY (`entity_id`);

--
-- Indexes for table `input_field_types`
--
ALTER TABLE `input_field_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entities`
--
ALTER TABLE `entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attributes`
--
ALTER TABLE `entity_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attribute_data`
--
ALTER TABLE `entity_attribute_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attribute_input_map`
--
ALTER TABLE `entity_attribute_input_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_attribute_map`
--
ALTER TABLE `entity_attribute_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_relations`
--
ALTER TABLE `entity_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_states`
--
ALTER TABLE `entity_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_state_map`
--
ALTER TABLE `entity_state_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_templates`
--
ALTER TABLE `entity_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entity_types`
--
ALTER TABLE `entity_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `input_field_types`
--
ALTER TABLE `input_field_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `entities`
--
ALTER TABLE `entities`
  ADD CONSTRAINT `entities_ibfk_1` FOREIGN KEY (`entity_type_id`) REFERENCES `entity_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_attribute_data`
--
ALTER TABLE `entity_attribute_data`
  ADD CONSTRAINT `entity_attribute_data_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_attribute_data_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `entity_attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_attribute_input_map`
--
ALTER TABLE `entity_attribute_input_map`
  ADD CONSTRAINT `entity_attribute_input_map_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `entity_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_attribute_input_map_ibfk_2` FOREIGN KEY (`input_type_id`) REFERENCES `input_field_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_attribute_map`
--
ALTER TABLE `entity_attribute_map`
  ADD CONSTRAINT `entity_attribute_map_ibfk_1` FOREIGN KEY (`entity_type_id`) REFERENCES `entity_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_attribute_map_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `entity_attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_relations`
--
ALTER TABLE `entity_relations`
  ADD CONSTRAINT `entity_relations_ibfk_1` FOREIGN KEY (`parent_entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_relations_ibfk_2` FOREIGN KEY (`child_entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_state_map`
--
ALTER TABLE `entity_state_map`
  ADD CONSTRAINT `entity_state_map_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entity_state_map_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `entity_states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `entity_updates`
--
ALTER TABLE `entity_updates`
  ADD CONSTRAINT `entity_updates_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `entities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
