<?php
include("../connectdb.php");

$sql1 = "CREATE TABLE users (
        userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(50),
        upassword varchar(255),
        email varchar(255),
        userImage varchar(255),
        urole varchar(20),
        faculty	varchar(50),
        matricNo varchar(9),
        matricImg varchar(255),
        status varchar(8),
        CONSTRAINT UC_User_Username UNIQUE (username),
        CONSTRAINT UC_User_Email UNIQUE (email)
)";
mysqli_query($con, $sql1);

$sql = "INSERT INTO `users` (`userID`, `username`, `upassword`, `email`, `userImage`, `urole`, `faculty`, `matricNo`, `matricImg`, `status`) VALUES
(1, 'admin', md5('1122'), 'admin@gmail.com', NULL, 'admin', NULL, '', NULL, 'APPROVED'),
(2, 'jingyi', md5('1122'), 'jingyi012@gmail.com', 'profileImg-2-7288.png', 'user', 'Computing', 'A21EC0210', NULL, 'APPROVED'),
(3, 'Jess', md5('1122'), 'wongjie@graduate.utm.my', NULL, 'user', 'Computing', 'A21EC0039', NULL, 'APPROVED'),
(4, 'chai12', md5('1122'), 'chaijing13691@gmail.com', 'profileImg-4-72925.png', 'user', 'Science', 'A21EM0090', NULL, 'APPROVED'),
(5, 'chai1', md5('1122'), 'cj@gmail.com', NULL, 'user', NULL, 'A21EC0011', 'matricNoImg-5-56773.jpg', 'PENDING')
;";

mysqli_query($con, $sql);

$sql2 = "CREATE TABLE events (
    eventID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    eventName varchar(50),
    locationName varchar(50),
    latitude decimal(20, 16),
    longitude decimal(20, 16),
    category varchar(50),
    eventImage varchar(50),
    eventDescp text,
    organizer varchar(255),
    startDate datetime,
    endDate datetime,
    duration varchar(100) GENERATED ALWAYS AS (
        CONCAT(
            FLOOR(HOUR(TIMEDIFF(endDate, startDate)) / 24), ' day(s) ',
            MOD(HOUR(TIMEDIFF(endDate, startDate)), 24), ' hour(s) ',
            MINUTE(TIMEDIFF(endDate, startDate)), ' min(s)'
        )
    ) STORED
    )";

mysqli_query($con, $sql2);

$sql = "INSERT INTO `events` (`eventID`, `eventName`, `locationName`, `latitude`, `longitude`, `category`, `eventImage`, `eventDescp`, `organizer`, `startDate`, `endDate`) VALUES
(1, 'Climate Change Panel Discussion', 'City Campus', 1.5608398343008292, 103.6360688961990900, 'Eco Panels', 'images/event/65096428ccaf9.jpg', 'Engage with leading experts in the field of climate science as they discuss the latest research, challenges, and solutions related to climate change.', 'FABU', '2023-09-10 14:00:00', '2023-09-10 16:00:00'),
(2, 'Campus Swap Meet AAA', '1.5608398343008292', 1.5608398343008292, 103.6360688961990900, 'Green Marketplace', 'images/event/64f7d815da58f.jpg', 'Bring your gently used items to buy, sell, or trade with fellow students. Promote sustainability by giving pre-loved items a new home.', '103.6360688961990900', '2023-09-17 11:00:00', '2023-09-17 15:00:00'),
(3, 'Environmental Film Screening', 'Campus Auditorium', 1.5608398343008292, 103.6360688961990900, 'Eco Panels', 'images/event/64f7d82200725.jpg', 'Join us for a screening of thought-provoking environmental documentaries followed by a discussion with guest speakers.', 'Film and Ecology Club', '2023-10-05 18:00:00', '2023-10-05 20:30:00'),
(4, 'Recycling Workshop', 'Campus Sustainability Center', 1.5608398343008292, 103.6360688961990900, 'Sustainable Workshops', 'images/event/64f7d82a67268.jpg', 'Learn the art of recycling and upcycling everyday items in this interactive workshop. Turn trash into treasures!', 'Green Initiatives Group', '2023-10-15 13:30:00', '2023-10-15 15:30:00'),
(5, 'Green Campus Tour', 'Campus Main Entrance', 1.5608398343008292, 103.6360688961990900, 'Nature Walks', 'images/event/64f7d83449605.png', 'Discover the sustainable initiatives on our campus during a guided tour. See our solar panels, rain gardens, and more.', 'Campus Sustainability Office', '2023-10-22 10:00:00', '2023-10-22 11:30:00'),
(6, 'Upcycled Art Exhibition', 'Campus Art Gallery', 1.5608398343008292, 103.6360688961990900, 'Green Marketplace', 'images/event/64f7d83aafd09.jpg', 'View and purchase unique art pieces created from upcycled materials. Support local artists and eco-friendly art.', 'Art and Sustainability Collective', '2023-11-02 15:00:00', '2023-11-02 18:00:00');
";

