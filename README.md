███████╗██╗   ██╗██████╗ ███████╗███╗   ██╗██╗   ██╗
██╔════╝██║   ██║██╔══██╗██╔════╝████╗  ██║██║   ██║
█████╗  ██║   ██║██████╔╝█████╗  ██╔██╗ ██║██║   ██║
██╔══╝  ██║   ██║██╔══██╗██╔══╝  ██║╚██╗██║██║   ██║
███████╗╚██████╔╝██║  ██║███████╗██║ ╚████║╚██████╔╝
╚══════╝ ╚═════╝ ╚═╝  ╚═╝╚══════╝╚═╝  ╚═══╝ ╚═════╝ 
         SYDNEY OPERA HOUSE SYSTEM


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

> **Recommended Screenshot:**

* Figure 12/13 (Registration)
* Figure 14/15 (Login)

---

### 🎭 **Show Browsing & Ticket Booking**

* Dynamic show catalogue from database
* Show detail page with schedule selection
* Add-to-cart system (PHP for logged-in users, localStorage for guests)
* Member discounts (10%)
* Checkout page with form validation
* Booking confirmation page

> **Recommended Screenshots:**

* Figure 17/18/19 (Show listings)
* Figure 20–22 (Booking flow)

---

### 🍽️ **Dining & Tour Reservations**

* Reservation form with:

  * Date rules (no past dates)
  * Disabled timeslots already booked
* Reservations displayed under *My Reservations*

> **Recommended Screenshots:**

* Figure 25–26 (Dining reservation flow)

---

### 🛠️ **Account Dashboard**

Includes tabs:

* Profile
* My Bookings
* Reservations
* Membership Perks
* Settings

> **Recommended Screenshot:**

* Figure 23/24 (Bookings table)

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

> **Recommended Screenshot:**

* Any screenshot of checkout page

---

### 🧪 **Tested for Reliability**

Your project includes complete:

* Functional test cases
* Non-functional test cases
* Browser/device responsive tests

> **Recommended Screenshot:**

* Any figure showing testing (optional)

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
