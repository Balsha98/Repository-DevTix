DROP DATABASE IF EXISTS dev_tix;

CREATE DATABASE dev_tix;

USE dev_tix;


-- ROLES
CREATE TABLE roles (
    role_id INT NOT NULL AUTO_INCREMENT,
    role_name VARCHAR(25) NOT NULL,
    PRIMARY KEY (role_id)
);

INSERT INTO roles VALUES
(1, "Administrator"),
(2, "Assistant"),
(3, "Patron");


-- USERS
CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT,
    role_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    username VARCHAR(25) NOT NULL,
    password CHAR(64) NOT NULL,
    joined_at TIMESTAMP NULL,
    last_active TIMESTAMP NULL,
    PRIMARY KEY (user_id),
    FOREIGN KEY (role_id) REFERENCES roles (role_id)
);

INSERT INTO users (user_id, role_id, first_name, last_name, email, username, password, joined_at) VALUES
(1, 1, "Admin", "User", "admin@devtix.com", "Admin", "8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918", NOW()),
(2, 2, "Assistant", "User", "assistant@devtix.com", "Assistant", "a39a7ffad4a3013f29da97b84f264337f234c1cf9b3c40c7c30c677a8a18609a", NOW()),
(3, 3, "Patron", "User", "patron@devtix.com", "Patron", "6e753a6b0a37cd1032c991ba167cee596db9adca33162ea9e48a0ba86c4daed3", NOW());

-- SELECT * FROM users;


-- USER DETAILS
CREATE TABLE user_details (
    details_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    age INT NOT NULL,
    gender ENUM("male", "female") NULL,
    image LONGBLOB NULL,
    profession VARCHAR(50) NULL,
    country VARCHAR(50) NULL,
    state VARCHAR(50) NULL,
    city VARCHAR(50) NULL,
    zip INT NULL,
    PRIMARY KEY (details_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id)
);
