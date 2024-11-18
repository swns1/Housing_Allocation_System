CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE properties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_name VARCHAR(100) NOT NULL,
    floor_area INT NOT NULL,
    monthly_rent DECIMAL(10,2) NOT NULL,
    annual_range VARCHAR(100) NOT NULL,
    capacity VARCHAR(50) NOT NULL,
    location_type VARCHAR(50) NOT NULL,
    utilities VARCHAR(255) NOT NULL,
    amenities VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL
);

INSERT INTO properties (property_name, floor_area, monthly_rent, annual_range, capacity, location_type, utilities, amenities, status) VALUES
('Studio', 32, 4500, '₱180,000 - ₱350,000/year', '1 person', 'Urban', 'Water, Electricity', 'Laundry area, Wi-Fi', 'Available'),
('1-Bedroom Apartment', 45, 6500, '₱250,000 - ₱400,000/year', '1-2 persons', 'Urban', 'Water, Electricity, Gas', 'Parking, Security, Gym', 'Available'),
('2-Bedroom Apartment', 60, 8000, '₱300,000 - ₱500,000/year', '3-4 persons', 'Urban', 'Water, Electricity, Gas', 'Playground, Community Hall', 'Available'),
('3-Bedroom House', 90, 7500, '₱300,000 - ₱600,000/year', '4-5 persons', 'Rural', 'Water, Electricity', 'Garden, Garage, Pet-friendly', 'Available'),
('1-Bedroom Apartment', 40, 5500, '₱220,000 - ₱400,000/year', '1-2 persons', 'Urban', 'Water, Electricity', 'Library, Café', 'Available'),
('2-Bedroom Townhouse', 75, 7000, '₱250,000 - ₱500,000/year', '3-4 persons', 'Urban', 'Water, Gas', 'Balcony, Garage, Pet-friendly', 'Available'),
('3-Bedroom Apartment', 80, 8000, '₱300,000 - ₱500,000/year', '4-5 persons', 'Urban', 'Water, Electricity, Gas', 'Playground, Security', 'Available'),
('4-Bedroom House', 110, 8000, '₱350,000 - ₱600,000/year', '5-6 persons', 'Rural', 'Water, Electricity', 'Swimming pool, Garage', 'Available'),
('2-Bedroom Apartment', 55, 6000, '₱250,000 - ₱450,000/year', '3-4 persons', 'Urban', 'Water, Electricity', 'Gym, Pet-friendly', 'Available'),
('Studio', 28, 4000, '₱150,000 - ₱300,000/year', '1 person', 'Rural', 'Water, Electricity', 'Wi-Fi, Shared workspace', 'Available');
