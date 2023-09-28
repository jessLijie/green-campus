-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2023 at 01:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `greenify`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `commentContent` text DEFAULT NULL,
  `commentDate` datetime DEFAULT NULL,
  `parent_commentID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `postID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `commentContent`, `commentDate`, `parent_commentID`, `userID`, `postID`) VALUES
(1, 'Switch off the fan and lamp if you are not in the room.', '2023-09-28 19:13:04', 0, 2, 4),
(2, 'recycle', '2023-09-28 19:13:30', 0, 2, 1),
(3, 'dispose the waste properly', '2023-09-28 19:15:25', 0, 3, 1),
(4, 'I agree', '2023-09-28 19:15:40', 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventID` int(11) NOT NULL,
  `eventName` varchar(50) DEFAULT NULL,
  `locationName` varchar(50) DEFAULT NULL,
  `latitude` decimal(20,16) DEFAULT NULL,
  `longitude` decimal(20,16) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `eventImage` varchar(50) DEFAULT NULL,
  `eventDescp` text DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `duration` varchar(100) GENERATED ALWAYS AS (concat(floor(hour(timediff(`endDate`,`startDate`)) / 24),' day(s) ',hour(timediff(`endDate`,`startDate`)) MOD 24,' hour(s) ',minute(timediff(`endDate`,`startDate`)),' min(s)')) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `eventName`, `locationName`, `latitude`, `longitude`, `category`, `eventImage`, `eventDescp`, `organizer`, `startDate`, `endDate`) VALUES
(1, 'Climate Change Panel Discussion', 'City Campus', 1.5608398343008292, 103.6360688961990900, 'Eco Panels', 'images/event/65096428ccaf9.jpg', 'Engage with leading experts in the field of climate science as they discuss the latest research, challenges, and solutions related to climate change.', 'FABU', '2023-10-21 14:00:00', '2023-10-21 16:00:00'),
(2, 'Campus Swap Meet AAA', '1.5608398343008292', 1.5608398343008292, 103.6360688961990900, 'Green Marketplace', 'images/event/64f7d815da58f.jpg', 'Bring your gently used items to buy, sell, or trade with fellow students. Promote sustainability by giving pre-loved items a new home.', '103.6360688961990900', '2023-10-23 11:00:00', '2023-10-23 15:00:00'),
(3, 'Environmental Film Screening', 'Campus Auditorium', 1.5608398343008292, 103.6360688961990900, 'Eco Panels', 'images/event/64f7d82200725.jpg', 'Join us for a screening of thought-provoking environmental documentaries followed by a discussion with guest speakers.', 'Film and Ecology Club', '2023-10-25 18:00:00', '2023-10-25 20:30:00'),
(4, 'Recycling Workshop', 'Campus Sustainability Center', 1.5608398343008292, 103.6360688961990900, 'Sustainable Workshops', 'images/event/64f7d82a67268.jpg', 'Learn the art of recycling and upcycling everyday items in this interactive workshop. Turn trash into treasures!', 'Green Initiatives Group', '2023-11-15 13:30:00', '2023-11-15 15:30:00'),
(5, 'Green Campus Tour', 'Campus Main Entrance', 1.5608398343008292, 103.6360688961990900, 'Nature Walks', 'images/event/64f7d83449605.png', 'Discover the sustainable initiatives on our campus during a guided tour. See our solar panels, rain gardens, and more.', 'Campus Sustainability Office', '2023-11-22 10:00:00', '2023-11-22 11:30:00'),
(6, 'Upcycled Art Exhibition', 'Campus Art Gallery', 1.5608398343008292, 103.6360688961990900, 'Green Marketplace', 'images/event/64f7d83aafd09.jpg', 'View and purchase unique art pieces created from upcycled materials. Support local artists and eco-friendly art.', 'Art and Sustainability Collective', '2023-12-02 15:00:00', '2023-12-02 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `guideID` int(11) NOT NULL,
  `guideTitle` varchar(255) NOT NULL,
  `guideContent` text DEFAULT NULL,
  `guideImg` varchar(255) DEFAULT NULL,
  `guideCategory` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`guideID`, `guideTitle`, `guideContent`, `guideImg`, `guideCategory`) VALUES
(1, 'Our Planet Starts with You Ten simple choices for a healthier planet.', '1. Reduce, reuse, and recycle.\r\n2. Volunteer.\r\n3. Educate.\r\n4. Conserve water.\r\n5. Choose sustainable.\r\n6. Shop wisely.\r\n7. Use long-lasting light bulbs.\r\n8. Plant a tree.\r\n9. Don\'t send chemicals into our waterways.\r\n10. Bike more.\r\n\r\nFor more info:\r\nhttps://oceanservice.noaa.gov/ocean/earthday.html', 'guideImg-650c2856ad21333086.jpg', 'Environment Protection'),
(2, 'Recycling 101', 'Three Basic Rules:\r\nRule 1: Recycle bottles, cans, paper and cardboard.\r\nRule 2: Keep food and liquid out of your recycling.\r\nRule 3: No loose plastic bags and no bagged recyclables.\r\n\r\nClick to find more details:\r\nhttps://www.wm.com/us/en/recycle-right/recycling-101', 'guideImg-650c28bb7f02847756.jpeg', 'Waste Reduction and Recycling'),
(3, 'How to Recycle: Tips and Tricks to Get Started', 'FIRST: Get set up with your waste management provider.\r\nTHEN: Find out what your recycling service accepts! \r\n\r\nClick to know more:\r\nhttps://www.ecoenclose.com/blog/how-to-recycle-tips-and-tricks-to-get-started/', 'guideImg-650c28c363c9d80600.png', 'Waste Reduction and Recycling'),
(4, 'Modes and Benefits of Green Transportation', 'Modes of Green Transportation:\r\n1. Bicycle\r\n2. Electric bike\r\n3. Electric vehicles\r\n4. Green trains\r\n5. Electric motorcycles\r\n6. Multiple occupant vehicles\r\n7. Service and freight vehicles\r\n8. Hybrid cars\r\n9. The new hybrid buses (Public Transportation)\r\n10. Pedestrians\r\n\r\nBenefits of Green Transportation:\r\n1. Fewer to no environmental pollution\r\n2. Saves you money\r\n3. Contribute to the building of a sustainable economy\r\n4. Improved health\r\n\r\nClick to learn more:\r\nhttps://www.conserve-energy-future.com/modes-and-benefits-of-green-transportation.php', 'guideImg-650c28ca4072634932.jpg', 'Transportation'),
(5, 'A guide to achieving sustainable transportation', 'What is sustainable transportation?\r\n‘Sustainable transportation’ refers to safe modes of transportation that have a low impact on the environment. You’ll often see the term ‘green transportation’ too. Where possible, this type of transportation tends to use renewable energy, rather than coal or other fossil fuels that can harm the Earth.\r\n\r\nNot all forms of transportation have to use an energy source to be sustainable, however, Cycling is one environmentally-friendly form of transportation that doesn’t require any energy other than that of the human using the bicycle.\r\n\r\nClick to learn more:\r\nhttps://www.joloda.com/news/a-guide-to-achieving-sustainable-transportation/', 'guideImg-650c28d2f015d84176.jpg', 'Transportation'),
(6, 'Green Energy 101', 'Types of Green Energy:\r\n1. Solar Energy\r\n2. Wind Energy\r\n3. Hydro Energy\r\n4. Bioenergy\r\n5. Geothermal Energy\r\n\r\nClick to learn more:\r\nhttps://www.bluettipower.com/blogs/news/a-guide-to-green-energy', 'guideImg-650c28ddc25bf58582.jpg', 'Energy and Resource'),
(7, '12 Energy Saving Tips', '1. Turning off the lights when leaving a room\r\n2. Use LED lights\r\n3. Switching to efficient appliances\r\n4. Unplug devices\r\n5. Lessen water usage\r\n6. Keep the thermostat at a lower temperature\r\n7. Use smart automated devices\r\n8. Use double glazing door\r\n9. Cook with the lid on\r\n10. Using smart meter\r\n11. Washing at low temp\r\n12. Solar-powered devices\r\n\r\nClick to learn more:\r\nhttps://www.greenmatch.co.uk/blog/2020/03/how-to-save-energy-at-home', 'guideImg-650c28e5dfcd82153.png', 'Energy and Resource'),
(8, 'How to Reduce Your Carbon Footprint', '1. Drive Less\r\nGoing carless for a year could save about 2.6 tons of carbon dioxide, according to 2017 study from researchers at Lund University and the University of British Columbia.\r\n\r\n2. Fly Less\r\nTaking one fewer long round-trip flight could shrink your personal carbon footprint significantly\r\n\r\nFor more information: \r\nhttps://www.nytimes.com/guides/year-of-living-better/how-to-reduce-your-carbon-footprint', 'guideImg-650c28f4a404944007.jpg', 'Carbon Footprint'),
(9, 'Green Landscaping: 5 Tips for a Lush and Eco-Friendly Landscape', 'Green landscaping is just another term for sustainable or eco-friendly landscaping and involves creating landscapes and gardens that nurture nature; reduce air soil and water pollution, and help protect the surrounding ecosystem. \r\n\r\nHere are our top five eco-friendly tips for a lush and “green” landscape.\r\n1. Go Native\r\n2. Use Mulch\r\n3. Amend the Soil\r\n4. Be Water-Wise\r\n5. Utilize Hardscapes\r\n\r\nClick to learn more: \r\nhttps://www.landscapeeast.com/blog/green-landscaping-5-tips-for-a-lush-and-eco-friendly-landscape-2020-02', 'guideImg-650c28fc6eedd76308.jpg', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `labelled_item`
--

CREATE TABLE `labelled_item` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(50) DEFAULT NULL,
  `itemImage` varchar(50) DEFAULT NULL,
  `item_lat` decimal(20,16) DEFAULT NULL,
  `item_lng` decimal(20,16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labelled_item`
--

INSERT INTO `labelled_item` (`itemID`, `itemName`, `itemImage`, `item_lat`, `item_lng`) VALUES
(1, 'hub', 'images/hub.png', 1.5610633368545000, 103.6404259134700000),
(2, 'hub', 'images/hub.png', 1.5586772764695000, 103.6383388763800000),
(3, 'hub', 'images/hub.png', 1.5617711770954000, 103.6356193949900000),
(4, 'hub', 'images/hub.png', 1.5618355261964000, 103.6453182626400000),
(5, 'bike', 'images/bike.png', 1.5572238356526000, 103.6371643473700000),
(6, 'bike', 'images/bike.png', 1.5604198455313000, 103.6340315272900000),
(7, 'bike', 'images/bike.png', 1.5591757617257000, 103.6451895166200000),
(8, 'bus', 'images/bus.png', 1.5628007624864000, 103.6363704135100000),
(9, 'bus', 'images/bus.png', 1.5596905551138000, 103.6347396304600000),
(10, 'bus', 'images/bus.png', 1.5579960264033000, 103.6402971674500000),
(11, 'bus', 'images/bus.png', 1.5603125969564000, 103.6416704584500000),
(12, 'bus', 'images/bus.png', 1.5627793127961000, 103.6391384531700000),
(13, 'park', 'images/park.png', 1.5634657027756000, 103.6425931383300000),
(14, 'park', 'images/park.png', 1.5648345526144000, 103.6393605961200000),
(15, 'park', 'images/park.png', 1.5530561795033000, 103.6464124512900000),
(16, 'park', 'images/park.png', 1.5568706004435000, 103.6349419870800000);

-- --------------------------------------------------------

--
-- Table structure for table `newsfeed`
--

CREATE TABLE `newsfeed` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `publish_date` datetime NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsfeed`
--

INSERT INTO `newsfeed` (`id`, `title`, `content`, `author`, `publish_date`, `image_url`, `category`) VALUES
(1, 'New Research Findings', 'Embracing Sustainability: The Path to a Green Campus\r\n\r\nIn an era where environmental concerns are paramount, educational institutions are stepping up to make a difference by creating green campuses. A green campus is more than just a trend; it\'s a commitment to sustainable practices that encompass everything from architecture and landscaping to energy consumption and waste management. As universities and colleges strive to educate the next generation of leaders, they are also taking on the responsibility of demonstrating how to build a better, more sustainable future.\r\n\r\nDesigning Sustainable Spaces\r\n\r\nAt the heart of a green campus is its design. Architects and urban planners are now incorporating eco-friendly principles into every stage of campus construction and renovation. The use of renewable materials, energy-efficient designs, and passive cooling and heating techniques can significantly reduce the environmental footprint of buildings. Rooftop gardens, solar panels, and rainwater harvesting systems have become common features, seamlessly blending sustainability with functionality.\r\n\r\nPromoting Renewable Energy\r\n\r\nOne of the cornerstones of a green campus is the adoption of renewable energy sources. Universities are increasingly turning to solar, wind, and geothermal energy to power their campuses. Solar panels installed on rooftops and parking structures not only generate clean electricity but also serve as educational tools, showcasing the potential of renewable energy to students and visitors alike. By reducing dependence on fossil fuels, these institutions are leading the way toward a more sustainable energy future.\r\n\r\nCurriculum for Sustainability\r\n\r\nA green campus is not only defined by its physical attributes but also by its curriculum. Educational institutions are incorporating sustainability-focused programs and courses across various disciplines. From environmental science and sustainable engineering to business ethics and urban planning, students are exposed to concepts that emphasize the importance of environmental stewardship and social responsibility. This interdisciplinary approach ensures that graduates are equipped with the knowledge and skills needed to tackle complex sustainability challenges.\r\n\r\nWaste Management and Recycling\r\n\r\nThe commitment to sustainability extends to waste management as well. Green campuses prioritize waste reduction, recycling, and composting. Students and staff are encouraged to recycle paper, plastics, and electronic waste, while composting organic materials. On-site recycling centers and educational campaigns raise awareness about the impact of waste on the environment and provide practical solutions for reducing it.\r\n\r\nBiodiversity and Landscaping\r\n\r\nA green campus is often characterized by lush greenery and vibrant biodiversity. Landscaping choices focus on native plants that require less water and maintenance, creating a harmonious relationship between the built environment and nature. These campuses serve as urban oases, providing habitats for local wildlife and contributing to improved air quality.\r\n\r\nCommunity Engagement\r\n\r\nA truly green campus engages not only its students and faculty but also the surrounding community. Sustainability-focused events, workshops, and seminars encourage collaboration and knowledge-sharing among different stakeholders. Community members are invited to participate in initiatives such as tree planting drives, clean-up campaigns, and sustainable gardening projects. This not only strengthens the bond between the campus and its neighbors but also amplifies the positive impact of sustainable practices.\r\n\r\nMeasuring and Improving Impact\r\n\r\nConstantly striving for improvement, green campuses monitor their environmental impact and set goals for reducing their carbon footprint. Through data collection and analysis, these institutions track energy and water consumption, waste generation, and emissions. This information guides decision-making and enables campuses to make informed choices about resource allocation and efficiency enhancements.\r\n\r\nConclusion\r\n\r\nThe concept of a green campus transcends physical infrastructure; it represents a holistic approach to education and sustainable living. By embracing renewable energy, integrating sustainability into curricula, and fostering a culture of eco-consciousness, educational institutions are creating hubs of innovation and inspiration. As green campuses continue to multiply, they serve as beacons of hope, demonstrating that a harmonious coexistence between human development and environmental preservation is not only possible but essential for a brighter future.', 'Crystal', '2023-08-21 11:04:00', 'newsImg-1-22262.jpg', 'Campus News'),
(2, 'Upcoming Workshop', 'Join us for a workshop on sustainable living.', 'Sustainability Team', '2023-08-18 00:00:00', 'newsImg-2-2344.jpeg', 'Facilities'),
(3, 'Faculty Spotlight', 'Get to know our featured faculty member of the month.', 'Faculty Committee', '2023-08-12 00:00:00', 'newsImg-3-35912.jpg', 'Campus News'),
(4, 'Athletics Update', 'Check out the latest results from our sports teams.', 'Athletics Department', '2023-08-08 00:00:00', 'newsImg-4-1070.jpg', 'Achievements'),
(5, 'Environmental Seminar', 'Learn about the importance of environmental conservation.', 'Guest Speaker', '2023-08-25 00:00:00', 'newsImg-5-84102.jpg', 'Events'),
(6, 'Student Showcase', 'Explore the impressive projects and work of our students.', 'Student Council', '2023-08-22 00:00:00', 'newsImg-6-70523.jpg', 'Achievements'),
(7, 'Campus Beautification', 'Join us for a volunteer day to beautify the campus.', 'Volunteer Committee', '2023-08-14 00:00:00', 'newsImg-7-11898.jpg', 'Events'),
(8, 'Community Outreach', 'Find out how we\"re making a positive impact in the local community.', 'Community Engagement Team', '2023-08-17 00:00:00', 'newsImg-8-65057.jpg', 'Achievements'),
(9, 'Alumni Spotlight', 'Meet one of our accomplished alumni and their journey post-graduation.', 'Alumni Association', '2023-08-19 00:00:00', 'newsImg-9-50581.jpeg', 'Facilities'),
(10, 'New Course Offering', 'Explore our latest addition to the course catalog.', 'Academic Department', '2023-08-11 00:00:00', 'newsImg-10-52699.jpeg', 'Facilities'),
(11, 'Healthy Living Tips', 'Discover tips for maintaining a healthy and balanced lifestyle.', 'Wellness Team', '2023-08-23 00:00:00', 'newsImg-11-40373.jpg', 'Campus News'),
(12, 'Cultural Festival', 'Experience a celebration of diverse cultures on campus.', 'Cultural Affairs Committee', '2023-08-26 00:00:00', 'newsImg-12-2656.jpg', 'Events'),
(13, 'Tech Innovation Showcase', 'Learn about the latest technological innovations from our students.', 'Innovation Center', '2023-08-28 00:00:00', 'newsImg-13-18789.jpg', 'Campus News'),
(14, 'Student Organizations', 'Explore the various student clubs and organizations you can join.', 'Student Activities Office', '2023-08-21 00:00:00', 'newsImg-14-8632.jpg', 'Facilities'),
(15, 'Faculty Research Symposium', 'Attend our annual symposium highlighting faculty research contributions.', 'Faculty Research Committee', '2023-08-29 00:00:00', 'newsImg-15-97584.jpg', 'Achievements'),
(16, 'Exciting Event Coming Up', 'Join us for an exciting event next week! Discover how sustainability is changing economies, society and the way we invest.', 'Admin', '2023-08-15 00:00:00', 'newsImg-16-96544.jpeg', 'Events'),
(17, 'New Green Initiatives', 'Learn about our new green initiatives to create a sustainable campus.', 'John Doe', '2023-08-10 00:00:00', 'newsImg-17-37695.png', 'Campus News'),
(18, 'Student Achievements', 'Congrats to our students for their outstanding achievements!', 'Jane Smith', '2023-08-05 00:00:00', 'newsImg-18-6880.jpg', 'Achievements');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_temp`
--

CREATE TABLE `password_reset_temp` (
  `email` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postID` int(11) NOT NULL,
  `postTitle` varchar(255) DEFAULT NULL,
  `postContent` text DEFAULT NULL,
  `postPic` varchar(255) DEFAULT NULL,
  `postCategory` varchar(255) DEFAULT NULL,
  `postDate` datetime DEFAULT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `postTitle`, `postContent`, `postPic`, `postCategory`, `postDate`, `userID`) VALUES
(1, 'Environment Protection', 'What are the activities related to environment protection?', 'postImg-650c265d418ae94419.png', 'Environment Protection', '2023-09-21 19:48:44', 2),
(2, 'Recycling', 'Why is it not common to see the recycle bin in UTM?', 'postImg-650c27a9dd35b65623.jpg', 'Waste Reduction and Recycling', '2023-09-21 19:23:21', 3),
(3, 'Let us share our carbon Footprint !', 'Let us share our carbon footprint under this post.', 'postImg-650c278fe5a8843951.jpg', 'Carbon Footprint', '2023-09-21 19:22:55', 2),
(4, 'Energy saving', 'How to save energy?', 'postImg-650c276bbddfc70655.jpg', 'Energy and Resource', '2023-09-21 19:22:19', 3),
(5, 'Let\'s Recycle', 'Is it recycle important? Yes, it is important!😍', 'postImg-650c26a5f207551006.jpeg', 'Waste Reduction and Recycling', '2023-09-21 20:03:05', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `upassword` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `userImage` varchar(255) DEFAULT NULL,
  `urole` varchar(20) DEFAULT NULL,
  `faculty` varchar(50) DEFAULT NULL,
  `matricNo` varchar(9) DEFAULT NULL,
  `matricImg` varchar(255) DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `upassword`, `email`, `userImage`, `urole`, `faculty`, `matricNo`, `matricImg`, `status`) VALUES
(1, 'admin', '3b712de48137572f3849aabd5666a4e3', 'admin@gmail.com', NULL, 'admin', NULL, '', NULL, 'APPROVED'),
(2, 'jingyi', '3b712de48137572f3849aabd5666a4e3', 'jingyi012@gmail.com', 'profileImg-2-7288.png', 'user', 'Computing', 'A21EC0210', NULL, 'APPROVED'),
(3, 'Jess', '3b712de48137572f3849aabd5666a4e3', 'wongjie@graduate.utm.my', NULL, 'user', 'Computing', 'A21EC0039', NULL, 'APPROVED'),
(4, 'chai12', '3b712de48137572f3849aabd5666a4e3', 'chaijing13691@gmail.com', 'profileImg-4-72925.png', 'user', 'Science', 'A21EM0090', NULL, 'APPROVED'),
(5, 'chai1', '3b712de48137572f3849aabd5666a4e3', 'cj@gmail.com', NULL, 'user', NULL, 'A21EC0011', 'matricNoImg-5-56773.jpg', 'PENDING');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `postID` (`postID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`guideID`);

--
-- Indexes for table `labelled_item`
--
ALTER TABLE `labelled_item`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `newsfeed`
--
ALTER TABLE `newsfeed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_temp`
--
ALTER TABLE `password_reset_temp`
  ADD KEY `email` (`email`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `UC_User_Username` (`username`),
  ADD UNIQUE KEY `UC_User_Email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `guideID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `labelled_item`
--
ALTER TABLE `labelled_item`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `newsfeed`
--
ALTER TABLE `newsfeed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`postID`) REFERENCES `post` (`postID`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset_temp`
--
ALTER TABLE `password_reset_temp`
  ADD CONSTRAINT `password_reset_temp_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
