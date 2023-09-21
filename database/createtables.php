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

$sql = "INSERT INTO users(username, upassword, email, urole, matricNo, status)
        VALUES ('admin', md5('1122'), 'admin@gmail.com', 'admin', '','APPROVED'),
        ('jingyi', md5('1122'), 'jingyi012@gmail.com', 'user', 'A23EC0091','APPROVED'),
        ('Jess', md5('1122'), 'wongjie@graduate.utm.my', 'user', 'A91EC0093', 'APPROVED');";

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
(1, 'Environment Protection', 'What are the activities related to environment protection?', 'postImg-650c265d418ae94419.png', 'environment-protection', '2023-09-21 19:48:44', 2),
(2, 'Recycling', 'Why is it not common to see the recycle bin in UTM?', 'postImg-650c27a9dd35b65623.jpg', 'waste-recycling', '2023-09-21 19:23:21', 3),
(3, 'Let us share our carbon Footprint !', 'Let us share our carbon footprint under this post.', 'postImg-650c278fe5a8843951.jpg', 'carbon-footprint', '2023-09-21 19:22:55', 14),
(4, 'Energy saving', 'How to save energy?', 'postImg-650c276bbddfc70655.jpg', 'energy-resource', '2023-09-21 19:22:19', 4),
(5, 'Let\'s Recycle', 'Is it recycle important? Yes, it is important!😍', 'postImg-650c26a5f207551006.jpeg', 'waste-recycling', '2023-09-21 20:03:05', 2);
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
// $sql4 = [];
// $markers = [
//     [1.5610633368545406, 103.64042591346818, 'hub'],
//     [1.5586772764694763, 103.63833887638042, 'hub'],
//     [1.5617711770954321, 103.63561939498715, 'hub'],
//     [1.5618355261964076, 103.64531826263638, 'hub'],
//     [1.5572238356525796, 103.63716434736952, 'bike'],
//     [1.5604198455313483, 103.63403152728813, 'bike'],
//     [1.5591757617257345, 103.6451895166191, 'bike'],
//     [1.5628007624863784, 103.63637041351328, 'bus'],
//     [1.5596905551138243, 103.6347396304572, 'bus'],
//     [1.5579960264032544, 103.64029716745091, 'bus'],
//     [1.5603125969563914, 103.64167045844547, 'bus'],
//     [1.5627793127961294, 103.63913845317423, 'bus'],
//     [1.5634657027755823, 103.64259313833247, 'park'],
//     [1.5648345526143883, 103.63936059611834, 'park'],
//     [1.55305617950327, 103.64641245128925, 'park'],
//     [1.5568706004434785, 103.63494198708115, 'park']
// ];

// foreach ($markers as $marker) {
//     $lat = $marker[0];
//     $lng = $marker[1];
//     $image = $marker[2];

//     $sql4[] = "INSERT INTO labelled_item (itemName, itemImage, item_lat, item_lng) VALUES ('$image', 'images/$image.png', $lat, $lng);";
// }

// foreach ($sql4 as $sqlInsert) {
//     mysqli_query($con, $sqlInsert);
// }


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
