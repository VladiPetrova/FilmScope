CREATE TABLE `users`(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`username` VARCHAR(30) NOT NULL,
`email` VARCHAR(50) NOT NULL,
`password` VARCHAR(255) NOT NULL,
`first_name` VARCHAR(50) NOT NULL,
`last_name` VARCHAR(50) NOT NULL,
`is_admin` BOOLEAN NOT NULL,
`register_date` DATE NOT NULL,
UNIQUE (`username`),
UNIQUE (`email`)
);

CREATE TABLE `genres`(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`genre_name` VARCHAR(100) NOT NULL,
UNIQUE (`genre_name`)
);

CREATE TABLE `movies`(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`title` VARCHAR(100) NOT NULL,
`description` TEXT NOT NULL,
`release_year` INT NOT NULL,
`poster` VARCHAR(255) NOT NULL,
`is_approved` BOOLEAN NOT NULL DEFAULT 0,
`date_added` DATE NOT NULL,
`actors` TEXT NOT NULL,
`user_id` INT UNSIGNED NOT NULL,
`genre_id` INT UNSIGNED NOT NULL,
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
FOREIGN KEY (`genre_id`) REFERENCES `genres`(`id`)
);

CREATE TABLE `reviews`(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`user_id` INT UNSIGNED NOT NULL,
`movie_id` INT UNSIGNED NOT NULL,
`review` TEXT NOT NULL,
`created_at` DATE NOT NULL,
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`)
);

CREATE TABLE `review_likes`(
`user_id` INT UNSIGNED NOT NULL,
`review_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `review_id`),
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
FOREIGN KEY (`review_id`) REFERENCES `reviews`(`id`)
);

CREATE TABLE `favourite_films`(
`user_id` INT UNSIGNED NOT NULL,
`movie_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `movie_id`),
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`)
);

CREATE TABLE `ratings`(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`movie_id` INT UNSIGNED NOT NULL,
`user_id` INT UNSIGNED NOT NULL,
`rating` TINYINT NOT NULL CHECK (`rating` BETWEEN 1 AND 10),
FOREIGN KEY (`movie_id`) REFERENCES `movies`(`id`),
FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);


INSERT INTO `genres` (`genre_name`) VALUES
('Action'),
('Adventure'),
('Comedy'),
('Drama'),
('Fantasy'),
('Horror'),
('Mystery'),
('Romance'),
('Sci-Fi'),
('Thriller'),
('Animation'),
('Documentary');
