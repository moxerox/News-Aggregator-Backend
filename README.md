# Installation
Clone the repository

Open a terminal and navigate to the project directory.

Run the following command to install the project dependencies:

```
composer install
```

Copy the .env.example file to .env:
```
cp .env.example .env
```

Place your API key for the news sources
```
GUARDIAN_API_KEY=
NEWS_API_KEY=
NYTIMES_API_KEY=
```

Run the custom app setup command
```
php artisan app:setup
```

Start the development server:
```
php artisan serve
```

Open your browser and visit http://localhost:8000 to see your Laravel application in action.

## Frontend Repo
You can find the React.js frontend application [here](https://github.com/moxerox/News-Aggregator-Frontend)
