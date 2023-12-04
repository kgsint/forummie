# Forum
You can visit [demo here](https://forummie.up.railway.app)

## Installation and Setup

clone this repo with `git clone https://github.com/kgsint/forum.git`

install required dependencies
```bash
composer install
```
```bash
npm install
```
copy `.env.example` file to `.env` :
```
cp .env.example .env
```
Generate `APP_KEY`
```bash
php artisan key:generate
```
To compile and hot reload, run:
```bash
npm run dev
```
Start your development server
```
php artisan serve
```

For Admin login, visit /admin
```
email - admin@gmail.com
password - password
```
