# master-salon
# Salon & Spa Manager

A modern, asynchronous web application for managing salon and spa operations, built using **HTML5**, **CSS3**, **PHP**, **JavaScript/jQuery**, and **AJAX/JSON** for seamless, no-page-refresh user experience.

---

## Features

- **Appointment Booking:** Customers can book, view, reschedule, and cancel appointments. Staff & admin views include calendar and reminders.
- **Staff Management:** Manage staff profiles, schedules, and assignments.
- **Customer Management:** Profiles, preferences, loyalty points, and visit history.
- **Service Menu Management:** Add, edit, and remove services. Set prices and durations.
- **Inventory Management:** Track products and supplies. Bulk product logic calculates price per scoop/ounce.
- **Point of Sale (POS):** Record sales, handle product usage, suggest service pricing based on product use and hourly rates.
- **Reports & Analytics:** Sales, appointments, and staff performance stats.
- **Promotions & Gift Cards:** Create and redeem discounts and gift cards.
- **User Roles & Permissions:** Admin, staff, and customer roles.
- **Customer Feedback:** Collect and view reviews after visits.

---

## Technology Stack

- **Frontend:** HTML5, CSS3, JavaScript, jQuery
- **Backend:** PHP 7+
- **Database:** MySQL/MariaDB
- **Communication:** AJAX, JSON (all actions are asynchronous, no page refresh)

---

## Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/salon-spa-app.git
   cd salon-spa-app
   ```

2. **Set Up Database:**
   - Import the provided SQL schema (see `database.sql` or the schema in this README).
   - Configure your database credentials in `includes/db.php`.

3. **Web Server:**
   - Deploy on Apache/Nginx with PHP 7+.
   - Ensure `mod_rewrite` is enabled (see `.htaccess`).
   - Set your document root to the project folder.

4. **File/Folder Permissions:**
   - Ensure the `uploads/` directory is writable by the web server.

5. **Open in Browser:**
   - Visit `http://localhost/salon-spa-app/` or your configured domain.

---

## Project Structure

```
salon-spa-app/
│
├── assets/          # CSS, JS, Images
├── includes/        # DB connection, Auth, Config, Utils
├── api/             # PHP endpoints for AJAX
├── templates/       # Header, Footer, Navigation, Modals
├── views/           # Main pages (dashboard, appointments, etc.)
├── models/          # PHP model classes (optional/advanced)
├── uploads/         # Uploaded files (images, etc.)
├── index.php
├── login.php
├── register.php
├── .htaccess
└── README.md
```

---

## Database Schema (MySQL)

See the [Database Schema Section](#database-schema) in the main documentation or in the `/docs` folder if provided.

---

## Usage Notes

- All management operations (add/edit/delete) are performed via AJAX for a smooth user experience.
- User roles determine access to sensitive features.
- The system is modular and easily extensible.

---

## Contribution

1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes.
4. Push to your fork and open a Pull Request.

---

## License

MIT License. See [LICENSE](LICENSE) for details.

---

## Support

For questions, feature requests, or support, please open an issue or contact [support@salonspa.com](mailto:support@eaglevisionsolutions.ca).
