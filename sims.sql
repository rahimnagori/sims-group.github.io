-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2021 at 01:28 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sims`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `type`, `name`, `last_login`, `is_logged_in`) VALUES
(1, 'admin@gmail.com', '123456', 1, 'Super Admin', '2021-05-15 06:55:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `business_details`
--

CREATE TABLE `business_details` (
  `id` int(11) NOT NULL,
  `business_name` varchar(100) DEFAULT NULL,
  `business_email` varchar(100) DEFAULT NULL,
  `business_email_1` varchar(100) DEFAULT NULL,
  `business_phone` varchar(100) DEFAULT NULL,
  `business_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `business_details`
--

INSERT INTO `business_details` (`id`, `business_name`, `business_email`, `business_email_1`, `business_phone`, `business_address`) VALUES
(1, 'SIMS Group', 'Infosimsdelhi@gmail.com', 'Services@simsgroup.co.in', '919319313401', 'First floor satyam shivam sundaram mandir sector 9, Rohini 110085');

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `query` text NOT NULL,
  `is_replied` tinyint(2) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `name`, `email`, `phone`, `query`, `is_replied`, `created`) VALUES
(1, 'Rahim', 'rahim.nagori@gmail.com', '94994949494', 'Test Message', 0, '2021-05-15 07:57:33');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_image` varchar(100) DEFAULT NULL,
  `service_description` text DEFAULT NULL,
  `service_details` text DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_image`, `service_description`, `service_details`, `is_deleted`) VALUES
