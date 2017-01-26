# laikacms

simple laravel based content management system in the first alpha version

# Install

edit your composer.json and add -->

	"require": {
        "php": ">=5.6.4",
        "laravel/framework": "5.3.*",
		"kspm/laikacms": "dev-development"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ksp-media/laikacms.git"
        }
    ],

Update your composer installation

	composer update

Add CMS Provider to your config/app.php

	/*
     * Package Service Providers...
     */
    KSPM\LCMS\LCMSNextServiceProvider::class,


Install vendor files

	php artisan vendor:publish

Call the Adminpage

	http://<yourdomain>/admin

Developed by KSP Media UG as free software under the GNU General Public License version 2

