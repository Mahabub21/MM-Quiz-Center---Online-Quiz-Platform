# 🎯 MM Quiz Center - Online Quiz Platform

![Quiz Platform](https://img.shields.io/badge/Quiz-Platform-brightgreen?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## 📋 Table of Contents
- [🌟 Overview](#-overview)
- [✨ Features](#-features)
- [🛠️ Technology Stack](#️-technology-stack)
- [📂 Project Structure](#-project-structure)
- [⚙️ Installation](#️-installation)
- [🔧 Configuration](#-configuration)
- [🚀 Usage](#-usage)
- [👥 User Roles](#-user-roles)
- [📱 Responsive Design](#-responsive-design)
- [🔒 Security Features](#-security-features)
- [📸 Screenshots](#-screenshots)
- [🤝 Contributing](#-contributing)
- [📞 Contact](#-contact)
- [📄 License](#-license)

## 🌟 Overview

**MM Quiz Center** is a comprehensive online quiz platform designed to provide an engaging and interactive learning experience. The platform allows users to take quizzes across various categories while administrators can manage content, track user progress, and maintain the system efficiently.

### 🎯 Mission
> "TEST YOUR WITS, LEARN WITH FUN!" - Our mission is to make learning enjoyable and accessible through interactive quizzes that challenge and educate users.

## ✨ Features

### 👤 User Features
- 🔐 **User Authentication** - Secure registration and login system
- 👤 **Profile Management** - Edit profile, upload profile pictures
- 📝 **Take Quizzes** - Interactive quiz-taking experience with time limits
- 📊 **Results Tracking** - View detailed quiz results and performance history
- 💬 **Feedback System** - Submit feedback and receive admin responses
- 🔄 **Password Recovery** - Forgot password functionality
- 📱 **Responsive Dashboard** - Mobile-friendly user interface

### 👨‍💼 Admin Features
- 🏠 **Admin Dashboard** - Comprehensive overview of platform statistics
- 👥 **User Management** - View, manage, and monitor user accounts
- 📚 **Category Management** - Create and manage quiz categories
- 📝 **Exam Management** - Create, edit, and delete exams
- ❓ **Question Management** - Add questions with multiple choice options
- 📊 **Results Overview** - Monitor user performance and exam statistics
- 💬 **Feedback Management** - Review and respond to user feedback
- 🗑️ **Content Moderation** - Delete inappropriate content

### 🔧 System Features
- 🔒 **Secure Authentication** - Password hashing and session management
- 📱 **Responsive Design** - Works seamlessly on all device sizes
- ⚡ **Real-time Updates** - Dynamic content loading
- 🎨 **Modern UI/UX** - Clean and intuitive interface design
- 📊 **Analytics** - Track user engagement and performance metrics

## 🛠️ Technology Stack

### Backend
- **PHP** 🐘 - Server-side scripting language
- **MySQL** 🗃️ - Relational database management
- **PDO** 🔗 - PHP Data Objects for database interaction

### Frontend
- **HTML5** 📄 - Semantic markup
- **CSS3** 🎨 - Modern styling with gradients and animations
- **JavaScript** ⚡ - Interactive functionality
- **Font Awesome** 🎯 - Icon library

### Development Tools
- **phpMyAdmin** 🔧 - Database administration
- **XAMPP/WAMP** 🖥️ - Local development environment

## 📂 Project Structure

```
📁 QUIZ/
├── 📄 index.php                 # Landing page
├── 📄 platform.sql             # Database schema
├── 📄 styles.css               # Main stylesheet
├── 📄 README.md                # Project documentation
├── 📁 admin/                   # Admin panel
│   ├── 📄 admin.php            # Admin dashboard
│   ├── 📄 admin_upload.php     # File upload management
│   ├── 📄 categories_dashboard.php # Category management
│   ├── 📄 exam.php             # Exam management
│   ├── 📄 feedback.php         # Feedback management
│   ├── 📄 user_management.php  # User administration
│   ├── 📄 results_overview.php # Results analytics
│   └── 📄 style3.css           # Admin panel styles
├── 📁 file1/                   # Authentication system
│   ├── 📄 config.php           # Database configuration
│   ├── 📄 login.php            # User login
│   ├── 📄 register-login.php   # User registration
│   ├── 📄 process.php          # Form processing
│   └── 📄 logout.php           # Session termination
├── 📁 forgot_password/         # Password recovery
│   ├── 📄 forgot_password.php  # Password reset request
│   └── 📄 reset_password.php   # Password reset form
├── 📁 user/                    # User dashboard
│   ├── 📄 user-dashboard.php   # User home page
│   ├── 📄 profile.php          # Profile management
│   ├── 📄 take_exam.php        # Quiz interface
│   ├── 📄 exam_result.php      # Result display
│   ├── 📄 user_feedback.php    # Feedback submission
│   └── 📁 uploads/             # User profile pictures
└── 📁 photo/                   # Static images and logos
```

## ⚙️ Installation

### Prerequisites
- 🖥️ Web server (Apache/Nginx)
- 🐘 PHP 7.4 or higher
- 🗃️ MySQL 5.7 or higher
- 🌐 Modern web browser

### Step-by-Step Installation

1. **📥 Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/mm-quiz-center.git
   cd mm-quiz-center
   ```

2. **🗃️ Setup Database**
   - Create a new MySQL database named `platform`
   - Import the provided SQL file:
   ```sql
   mysql -u root -p platform < platform.sql
   ```

3. **⚙️ Configure Database Connection**
   - Edit `file1/config.php`:
   ```php
   <?php
   $host = 'localhost';
   $db = 'platform';
   $user = 'your_username';
   $pass = 'your_password';
   ?>
   ```

4. **📁 Set Permissions**
   ```bash
   chmod 755 user/uploads/
   chmod 755 photo/
   ```

5. **🚀 Launch Application**
   - Start your web server
   - Navigate to `http://localhost/quiz/`

## 🔧 Configuration

### Database Configuration
Update the database connection settings in `file1/config.php`:

```php
$host = 'localhost';        // Database host
$db = 'platform';          // Database name
$user = 'root';            // Database username
$pass = '';                // Database password
```

### Admin Account Setup
Default admin credentials:
- **Email:** `admin@gmail.com`
- **Password:** `admin123` (Change immediately after first login)

### File Upload Settings
- **Profile Pictures:** `user/uploads/`
- **Maximum File Size:** 2MB
- **Allowed Formats:** JPG, JPEG, PNG, GIF

## 🚀 Usage

### For Students/Users 👨‍🎓

1. **Registration** 📝
   - Visit the homepage
   - Click on "Register" 
   - Fill in required details
   - Upload profile picture (optional)

2. **Taking Quizzes** 📚
   - Login to your account
   - Browse available categories
   - Select an exam
   - Answer questions within time limits
   - Submit and view results

3. **Profile Management** ⚙️
   - Edit personal information
   - Change profile picture
   - View quiz history

### For Administrators 👨‍💼

1. **Dashboard Access** 🏠
   - Login with admin credentials
   - View platform statistics
   - Monitor user activity

2. **Content Management** 📝
   - Create quiz categories
   - Add new exams
   - Input questions with multiple choices
   - Set time limits

3. **User Management** 👥
   - View registered users
   - Monitor user performance
   - Manage user accounts

## 👥 User Roles

### 🎓 Student/User
- Take quizzes and exams
- View personal results
- Submit feedback
- Manage profile

### 👨‍💼 Administrator
- Full system access
- Content management
- User administration
- Analytics and reporting

## 📱 Responsive Design

The platform is fully responsive and optimized for:
- 🖥️ **Desktop** - Full-featured experience
- 📱 **Mobile** - Touch-friendly interface
- 📟 **Tablet** - Optimized layout

## 🔒 Security Features

- 🔐 **Password Hashing** - Secure bcrypt encryption
- 🛡️ **SQL Injection Prevention** - Prepared statements
- 🔒 **Session Management** - Secure session handling
- 🚫 **CSRF Protection** - Cross-site request forgery prevention
- 📝 **Input Validation** - Server-side data validation

## 📸 Screenshots

### 🏠 Homepage
Beautiful landing page with modern design and clear navigation.

### 📊 Admin Dashboard
Comprehensive overview with statistics and quick access to management tools.

### 📝 Quiz Interface
Clean and intuitive quiz-taking experience with timer functionality.

### 👤 User Profile
Personalized dashboard with performance tracking and profile management.

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. 🍴 Fork the repository
2. 🌿 Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. 💾 Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. 📤 Push to the branch (`git push origin feature/AmazingFeature`)
5. 🔄 Open a Pull Request

### 📋 Contribution Guidelines
- Follow PHP PSR-12 coding standards
- Write clear commit messages
- Add comments for complex logic
- Test thoroughly before submitting

## 📞 Contact

### 🏢 MM Quiz Center
- 📍 **Address:** 159/18/A-1 West Shawrapara, Mirpur, Dhaka 1216
- 📞 **Phone:** (+880) 0107141820
- 📧 **Email:** info@mmquizcenter.com

### 🌐 Social Media
- 📘 [Facebook](https://facebook.com/mmquizcenter)
- 🐦 [Twitter](https://twitter.com/mmquizcenter)
- 📷 [Instagram](https://instagram.com/mmquizcenter)
- 💼 [LinkedIn](https://linkedin.com/company/mmquizcenter)

### 📱 Mobile Apps
- 🍎 [Download on App Store](https://www.apple.com/app-store/)
- 🤖 [Get it on Google Play](https://play.google.com/store)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

### 🌟 Made with ❤️ by MM Quiz Center Team

**© 2023 MM Quiz Center. All Rights Reserved.**

---

### 🚀 Quick Start Commands

```bash
# Clone the repository
git clone https://github.com/yourusername/mm-quiz-center.git

# Setup database
mysql -u root -p platform < platform.sql

# Start local server
php -S localhost:8000
```

### 🔗 Useful Links
- [📚 Documentation](docs/)
- [🐛 Report Issues](issues/)
- [💡 Feature Requests](issues/new)
- [📖 Wiki](wiki/)

---

*Happy Learning! 🎓✨*