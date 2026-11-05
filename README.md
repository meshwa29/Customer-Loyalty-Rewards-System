# Customer Loyalty Rewards System

A PHP + MySQL web application for a factory that sells physical products in boxes. Each eligible box contains a unique 12-character reward code. Customers register, sign in, redeem a code once, earn points, view their points ledger and request rewards. The factory owner generates code batches and monitors customers, redemptions and reward activity.

## Features
- Customer registration and login with securely hashed passwords.
- Factory-owner setup and login.
- Admin-generated cryptographically random 12-character product codes.
- One-time code redemption using a database transaction and row lock.
- One-time code uniqueness enforced by a database UNIQUE constraint.
- Per-customer hourly redemption-attempt limit.
- Points ledger and reward catalogue; customers can spend points to request a reward.
- Owner dashboard, code status list, customer list and reward creation.
- Prepared SQL statements, output escaping, CSRF tokens and session ID regeneration.

## Tech stack
- PHP 8.1+ (PDO)
- MySQL 8+ / MariaDB 10.4+ (InnoDB)
- Apache via XAMPP
- HTML, CSS and a small amount of vanilla JavaScript

## Setup and run with XAMPP
1. Install/start XAMPP. Start **Apache** and **MySQL**.
2. Extract this project folder into `C:\xampp\htdocs\Customer_Loyalty_Rewards`.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Select **Import**, choose `sql/schema.sql` from this project, and click **Go**. This SQL file creates the `loyalty_rewards` database and tables. Do not import any `.php` file.
5. Open `config.php`. The defaults are for a standard XAMPP install (`localhost`, user `root`, blank password). Change `DB_PASS` if your local MySQL root account has a password.
6. Visit `http://localhost/Customer_Loyalty_Rewards/`.
7. Create a factory owner account once at `http://localhost/Customer_Loyalty_Rewards/admin/setup.php`. Use a strong password. Setup disables itself once an admin exists.
8. Sign in at `http://localhost/Customer_Loyalty_Rewards/admin/login.php`. Generate a batch of codes and place one unique code inside each eligible box. Keep the generated code list private.
9. Customers register at the home page, sign in, enter the code from the box, and earn 10 points per valid code. They can request a reward when they have enough points.

## Database import note
Only `sql/schema.sql` is a SQL import file. `config.php`, `customer/dashboard.php` and other `.php` files are application source code and must stay in the project folder; they are not imported through phpMyAdmin.

## Tests
See [`tests/MANUAL_TEST_PLAN.md`](tests/MANUAL_TEST_PLAN.md) for test cases and expected results. Run them on a local XAMPP instance after importing the schema. Automated test execution is not configured in this starter repository.

## Security and deployment notes
This is a college assignment/demo. Use HTTPS, secure cookie settings, a non-root database account, backups, monitoring and stronger IP/device abuse controls before any public deployment. The app intentionally does not include a public deployed URL. Product codes should be printed under scratch-off/inside-box protection and generated code exports must be handled securely.

## Repository history
The `.git` folder is included in the ZIP with staged, meaningful development commits. Continue committing changes as you test and improve the application.
