# Projettos

Optimize the efficiency of your projects with our project management tool. Centralize the collection of resource requests, stimulate creative ideas, and provide straightforward and uncomplicated support.

![Roadmap screenshot](/public/screenshots/screenshot.png)

## Features
**Suggestions**: Collect suggestions and ideas from your customers to help you iterate and improve faster.

**Feature Upvotes**: Quickly see which ideas have traction as your users upvote the ideas they’d love to see.

**Discord and Slack Integration**: Get notified of new suggestions and comments directly to your team's Discord or Slack account.

**Product Roadmap**: Generate a roadmap from your suggestions, showing planned, in progress, and completed features.

**Support Ticket Management**: Efficiently manage and track customer support tickets.

**Project Changelog Management**: Keep track of changes made to your project, ensuring transparency and accountability.

**Project Docs Management (Coming soon)**: Easily manage project documentation to ensure all necessary information is organized and accessible.

**Project FAQs Management (Coming soon)**: Create and manage frequently asked questions for your project, providing helpful information to users.

**Mention Users in Comments**: Mention specific users in comments to notify them or draw their attention to a particular discussion or topic.

**Upvote Items to See Which Has More Priority**: Allow users to upvote items to indicate their priority, helping you prioritize feature development.

**Automatic Slug Generation**: Automatically generate slugs (URL-friendly strings) for items or content, simplifying their identification and access.

**Filament Admin Panel**: Access a comprehensive admin panel for easy management and control of your project's settings and configurations.

**Simplified Role System (Administrator, Employee & User)**: Establish a simplified role system with predefined roles such as administrator, employee, and user, to manage user access and permissions.

**OAuth 2 Single Sign-On with Your Own Application**: Enable single sign-on (SSO) functionality using OAuth 2 with your own application, providing users with a seamless authentication experience.

**GitHub Integration**: Integrate with GitHub to facilitate version control and collaboration on software development projects.

**Docker Support**: Benefit from Docker support, allowing for easier deployment and management of your application in containerized environments.

**Automatic OG Image Generation**: Automatically generate Open Graph (OG) images, which are used as thumbnail previews when sharing links on social media platforms, enhancing the visual representation of your content.

## Requirements

- PHP >= 8.1
- Database (MySQL, PostgreSQL)
- GD Library (>=2.0) or
- Imagick PHP extension (>=6.5.7)

## Installation

First set up a database, and remember the credentials.

```
git clone https://github.com/codions/projettos.git
composer install
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
npm ci
npm run production
```

Now edit your `.env` file and set up the database credentials, including the app name you want.

Optionally you may set up the language with `APP_LOCALE`, if your language is not working we accept PR's for new languages. We recommend copying those files from the `lang/en` folder.
As well as the timezone can be set with `APP_TIMEZONE`, for example: `APP_TIMEZONE="America/Sao_Paulo"`.

Now run the following:

```
php artisan app:install
```

And login with the credentials you've provided, the user you've created will automatically be admin.

## Docker

### Getting up and running

`docker-compose up -d --build`

Set your database .env.docker variables:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=roadmap
DB_USERNAME=root
DB_PASSWORD=secret
```

Composer Install:

`docker exec -it app composer install`

Running artisan commands:

`docker exec -it app php artisan <command>`

The Application will be running on `localhost:8080`

## Docs
See advanced installation and setup options in the [Docs](docs/README.md)

## License

The MIT License (MIT). Please see [License](LICENSE) for more information.
