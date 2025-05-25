# 🛠️ Symfony JWT API Starter Kit

Welcome! This Starter Kit helps you quickly launch a Symfony-based REST API project with JWT authentication, user registration, role-based access, and protected routes.

Perfect if you want to skip setup and get straight to building your app.

---

## 🚀 Key Features

- ✅ JWT login and token authentication
- ✅ User registration with password hashing
- ✅ Protected routes (authenticated access)
- ✅ Role-based access control (`ROLE_USER`, `ROLE_ADMIN`, etc.)
- ✅ Auto-generated API documentation (Swagger via NelmioApiDocBundle)
- ✅ Clean, modular code (Controllers, Services, DTOs)
- ✅ Dev-friendly setup (MakerBundle included)

---

## ⚠️ Security: What you **must** change after installation

To keep your project secure, **these steps are mandatory** after downloading the kit.

### 🔐 1. Generate your own JWT keys

The kit includes default development keys. **Do not use them in production.**

> 🎯 Run the following command:
```bash
php bin/console lexik:jwt:generate-keypair
```
Your new keys will be saved in config/jwt/ and will replace the default ones.

### 🧪 2. Set your own JWT passphrase
Edit the .env file and update:
```
JWT_PASSPHRASE=REPLACE_ME
```
Replace **REPLACE_ME** with the passphrase you used when generating your key.

### 🧯 3. Disable the debug endpoint
The ***/api/debug/create-user*** endpoint is intended for development use only.

Options:

- Delete it
- Restrict it based on APP_ENV != prod
- Protect it with a temporary secret/token

### 🌐 4. Configure CORS properly
Open config/packages/nelmio_cors.yaml and make sure you restrict allowed domains:
```
allow_origin: ['https://your-domain.com']
```
⚠️ Avoid using ['*'] in production.

### 🚦 5. (Optional) Enable rate limiting
To protect /api/login from brute-force attacks, add:
```
# config/packages/rate_limiter.yaml
framework:
rate_limiter:
login:
policy: 'sliding_window'
limit: 5
interval: '1 minute'
```
Then annotate your login controller:
```
#[RateLimit(name: 'login')]
```

## 🔧 Quick Setup
1. Clone or unzip the project
2. Install dependencies:
    ```
    composer install
    ```
3. Copy .env to .env.local and set up your DB credentials and JWT passphrase
4. Generate JWT keys:
   ```
   php bin/console lexik:jwt:generate-keypair
   ```
5. Run database migrations:
    ```
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```
6. Start the server:
    ```
    symfony server:start
    ```
   
## 🧾 API Documentation
```
/api/doc
```
Powered by NelmioApiDocBundle

## 📦 Tech Stack
- Symfony 6.x
- LexikJWTAuthenticationBundle
- Doctrine ORM
- Symfony Security, Validator, Serializer
- NelmioApiDocBundle (Swagger)
- PHPUnit

## 💬 Support & Feedback
Need help or want to suggest improvements? Message me on Ko-fi or reach out via the support channel.

Thanks for choosing this Starter Kit and happy coding with Symfony! ❤️
https://ko-fi.com/spyrash
