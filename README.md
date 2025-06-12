# Project Overview

This project allows users to create and manage a personalized profile page with customizable content, design elements, and social links.

<details>
<summary>📄 File Descriptions</summary>

### `index.php`
Handles user login by validating email input and setting up the session. Redirects to `dashboard.php` on success.

### `initial_info.php`
Displays a form for collecting the user's name, favicon URL, and tab title immediately after login or registration.

### `dashboard.php`
Provides the user dashboard with navigation links to preview the public profile, edit page content, or logout.

### `edit.php`
Displays a comprehensive form allowing users to edit:
- Browser tab metadata (title, favicon)
- Page address and username
- Profile picture and description
- Main title and content sections
- Social media links  
Pre-populates fields with existing user data for convenience.

### `preview.php`
Public-facing profile page renderer. It uses stored user data to dynamically display the page as it would appear to others.

</details>

---

## 📦 Data Flow
User inputs are collected via forms and stored in a shared data source (likely a JSON file or database via utility functions like `get_users()`), then retrieved and rendered as needed in each file.

## 🔐 Session Handling
Sessions are used for maintaining login state and accessing user-specific data throughout the app.
