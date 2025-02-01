
CREATE DATABASE IF NOT EXISTS book_store;
USE book_store;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    author VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL COMMENT 'Price in dollars'
);

