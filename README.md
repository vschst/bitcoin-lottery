# Bitcoin Lottery
The Bitcoin-based virtual platform for organization and conduct a drawing of bitcoins.

The following dependencies are used in the project:
* [CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [Bootstrap](https://github.com/twbs/bootstrap)
* [jQuery](https://github.com/jquery/jquery)
* [Popper.js](https://github.com/FezVrasta/popper.js/)
* [Font Awesome](https://github.com/FortAwesome/Font-Awesome)

## Server requirements
PHP version 5.6 or newer; MySQL Server 5.7

## Installation instructions
### Copying repository files.
Clone this repository into your site directory
```
git clone https://github.com/victor192/bitcoin-lottery.git
```

### Update Composer dependencies
To get the latest versions of the dependencies and to update the `composer.lock` file, you should run
```
composer update
```

### Update Local Packages
To update all the packages listed to the latest version, with [npm](https://www.npmjs.com/) do:
```
cd public/assets
npm update
```

#### Creating browserify bundle
For recursively bundle up all the required modules of the `main.js` into a single file called `bundle.js` use the [browserify](http://browserify.org/) command:
```
browserify main.js -o js/bundle.js
```
#### Compiling Sass
You need to compile all [Sass](https://sass-lang.com/) files from the `scss` directory into CSS files in the `css` directory.
For example, you can do this with [Koala](http://koala-app.com/).

### Creating tables in a database
For initial setup, run all queries from the file `setup.sql`.

## Settings
### CodeIgniter
Make sure that you have properly configured database, routes and email config.

For more information, see [here](https://codeigniter.com/user_guide/).

### Blockchain API
Open the `application/config/blockchain_api.php` file and change the *xpub* and *api* keys:
```php
$config['xpub_key'] = '';    // Your xpub key
$config['api_key'] = '';    // Your api key
 ```