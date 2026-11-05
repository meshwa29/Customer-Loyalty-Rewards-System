# AI development log

This log records representative prompts, review decisions and corrections. It is a truthful development record for this project; update it with the actual prompts and observations from your own AI-assisted work before submission.

## 1. Initial requirements decomposition
**Prompt:** “Design a customer loyalty rewards application for a factory selling boxed physical products. Address proof of purchase, fraud/code reuse, owner monitoring and all required repository files.”
**Decision:** Modelled a unique code inside each box, customer accounts, points ledger, rewards and an owner dashboard.

## 2. Stack selection
**Prompt:** “Build the project for a student using XAMPP, Apache, PHP and phpMyAdmin. Do not use Python or SQLite.”
**Decision:** Selected PHP + PDO + MySQL/MariaDB so the database can be imported using a `.sql` file in phpMyAdmin.

## 3. AI mistake – wrong database import format
**AI suggestion/error:** An earlier generated project used a Python `database.py` file, which the student tried to import through phpMyAdmin. MySQL returned error `#1064` at `import sqlite3`.
**How it was noticed:** phpMyAdmin expects SQL statements, not Python source code.
**Fix:** This assignment uses `sql/schema.sql` for phpMyAdmin import. PHP source files remain in `htdocs` and are executed by Apache.

## 4. AI mistake – wrong working directory
**AI suggestion/error:** Running `python app.py` from `C:\Users\Admin` failed because the project was not in that current directory; `requirements.txt` was also not found.
**How it was noticed:** The terminal path showed the home directory, not the extracted project directory.
**Fix:** This PHP project does not require Python commands. Open it through `http://localhost/Customer_Loyalty_Rewards/` after copying it into `C:\xampp\htdocs`.

## 5. Unique code and concurrency design
**Prompt:** “Prevent the same product code from being credited twice, including when two customers submit it at nearly the same time.”
**Decision:** Added a UNIQUE constraint, InnoDB transaction, `SELECT ... FOR UPDATE`, and conditional status update.

## 6. Fraud review
**Prompt:** “Add sensible college-project fraud controls without external SMS or payment APIs.”
**Decision:** Added random codes generated with PHP `random_bytes`, exact format validation, disabled/redeemed rejection, attempt audit and per-account hourly attempt cap.

## 7. Points and rewards
**Prompt:** “Let customers see a points history and redeem a reward when their balance is sufficient.”
**Decision:** Added a points ledger and transactional reward request that deducts points and records a pending fulfilment request.

## 8. Security review
**Prompt:** “Review basic web security: SQL injection, password storage, output encoding, CSRF and sessions.”
**Decision:** Used PDO prepared statements, `password_hash`/`password_verify`, `htmlspecialchars`, CSRF tokens and session ID regeneration on successful login.

## 9. Documentation and testing
**Prompt:** “Create README, assumptions, architecture diagram and a manual test plan that a student can demonstrate.”
**Decision:** Added setup steps specifically for XAMPP and explicit test cases for valid, reused, invalid and concurrent code redemption.
