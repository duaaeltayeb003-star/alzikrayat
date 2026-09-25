⬛ Alzikrayat - Project Report

1. Project Overview

Alzikrayat is a specialized campus memory-sharing web platform built for university students to archive, interact with, and revisit university moments. The system provides secure user authentication, photo uploading with metadata, and interactive comment streams to build an engaging academic community archive.


2. Architecture & Project Structure

The application is built entirely from scratch using a pure, native **Model-View-Controller (MVC)** architectural pattern combined with a Front Controller pattern without external backend frameworks.

alzikrayat/
│
├── config/              # Database connection and environment configurations
├── controllers/         # Application controllers (Auth, Photo, Comment, Home)
├── core/                # Core framework engine (Router, Controller, Model, Database)
├── models/              # Data models handling database logic (User, Photo, Comment)
├── public/              # Web root entry point and public assets
│   ├── css/             # Custom responsive stylesheets
│   ├── images/uploads/  # Secure media upload destination
│   ├── .htaccess        # URL rewriting rules for clean routing
│   └── index.php        # Front Controller routing all incoming requests
└── views/               # Presentation layer (Layouts, Auth, Photos, Pages)

3. Database Design

The relational database (alzikrayat_db) consists of three normalized entities with primary-foreign key relationships:

users Table: Stores user accounts, encrypted credentials, and timestamps (id, name, email, password, created_at).

photos Table: Stores uploaded memory records linked to contributors (id, user_id, title, description, image_path, created_at). Foreign key relates user_id to users(id) with cascading deletion.

comments Table: Stores interactions per photo (id, photo_id, user_id, comment, created_at). Foreign keys bind photo_id to photos(id) and user_id to users(id).

4. Main Features

User Authentication & Session Security: Complete registration and login system utilizing PASSWORD_BCRYPT hashing and secure cookie-based session tracking.

Photo Upload Workflow: Form handling with MIME-type verification, file size checks, unique file renaming, and safe server storage.

Interactive Comments: Contextual comment system allowing authenticated users to comment directly on specific memories.

Responsive User Interface: Clean, mobile-friendly design developed using Bootstrap 5 and customized modern CSS components.

5. Novelty & Advanced Features

Strict Ownership Authorization: A server-side authorization check preventing unauthorized deletions; only the original creator of a photo possesses the privilege to delete it.

Dynamic Multi-View Gallery Switcher: Client-side layout engine enabling users to instantly switch views between 3-column cards, 4-column compact grids, and vertical list feeds without page reloading.

Zero-Dependency Native MVC Engine: Complete custom-built router parsing RESTful URL parameters and mapping requests dynamically to controllers and actions.

6. Conclusion

The Alzikrayat platform successfully demonstrates that a secure, scalable, and responsive social archive application can be engineered purely with native PHP, MySQL, and vanilla front-end technologies. By adhering strictly to MVC separation of concerns, the codebase remains clean, maintainable, and production-ready for academic evaluation.