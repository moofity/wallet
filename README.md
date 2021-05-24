<p align="center">
  <h3 align="center">Simple Wallet</h3>

  <p align="center">
    An awesome project example utilising wallet functionality!
  </p>
</p>



<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

### Built With

* [Laravel 8](https://laravel.com/)
* [Laravel UI](https://github.com/laravel/ui)
* [Laravel Sail](https://laravel.com/docs/8.x/sail)


<!-- GETTING STARTED -->
## Getting Started

This is an example of how you may give instructions on setting up your project locally.
To get a local copy up and running follow these simple example steps.

### Prerequisites

This is an example of how to list things you need to use the software and how to install them.
* npm
  ```sh
  npm install npm@latest -g
  ```

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/moofity/wallet.git
   ```
2. Copy the env file
   ```sh
   cp .env.example .env
   ```
3. Enter your Google credentials in `.env`
   ```
    GOOGLE_CLIENT_ID=000000000000-XXXXXXXXXXX.apps.googleusercontent.com
    GOOGLE_CLIENT_SECRET=XXXXXXXXXXXXX
    GOOGLE_REDIRECT=http://localhost/auth/google/callback
   ```
4. Run the application with `sail`. (*It may take little longer when creating container initially*)
   ```sh
    sail up -d
   ```
5. Run migrations
   ```sh
    sail artisan migrate
   ```
6. Setup the UI
   ```sh
    sail npm install
    sail npm run prod # or dev
   ```
7. Run the tests
   ```sh
    sail test
   ```
