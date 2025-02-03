
CREATE DATABASE IF NOT EXISTS todo_api;
USE todo_api;

CREATE TABLE user (
    user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    name VARCHAR(255) NOT NULL UNIQUE COMMENT 'User Name',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email Address',
    password VARCHAR(255) NOT NULL COMMENT 'Password Hash',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Time'
) COMMENT='Table to store user information';
CREATE TABLE tasks (
    task_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    title VARCHAR(255) NOT NULL COMMENT 'Task Title',
    description TEXT NOT NULL COMMENT 'Task Description',
    author_id INT NOT NULL COMMENT 'Foreign Key to Users Table',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation Time',
    updated_at DATETIME COMMENT 'Updated Time',
    FOREIGN KEY (author_id) REFERENCES user(user_id) ON DELETE CASCADE
) COMMENT='Table to store tasks with reference to authors';

/*************  ✨ Codeium Command 🌟  **************/
ALTER table tasks MODIFY status BOOLEAN DEFAULT FALSE COMMENT 'Tasks status';
ALTER table tasks ADD status BOOLEAN COMMENT 'Tasks status';
/******  1e64f29a-73fd-4973-9ab0-c36ee36a5ce7  *******/