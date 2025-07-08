
-- Cities
INSERT IGNORE INTO `cities` (`id`, `name`) VALUES
  (1, 'Delhi'),
  (2, 'Mumbai'),
  (3, 'Bengaluru'),
  (4, 'Hyderabad');

-- Properties (5 per city = 20)
INSERT INTO `properties` (`id`, `city_id`, `name`, `address`, `description`, `gender`, `rent`, `rating_clean`, `rating_food`, `rating_safety`) VALUES
-- Delhi
(1, 1, 'Saxena\'s Paying Guest', 'H.No. 3958 Kaseru Walan, Pahar Ganj, New Delhi', 'Furnished studio apartment in Bijwasan...', 'male', 5000, 4.3, 3.4, 4.8),
(2, 1, 'Navrang PG Home', '644-C, Tooti Chowk, Paharganj, New Delhi', 'Shared PG with cozy rooms...', 'unisex', 6000, 2.9, 3.4, 3.8),
(3, 1, 'Dream Stay PG', 'D-105, Laxmi Nagar, Delhi', 'Affordable PG near metro with modern amenities.', 'female', 5500, 4.2, 3.7, 4.5),
(4, 1, 'UrbanNest PG', 'B-19, South Extension, New Delhi', 'Luxury PG with AC and WiFi for girls.', 'female', 7500, 4.4, 4.0, 4.6),
(5, 1, 'Study Stay PG', 'F-11, Karol Bagh, Delhi', 'Ideal for college students. Safe and reliable.', 'male', 5200, 3.9, 3.5, 4.0),

-- Mumbai
(6, 2, 'Navkar Paying Guest', '44, Juhu Scheme, Juhu, Mumbai', 'Clean PG with daily housekeeping.', 'female', 9500, 3.9, 3.8, 4.9),
(7, 2, 'PG for Girls Borivali West', 'Plot no.258/D4, Borivali West, Mumbai', 'Comfortable girls PG.', 'female', 8000, 4.2, 4.1, 4.5),
(8, 2, 'Ganpati Paying Guest', 'SV Rd, Borivali East, Mumbai', 'Spacious rooms and fast internet.', 'male', 8500, 4.2, 3.9, 4.6),
(9, 2, 'CozyNest PG', 'Malad West, Mumbai', 'New PG with vibrant interior and rooftop.', 'unisex', 8700, 4.1, 4.0, 4.3),
(10, 2, 'Seaside PG', 'Bandra West, Mumbai', 'Sea view PG with gym and WiFi.', 'female', 9200, 4.4, 4.3, 4.7),

-- Bengaluru
(11, 3, 'Green Nest PG', 'Koramangala 6th Block, Bengaluru', 'All facilities in heart of city.', 'female', 7000, 4.5, 4.2, 4.7),
(12, 3, 'Silicon Stay PG', 'Indiranagar 2nd Stage, Bengaluru', 'Ideal PG for techies.', 'male', 8000, 4.1, 3.9, 4.6),
(13, 3, 'Lake View PG', 'Banaswadi, Bengaluru', 'Relaxing lake view, perfect for students.', 'unisex', 7300, 4.3, 4.1, 4.5),
(14, 3, 'Garden Stay PG', 'HSR Layout, Bengaluru', 'Spacious and green surroundings.', 'female', 7500, 4.2, 3.9, 4.4),
(15, 3, 'MetroNest PG', 'MG Road, Bengaluru', 'Walkable from metro. Best for working professionals.', 'male', 7700, 4.0, 3.8, 4.3),

-- Hyderabad
(16, 4, 'Cyber City PG', 'Madhapur, Hitech City, Hyderabad', 'Stylish PG for IT folks.', 'unisex', 8500, 4.0, 4.1, 4.4),
(17, 4, 'Pearl Nest PG', 'Tarnaka, Secunderabad, Hyderabad', 'Peaceful location and good food.', 'female', 7500, 4.3, 3.8, 4.5),
(18, 4, 'Techie Stay PG', 'Gachibowli, Hyderabad', 'Budget-friendly PG with fast internet.', 'male', 7300, 4.1, 4.0, 4.3),
(19, 4, 'City Central PG', 'Ameerpet, Hyderabad', 'Near all coaching centers. Best for students.', 'unisex', 6800, 4.2, 3.9, 4.2),
(20, 4, 'Sunrise PG', 'Begumpet, Hyderabad', 'New building with elevator and WiFi.', 'female', 7900, 4.4, 4.2, 4.6);

