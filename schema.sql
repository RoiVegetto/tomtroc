CREATE DATABASE IF NOT EXISTS tomtroc
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE tomtroc;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(120) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  avatar VARCHAR(255) DEFAULT NULL,
  UNIQUE KEY uniq_users_username (username),
  UNIQUE KEY uniq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS books (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  photo VARCHAR(255) DEFAULT NULL,
  title VARCHAR(150) NOT NULL,
  author VARCHAR(150) NOT NULL,
  description TEXT DEFAULT NULL,
  is_available TINYINT(1) NOT NULL DEFAULT 1,
  user_id INT UNSIGNED NOT NULL,
  KEY idx_books_user_id (user_id),
  CONSTRAINT fk_books_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS conversations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user1_id INT UNSIGNED NOT NULL,
  user2_id INT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_conversations_users (user1_id, user2_id),
  KEY idx_conversations_user1 (user1_id),
  KEY idx_conversations_user2 (user2_id),
  CONSTRAINT fk_conversations_user1
    FOREIGN KEY (user1_id) REFERENCES users(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_conversations_user2
    FOREIGN KEY (user2_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  conversation_id INT UNSIGNED NOT NULL,
  sender_id INT UNSIGNED NOT NULL,
  receiver_id INT UNSIGNED NOT NULL,
  body TEXT NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY idx_messages_conversation (conversation_id),
  KEY idx_messages_receiver (receiver_id),
  CONSTRAINT fk_messages_conversation
    FOREIGN KEY (conversation_id) REFERENCES conversations(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_messages_sender
    FOREIGN KEY (sender_id) REFERENCES users(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_messages_receiver
    FOREIGN KEY (receiver_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
