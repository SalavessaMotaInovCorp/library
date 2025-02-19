# Library Management System  

This project is a **Library Management System** built with **Laravel Jetstream**, **Livewire**, and **DaisyUI**. It allows managing books, authors, and publishers, with additional features like **Google Books API integration (for admins only)**, **book previews**, **a 3D book carousel**, **book request management**, **search functionality**, **data export**, and **user authentication**.  

---

## ** Features**  

### **📖 Book Management**  
- Add, edit, delete, and view books with details like ISBN, description, cover image, and price.  
- **Google Books API Integration** – **Only admins** can search books in the external API and import them into the local database.  
- **Book Preview** – Logged-in users can preview books directly from Google Books (if available).  
- **3D Book Carousel** – Displays the latest additions dynamically with clickable covers to view book details.  

### ** Book Request System**  
- Users can **request books** from the library.  
- The system tracks **request dates, due dates, and return status**.  
- Requests must be **confirmed** by admins before they are completed.  
- The status updates automatically based on the user's interactions.  
- Users can have up to **3 active book requests** at the same time.
- Automatic emails when a book request is made, both for the user and also to all admins.
- Automatic email alert to remind the user that a book request due date is aproxing.  

### ** Search System**  
- **Citizens (Regular Users)** – Can **search for books only in the local database**.  
- **Admins** – Can **search for books both locally and in the Google Books API**. If a book is not available locally, admins can import it into the system.  
- **Optimized Performance** – The system follows a **"request on demand"** model to avoid unnecessary API calls and improve efficiency.  

### ** Authors & Publishers Management**  
- Manage authors, including their names and photos.  
- Add and edit publishers with logo support.  
- Many-to-Many Relationship – Books can have multiple authors.  

### ** Data Export & Authentication**  
- Export books, authors, and publishers data to Excel format.  
- Secure login, registration, and session management using **Laravel Jetstream**.  
- **Fully Responsive UI** – Designed with **DaisyUI & TailwindCSS** for a seamless experience on all devices.  

---

## ** Technologies Used**  
- **Laravel Jetstream** (Livewire for interactivity)  
- **DaisyUI** (Tailwind CSS Components)  
- **MySQL** (or any supported database)  
- **Google Books API** (for external book search & preview – Admins Only)  
- **Maatwebsite/Laravel-Excel** (for data export)  
- **Rappasoft Laravel Livewire Tables** (for dynamic data tables)  

---

## ** Database Structure**  

### **Books, Authors & Publishers**  
- **Authors:** `id`, `name`, `photo`  
- **Books:** `id`, `isbn`, `name`, `publisher_id`, `description`, `cover_image`, `price`  
- **Publishers:** `id`, `name`, `logo`  
- **Pivot Table:** `author_book` (for many-to-many relationships)  

### **Book Requests**  
- **Users can request books from the library.**  
- **Table Schema:**  
  - `id`, `user_id`, `book_id`  
  - `user_name`, `user_email`  
  - `request_date`, `due_date`, `return_date` (nullable)  
  - `is_returned` (boolean), `is_confirmed` (boolean)  
  - `confirmed_at` (timestamp, nullable)  
  - `status` (enum: `active`, `pending_return_confirm`, `returned`)  
  - `total_request_days` (integer, default: 1)  
  - `timestamps`  

---

## ** Data Export**  
Export data as Excel files:  
- `/books/export`  
- `/authors/export`  
- `/publishers/export`  

---

## ** How It Works**  

1️⃣ **Users search for books**  
   - **Regular users** can only search in the **local database**.  
   - **Admins** can search both **locally** and in the **Google Books API**.  

2️⃣ **Admins import books from the Google Books API**  
   - If a book is missing from the local database, an **admin** can request it from the **Google Books API** and import it.  

3️⃣ **Users view book details**  
   - Books contain detailed information, including **cover, authors, publisher, and description**.  

4️⃣ **Preview books**  
   - If a preview is available via Google Books API, **logged-in users** can read a sample.  

5️⃣ **Users request books**  
   - Users can **request books from the library**, track their request status, and manage their borrowing history.  

6️⃣ **3D Rotating Carousel**  
   - A **3D rotating display** showcases the latest books added to the library dynamically.  

---

## ** Summary of Recent Updates**  

**Google Books API Integration (Admins Only)** – Admins can now search, preview, and import books dynamically.  
**3D Carousel** – Displays the latest books in an interactive rotating display.  
**Book Preview Feature** – Logged-in users can read excerpts from books directly via the Google API.  
**Book Request System** – Users can request books and manage their borrowing history.  

This version introduces **API-powered book management, interactive visuals, and real-world API integration logic**, making it **one of the most complete updates so far**!   

---
