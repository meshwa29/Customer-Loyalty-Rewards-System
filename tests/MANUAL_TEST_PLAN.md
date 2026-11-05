# Manual test plan and result record

Run against a fresh local XAMPP database after importing `sql/schema.sql`. The results below are **expected results**, not claims that tests have already been executed on your computer. Fill in the Observed Result and Pass/Fail columns while testing.

| ID | Test | Steps | Expected result | Observed result | Status |
|---|---|---|---|---|---|
| T01 | Database setup | Import `sql/schema.sql` in phpMyAdmin | `loyalty_rewards` and all tables are created | Pending local run | Not run |
| T02 | Admin setup | Open `/admin/setup.php`; create owner | Admin is created; setup page disables itself | Pending local run | Not run |
| T03 | Customer registration | Register with valid name/email/password | Account created and customer dashboard opens | Pending local run | Not run |
| T04 | Duplicate email | Register another account with same email | Friendly duplicate-email error; no second account | Pending local run | Not run |
| T05 | Generate codes | Admin generates a batch of 5 | Five unique 12-character codes appear once | Pending local run | Not run |
| T06 | Valid redemption | Customer enters an active generated code | Code changes to redeemed; 10 points and ledger row added | Pending local run | Not run |
| T07 | Reuse code | Submit the same code again | Rejected; points balance unchanged | Pending local run | Not run |
| T08 | Invalid code | Submit a random 12-character code | Rejected; points balance unchanged | Pending local run | Not run |
| T09 | Invalid format | Submit a short or special-character code | Rejected by format validation | Pending local run | Not run |
| T10 | Attempt throttling | Submit 20+ invalid codes within an hour for one account | Further attempts are temporarily blocked | Pending local run | Not run |
| T11 | Concurrent redemption | Submit one active code from two sessions close together | Only one session receives points; code is redeemed once | Pending local run | Not run |
| T12 | Reward request | Earn enough points, then redeem a reward | Points deducted once; pending reward request and ledger entry created | Pending local run | Not run |
| T13 | Admin access | Open admin dashboard without signing in | Redirected to admin login | Pending local run | Not run |
| T14 | Customer access | Open customer dashboard without signing in | Redirected to customer login | Pending local run | Not run |

## Test execution notes
- Use two separate browser profiles for T11.
- Check `product_codes`, `points_ledger`, `customers` and `reward_redemptions` in phpMyAdmin to verify database changes.
- Do not use real customer data or real production codes during testing.
