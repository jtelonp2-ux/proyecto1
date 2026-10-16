CREATE DATABASE IF NOT EXISTS organizador
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE organizador;

CREATE TABLE IF NOT EXISTS users (
    activation_token VARCHAR(64) NULL,
    remember_token VARCHAR(64) NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 0,
    administrator TINYINT(1) NOT NULL DEFAULT 0,
    photo VARCHAR(255) NULL,
    activation_token VARCHAR(64) NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL    
);

CREATE TABLE IF NOT EXISTS tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);