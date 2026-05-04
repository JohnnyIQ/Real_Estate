CREATE DATABASE real_estate_portal_db;
USE real_estate_portal_db;

CREATE TABLE  Users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(50) UNIQUE NOT NULL,
    contactInfo VARCHAR(200),
    passwordHash VARCHAR(255) NOT NULL,
    userType VARCHAR(20) NOT NULL
);

CREATE TABLE Properties (
    propertyId INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    propertyType VARCHAR(50) NOT NULL,
    address VARCHAR(200) NOT NULL,
    city VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'available',
    agentId INT,
    image VARCHAR(255),
    FOREIGN KEY (agentId) REFERENCES Users(userId)
);

CREATE TABLE  Inquiries (
    inquiryId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    propertyId INT,
    message VARCHAR(255),
    inquiryDate DATETIME,
    FOREIGN KEY (userId) REFERENCES Users(userId),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId)
);

CREATE TABLE Transactions (
    transactionId INT AUTO_INCREMENT PRIMARY KEY,
    propertyId INT,
    userId INT,
    transactionType VARCHAR(20),
    transactionDate DATETIME,
    amount DECIMAL(12,2),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId),
    FOREIGN KEY (userId) REFERENCES Users(userId)
);

CREATE TABLE Favorites (
    favoriteId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    propertyId INT,
    savedDate DATETIME,
    FOREIGN KEY (userId) REFERENCES Users(userId),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId)
    ON DELETE CASCADE
);

INSERT INTO Users (userName, contactInfo, passwordHash, userType)
VALUES
('michael.brooks', 'michael.brooks@gmail.com', 'agent123', 'agent'),
('sophia.reed', 'sophia.reed@yahoo.com', 'buyer123', 'buyer'),
('daniel.khan', 'dkhan@outlook.com', 'renter123', 'renter');

INSERT INTO Properties (title, propertyType, address, city, price, status, agentId, image)
VALUES
('Modern Downtown Loft with Skyline View', 'Apartment', '88 Hudson St', 'New York', 725000.00, 'available', 1, 'images/property1.webp'),

('Coastal Family Home Near Boardwalk', 'House', '14 Seaside Drive', 'Long Beach', 890000.00, 'available', 1, 'images/property2.jpg'),

('Compact Studio Near University District', 'Studio', '221 College Ave', 'Newark', 255000.00, 'available', 1, 'images/property3.jpg'),

('Renovated Brownstone with Private Backyard', 'House', '45 Willow Ave', 'Hoboken', 975000.00, 'available', 1, 'images/property4.jpg'),

('Luxury High-Rise Condo with River Views', 'Condo', '300 Riverfront Blvd, Apt 22C', 'Jersey City', 650000.00, 'available', 1, 'images/property5.jpg');

INSERT INTO Inquiries (userId, propertyId, message, inquiryDate)
VALUES
(2, 1, 'Is the loft still available?', NOW()),
(3, 2, 'Is price negotiable?', NOW()),
(2, 3, 'Is it furnished?', NOW());

INSERT INTO Transactions (propertyId, userId, transactionType, transactionDate, amount)
VALUES
(1, 2, 'sale', NOW(), 710000.00),
(2, 3, 'rental', NOW(), 3200.00),
(3, 2, 'sale', NOW(), 248000.00);

INSERT INTO Favorites (userId, propertyId, savedDate)
VALUES
(2, 1, NOW()),
(2, 2, NOW()),
(3, 1, NOW());

CREATE OR REPLACE VIEW PropertyListingView AS
SELECT 
    p.propertyId,
    p.title,
    p.propertyType,
    p.city,
    p.price,
    p.status,
    p.image,
    u.userName AS agentName
FROM Properties p
JOIN Users u ON p.agentId = u.userId;