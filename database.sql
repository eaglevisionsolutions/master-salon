-- Users and Roles
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password_hash VARCHAR(255),
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'staff', 'customer') DEFAULT 'customer',
    full_name VARCHAR(100),
    phone VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME
);

-- Staff Profiles
CREATE TABLE staff_profiles (
    user_id INT PRIMARY KEY,
    bio TEXT,
    photo VARCHAR(255),
    availability_json TEXT, -- JSON for schedule
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Customers
CREATE TABLE customers (
    user_id INT PRIMARY KEY,
    loyalty_points INT DEFAULT 0,
    preferences TEXT,
    visit_history_json TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Services (Menu)
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    duration_minutes INT,
    active BOOLEAN DEFAULT TRUE
);

-- Appointments
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    staff_id INT,
    service_id INT NOT NULL,
    scheduled_at DATETIME NOT NULL,
    status ENUM('booked', 'completed', 'cancelled', 'no-show') DEFAULT 'booked',
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

-- Inventory & Bulk Products
CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100),
    product_type VARCHAR(50),
    quantity DECIMAL(10,2), -- In ounces
    bulk_price DECIMAL(10,2), -- Price for the bulk amount
    bulk_size DECIMAL(10,2), -- Size in ounces
    price_per_ounce DECIMAL(10,4) GENERATED ALWAYS AS (bulk_price/bulk_size) STORED,
    low_stock_threshold DECIMAL(10,2) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- POS Transactions (with product usage)
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT,
    customer_id INT,
    staff_id INT,
    total_amount DECIMAL(10,2),
    payment_method VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (staff_id) REFERENCES users(id)
);

CREATE TABLE transaction_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT,
    inventory_id INT,
    scoops_used DECIMAL(10,2),
    product_cost DECIMAL(10,2),
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    FOREIGN KEY (inventory_id) REFERENCES inventory(id)
);

-- Promotions & Gift Cards
CREATE TABLE promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    description TEXT,
    discount_type ENUM('percent', 'amount'),
    discount_value DECIMAL(10,2),
    active BOOLEAN DEFAULT TRUE,
    valid_from DATETIME,
    valid_to DATETIME
);

CREATE TABLE gift_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    customer_id INT,
    balance DECIMAL(10,2),
    issued_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    FOREIGN KEY (customer_id) REFERENCES users(id)
);

-- Feedback & Reviews
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT,
    customer_id INT,
    staff_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (staff_id) REFERENCES users(id)
);