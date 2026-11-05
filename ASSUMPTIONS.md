# Assumptions

1. **Customer identity:** A customer account is identified by a unique email address and password. Email is practical for a small factory loyalty programme; phone is optional. No external identity provider is required.
2. **Proof of purchase:** Each genuine eligible product box contains a factory-generated, random 12-character alphanumeric code. The customer must enter it after signing in. This assumes the factory controls code insertion and distribution.
3. **Code creation:** Only the factory owner/admin can generate codes in batches. Codes are created as active and should be printed/inserted once. The generated list is shown once after generation and must be stored securely by the factory.
4. **Code value:** Every valid code awards 10 points. The assignment did not specify point values, so a simple fixed value is used and can be changed in `config.php`.
5. **One-time use:** A code may be redeemed once globally, not once per customer. The unique database index, conditional update and transaction prevent simultaneous double redemption.
6. **Code format:** Codes contain exactly 12 uppercase letters/digits. The factory code generator uses a cryptographically secure random source.
7. **Fraud controls:** The system rejects unknown, disabled or already-redeemed codes; limits each account to 20 code attempts per rolling hour; records attempts; and uses row locks/transactions. This reduces basic reuse and guessing but cannot fully prevent resale, account sharing or collusion.
8. **Public display:** No customer photos or public personal profiles are needed. Only the logged-in customer and factory owner can see account-specific information. The admin customer list is restricted to authenticated admins.
9. **Rewards:** The factory owner can add rewards with point thresholds. Customers can request a reward if they have enough points. Requests are marked pending; physical fulfilment is handled offline by the factory. Admin approval/fulfilment workflow is a future enhancement.
10. **Concurrency:** Multiple customers may submit codes at once. InnoDB transactions, `SELECT ... FOR UPDATE`, unique constraints and a conditional update protect each code from being credited twice.
11. **Database:** The local college deployment uses MySQL/MariaDB through XAMPP because phpMyAdmin is available. The app is not a SQLite project.
12. **Point expiry:** Points do not expire in this assignment version because no expiry policy was specified.
13. **Returns/refunds:** A returned product does not automatically reverse points. The factory would need a return verification and adjustment policy in a production system.
14. **Language/currency:** The initial interface is English; no currency calculations are needed.
15. **Deployment:** The project is intended to run locally in XAMPP. No public deployment URL or production credentials are supplied.