-- Testimonials (2 per PG = 40)
INSERT INTO `testimonials` (`id`, `property_id`, `user_name`, `content`) VALUES
(1, 1, 'Ashutosh Gowariker', 'You just have to arrive at the place...'),
(2, 1, 'Karan Johar', 'Clean and peaceful environment.'),
(3, 2, 'Zoya Akhtar', 'Very welcoming PG with good facilities.'),
(4, 2, 'Farhan Akhtar', 'Comfortable for both work and study.'),
(5, 3, 'Rhea Kapoor', 'Neat rooms and friendly neighborhood.'),
(6, 3, 'Tanya Singh', 'Budget friendly PG near metro.'),
(7, 4, 'Ishita Sharma', 'Good for girls. AC and WiFi included.'),
(8, 4, 'Neerja Kaur', 'Helpful staff and clean bathrooms.'),
(9, 5, 'Manav Arora', 'Perfect for DU students.'),
(10, 5, 'Tushar Sharma', 'Decent food and good management.'),
(11, 6, 'Amrita Rao', 'The Juhu location is unbeatable.'),
(12, 6, 'Rohini Desai', 'Rooms are spacious and safe.'),
(13, 7, 'Priya Kamat', 'Felt like home, staff is kind.'),
(14, 7, 'Sonal Yadav', 'Great experience living here.'),
(15, 8, 'Rajeev Mehta', 'WiFi speed is great, perfect for WFH.'),
(16, 8, 'Sameer Jain', 'Affordable with all facilities.'),
(17, 9, 'Kajal Jadhav', 'Loved the rooftop and group vibe.'),
(18, 9, 'Ritu Mehta', 'Amazing interiors and lounge area.'),
(19, 10, 'Suhana Khan', 'Seaside view every morning!'),
(20, 10, 'Sanya Malhotra', 'Bandra is the best location.'),
(21, 11, 'Pooja Hegde', 'Koramangala is super happening. PG is peaceful.'),
(22, 11, 'Neha Bhat', 'Felt very secure and calm.'),
(23, 12, 'Yash Gowda', 'Super clean and very helpful owner.'),
(24, 12, 'Amit Sinha', 'Modern rooms with all amenities.'),
(25, 13, 'Amit Rathi', 'Quiet PG with great food options nearby.'),
(26, 13, 'Roshni Naik', 'Nice lake view and peaceful stay.'),
(27, 14, 'Sneha Rao', 'Green area and friendly flatmates.'),
(28, 14, 'Divya Kumar', 'Best place I have stayed so far.'),
(29, 15, 'Raj Malhotra', 'Great value, next to metro.'),
(30, 15, 'Meera Sharma', 'Budget friendly and accessible.'),
(31, 16, 'Samantha Ruth Prabhu', 'Perfect for Hitech City workers.'),
(32, 16, 'Arjun Reddy', 'Neat and professionally managed.'),
(33, 17, 'Keerthy Suresh', 'Good management and peaceful place.'),
(34, 17, 'Nithya Menen', 'I feel safe and comfortable.'),
(35, 18, 'Ram Charan', 'Gachibowli is great for students and professionals.'),
(36, 18, 'Allu Arjun', 'High-speed WiFi is a lifesaver!'),
(37, 19, 'Suresh Menon', 'Centrally located. Close to everything.'),
(38, 19, 'Anita Joseph', 'Clean and quiet PG.'),
(39, 20, 'Shruti Haasan', 'Very clean and quiet. Great for girls.'),
(40, 20, 'Nithya Menen', 'Affordable and new PG. Highly recommend.');
INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `phone`, `gender`, `college_name`) VALUES
(1, 'anuj.kalbalia@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Anuj Kalbalia', '9535100112', 'male', 'NITD'),
(2, 'shadab@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Shadab Alam', '9876543210', 'male', 'NITJ'),
(3, 'aditya@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Aditya Sood', '9876543210', 'male', 'Chandigarh University'),
(4, 'radhika@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Radhika Bhatia', '9876543210', 'female', 'Delhi University'),
(5, 'manya.sharma@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Manya Sharma', '9123456780', 'female', 'IGDTUW'),
(6, 'rohit.verma@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Rohit Verma', '9234567891', 'male', 'IIT Delhi'),
(7, 'kanika.kapoor@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Kanika Kapoor', '9345678902', 'female', 'BITS Pilani'),
(8, 'yuvraj.singh@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Yuvraj Singh', '9456789013', 'male', 'NIT Trichy'),
(9, 'ishika.rai@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Ishika Rai', '9567890124', 'female', 'Amity University'),
(10, 'avinash.pandey@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Avinash Pandey', '9678901235', 'male', 'DTU'),
(11, 'neha.kaur@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Neha Kaur', '9789012346', 'female', 'SRM University'),
(12, 'vishal.mehta@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Vishal Mehta', '9890123457', 'male', 'JNU'),
(13, 'ananya.singh@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Ananya Singh', '9012345678', 'female', 'IGDTUW'),
(14, 'arjun.malhotra@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Arjun Malhotra', '9023456789', 'male', 'IIT Bombay'),
(15, 'meera.iyer@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Meera Iyer', '9034567890', 'female', 'Anna University'),
(16, 'karthik.reddy@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Karthik Reddy', '9045678901', 'male', 'IIIT Hyderabad'),
(17, 'shruti.das@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Shruti Das', '9056789012', 'female', 'Jadavpur University'),
(18, 'ranveer.jain@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Ranveer Jain', '9067890123', 'male', 'VIT Vellore'),
(19, 'tanya.kapoor@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Tanya Kapoor', '9078901234', 'female', 'Lady Shri Ram College'),
(20, 'rishi.gupta@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Rishi Gupta', '9089012345', 'male', 'IIT Kanpur'),
(21, 'aarti.verma@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Aarti Verma', '9090123456', 'female', 'Punjab University'),
(22, 'sachin.bhatt@gmail.com', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'Sachin Bhatt', '9101234567', 'male', 'Jamia Millia Islamia');
INSERT INTO `interested_users_properties` (`id`, `user_id`, `property_id`) VALUES
(1, 1, 1), (2, 1, 2), (3, 1, 5),
(4, 2, 1), (5, 2, 5),
(6, 3, 1), (7, 3, 2), (8, 3, 5),
(9, 4, 2), (10, 4, 3), (11, 4, 4);
INSERT INTO `amenities` (`id`, `name`, `type`, `icon`) VALUES
(1, 'Wifi', 'Common Area', 'wifi'),
(2, 'Power Backup', 'Building', 'powerbackup'),
(3, 'Fire Extinguisher', 'Building', 'fireext'),
(4, 'TV', 'Common Area', 'tv'),
(5, 'Bed with Mattress', 'Bedroom', 'bed'),
(6, 'Parking', 'Building', 'parking'),
(7, 'Water Purifier', 'Common Area', 'rowater'),
(8, 'Dining', 'Common Area', 'dining'),
(9, 'Air Conditioner', 'Bedroom', 'ac'),
(10, 'Washing Machine', 'Common Area', 'washingmachine'),
(11, 'Lift', 'Building', 'lift'),
(12, 'CCTV', 'Building', 'cctv'),
(13, 'Geyser', 'Washroom', 'geyser');
INSERT INTO `properties_amenities` (`id`, `property_id`, `amenity_id`) VALUES
-- For property 1
(1, 1, 1), (2, 1, 2), (3, 1, 4), (4, 1, 5), (5, 1, 7), (6, 1, 8), (7, 1, 9), (8, 1, 10), (9, 1, 11), (10, 1, 13),
-- Property 2
(11, 2, 1), (12, 2, 2), (13, 2, 3), (14, 2, 4), (15, 2, 5), (16, 2, 7), (17, 2, 8), (18, 2, 9), (19, 2, 10), (20, 2, 11), (21, 2, 13),
-- Property 3
(22, 3, 1), (23, 3, 2), (24, 3, 3), (25, 3, 4), (26, 3, 5), (27, 3, 7), (28, 3, 8), (29, 3, 10), (30, 3, 11), (31, 3, 12), (32, 3, 13),
-- Property 4
(33, 4, 1), (34, 4, 3), (35, 4, 4), (36, 4, 5), (37, 4, 7), (38, 4, 8), (39, 4, 10), (40, 4, 11), (41, 4, 12), (42, 4, 13),
-- Property 5
(43, 5, 1), (44, 5, 3), (45, 5, 4), (46, 5, 5), (47, 5, 7), (48, 5, 8), (49, 5, 10), (50, 5, 11), (51, 5, 12), (52, 5, 13),
-- Property 6
(53, 6, 1), (54, 6, 2), (55, 6, 4), (56, 6, 5), (57, 6, 7), (58, 6, 8), (59, 6, 10), (60, 6, 13),
-- Property 7
(61, 7, 1), (62, 7, 3), (63, 7, 4), (64, 7, 5), (65, 7, 7), (66, 7, 10), (67, 7, 11), (68, 7, 12),
-- Property 8
(69, 8, 1), (70, 8, 2), (71, 8, 4), (72, 8, 5), (73, 8, 9), (74, 8, 10), (75, 8, 12), (76, 8, 13),
-- Property 9
(77, 9, 1), (78, 9, 3), (79, 9, 5), (80, 9, 7), (81, 9, 8), (82, 9, 10), (83, 9, 11), (84, 9, 13);
-- Property 10 (Seaside PG - Mumbai)
(85, 10, 1), (86, 10, 2), (87, 10, 4), (88, 10, 5), (89, 10, 7), (90, 10, 8), (91, 10, 9), (92, 10, 10), (93, 10, 11), (94, 10, 12),

