# CodeIgniter 4 Application Starter

## Installation

- clone project

  using `https`

  ```bash
  https://github.com/AnasKhalif/CodeigniterAPI.git
  ```

  using `ssh`

  ```bash
  git@github.com:AnasKhalif/CodeigniterAPI.git
  ```

- Install dependencies

  ```bash
  composer install
  ```

- Copy .env

  ```bash
  cp env .env
  ```

- Migrate database

  ```bash
  php artisan migrate
  ```

- Running app

  ```bash
  php spark serve
  ```

- API endpoint Register

  ```bash
  http://localhost:8080/codeigniter_api/auth/register
  ```

- API endpoint Login

  ```bash
  http://localhost:8080/codeigniter_api/auth/login
  ```

# Register User

**Endpoint**: `POST /auth/register`

**Description**:
Endpoint ini digunakan untuk mendaftarkan pengguna baru ke sistem.

# Request Header:

- **Content-Type**: `application/json`

# Request Body (JSON):

````json
{
    "username": "jonyper",
    "email": "jonyper@gmail.com",
    "password": "password123"
}


# Login User
**Endpoint**: `POST /auth/login`

**Description**:
Endpoint ini digunakan untuk melakukan login pengguna ke sistem.

# Request Header:
- **Content-Type**: `application/json`

# Request Body (JSON):
```json
{
    "username": "jonyper",
    "password": "password123"
}
````
