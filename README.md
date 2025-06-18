# FilmScope — Movie Review Website

**FilmScope** is a movie review website that allows users to add and rate movies, write and like reviews, and manage their personal profiles. The project includes an admin system with functionality to approve new movie submissions and delete user content.

---

## Key Features

- **User Registration and Login**
- **Add and Browse Movies**
- **Write and Like Reviews**
- **Rate Movies from 1 to 10**
- **Add Movies to Favorites**
- **User Profile and Settings**
- **Admin Panel for Movie Approval and Review Moderation**
- **Guests Can View Movies but Cannot Comment or Rate**

---

## Technologies Used

- **PHP**  
- **MySQL**  
- **HTML / CSS / JavaScript**  
- **Additional Features:**
  - Review pagination
---

## 🗄️ Database Structure

- `users` – Stores name, email, password, profile picture, role (admin(1)/user(0))
- `movies` – Stores title, description, year, actors, genre, approval status
- `reviews` – Stores user  linked reviews 
- `ratings` – Stores user ratings for movies (1–10)
- `review_Likes` – Stores likes for reviews
- `favourite_films` – Stores user favourite movies
- `genres` – Stores genres

---

## Installation and Setup


### 1. Clone the repository using git clone.

### 2. Open the file db_config.php from the project directory. Copy all SQL statements provided in the file. Go to your preferred MySQL interface.

### 3. Create a database named FilmScope. Paste and execute the SQL code from db_config.php to create all necessary tables.

### 4. Find the file config.example.php in the config_bd directory. Rename it to config.php.

### 5. Open the config.php file and replace the placeholder values with your actual database information.

### 6. Give folder "assets/img" full permissions.