mysqli_query($con, $sql);

$sql="CREATE TABLE `password_reset_temp` (
        `email` varchar(250) NOT NULL,
        `key` varchar(250) NOT NULL,
        `expDate` datetime NOT NULL,
          FOREIGN KEY (email) REFERENCES users(email)
      )";
mysqli_query($con, $sql);

$sql="CREATE TABLE post (
        postID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        postTitle varchar(255),
        postContent TEXT,
        postPic VARCHAR(255),
        postCategory varchar(255),
        postDate datetime,
        userID int,
        FOREIGN KEY (userID) REFERENCES users(userID)
        )";
mysqli_query($con, $sql);

$sql = "INSERT INTO `post` (`postID`, `postTitle`, `postContent`, `postPic`, `postCategory`, `postDate`, `userID`) VALUES
(1, 'Environment Protection', 'What are the activities related to environment protection?', 'postImg-650c265d418ae94419.png', 'Environment Protection', '2023-09-21 19:48:44', 2),
(2, 'Recycling', 'Why is it not common to see the recycle bin in UTM?', 'postImg-650c27a9dd35b65623.jpg', 'Waste Reduction and Recycling', '2023-09-21 19:23:21', 3),
(3, 'Let us share our carbon Footprint !', 'Let us share our carbon footprint under this post.', 'postImg-650c278fe5a8843951.jpg', 'Carbon Footprint', '2023-09-21 19:22:55', 2),
(4, 'Energy saving', 'How to save energy?', 'postImg-650c276bbddfc70655.jpg', 'Energy and Resource', '2023-09-21 19:22:19', 3),
(5, 'Let\'s Recycle', 'Is it recycle important? Yes, it is important!😍', 'postImg-650c26a5f207551006.jpeg', 'Waste Reduction and Recycling', '2023-09-21 20:03:05', 2);
";
mysqli_query($con, $sql);

$sql3 = "CREATE TABLE labelled_item(
        itemID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        itemName varchar(50),
        itemImage varchar(50),
        item_lat decimal(20, 16),
        item_lng decimal(20, 16)
)";
mysqli_query($con,$sql3);

// predefined labels
$sql4 = [];
$markers = [
    [1.5610633368545406, 103.64042591346818, 'hub'],
    [1.5586772764694763, 103.63833887638042, 'hub'],
    [1.5617711770954321, 103.63561939498715, 'hub'],
    [1.5618355261964076, 103.64531826263638, 'hub'],
    [1.5572238356525796, 103.63716434736952, 'bike'],
    [1.5604198455313483, 103.63403152728813, 'bike'],
    [1.5591757617257345, 103.6451895166191, 'bike'],
    [1.5628007624863784, 103.63637041351328, 'bus'],
    [1.5596905551138243, 103.6347396304572, 'bus'],
    [1.5579960264032544, 103.64029716745091, 'bus'],
    [1.5603125969563914, 103.64167045844547, 'bus'],
    [1.5627793127961294, 103.63913845317423, 'bus'],
    [1.5634657027755823, 103.64259313833247, 'park'],
    [1.5648345526143883, 103.63936059611834, 'park'],
    [1.55305617950327, 103.64641245128925, 'park'],
    [1.5568706004434785, 103.63494198708115, 'park']
];

