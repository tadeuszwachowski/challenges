CREATE DATABASE IF NOT EXISTS race_condition_db;

USE race_condition_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    tickets INT DEFAULT 0
);

INSERT INTO users (session_id) VALUES ('4d8c1d5bc58eeb45489bc58d70647fbb');
