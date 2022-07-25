# CodeIgniter 4 Landing Page Procedures (for Developer)

## First Setup Framework

Git Clone `https://github.com/dhonstudio/ci4_adminweb.git`.

## Setup Single System

Edit `$systemDirectory` in `app/Config/Paths.php` with central system path (default put the `system` from CI4 in `htdocs/framework/ci4`).

## Initialize and Syncronize Git

Run command:

```
git config user.name "name"
git config user.email "email@email.com"
git config --global alias.add-commit '!git add -A && git commit'
git add-commit -m "init project"
```

Create repo in git cloud.

```
git remote set-url origin <url>
git push --set-upstream origin master
```

## Setup BaseController

Set default baseurl, assets path, and git assets path base on ENVIRONMENT.

Create central assets path (default in `htdocs/assets`).

Git Clone `https://github.com/dhonstudio/ci4_libraries.git` on `htdocs/assets`.

Set default data.

Set default lang, keywords, author, generator, ogimage, description, css, favicon, title, and social media in data.

Set API auth credential.

## Setup BaseController (for Hit Traffic Identification)

Set DhonHit `api_url` base on ENVIRONMENT.

## Setup Home Controller and Views

Set start from body tag in `Views/home`.

# CodeIgniter 4 Landing Page Procedures (for Owner)

## First Setup Framework

Copy Framework.

Create `index.php` filled:

```
<?php

require 'public/index.php';
```

Copy `public/.htaccess` to `root` path.

Delete `composer.json`.

## Setup Single System and Set env

Delete `system` folder and make sure any single `system` folder.

Edit `$systemDirectory` in `app/Config/Paths.php` with central system path.

Copy `env` to `root` path and rename one of them to `.env`.

Uncomment `.env` in `.gitignore`.

Uncomment `CI_ENVIRONMENT = production` and change to `CI_ENVIRONMENT = development`.

## Initialize and Syncronize Git

Run command:

```
git init
git config user.name "name"
git config user.email "email@email.com"
git config --global alias.add-commit '!git add -A && git commit'
git add-commit -m "init project"
```

Create repo in git cloud.

```
git remote add origin <url>
git push --set-upstream origin master
```

## Setup BaseController

Create default baseurl, assets path, and git assets path base on ENVIRONMENT.

Create default data.

Create API auth credential.

## Setup BaseController (for Hit Traffic Identification)

Create and set DhonHit `api_url` base on ENVIRONMENT.

Add `$this->dhonhit->collect();` on Controller.

## Setup Home Controller and Views

Create `initController` function.

Edit `welcome_message` to `home`.

Edit `Views/welcome_message.php` to `Views/home.php`, fill with:

```
<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>

<body code>

<?= $this->endSection(); ?>
```

Create `Views/layouts/template.php`

# CodeIgniter 4 Framework

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

This repository holds the distributable version of the framework,
including the user guide. It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the _public_ folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's _public_ folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter _public/..._, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [_Contributing to CodeIgniter_](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
