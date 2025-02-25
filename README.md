# Library Management System

This project is a **Library Management System** built with **Laravel Jetstream**, **Livewire**, and **DaisyUI**. It allows managing books, authors, and publishers, with additional features like **Google Books API integration (for admins only)**, **book previews**, **a 3D book carousel**, **book request management**, **search functionality**, **data export**, **user authentication**, and **e-commerce capabilities** such as **shopping cart, order management, and Stripe payments**.

---  

## **Features**

### **Book Management**
- Add, edit, delete, and view books with details like ISBN, description, cover image, and price.
- **Google Books API Integration** – **Only admins** can search books in the external API and import them into the local database.
- **Book Preview** – Logged-in users can preview books directly from Google Books (if available).
- **3D Book Carousel** – Displays the latest additions dynamically with clickable covers to view book details.

### **Book Request System**
- Users can **request books** from the library.
- The system tracks **request dates, due dates, and return status**.
- Requests must be **confirmed** by admins before they are completed.
- The status updates automatically based on the user's interactions.
- Users can have up to **3 active book requests** at the same time.
- Automatic emails when a book request is made, both for the user and also to all admins.
- Automatic email alert to remind the user that a book request due date is approaching.

### **Search System**
- **Citizens (Regular Users)** – Can **search for books only in the local database**.
- **Admins** – Can **search for books both locally and in the Google Books API**. If a book is not available locally, admins can import it into the system.
- **Optimized Performance** – The system follows a **"request on demand"** model to avoid unnecessary API calls and improve efficiency.

### **Authors & Publishers Management**
- Manage authors, including their names and photos.
- Add and edit publishers with logo support.
- Many-to-Many Relationship – Books can have multiple authors.

### **E-Commerce: Shopping Cart & Orders**
- **Shopping Cart** – Users can add books to their cart before purchasing.
- **Checkout Process** – Users proceed to checkout where they confirm their order details.
- **Payment Processing with Stripe** – Secure transactions handled via Stripe.
- **Order Management (Admin Panel)** – Admins can view a list of all orders, including:
    - **Pending Payments**
    - **Completed Orders**

### **Data Export & Authentication**
- Export books, authors, and publishers data to Excel format.
- Secure login, registration, and session management using **Laravel Jetstream**.
- **Fully Responsive UI** – Designed with **DaisyUI & TailwindCSS** for a seamless experience on all devices.

---  

## **Technologies Used**
- **Laravel Jetstream** (Livewire for interactivity)
- **DaisyUI** (Tailwind CSS Components)
- **MySQL** (or any supported database)
- **Google Books API** (for external book search & preview – Admins Only)
- **Maatwebsite/Laravel-Excel** (for data export)
- **Rappasoft Laravel Livewire Tables** (for dynamic data tables)
- **Stripe API** (for payment processing)

---  

## **How It Works**

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

6️⃣ **Users can add books to their shopping cart**
- Books can be added to a cart for purchase.
- The cart displays book details, total price, and allows users to remove items.

7️⃣ **Checkout & Payment with Stripe**
- Users confirm their order and proceed with payment via Stripe.
- Upon successful payment, an order confirmation email is sent.

8️⃣ **Admins manage orders**
- Admins have an order management section to track pending and completed payments.

9️⃣ **3D Rotating Carousel**
- A **3D rotating display** showcases the latest books added to the library dynamically.

---  

## **Summary of Recent Updates**

**Shopping Cart & Checkout** – Users can now add books to a cart and purchase them directly.  
**Stripe Integration** – Secure payment processing for seamless transactions.  
**Order Management** – Admins can track orders, including pending and completed payments.  
**Google Books API Integration (Admins Only)** – Admins can now search, preview, and import books dynamically.  
**3D Carousel** – Displays the latest books in an interactive rotating display.  
**Book Preview Feature** – Logged-in users can read excerpts from books directly via the Google API.  
**Book Request System** – Users can request books and manage their borrowing history.


---
