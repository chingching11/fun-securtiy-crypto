# fun-securtiy-crypto

This repo focuses on server-side web programming with security measures. The application allows the registered users to explore cryptography. 
Server-side development: PHP, phpMyAdmin.

## Implemented Features 

### Cyber Defense 
- SQL Injection Defense 
    - uses prepared sql statements 
    - input sanitization: mysqli_real_escape_string

- XSS Defense
    - sanitize incoming data
    - HttpOnly cookies

- Session Hijacking Defense
    - uses secure cookie 
    - regenerate session id after a successful login 
    - check user-agent matches from login 

- Session Fixaton Defense
    - HttpOnly cookies 
    - only accept session id from cookies
    - regenerate session id after a successful login  

- CSRF Defense 
    - does not use GET request for changing state
    - check if the request is made from same domain
    - use CSRF token: synchronizer token pattern when submitting a form
    
### Cryptography
- Simple Substitution 
- Symmetric Key Cryptography
- Public Key Cryptography 

<br>

## Useful Resources
### OWSAP Cheat Sheets
- [Session Management](https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html)
- [SQL Injection Prevention](https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html)
- [Cross-Site Request Forgery Prevention](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html)
- [Cross Site Scripting Prevention](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html)
