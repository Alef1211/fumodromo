-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS quit_smoking;
USE quit_smoking;

-- Tabela de usuários
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    quit_date DATETIME NOT NULL,
    cigarettes_per_day INT NOT NULL,
    pack_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de recaídas
CREATE TABLE relapses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    relapse_date DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
