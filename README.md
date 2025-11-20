# 📘 Sydney Opera House Booking System

🔰 Badges
<p> <img src="https://img.shields.io/badge/Status-Complete-brightgreen?style=flat-square"> <img src="https://img.shields.io/badge/Frontend-HTML%2FCSS%2FJS-blue?style=flat-square"> <img src="https://img.shields.io/badge/Backend-PHP-orange?style=flat-square"> <img src="https://img.shields.io/badge/Database-MySQL-red?style=flat-square"> <img src="https://img.shields.io/badge/Security-Validated-green?style=flat-square"> <img src="https://img.shields.io/badge/Responsive-Yes-9cf?style=flat-square"> <img src="https://img.shields.io/badge/License-Academic-lightgrey?style=flat-square"> </p>

## 📄 Overview

The **Sydney Opera House Booking System** is a full-stack web application that allows users to browse shows, book tickets, reserve dining/private events, manage bookings, and explore tours/experiences.
It is built with **HTML5, CSS, JavaScript, PHP, and MySQL** 

The system features:

* Dynamic show listings
* Secure user registration/login
* Add-to-cart & checkout flow
* Show booking & confirmation
* Dining reservation module
* Account dashboard
* Calendar with clickable show dates
* Tailwind-powered AI-style recommendations page

---

## 🚀 Features

### 🔐 **User Authentication**

* Registration with validation
* Login with password hashing
* Session-based access control
* Profile editing & password change

<img width="452" height="234" alt="image" src="https://github.com/user-attachments/assets/cb046f6c-c7f4-404a-9a61-2e1f7d770a0b" />

<img width="452" height="238" alt="image" src="https://github.com/user-attachments/assets/55681295-86f8-4f35-9666-46beffb90ddb" />

---

### 🎭 **Show Browsing & Ticket Booking**

* Dynamic show catalogue from database
* Show detail page with schedule selection
* Add-to-cart system (PHP for logged-in users, localStorage for guests)
* Member discounts (10%)
* Checkout page with form validation
* Booking confirmation page

<img width="452" height="245" alt="image" src="https://github.com/user-attachments/assets/817622c1-78a3-4764-a75a-0b2d1c8d53f1" />
<img width="452" height="246" alt="image" src="https://github.com/user-attachments/assets/3eac9dae-eef2-4edf-8beb-e3be6accc751" />

---

### 🍽️ **Dining & Tour Reservations**

* Reservation form with:

  * Date rules (no past dates)
  * Disabled timeslots already booked
* Reservations displayed under *My Reservations*

<img width="452" height="217" alt="image" src="https://github.com/user-attachments/assets/8ae6d274-9838-4e7a-96f5-34cc204c39a2" />
<img width="452" height="195" alt="image" src="https://github.com/user-attachments/assets/0f7f4a96-1343-4099-b174-6e866ed286b1" />
---

### 🛠️ **Account Dashboard**

Includes tabs:

* Profile
* My Bookings
* Reservations
* Membership Perks
* Settings

<img width="452" height="238" alt="image" src="https://github.com/user-attachments/assets/820029b4-68c8-4f9d-85df-bbd45d1aa1e2" />

---

### 📅 **Interactive Events Calendar**

* Highlights days with shows
* Clicking a date deep-links to relevant show
* Fully dynamic month switching

---

### 💳 **Checkout System**

* Validates card number, expiry & CVV
* Calculates totals + member discount
* Clears cart upon success
* Stores order & order_items in MySQL

<img width="451" height="131" alt="image" src="https://github.com/user-attachments/assets/673e4f99-e852-4152-816b-ab3c17dcce81" />
---

### 🧪 **Tested for Reliability**

Your project includes complete:

* Functional test cases
* Non-functional test cases
* Browser/device responsive tests

---

## 🗂️ Tech Stack

| Area         | Technologies                                  |
| ------------ | --------------------------------------------- |
| Frontend     | HTML5, CSS3, JavaScript                       |
| Backend      | PHP (procedural)                              |
| Database     | MySQL (XAMPP / phpMyAdmin)                    |
| Storage      | PHP Sessions + LocalStorage (for guest carts) |
| Enhancements | Tailwind CSS (only for Recommends page)       |

---

## 📌 System Architecture

### **Core Components**

* `/index.php` – Homepage
* `/shows.php` – Show catalogue
* `/experiences.php` – Tours/Dining/Calendar
* `/carts.php` – Cart system
* `/checkout.php` – Checkout processor
* `/confirmation.php` – Booking summary
* `/account.php` – All user data & bookings
* `/reservation.php` – Dining reservation handler

### **Database Entities**

✔ users
✔ shows
✔ orders
✔ order_items
✔ cart_items
✔ reservations
✔ payments

> **Recommended Screenshot:**

* ERD diagram section in your report

---

## 📌 Conclusion

The **Sydney Opera House Booking System** is a fully functional booking web application demonstrating strong understanding of:

* Secure authentication
* Database-driven dynamic content
* Form validation (client + server)
* Cart & Checkout flow
* Reservations module
* Scalable architecture
* UX/UI design principles

It is stable, modular, extendable, and ready for real implementation or future enhancements like payment APIs and admin dashboards.
