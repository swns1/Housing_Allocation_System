CREATE DATABASE IF NOT EXISTS php_project;
USE php_project;

CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE buyers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    property_id INT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE buyers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (property_id) REFERENCES properties(id)
);

INSERT INTO properties (title, property_type, description, price, price_range, location, area, capacity, status) VALUES
('Modern Apartment', 'Apartment', 'Located near major universities, shopping malls, and MRT stations for easy commuting.', 300000.00, '200,000 - 400,000', 'Metro Manila, Quezon City', 32, '1-2 persons', 'available'),
('Prime Lot', 'Residential Lot', 'Situated in a gated community, close to schools, hospitals, and public markets.', 450000.00, '300,000 - 600,000', 'Cavite, Dasmariñas City', 50, 'N/A (Lot only)', 'available'),
('Luxury Condo', 'Condo', 'Walking distance to business districts, parks, and upscale restaurants.', 800000.00, '600,000 - 1,000,000', 'Metro Manila, Makati City', 35, '1-2 persons', 'available'),
('Family Home', 'House and Lot', 'Located in a suburban area near industrial zones, schools, and commercial establishments.', 900000.00, '800,000 - 1,000,000', 'Laguna, Sta. Rosa City', 60, '3-4 persons', 'available'),
('City Apartment', 'Apartment', 'Close to Clark Freeport Zone, SM City Clark, and Angeles University Foundation.', 375000.00, '250,000 - 500,000', 'Pampanga, Angeles City', 40, '2-3 persons', 'available'),
('Business Space', 'Commercial', 'Strategically located near public markets, transportation hubs, and schools.', 750000.00, '500,000 - 1,000,000', 'Bulacan, Malolos City', 70, 'N/A (Commercial)', 'available'),
('Hilltop Lot', 'Residential Lot', 'Overlooks the Metro Manila skyline; near churches, resorts, and eco-tourism sites.', 550000.00, '400,000 - 700,000', 'Rizal, Antipolo City', 80, 'N/A (Lot only)', 'available'),
('Suburban House', 'House and Lot', 'Located in a peaceful community near Lipa Cathedral and SM City Lipa.', 750000.00, '600,000 - 900,000', 'Batangas, Lipa City', 65, '3-4 persons', 'available'),
('BGC Studio', 'Condo', 'Situated in Bonifacio Global City, near high-end malls and multinational offices.', 850000.00, '700,000 - 1,000,000', 'Metro Manila, Taguig City', 30, '1 person', 'available'),
('Provincial Lot', 'Residential Lot', 'Located in a quiet area near government offices and cultural landmarks.', 250000.00, '200,000 - 300,000', 'Ilocos Norte, Laoag City', 100, 'N/A (Lot only)', 'available');