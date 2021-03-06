<div align="center">
    <p>
        <img src="https://ik.imagekit.io/taskordimg/logo_FLhAmih_U.svg" height="70" alt="Taskord Logo">
    </p>
    <h1>Taskord</h1>
    <strong>✅ Get things done in public</strong>
</div>
<br>
<div align="center">
    <a href="https://gitlab.com/taskord/taskord/-/commits/main">
        <img src="https://img.shields.io/gitlab/pipeline/taskord/taskord/main?label=build" alt="Build CI">
    </a>
    <a href="https://github.com/taskordhq/web/actions/workflows/test.yml">
        <img src="https://github.com/taskordhq/web/actions/workflows/test.yml/badge.svg?branch=main" alt="GitHub Action">
    </a>
    <a href="https://depfu.com/gitlab/taskord/taskord">
        <img src="https://badges.depfu.com/badges/f0625abc743939efb59a25395cc964cb/overview.svg" alt="Depfu">
    </a>
    <a href="https://gitlab.styleci.io/repos/20359920?branch=main">
        <img src="https://gitlab.styleci.io/repos/20359920/shield" alt="Style CI">
    </a>
    <a href="https://www.codacy.com/gl/taskord/taskord/dashboard">
        <img src="https://app.codacy.com/project/badge/Grade/7a9d7f0b31cb472185605c5089a6e2d8" alt="CodeClimate"/>
    </a>
    <a href="https://www.php.net">
        <img src="https://img.shields.io/badge/PHP-v8.0-green.svg" alt="PHP version">
    </a>
    <a href="https://laravel.com">
        <img src="https://img.shields.io/badge/Laravel-v8.x-brightgreen.svg" alt="Laravel version">
    </a>
    <a href="LICENSE">
        <img src="https://img.shields.io/badge/license-MIT-green?longCache=true" alt="MIT License">
    </a>
    <a href="https://gitlab.com/taskord/taskord">
        <img src="https://img.shields.io/github/languages/code-size/taskordhq/web" alt="Code size">
    </a>
    <a href="https://gitlab.com/taskord/taskord/-/commits/main">
        <img src="https://badgen.net/gitlab/last-commit/taskord/taskord" alt="Last commit">
    </a>
    <a href="https://discord.gg/9M4Q65b">
        <img src="https://img.shields.io/discord/742712073670230026.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2" alt="Discord">
    </a>
    <a href="https://twitter.com/taskord">
        <img src="https://img.shields.io/twitter/follow/taskord?label=taskord&style=flat&logo=twitter&color=1DA1F2" alt="Taskord Twitter">
    </a>
</div>
<div align="center">
    <br>
    <a href="https://taskord.com"><b>taskord.com »</b></a>
    <br><br>
    <a href="https://gitlab.com/taskord/taskord/-/issues/new"><b>Report Bug</b></a>
    •
    <a href="https://gitlab.com/taskord/taskord/-/issues/new"><b>Request Feature</b></a>
</div>

## 🍭 About Taskord

Taskord is a community of makers in tech shipping and working together. Makers post their daily tasks, questions, milestones in public and grow a network of supportive, like-minded people!

## ✨ Feature Highlights

- **✅ Tasks:** All tasks are public and added to your maker profile.
- **🔥 Reputation:** Earn reputations by completing, liking, and commenting on tasks and questions, which helps you to stay productive.
- **😀 Makers:** Community of peoples who ships constantly.
- **📦 Products:** Ship your products to Taskord and make regular updates about the product and even add tasks to them.
- **💬 Q&A:** Get your questions answered and use this feature as discussion too.
- **⛳ Milestones:** Add tasks to the milestone and accomplish them in time.
- **🤝 Meetups:** Find or create your own meetup and meet people near you who share your interests.
- **🎁 Deals:** Discounts and special deals for Taskord members. Only available to patrons.
- **🌑 Dark Mode:** A built-in light and dark color scheme.

More features are already planned. Take a look at the [project board](https://gitlab.com/taskord/taskord/-/boards/1919668) for more information.

## 🤝 Contributing

We encourage you to contribute to Taskord! Please check out the [Contributing guide](CONTRIBUTING.md) for guidelines about how to proceed.

## ✅ Community

Got Questions? Join the conversation in our [Discord](https://discord.gg/9M4Q65b).

## 💡 Support

You can get personal and dedicated support by becoming a [Taskord Patron](https://taskord.com/patron). ⭐

## ⚙️ Setup

### Development

#### Prerequisites

- [PHP](https://www.php.net)
- [Node.js](https://nodejs.org/en)
- [Yarn](https://yarnpkg.com)
- [Redis](https://redis.io)

#### Setup

The following steps assume that you are using Linux or Mac for development, which we highly encourage. If you use other ways to work with PHP projects you must adapt the commands to your system. Fork and clone the repository to your machine and run the following commands to start the development.

Setup environment variables

```sh
cp .env.example .env
```

Now, install all php and yarn dependencies

```sh
composer install
npm install
OR
yarn install
```

Last step: compile all assets. Node 14 LTS is the minimum version required and recommended to use. You may use either NPM or Yarn for installing the asset dependencies.

```sh
yarn watch
```

Generate appliaction key and migrate the database

```sh
php artisan key:generate
php artisan migrate --seed
```

Start the application

```sh
php artisan serve
```

Visit http://localhost:8000

#### Tests

You can run existing tests with the following command

```sh
php artisan test
```

## ⚖️ License

Taskord is open-sourced software licensed under the © [MIT license](LICENSE).
