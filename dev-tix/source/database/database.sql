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
    view_as_user_id INT NOT NULL,
    role_id INT NOT NULL,
    view_as_role_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    username VARCHAR(25) NOT NULL,
    password CHAR(64) NOT NULL,
    joined_at TIMESTAMP NOT NULL,
    last_active TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id),
    FOREIGN KEY (role_id) REFERENCES roles (role_id)
);

INSERT INTO users (user_id, view_as_user_id, role_id, view_as_role_id, first_name, last_name, email, username, password, joined_at) VALUES
(1, 1, 1, 1, "Admin", "User", "admin@devtix.com", "Administrator", "8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918", NOW());
-- (2, 2, 2, 2, "Assistant1", "User", "assistant1@devtix.com", "Assistant1", "a39a7ffad4a3013f29da97b84f264337f234c1cf9b3c40c7c30c677a8a18609a", NOW()),
-- (3, 3, 2, 2, "Assistant2", "User", "assistant2@devtix.com", "Assistant2", "a39a7ffad4a3013f29da97b84f264337f234c1cf9b3c40c7c30c677a8a18609a", NOW()),
-- (4, 4, 2, 2, "Assistant3", "User", "assistant3@devtix.com", "Assistant3", "a39a7ffad4a3013f29da97b84f264337f234c1cf9b3c40c7c30c677a8a18609a", NOW()),
-- (5, 5, 3, 3, "Patron1", "User", "patron1@devtix.com", "Patron1", "6e753a6b0a37cd1032c991ba167cee596db9adca33162ea9e48a0ba86c4daed3", NOW()),
-- (6, 6, 3, 3, "Patron2", "User", "patron2@devtix.com", "Patron2", "6e753a6b0a37cd1032c991ba167cee596db9adca33162ea9e48a0ba86c4daed3", NOW());

-- SELECT * FROM users;


-- USER DETAILS
CREATE TABLE user_details (
    details_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    bio TEXT NULL,
    age INT NULL,
    gender ENUM("male", "female") NULL,
    profession VARCHAR(50) NULL,
    user_image LONGBLOB NULL,
    user_image_type VARCHAR(10) NULL,
    country VARCHAR(50) NULL,
    city VARCHAR(50) NULL,
    zip INT NULL,
    PRIMARY KEY (details_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) 
        ON DELETE CASCADE
);

INSERT INTO user_details (details_id, user_id, age, gender) VALUES 
(1, 1, NULL, NULL);
-- (2, 2, NULL, NULL),
-- (3, 3, NULL, NULL),
-- (4, 4, NULL, NULL),
-- (5, 5, NULL, NULL),
-- (6, 6, NULL, NULL);

-- SELECT * FROM user_details;


-- TICKET REQUESTS
CREATE TABLE ticket_requests (
    request_id INT NOT NULL AUTO_INCREMENT,
    patron_id INT NOT NULL,
    assistant_id INT NULL,
    type VARCHAR(50) NOT NULL,
    subject VARCHAR(50) NOT NULL,
    question TEXT NOT NULL,
    posted_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM("unassigned", "pending", "resolved", "cancelled") NOT NULL DEFAULT "unassigned",
    turn_id INT NULL DEFAULT 0,
    PRIMARY KEY (request_id),
    FOREIGN KEY (patron_id) REFERENCES users (user_id) 
        ON DELETE CASCADE,
    FOREIGN KEY (assistant_id) REFERENCES users (user_id) 
        ON DELETE SET NULL
);

-- INSERT INTO ticket_requests (request_id, patron_id, assistant_id, type, subject, question, status, turn_id) VALUES
-- (1, 5, NULL, "Frontend", "Web Development", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "unassigned", 0),
-- (2, 5, NULL, "Frontend", "Web Development", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "unassigned", 0),
-- (3, 5, NULL, "Frontend", "Web Development", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "unassigned", 0),
-- (4, 5, NULL, "Frontend", "Web Development", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "unassigned", 0),
-- (5, 5, NULL, "Frontend", "Web Development", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "unassigned", 0),
-- (6, 5, NULL, "Frontend", "Web Development", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "unassigned", 0);

-- SELECT * FROM ticket_requests;


-- TICKET IMAGES
CREATE TABLE request_images (
    request_image_id INT NOT NULL AUTO_INCREMENT,
    request_id INT NOT NULL,
    request_image LONGBLOB NOT NULL,
    request_image_type VARCHAR(10),
    PRIMARY KEY (request_image_id),
    FOREIGN KEY (request_id) REFERENCES ticket_requests (request_id) 
        ON DELETE CASCADE
);

-- SELECT * FROM request_images;


-- TICKET RESPONSES
CREATE TABLE ticket_responses (
    response_id INT NOT NULL AUTO_INCREMENT,
    request_id INT NOT NULL,
    user_id INT NOT NULL,
    response TEXT NOT NULL,
    posted_at TIMESTAMP NOT NULL,
    PRIMARY KEY (response_id),
    FOREIGN KEY (request_id) REFERENCES ticket_requests (request_id) 
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (user_id) 
        ON DELETE CASCADE
);


-- LEAGUES
CREATE TABLE leagues (
    league_id INT NOT NULL AUTO_INCREMENT,
    league_name VARCHAR(25) NOT NULL,
    PRIMARY KEY (league_id)
);

INSERT INTO leagues (league_id, league_name) VALUES 
(1, "Legendary"),
(2, "Senior"),
(3, "Junior"),
(4, "Rookie");


-- LEADERBOARDS
CREATE TABLE leaderboards (
    leaderboard_id INT NOT NULL AUTO_INCREMENT,
    league_id INT NOT NULL,
    assistant_id INT NOT NULL UNIQUE,
    resolved_tickets INT NOT NULL,
    PRIMARY KEY (leaderboard_id),
    FOREIGN KEY (league_id) REFERENCES leagues (league_id)
        ON DELETE CASCADE,
    FOREIGN KEY (assistant_id) REFERENCES users (user_id) 
        ON DELETE CASCADE
);

-- SELECT * FROM leaderboards;


-- NOTIFICATIONS
CREATE TABLE notifications (
    notification_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    type ENUM("signup", "profile", "request", "response", "league") NOT NULL,
    title VARCHAR(50) NOT NULL,
    message VARCHAR(100) NOT NULL,
    is_read INT NULL DEFAULT 0,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (notification_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) 
        ON DELETE CASCADE
);

-- INSERT INTO notifications (notification_id, user_id, type, title, message) VALUES
-- (1, 2, "signup", "Welcome To DevTix", "You have successfully made an account."),
-- (2, 3, "signup", "Welcome To DevTix", "You have successfully made an account."),
-- (3, 4, "signup", "Welcome To DevTix", "You have successfully made an account."),
-- (4, 5, "signup", "Welcome To DevTix", "You have successfully made an account."),
-- (5, 6, "signup", "Welcome To DevTix", "You have successfully made an account.");

-- SELECT * FROM notifications;


-- NEWSLETTERS
CREATE TABLE newsletters (
    newsletter_id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    activated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (newsletter_id)
);


-- LOGS
CREATE TABLE logs (
    log_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    type ENUM("signup", "login", "profile", "request", "response", "client") NOT NULL,
    title VARCHAR(50) NOT NULL,
    message VARCHAR(100) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (log_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) 
        ON DELETE CASCADE
);
