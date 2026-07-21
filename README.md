# Blood Donation Web App

[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4.svg)](https://www.php.net/)
[![Drupal](https://img.shields.io/badge/CMS-Drupal%2010-0678BE.svg)](https://www.drupal.org/)
[![Database](https://img.shields.io/badge/Database-MySQL/MariaDB-003B57.svg)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-GPL--2.0-green.svg)](LICENSE.txt)

> **A robust and secure web platform for managing blood donations, donors, and blood bank operations.**

---

## 📑 Table of Contents
1. [About the Project](#-about-the-project)
2. [Main Features](#-main-features)
3. [Technical Stack](#-technical-stack)
4. [Project Structure](#-project-structure)
5. [Requirements and Installation](#-requirements-and-installation)
6. [Database Configuration](#-database-configuration)
7. [Usage](#-usage)
8. [Author](#-author)
9. [License](#-license)

---

## 📌 About the Project
This project is a complete web application designed to simplify and digitize the blood donation process. It allows administrators to manage blood supplies, monitor donors, organize blood collection campaigns, and provide essential information to users.

Built with the **Drupal 10** CMS, the application benefits from a modular architecture, enhanced security features, and an intuitive administration interface.

---

## ✨ Main Features
- 👤 **Profile Management**: Registration and management of donors and medical staff accounts.
- 🩸 **Blood Stock Monitoring**: Real-time visualization of blood availability by blood group.
- 📅 **Campaign Management**: Planning and tracking of blood donation events.
- 🔔 **Notification System**: Alerts for eligible donors and critical blood stock levels.
- 🎨 **Custom Theme**: Responsive user interface adapted to the healthcare context.

---

## 🛠️ Technical Stack

| Category | Technologies Used |
| :--- | :--- |
| **Backend** | PHP 8.x, Drupal 10 |
| **Frontend** | Twig, HTML5, CSS3/SCSS, JavaScript |
| **Database** | MySQL / MariaDB |
| **Dependency Management** | Composer |
| **Web Server** | Apache (with `.htaccess`) or Nginx |

---

## 📂 Project Structure

The project follows the standard Drupal architecture:

```text
blood_donation_web_app/
│
├── core/                 # Drupal core framework (do not modify)
├── modules/              # Custom and contributed Drupal modules
├── themes/               # Custom graphical themes
├── profiles/             # Drupal installation profiles
├── vendor/               # PHP dependencies managed by Composer
├── sites/                # Site-specific configurations, files, and modules
├── drupalwebb.sql        # Database dump file
├── composer.json         # PHP dependency management file
└── README.md             # Project documentation