-- Property 11 (Green Nest PG - Bengaluru)
(95, 11, 1), (96, 11, 2), (97, 11, 4), (98, 11, 5), (99, 11, 7), (100, 11, 8), (101, 11, 10), (102, 11, 11), (103, 11, 13),

-- Property 12 (Silicon Stay PG - Bengaluru)
(104, 12, 1), (105, 12, 3), (106, 12, 4), (107, 12, 5), (108, 12, 6), (109, 12, 9), (110, 12, 10), (111, 12, 12), (112, 12, 13),

-- Property 13 (Lake View PG - Bengaluru)
(113, 13, 1), (114, 13, 2), (115, 13, 4), (116, 13, 5), (117, 13, 7), (118, 13, 8), (119, 13, 9), (120, 13, 10), (121, 13, 11),

-- Property 14 (Garden Stay PG - Bengaluru)
(122, 14, 1), (123, 14, 3), (124, 14, 4), (125, 14, 5), (126, 14, 7), (127, 14, 10), (128, 14, 12), (129, 14, 13),

-- Property 15 (MetroNest PG - Bengaluru)
(130, 15, 1), (131, 15, 2), (132, 15, 4), (133, 15, 5), (134, 15, 6), (135, 15, 7), (136, 15, 9), (137, 15, 11), (138, 15, 13),

