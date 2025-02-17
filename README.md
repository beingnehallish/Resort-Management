# Resort Management System

## Project Overview
The **Resort Management System** is a web-based application developed using **PHP**, **MySQL**, and **PHPMyAdmin**, with **XAMPP** used as the local development environment. This system helps streamline the management of a resort, including booking reservations, managing customers, handling payments, and overseeing room availability.

## Technologies Used
- **PHP**: Server-side scripting for handling logic.
- **MySQL**: Database management.
- **PHPMyAdmin**: Web-based database management tool.
- **XAMPP**: Local web server for hosting the project.

## Features
- User Authentication (Admin and Customer Login)
- Room Booking and Availability Management
- Payment and Invoice Management
- Customer Profile Management
- Admin Dashboard for Resort Operations
- Reports and Data Analytics

## Installation Guide

### Step 1: Install XAMPP
Download and install [XAMPP](https://www.apachefriends.org/) based on your operating system.

### Step 2: Clone the Repository
```sh
git clone https://github.com/your-username/Resort-Management.git
```
Or manually download and extract the project files into the `htdocs` folder inside the XAMPP directory.

### Step 3: Setup the Database
1. Start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Open [PHPMyAdmin](http://localhost/phpmyadmin/).
3. Create a new database named `resort_management`.
4. Import the SQL file located in `database/resort_management.sql`.

### Step 4: Configure Database Connection
Edit `config.php` and update the following:
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resort_management";
```

### Step 5: Run the Application
1. Open a web browser and go to:
   ```
   http://localhost/Resort-Management/
   ```
2. Login using the default credentials (if applicable):
   - **Admin:** Username: `admin` | Password: `admin123`
   - **Customer:** Sign up via the registration page.

## Folder Structure
```
Resort-Management/
│── assets/            # CSS, JavaScript, and images
│── database/          # Database SQL file
│── includes/          # Configuration and helper files
│── pages/             # Main application pages
│── index.php          # Homepage
│── config.php         # Database connection file
│── README.md          # Documentation
```

## Future Enhancements
- Online Payment Integration
- Mobile-Friendly UI
- Automated Email Confirmations

## License
This project is open-source and available under the MIT License.


