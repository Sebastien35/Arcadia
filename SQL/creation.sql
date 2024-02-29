CREATE TABLE IF NOT EXISTS 'user' (
    'id' INT AUTO INCREMENT PRIMARY KEY NOT NULL,
    'varchar' VARCHAR(255) NOT NULL
    'role' JSON NOT NULL
    'password' VARCHAR(255) NOT NULL
    'created_at' DATETIME NOT NULL
    'updated_at' DATETIME NOT NULL
    DEFAULT CHARSET=utf8
    COLLATE=`utf8_general_ci`
    ENGINE=InnoDB
)