-- Create the golf_courses table
CREATE TABLE golf_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    difficulty ENUM('Easy', 'Intermediate', 'Hard', 'Pro') NOT NULL,
    holes TINYINT,
    description TEXT,
    amenities TEXT,
    cost DECIMAL(10, 2),
    rating DECIMAL(3, 2),
    image_url TEXT
);

-- Create the reviews table
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    review_text TEXT,
    rating DECIMAL(3, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES golf_courses(id) ON DELETE CASCADE
);
