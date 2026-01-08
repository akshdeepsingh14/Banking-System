-- Create Database
CREATE DATABASE IF NOT EXISTS bank_db;
USE bank_db;

-- -------------------------------
-- Users Table
-- -------------------------------
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    dob DATE,
    phone VARCHAR(15),
    account_number VARCHAR(20),
    balance DECIMAL(10,2) DEFAULT 0.00,
    profile_image VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------
-- Transactions Table
-- -------------------------------
CREATE TABLE transactions (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11),
    type VARCHAR(20), -- deposit, withdraw, transfer
    amount DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
