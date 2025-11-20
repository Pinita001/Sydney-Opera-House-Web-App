-- Create the database
CREATE DATABASE IF NOT EXISTS cinema_booking_db;

USE cinema_booking_db;  -- select the active database context

-- Table for storing users (for authentication)
CREATE TABLE users (  -- begin definition for `users`
    id INT AUTO_INCREMENT PRIMARY KEY,  -- primary key for users
    full_name VARCHAR(255) NOT NULL,  -- user's display name
    email VARCHAR(100) NOT NULL UNIQUE,  -- unique login identifier
    password VARCHAR(255) NOT NULL,  -- hashed password string
    phone VARCHAR(15),  -- optional contact number
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- timestamp when user row was created
);

-- Table for storing shows
CREATE TABLE shows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    venue VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for storing users' orders (bookings)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- foreign key constraint referencing `users`
);

-- Table for storing the details of items in the cart before checkout
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    show_id INT,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE
);

-- Table for storing order items (tickets for confirmed bookings)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    show_id INT,
    quantity INT DEFAULT 1,
    price DECIMAL(10, 2),
    show_time VARCHAR(100), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(id)
);

-- Table for storing payment information (just for tracking payments)
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    payment_method ENUM('Credit Card', 'PayPal', 'Cash') NOT NULL,
    payment_status ENUM('Pending', 'Paid', 'Failed') DEFAULT 'Pending',
    amount DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);


-- Table for dining/private event reservations
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT NOT NULL,
    notes VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
