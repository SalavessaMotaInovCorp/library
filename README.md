# Library Management System

This project is a **Library Management System** built with **Laravel Jetstream**, **Livewire**, and **DaisyUI**. It allows managing books, authors, and publishers, with additional features like search, data export, and user authentication.

## Features

- **Books Management:** Create, read, update, and delete books with detailed information (ISBN, description, cover image, price).
- **Authors Management:** Manage authors, including their names and photos.
- **Publishers Management:** Add and edit publishers with logo support.
- **Many-to-Many Relationships:** Link multiple authors to multiple books seamlessly.
- **Advanced Search Functionality:** Real-time search for books, authors, and publishers using Livewire.
- **Data Export:** Export books, authors, and publishers data to Excel format.
- **User Authentication:** Secure login, registration, and user session management with Laravel Jetstream.
- **Responsive UI:** Fully responsive design using DaisyUI, ensuring a great experience on all devices.
- **Database Seeding:** Pre-populate the database with sample data for easy testing.

## Technologies Used

- **Laravel Jetstream** (with Livewire)
- **DaisyUI** (Tailwind CSS Components)
- **MySQL** (or any supported DB)
- **Maatwebsite/Laravel-Excel** (for data export)
- **Rappasoft Laravel Livewire Tables** (for dynamic data tables)

##  Database Structure

- **Authors:** `id`, `name`, `photo`
- **Books:** `id`, `isbn`, `name`, `publisher_id`, `description`, `cover_image`, `price`
- **Publishers:** `id`, `name`, `logo`
- **Pivot Table:** `author_book` (for many-to-many relationship)

##  Data Export

- Export data as Excel files:
    - `/books/export`
    - `/authors/export`
    - `/publishers/export`

##  Screenshots

Here are some screenshots of the application:

- **Main Page**
  ![Main Page](https://aircinelmvc.blob.core.windows.net/resources/PrintsScreens%20Library/mainpage.jpg)

- **Books List:**
  ![Books List](https://aircinelmvc.blob.core.windows.net/resources/PrintsScreens%20Library/books.jpg)

- **Authors Management:**
  ![Authors Management](https://aircinelmvc.blob.core.windows.net/resources/PrintsScreens%20Library/authors.jpg)

- **Publishers Section:**
  ![Publishers Section](https://aircinelmvc.blob.core.windows.net/resources/PrintsScreens%20Library/publishers.jpg)