foreach ($markers as $marker) {
    $lat = $marker[0];
    $lng = $marker[1];
    $image = $marker[2];

    $sql4[] = "INSERT INTO labelled_item (itemName, itemImage, item_lat, item_lng) VALUES ('$image', 'images/$image.png', $lat, $lng);";
}

foreach ($sql4 as $sqlInsert) {
    mysqli_query($con, $sqlInsert);
}


$sql="CREATE TABLE comments(
        commentID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        commentContent TEXT,
        commentDate datetime,
        parent_commentID int,
        userID int,
        postID int,
        FOREIGN KEY (userID) REFERENCES users(userID),
        FOREIGN KEY (postID) REFERENCES post(postID) ON DELETE CASCADE
)";
mysqli_query($con, $sql);

$sql1 = "CREATE TABLE NewsFeed (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        author VARCHAR(100) NOT NULL,
        publish_date DATETIME NOT NULL,
        image_url VARCHAR(255),
        category VARCHAR(50)
)";
mysqli_query($con, $sql1);

$sql = "INSERT INTO `newsfeed` (`id`, `title`, `content`, `author`, `publish_date`, `image_url`, `category`) VALUES
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
";

mysqli_query($con, $sql);

$sql = "CREATE TABLE guides(
        guideID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        guideTitle varchar(255) NOT NULL,
        guideContent TEXT,
        guideImg varchar(255),
        guideCategory varchar(255)
)";
mysqli_query($con, $sql);

