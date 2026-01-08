🏦 Banking System (PHP & MySQL)

A simple Online Banking System built using PHP, MySQL, HTML, CSS, and JavaScript.
This project allows users to register, log in, manage their profile, and perform basic banking operations like deposits, withdrawals, and money transfers.

🚀 Features

🔐 User Authentication (Register & Login)
👤 User Profile Management
💰 Deposit Money
💸 Withdraw Money
🔄 Transfer Money Between Users
📊 Dashboard with Account Details
🛡️ Secure Password Hashing
📱 Responsive & Animated UI

🛠️ Technologies Used
Frontend: HTML, CSS, JavaScript
Backend: PHP
Database: MySQL
Server: XAMPP / WAMP / LAMP

Version Control: Git & GitHub

📂 Project Structure
banking-system/
│
├── index.php          # Login Page
├── register.php       # Registration Page
├── dashboard.php      # User Dashboard
├── profile.php        # User Profile
├── deposit.php        # Deposit Money
├── withdraw.php       # Withdraw Money
├── transfer.php       # Transfer Money
│
├── bank_db.sql    # Database File
│
├── config/
│   └── db.php         # Database Connection
│
├── css/
│   └──  style.css  # Main CSS File
├── js/
│   └──  script.js  # JavaScript
│
└── README.md

⚙️ Installation & Setup
Clone the Repository
git clone https://github.com/akshdeepsingh14/banking-system.git


Move Project to Server Folder
C:/xampp/htdocs/banking-system

Create Database
Open phpMyAdmin
Create a database named:
bank_db
Import bank_db.sql from the database folder

Configure Database
Edit config/db.php:

$conn = mysqli_connect("localhost", "root", "", "bank_db");


Run the Project
Open browser and go to:
http://localhost/banking-system

🔑 Default User Flow
Register a new account
Login with email & password
Access dashboard
Deposit / Withdraw / Transfer money
Logout securely

❗ Security Notes
Passwords are stored using password_hash()
Session-based authentication is used
Input validation is implemented (basic)

🎯 Future Improvements
Transaction history
Admin panel
Email verification
OTP-based transfers
Better security (CSRF, prepared statements)

👨‍💻 Author
Akshdeep Singh

GitHub: https://github.com/akshdeepsingh14

📜 License
This project is for educational purposes only.
Feel free to use and modify it.

