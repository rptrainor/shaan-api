# Laravel API for Blog Web App

This repository is part of a larger project that demonstrates a blog web application using Laravel, Cloudflare Workers, Nuxt, Vue, and TailwindCSS. This specific repository contains the backend API, built with Laravel, which provides data and functionality for the blog.

## Role in the Larger Project

The Laravel API handles all the server-side logic, including managing blog articles, authentication, and providing a RESTful API for the frontend applications. It serves as the core backend service that other parts of the project interact with.

## Why Build This Part?

If we wanted to, we could handle all of our server-side logic with Cloudflare Workers and the D1 SQLite database. I chose to include this Laravel server for three main reasons.

1. **Unified Architecture**: Having a single web server to handle the backend logic provides a more unified architecture than distributing controllers, models, authentication, and any future logic across various Cloudflare Workers.

2. **Developer Experience**: Existing libraries and the opinionated design of a Laravel web server contribute positively to the developer experience and speed at which new features can be developed.

3. **Efficient Usage**: This server will primarily be interacted with by internal users of the blog application. General visitors to the blog will first call the client, which is a Nuxt/Vue web app on Cloudflare Pages. That app gets the most recent list of blog articles from the cache in our Cloudflare Worker. Therefore, for the majority of visitors to the blog web app, we are fully leveraging the Cloudflare Global Distribution network. This web server handles business logic that we can afford to process asynchronously. Thus, we get the best of both worlds: a scalable web server designed for future features and a fast, globally distributed client.

## Technologies Used

- Laravel
- PHP
- SQLite
- Carbon (for date handling)

## Setup Instructions

1. **Clone the repository:**

    ```bash
    git clone https://github.com/rptrainor/shaan-api.git
    cd shaan-api
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Copy the example environment file and set up your environment variables:**

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database and other configuration details.

4. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run the database migrations:**

    ```bash
    php artisan migrate
    ```

6. **Seed the database (optional):**

    If you have seed data and want to populate the database with it, run:

    ```bash
    php artisan db:seed
    ```

7. **Start the development server:**

    ```bash
    php artisan serve
    ```

Your Laravel API should now be running at `http://127.0.0.1:8000`.

## Endpoints

- `GET /articles` - Retrieve all articles.
- `GET /articles/{slug}` - Retrieve a single article by slug.
- `POST /articles` - Create a new article.
- `PUT /articles/{id}` - Update an article by ID.
- `DELETE /articles/{id}` - Delete an article by ID.

Ensure to use an authorization token for protected routes.

## Contributing

If you would like to contribute to this project, please fork the repository and use a feature branch. Pull requests are warmly welcome.

## License

This project is licensed under the MIT License.