-- Property 16 (Cyber City PG - Hyderabad)
(139, 16, 1), (140, 16, 2), (141, 16, 3), (142, 16, 4), (143, 16, 5), (144, 16, 6), (145, 16, 7), (146, 16, 9), (147, 16, 10), (148, 16, 12), (149, 16, 13),

-- Property 17 (Pearl Nest PG - Hyderabad)
(150, 17, 1), (151, 17, 3), (152, 17, 4), (153, 17, 5), (154, 17, 7), (155, 17, 8), (156, 17, 10), (157, 17, 12), (158, 17, 13),

-- Property 18 (Techie Stay PG - Hyderabad)
(159, 18, 1), (160, 18, 2), (161, 18, 4), (162, 18, 5), (163, 18, 6), (164, 18, 7), (165, 18, 9), (166, 18, 10), (167, 18, 11), (168, 18, 12), (169, 18, 13),

-- Property 19 (City Central PG - Hyderabad)
(170, 19, 1), (171, 19, 3), (172, 19, 4), (173, 19, 5), (174, 19, 6), (175, 19, 7), (176, 19, 8), (177, 19, 10), (178, 19, 12), (179, 19, 13),

-- Property 20 (Sunrise PG - Hyderabad)
(180, 20, 1), (181, 20, 2), (182, 20, 3), (183, 20, 4), (184, 20, 5), (185, 20, 7), (186, 20, 8), (187, 20, 10), (188, 20, 11), (189, 20, 12), (190, 20, 13);
