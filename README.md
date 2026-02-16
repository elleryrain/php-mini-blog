# Mini Blog (Laravel 12)

A simple MVP blog built with Laravel 12 + Blade + Tailwind/Vite.

## Features

-   Public post list (`/`, `/posts`)
-   Search by title/excerpt/body
-   Pagination
-   Post details page (`/posts/{slug}`)
-   Auth-protected post creation/edit/delete
-   Authorization via `PostPolicy` (only owner can update/delete)
-   Image upload + center crop + resize to `1200x630`
-   Seeders/factories for demo data

---

## Stack

-   PHP 8.2+ (tested on PHP 8.4)
-   Laravel 12
-   PostgreSQL (current `.env` setup)
-   Vite + Tailwind CSS
-   Blade templates

---

## Requirements

-   Composer
-   Node.js + npm
-   PostgreSQL
-   PHP extension `gd` (required for image processing)

---

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```
