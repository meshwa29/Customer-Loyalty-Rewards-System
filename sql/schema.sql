CREATE DATABASE IF NOT EXISTS loyalty_rewards CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE loyalty_rewards;
CREATE TABLE IF NOT EXISTS admins (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE, password_hash VARCHAR(255) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS customers (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE, phone VARCHAR(30) NULL,
 password_hash VARCHAR(255) NOT NULL, points INT NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS product_codes (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, code CHAR(12) NOT NULL UNIQUE,
 status ENUM('active','redeemed','disabled') NOT NULL DEFAULT 'active',
 customer_id INT UNSIGNED NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 redeemed_at DATETIME NULL,
 CONSTRAINT fk_code_customer FOREIGN KEY(customer_id) REFERENCES customers(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS points_ledger (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, customer_id INT UNSIGNED NOT NULL,
 points INT NOT NULL, entry_type ENUM('earned','spent','adjustment') NOT NULL,
 description VARCHAR(255) NOT NULL, reference_code_id BIGINT UNSIGNED NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_ledger_customer FOREIGN KEY(customer_id) REFERENCES customers(id),
 CONSTRAINT fk_ledger_code FOREIGN KEY(reference_code_id) REFERENCES product_codes(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS rewards (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL,
 description TEXT NULL, points_required INT UNSIGNED NOT NULL,
 active TINYINT(1) NOT NULL DEFAULT 1, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS reward_redemptions (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, customer_id INT UNSIGNED NOT NULL,
 reward_id INT UNSIGNED NOT NULL, points_spent INT UNSIGNED NOT NULL,
 status ENUM('pending','approved','fulfilled','rejected') NOT NULL DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_rr_customer FOREIGN KEY(customer_id) REFERENCES customers(id),
 CONSTRAINT fk_rr_reward FOREIGN KEY(reward_id) REFERENCES rewards(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS redemption_attempts (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, customer_id INT UNSIGNED NOT NULL,
 ip_address VARCHAR(45) NOT NULL, attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_attempt_customer_time(customer_id,attempted_at),
 CONSTRAINT fk_attempt_customer FOREIGN KEY(customer_id) REFERENCES customers(id)
) ENGINE=InnoDB;
INSERT INTO rewards(name,description,points_required) VALUES
('Factory merchandise','A branded gift from the factory.',100),
('Discount voucher','A discount voucher for a future purchase.',200),
('Premium gift box','A premium gift selected by the factory.',500);
