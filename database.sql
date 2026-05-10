USE dat_phong_ks;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    sdt VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE rooms(
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(50) NOT NULL UNIQUE,
    room_type VARCHAR(50) NOT NULL,
    price DECIMAL(20,2) NOT NULL,
    img VARCHAR(255),
    status ENUM('available','booked','using')
    DEFAULT 'available'
);

CREATE TABLE bookings(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    status ENUM('pending','confirmed','cancelled')
    DEFAULT 'pending',
    total_price DECIMAL(20,2) NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(room_id) REFERENCES rooms(id)
);

CREATE TABLE bills(
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    payment_method ENUM('cash','bank_transfer')
    DEFAULT 'bank_transfer',
    amount DECIMAL(20,2) NOT NULL,
    content TEXT,
    FOREIGN KEY(booking_id)  REFERENCES bookings(id)
);