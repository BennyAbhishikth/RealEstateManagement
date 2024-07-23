CREATE TABLE user_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    profile_picture VARCHAR(255),
    profession VARCHAR(255) NOT NULL,
    residence VARCHAR(255) NOT NULL,
    pan_number VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    status VARCHAR(255)
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);