(1, 'test', NULL, NULL, NULL, 1),
(2, 'test', NULL, '<p>test</p>', NULL, 1),
(3, 'test 22', 'assets/site/img/56bf250919f674aecc3843ea04a56e3a.png', '<p>test 22</p>', NULL, 1),
(4, 'test', 'assets/site/img/d350c0932f26b816723504f4a1de2b9b.png', '<p>test</p>', NULL, 1),
(5, 'Covid 19 Products', 'assets/site/img/b49ec9541f14ba9c5e64d6f989eeae30.jpg', '<p>PPE Kit | Gloves | Masks | Sanitizers</p>', '<h3 class=\"details-heading\">Covid 19 Products</h3>\r\n<hr />\r\n<ul>\r\n<li>Foot operated sanitizer machine.</li>\r\n<li>Automatic sanitizer machine.</li>\r\n<li>Hand sanitizer machine.</li>\r\n<li>All types of masks - 3M | Venus | Honeywell</li>\r\n</ul>\r\n<h3 class=\"details-heading\">Why these products?</h3>\r\n<hr />\r\n<p>We understand that in midst of a lockdown, it cannot be expected for regular sanitation workers to perform to their fullest. And that is why as one of North India\'s well-known home healthcare firm we provide a package where our staff can help perform Sanitization and Prevention measures from COVID-19 like monitoring body temperature of individuals using Infra-red thermometer, Sanitization of residential and office spaces, and installing a Tunnel spray disinfectant.</p>\r\n<p>During a time when the Coronavirus pandemic has affected all sections of the society, it is important that we follow all the guidelines and precautions to keep ourselves and loved ones safe. In light of the same, we at Zorgers are committed towards aiding our range of elderly and patient care services, by introducing for the first-time in the Home Healthcare industry, cleaning and disinfection services at Office space, Factories or Industrial Facilities, Bank ATMs and Homes in Tricity.</p>\r\n<h3 class=\"details-heading\">Office Disinfection and Sanitization</h3>\r\n<hr />\r\n<p>The Coronavirus can survive on a surface for up to 14 days or more. That is why having a trusted professional to clean and disinfect your office space is important. At Zorgers, we believe in maintaining complete health protection which is why our office or workspace sanitation procedure follows strict guidelines as mentioned by the Health Ministry.</p>\r\n<h3 class=\"details-heading\">How does it work</h3>\r\n<hr />\r\n<p>Alcohol-based sanitizers have been proven to inactivate many types of microbes, virus and bacteria from a surface. At Zorgers, we use government-approved sanitizers which although contain 70% alcohol are eco-friendly and kills 99.9% of germs.Our state-of-the-art equipments to disinfect office spaces includes no-contact spraying equipment, industrial strength disinfectants with a broad spectrum kill, disposal of waste, disinfecting work desks and high-contact surfaces like lift buttons, door knobs, water taps, Restrooms, Intercoms, Cafeteria, Meeting rooms and so on. The team at Zorgers employs well trained professionals who are provided with fully encapsulated PPE [Personal Protective Equipment], disposable rubber boots and triple layer masks that they wear at all times.Reopening after lockdown, we comply with stringent Coronavirus demobilization process assuring the health and safety of the employees and their families.</p>\r\n<p>Book an Office Sanitization and Disinfecting session in Tricity (Chandigarh, Delhi NCR, Rahasthan ) at the best price, Call +919319313401</p>\r\n<h3 class=\"details-heading\">Home Sanitization</h3>\r\n<hr />\r\n<p>When in a lockdown it is of utmost importance that we maintain regular sanitization and disinfecting measure at Home at all times. Zorgers provides the best price package for cleaning and disinfecting your Home anywhere in in Tricity (Chandigarh, Mohali, Panchkula).sanitizing-tunnel-image.jpg</p>\r\n<h3 class=\"details-heading\">Chemical Description</h3>\r\n<hr />\r\n<p>A one-step, quaternary-based disinfectant cleaner concentrate providing broad spectrum disinfection at 1:256 dilution. Use in healthcare and other facilities where cleaning and prevention of cross-contamination are critical. Bactericidal, virucidal and fungicidal. Kills MRSA and VRE. Meets bloodborne pathogen standards for decontaminating blood and body fluids. Blue in color with a minty scent.</p>\r\n<h3 class=\"details-heading\">Certifications</h3>\r\n<hr />\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>EPA</li>\r\n<li>FDA</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<h3 class=\"details-heading\">Features</h3>\r\n<hr />\r\n<p>Kills microorganisms including HIV-1, VRE, MRSA, GRSA, MRSE, VISA, PRSP, Herpes Simplex Types 1&amp;2, Influenza Type A2, Adenovirus, Rotavirus and many more Kills the organisms that cause odors and works as an odor counteractant to further eliminate odors not associated with bacteria.<br />Highly concentrated quaternary formula provides excellent one-step, cost-effective cleaning and disinfection</p>\r\n<p><strong>We are using VIREX 256 chemical for sanitization services.</strong></p>', 0),
(6, 'Electrical Work', 'assets/site/img/92b2e07d8bc949cdfa2620fb48233dc8.jpg', '<p>We deals in Electrical Contracts and able to provide all the latest technologies and higher standard works.</p>', '<h3 class=\"details-heading\">Commercial Services</h3>\r\n<hr />\r\n<ul>\r\n<li>Project Planning</li>\r\n<li>Wiring</li>\r\n<li>Site Inspections</li>\r\n<li>Electrical Product Installation</li>\r\n<li>Service Work - Troubleshooting</li>\r\n<li>Underground Cabelling</li>\r\n<li>Maintenance</li>\r\n<li>Remodeling - Retrofits</li>\r\n</ul>\r\n<h3 class=\"details-heading\">Domestic Services</h3>\r\n<hr />\r\n<ul>\r\n<li>Project Planning</li>\r\n<li>Wiring</li>\r\n<li>Site Inspections</li>\r\n<li>Wiring</li>\r\n<li>Electric Service Upgrades</li>\r\n<li>New Panels and Breakers</li>\r\n<li>Outdoor Lighting</li>\r\n</ul>\r\n<h3 class=\"details-heading\">Premium Services</h3>\r\n<hr />\r\n<ul>\r\n<li>Swimming Pool Wiring</li>\r\n<li>Smart Home Wiring</li>\r\n<li>Security Lighting</li>\r\n</ul>\r\n<p><strong>We are flexible with our contracts, we provide ability to our customers to choose either \'With Material\' or \'Without Material\' option.</strong></p>', 0),
(7, 'Transformer servicing', 'assets/site/img/11c6adbbf47dd533fdeb8da16c33aeac.jpg', '<p>We deals in all types of transformer service on site. We do provide all type of transformer testing.</p>', '<h3 class=\"details-heading\">Tranformer Repairing Service</h3>\r\n<hr />\r\n<p>Tranformer itself is a highly used electrical equipment. It is placed in a open place thus chances of getting it damaged are very high.<br />We provide very competitive repairing price of transformer with the topmost quality in the town. We do understand the need of our customers. Our highly skilled engineers ensures the work by adopting international testing standards.<br />We believe that Words of Mouth are the biggest way to advertise your product so we rely on it. Our customers itself speak of our service quality.</p>\r\n<h3 class=\"details-heading\">Monthly Basis Maintenance of Transformer</h3>\r\n<hr />\r\n<p>Let us first discuss about the action to be taken on power transformer in monthly basis.<br />1. The oil level in oil cap under silica gel breather must be checked in a one-month interval. If it is found the transformer oil inside the cup comes below the specified level, oil to be top up as per specified level.<br />2. Breathing holes in silica gel breather should also be checked monthly and properly cleaned if required, for proper breathing action.<br />3. If the transformer has oil filled bushing the oil level of transformer oil inside the bushing must be vidually checked in the oil gage attached to those bushing. This action also to be done monthly basis.<br />If it is required, the oil to be filled in the bushing upto correct level. Oil filling to be done under shutdown condition.</p>\r\n<h3 class=\"details-heading\">Daily Basis Maintenance and Checking</h3>\r\n<hr />\r\n<p>There are three main things which to be checked on a power transformer on a daily basis:<br />1. Reading of MOG (Magnetic Oil Gauge) of main tank and conservator tank.<br />2. Color of silica gel in breather.<br />3. Leakage of oil from any point of a transformer.<br />In case of unsatisfactory oil level in the MOG, oil to be filled in transformer and also the transformer tank to be checked for oil leakage. If oil leakage is found take required action to plug the leakage. If silica gel becomes pinkish, it should be replaced.</p>\r\n<h3 class=\"details-heading\">Yearly Basis Transformer Maintenance Schedule</h3>\r\n<hr />\r\n<p>1. The auto, remote, manual function of cooling system that means, oil pumps, air fans, and other items engaged in cooling system of transformer, along with their control circuit to be checked in the interval of one year. In the case of trouble, investigate control circuit and physical condition of pumps and fans.<br />2. All the bushings of the transformer to be cleaned by soft cotton cloths yearly. During cleaning the bushing should be checked for cracking.<br />3. Oil condition of OLTC to be examined in every year. For that, oil sample to be taken from drain valve of divertor tank, and this collected oil sample to be tested for dielectric strength (BDV) and moisture content (PPM). If BDV is low and PPM for moisture is found high compared to recommended values, the oil inside the OLTC to be replaced or filtered.<br />4. Mechanical inspection of Buchholz relays to be carried out on yearly basis.<br />5. All marshalling boxes to be cleaned from inside at least once in a year. All illumination, space heaters, to be checked whether they are functioning properly or not. If not, required maintenance action to be taken. All the terminal connections of control and relay wiring to be checked an tighten at least once in a year.<br />6. All the relays, alarms and control switches along with their circuit, in R&amp;C panel (Relay and Control Panel) and RTCC (Remote Tap Changer Control Panel) to be cleaned by appropriate cleaning agent.<br />7. The pockets for OTI, WTI (Oil Temperature Indicator &amp; Winding Temperature Indicator) on the transformer top cover to be checked and if required oil to be replenished.<br />8. The proper function of Pressure Release Device and Buchholz relay must be checked annually. For that, trip contacts and alarm contacts of the said devices are shorted by a small piece of wire, and observe whether the concerned relays in remote panel are properly working or not.<br />9. Insulation resistance and polarization index of transformer must be checked with battery operated megger of 5 KV range.<br />10. Resistive value of earth connection and rizer must be measured annually with clamp on earth resistance meter.<br />11. DGA or Dissolve Gas Analysis of transformer Oil should be performed, annually for 132 KV transformer, once in 2 years for the transformer below 132 KV transformer and in 2 years interval for the transformer above 132 KV transformer.</p>\r\n<h3 class=\"details-heading\">The Action to be taken once in 2 years</h3>\r\n<hr />\r\n<p>1. The calibration of OTI and WTI must be carried once in two years.<br />2. Tan &amp; delta; measurement of bushings of transformer also to be done once in two years.</p>\r\n<h3 class=\"details-heading\">Maintenance of Transformer on Half Yearly Basis</h3>\r\n<hr />\r\n<p>The transformer oil must be checked half yearly basis that means once in 6 months, for dielectric strength, water content, acidity, sludge content, flash point, DDA, IFT, resistivity for transformer oil.<br />In the case of a distribution transformer, as they are operating light load condition all the time of day remaining peak hours, so there are no maintenance required.<br />1. Thermo vision camera to be used for checking any hot spots in the capacitor stacks to ensure pro action of rectification.<br />2. The terminal connections PT junction box including earth connections to be checked for tightness once in a year. In addition to that, the PT junction box also to be cleaned properly once in a year.<br />3. The health of all gasket joint also to be visually checked and replaced if any damaged gasket found.</p>\r\n<hr />\r\n<p>Note that in addition all yearly basis maintenance of potential transformer or capacitor voltage transformer must also be checked for tan &delta; once in 3 years. An increase in the value of tan &delta; indicates deterioration of insulation whereas both increases in tan &delta; and capacitance indicate the entry of moisture into the insulation.</p>', 0),
(8, 'HT & LT Panel', 'assets/site/img/93e0dc88ee1ac4da460389495be17b52.jpg', '<p>We deals in all type of HT &amp; LT breaker on site service. Also we can take care of calibration with Transformer too.</p>', '<h3 class=\"details-heading\">HT &amp; LT Panels</h3>\r\n<hr />\r\n<p>Service provider for repair, maintenance &amp; servicing of H.T. switchgear (up to 33 KV), L.T. switchgear and power transformer, protection relay testing,Installation of earthing, control panel painting work. Checking all connections, Checking proper earthing connections, Tightening cable connections, Lubricating moving parts, Testing, All ON or OFF operations,</p>\r\n<h3 class=\"details-heading\">Vacuum Circuit Breaker (VCB)</h3>\r\n<hr />\r\n<p>&bull; Cleaning of Vacuum Circuit Breaker with CRC-226<br />&bull; Removal of old grease and re-greasing the same with recommended grease<br />&bull; Check condition of SIC Contacts<br />&bull; Checking condition and alignment of jaw Contact<br />&bull; Checking and proper tightening of hardware<br />&bull; Checking proper closing of all poles together<br />&bull; Checking of breaker tripping through push button<br />&bull; Checking and adjusting gap between hylam sheet and side plate<br />&bull; Checking motor operation in case of EDO.<br />&bull; Checking of auxiliary contacts continuity proper change over<br />&bull; Checking presence of all circlips<br />&bull; Checking IR between phase &ndash; phase (VCB closed condition)<br />&bull; Checking IR between phase &ndash; earth (VCB closed condition)<br />&bull; Checking IR between phase &ndash; earth (VCB in Open condition)<br />&bull; Any faculty spare replace by new one, which will be charged extra.</p>\r\n<h3 class=\"details-heading\">Oil Circuit Breaker (OCB)</h3>\r\n<hr />\r\n<p>&bull; Cleaning of Oil Circuit Breaker with CRC-226<br />&bull; Removal of old grease and re-greasing the same with recommended grease<br />&bull; Check condition of SIC Contacts<br />&bull; Checking condition and alignment of jaw Contact<br />&bull; Checking and proper tightening of hardware<br />&bull; Checking proper closing of all poles together<br />&bull; Checking of breaker tripping through push button<br />&bull; Checking and adjusting gap between hylam sheet and side plate<br />&bull; Checking motor operation in case of EDO.<br />&bull; Checking of auxiliary contacts continuity proper change over<br />&bull; Checking presence of all circlips<br />&bull; Checking IR between phase &ndash; phase (OCB closed condition)<br />&bull; Checking IR between phase &ndash; earth (OCB closed condition)<br />&bull; Checking IR between phase &ndash; earth (OCB in Open condition)<br />&bull; Any faculty spare replace by new one, which will be charged extra</p>\r\n<h3 class=\"details-heading\">LT Panel: We do following during regular maintenance of LT Panel</h3>\r\n<hr />\r\n<p>&bull; Cleaning of Panel Breaker with CRC-226<br />&bull; Check condition of Bus bars<br />&bull; Checking condition and alignment of jaw Contact<br />&bull; Checking and proper tightening of hardwares<br />&bull; Checking of breaker tripping through push button<br />&bull; Checking motor operation in case of EDO.<br />&bull; Checking of auxiliary contacts continuity proper change overs<br />&bull; Checking presence of all circlips<br />&bull; Checking IR between phase &ndash; phase (ACB closed condition)<br />&bull; Checking IR between phase &ndash; earth (ACB closed condition)<br />&bull; Checking IR between phase &ndash; earth (ACB in Open condition)<br />&bull; Checking of Contactor NO NC Point<br />&bull; Checking of ad on block NO NC Point<br />&bull; Checking of Control Wiring<br />&bull; Checking of Thimble Tightness<br />&bull; Checking of MCCB<br />&bull; Checking o MCB<br />&bull; Any faculty spare replace by new one, which will be charged extra.</p>', 0),
(9, 'New Chair And Repairing Service', 'assets/site/img/2f597b4d53ee899d935dc707b0f67cc2.jpg', '<p>We deals in all type of LT breaker on site service.</p>', '<h3 class=\"details-heading\">We deals in</h3>\r\n<hr />\r\n<ul>\r\n<li>Wooden Chair</li>\r\n<li>Executive Chair</li>\r\n<li>Hydraulic Chair</li>\r\n<li>Revolving Chair</li>\r\n<li>Office Chair</li>\r\n<li>Mesh Chair</li>\r\n<li>Conference Chair</li>\r\n<li>Tant Chair</li>\r\n<li>Cane Chair</li>\r\n<li>And also Chair Repairing</li>\r\n</ul>\r\n<h3 class=\"details-heading\">Why us?</h3>\r\n<hr />\r\n<p>We provides 1 to 2 years of warranty on some conditional basis.<br />Best industry standard equipments are used for chair mechanism.<br />We use Gas Hydraulic which is considered best in industry.<br />Our prices are very Reasonable &amp; Competitive.<br />We serve to Wholeseller as well as Retailer.</p>\r\n<p><strong>We customize and manufacture chairs as per customer\'s description</strong></p>', 0),
(10, 'Carpenter Service', 'assets/site/img/f459e4445054e0b936a7437a40010b84.jpg', '<p>We deals in all type of carpenter work at Industries, Corporate office and client\'s home.</p>', '<h3 class=\"details-heading\">Carpenter Service</h3>\r\n<hr />\r\n<p>We provide Interior &amp; Decorators service along with furniture manufacturing, customize furniture as per the customer\'s need and renovation of the old furnitures.<br />Carpenter service with highly skilled labors with the help of most technological advanced machine. We promise to work in given time and does work on the customer\'s demand.<br />We modify the current furniture. Our team of highly skilled Interior Decorators works in a way that customer fall in love with the renovation.</p>\r\n<h3 class=\"details-heading\">Our carpenter work in Residential, commercial, industrial as below</h3>\r\n<hr />\r\n<p>Work station<br />Office partition (Gypsum, Wooden , Glass , Half Partition etc)<br />Glass work<br />Table<br />Conference room<br />Conference table<br />Meeting Table<br />Door &amp; Window Work<br />Wooden Rack<br />Almira<br />Drawer<br />Pedestal drawer<br />Polish Work<br />Chair<br />Modular kitchen</p>', 0),
(11, 'Fire Extinguisher', 'assets/site/img/5f473dbef9374b8e0c497921fee5f16f.png', '<p>We deals in different types of Fire Extinguishers.</p>', '<p><strong>We are authorized to sell Fire Extinguishers.</strong>&nbsp;We have top most brands Fire Extinguishers in our stocks. Send us your quotation, visit or contact us.</p>\r\n<h3 class=\"details-heading\">In Stock FE Types</h3>\r\n<hr />\r\n<ul>\r\n<li>CO2</li>\r\n<li>ABC MAP 90/ MAP 50</li>\r\n<li>Powder</li>\r\n<li>Dry type extinguisher</li>\r\n<li>HFC 236FA medical range</li>\r\n<li>Home and car fire extinguisher (Clean agent base )</li>\r\n<li>Water type fire extinguisher</li>\r\n<li>Foam type fire extinguisher</li>\r\n</ul>', 0),
(12, 'test', 'assets/site/img/8533a33c02b5ab8e3cc57f758d8ce8d1.jpg', '<p>test</p>', '<p>test test e</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_brochures`
--

CREATE TABLE `service_brochures` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `brochure` text NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_brochures`
--

INSERT INTO `service_brochures` (`id`, `service_id`, `brochure`, `is_deleted`, `created`) VALUES
(1, 5, 'assets/site/brochure/8873a9336d258b57c0b1140a4cb40116.pdf', 0, NULL),
(2, 5, 'assets/site/brochure/07e71b9a1c65796928130fcf27fb2c6c.pdf', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_images`
--

CREATE TABLE `service_images` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_image` text NOT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_images`
--

INSERT INTO `service_images` (`id`, `service_id`, `service_image`, `is_deleted`, `created`) VALUES
(1, 5, 'assets/site/img/144fde4a115f8730ee587946d21a636b.jpg', 1, NULL),
(2, 5, 'assets/site/img/85f6bf7a06a3100a11bcaa212a3646d6.jpg', 0, NULL),
(3, 5, 'assets/site/img/a29469a3d0105c05f53ab5a8ca1a21c4.jpg', 0, NULL),
(4, 5, 'assets/site/img/324176e99457c98e37b152aab422249d.jpg', 0, NULL),
(5, 5, 'assets/site/img/f4d5b99f5ddadde056c8738d42fd1d80.jpg', 0, NULL),
(6, 5, 'assets/site/img/8d938013f43aa87c017b5ccb734091f5.jpg', 0, NULL),
(7, 6, 'assets/site/img/64bb7934821024044fbf83812225e49e.jpg', 0, '2021-05-05 07:22:40'),
(8, 6, 'assets/site/img/1f780f2d289d2b3d9acdd892b2bd4932.jpg', 0, '2021-05-05 07:22:44'),
(9, 6, 'assets/site/img/f025063abb3d28167340f4819c8c8b1b.jpg', 0, '2021-05-05 07:22:49'),
(10, 6, 'assets/site/img/9b8ccd8e06a1ec5fe9aa336d702f758f.jpg', 0, '2021-05-05 07:22:55'),
(11, 8, 'assets/site/img/d65c78e3bca4a5206a5f31c3ad943362.jpg', 0, '2021-05-05 07:24:26'),
(12, 8, 'assets/site/img/b992390e3a638a5bf2ac3351dc9330dd.jpg', 0, '2021-05-05 07:24:30'),
(13, 8, 'assets/site/img/f61f98daef280a5be0e3647bfee3e353.jpg', 0, '2021-05-05 07:24:35'),
(14, 8, 'assets/site/img/4c7422a6d6cee672f1199e41038ddf19.jpg', 0, '2021-05-05 07:24:40'),
(15, 9, 'assets/site/img/0269581cb69773e8039a72a93313ac5a.jpg', 0, '2021-05-05 07:26:28'),
(16, 9, 'assets/site/img/bc9c3af19bcc1b1cb9c85dc093ca6b3a.jpg', 0, '2021-05-05 07:26:32'),
(17, 9, 'assets/site/img/7197b8e4c298679f5c2585279ac4f00d.jpg', 0, '2021-05-05 07:26:37'),
(18, 9, 'assets/site/img/e6a1385385e66fe664f8d6708d1099e7.jpg', 0, '2021-05-05 07:26:42'),
(19, 9, 'assets/site/img/1fcc148e5557bd9faf26a85240f5396f.jpg', 0, '2021-05-05 07:26:46'),
(20, 9, 'assets/site/img/486b563344395df2817b5b39ee3853d4.jpg', 0, '2021-05-05 07:26:51'),
(21, 9, 'assets/site/img/adf76eb3cbd8f2426f0ba343c93d2162.jpg', 0, '2021-05-05 07:26:57'),
(22, 9, 'assets/site/img/9dab18594ee574d08007440b120c95f7.jpg', 0, '2021-05-05 07:27:03'),
(23, 9, 'assets/site/img/407b188400cd9bd24ff072340f8ebfca.jpg', 0, '2021-05-05 07:27:10'),
(24, 9, 'assets/site/img/8cddb7b09f5650500997cc995bf41e05.jpg', 0, '2021-05-05 07:27:15'),
(25, 10, 'assets/site/img/13c53241d04b0dc98bf0480aca9724ef.jpg', 0, '2021-05-05 07:28:22'),
(26, 10, 'assets/site/img/a44f242cfcf973f9b8f32e42f526b0ba.jpg', 0, '2021-05-05 07:28:27'),
(27, 10, 'assets/site/img/93d591167526dcea5260095b5ddbd5f9.jpg', 0, '2021-05-05 07:28:33'),
(28, 10, 'assets/site/img/c413896d0e4d96f664d5dc748651406c.jpg', 0, '2021-05-05 07:28:40'),
(29, 10, 'assets/site/img/b184e14f363a1d458ff3ab996747bccd.jpg', 0, '2021-05-05 07:28:47'),
(30, 11, 'assets/site/img/0cb8c79bff4dc9b3610addc04127e0ba.jpg', 0, '2021-05-05 07:30:04'),
(31, 11, 'assets/site/img/b79a9b0b493e11189224a26b48e22d0e.jpg', 0, '2021-05-05 07:30:10'),
(32, 11, 'assets/site/img/876caf10a81181e348223c3d056a4b54.jpg', 0, '2021-05-05 07:30:15'),
(33, 11, 'assets/site/img/2492d6605dec48f19fc9d6432bd94ad1.jpg', 0, '2021-05-05 07:30:21'),
(34, 7, 'assets/site/img/383a986d6d920cbb17b27c2d24cedee0.jpg', 0, '2021-05-05 07:30:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_details`
--
ALTER TABLE `business_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_brochures`
--
ALTER TABLE `service_brochures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_images`
--
ALTER TABLE `service_images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_details`
--
ALTER TABLE `business_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `service_brochures`
--
ALTER TABLE `service_brochures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_images`
--
ALTER TABLE `service_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