$sql = "INSERT INTO `guides` (`guideID`, `guideTitle`, `guideContent`, `guideImg`, `guideCategory`) VALUES
(1, 'Our Planet Starts with You Ten simple choices for a healthier planet.', '1. Reduce, reuse, and recycle.\r\n2. Volunteer.\r\n3. Educate.\r\n4. Conserve water.\r\n5. Choose sustainable.\r\n6. Shop wisely.\r\n7. Use long-lasting light bulbs.\r\n8. Plant a tree.\r\n9. Don\'t send chemicals into our waterways.\r\n10. Bike more.\r\n\r\nFor more info:\r\nhttps://oceanservice.noaa.gov/ocean/earthday.html', 'guideImg-650c2856ad21333086.jpg', 'Environment Protection'),
(2, 'Recycling 101', 'Three Basic Rules:\r\nRule 1: Recycle bottles, cans, paper and cardboard.\r\nRule 2: Keep food and liquid out of your recycling.\r\nRule 3: No loose plastic bags and no bagged recyclables.\r\n\r\nClick to find more details:\r\nhttps://www.wm.com/us/en/recycle-right/recycling-101', 'guideImg-650c28bb7f02847756.jpeg', 'Waste Reduction and Recycling'),
(3, 'How to Recycle: Tips and Tricks to Get Started', 'FIRST: Get set up with your waste management provider.\r\nTHEN: Find out what your recycling service accepts! \r\n\r\nClick to know more:\r\nhttps://www.ecoenclose.com/blog/how-to-recycle-tips-and-tricks-to-get-started/', 'guideImg-650c28c363c9d80600.png', 'Waste Reduction and Recycling'),
(4, 'Modes and Benefits of Green Transportation', 'Modes of Green Transportation:\r\n1. Bicycle\r\n2. Electric bike\r\n3. Electric vehicles\r\n4. Green trains\r\n5. Electric motorcycles\r\n6. Multiple occupant vehicles\r\n7. Service and freight vehicles\r\n8. Hybrid cars\r\n9. The new hybrid buses (Public Transportation)\r\n10. Pedestrians\r\n\r\nBenefits of Green Transportation:\r\n1. Fewer to no environmental pollution\r\n2. Saves you money\r\n3. Contribute to the building of a sustainable economy\r\n4. Improved health\r\n\r\nClick to learn more:\r\nhttps://www.conserve-energy-future.com/modes-and-benefits-of-green-transportation.php', 'guideImg-650c28ca4072634932.jpg', 'Transportation'),
(5, 'A guide to achieving sustainable transportation', 'What is sustainable transportation?\r\n‘Sustainable transportation’ refers to safe modes of transportation that have a low impact on the environment. You’ll often see the term ‘green transportation’ too. Where possible, this type of transportation tends to use renewable energy, rather than coal or other fossil fuels that can harm the Earth.\r\n\r\nNot all forms of transportation have to use an energy source to be sustainable, however, Cycling is one environmentally-friendly form of transportation that doesn’t require any energy other than that of the human using the bicycle.\r\n\r\nClick to learn more:\r\nhttps://www.joloda.com/news/a-guide-to-achieving-sustainable-transportation/', 'guideImg-650c28d2f015d84176.jpg', 'Transportation'),
(6, 'Green Energy 101', 'Types of Green Energy:\r\n1. Solar Energy\r\n2. Wind Energy\r\n3. Hydro Energy\r\n4. Bioenergy\r\n5. Geothermal Energy\r\n\r\nClick to learn more:\r\nhttps://www.bluettipower.com/blogs/news/a-guide-to-green-energy', 'guideImg-650c28ddc25bf58582.jpg', 'Energy and Resource'),
(7, '12 Energy Saving Tips', '1. Turning off the lights when leaving a room\r\n2. Use LED lights\r\n3. Switching to efficient appliances\r\n4. Unplug devices\r\n5. Lessen water usage\r\n6. Keep the thermostat at a lower temperature\r\n7. Use smart automated devices\r\n8. Use double glazing door\r\n9. Cook with the lid on\r\n10. Using smart meter\r\n11. Washing at low temp\r\n12. Solar-powered devices\r\n\r\nClick to learn more:\r\nhttps://www.greenmatch.co.uk/blog/2020/03/how-to-save-energy-at-home', 'guideImg-650c28e5dfcd82153.png', 'Energy and Resource'),
(8, 'How to Reduce Your Carbon Footprint', '1. Drive Less\r\nGoing carless for a year could save about 2.6 tons of carbon dioxide, according to 2017 study from researchers at Lund University and the University of British Columbia.\r\n\r\n2. Fly Less\r\nTaking one fewer long round-trip flight could shrink your personal carbon footprint significantly\r\n\r\nFor more information: \r\nhttps://www.nytimes.com/guides/year-of-living-better/how-to-reduce-your-carbon-footprint', 'guideImg-650c28f4a404944007.jpg', 'Carbon Footprint'),
(9, 'Green Landscaping: 5 Tips for a Lush and Eco-Friendly Landscape', 'Green landscaping is just another term for sustainable or eco-friendly landscaping and involves creating landscapes and gardens that nurture nature; reduce air soil and water pollution, and help protect the surrounding ecosystem. \r\n\r\nHere are our top five eco-friendly tips for a lush and “green” landscape.\r\n1. Go Native\r\n2. Use Mulch\r\n3. Amend the Soil\r\n4. Be Water-Wise\r\n5. Utilize Hardscapes\r\n\r\nClick to learn more: \r\nhttps://www.landscapeeast.com/blog/green-landscaping-5-tips-for-a-lush-and-eco-friendly-landscape-2020-02', 'guideImg-650c28fc6eedd76308.jpg', 'Other');
";

mysqli_query($con, $sql);

echo "Tables created";
mysqli_close($con);
?>
