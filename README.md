# Introduction
This guide explains step by step how to provide your [WHMCS](https://www.whmcs.com/) affiliate users with a shorter version of their referral links. We are going to use a custom _Smarty_ PHP plugin for WHMCS along with [YOURLS](https://yourls.org/) software as our URL shortener, and I'm going to use my website as an example to explain how it works. 

In general, WHMCS affiliate referral links look like that: [**_`www.ca.netmoly.com/aff.php?aff=9`_**](https://ca.netmoly.com/aff.php?aff=9).

After implementation of the plugin, referral links will be shown to users like that:  [**_`www.netly.click/cWZPQ`_**](https://netly.click/cWZPQ/)

# How it Works
The plugin defines a new _Smarty_ function and sets a custom variable in order to be placed inside the _`affiliates.tpl`_ file. When a user access their affiliate account for the first time, the variable will call our plugin on `|Server A|` to execute, the plugin then communicates remotely with the URL shortener on `|Server B|` through its API; it takes the original long link and send it out to the URL shortener, then retrieve the generated short version of that URL, and lastly post it back to the user. 

#### Further more..
* Original referral links will still be working but hidden.
* Users will not be able to see the original URLs before they get shrinked.
* The affiliate cookie behavior remains unchanged.
* Only single short link (Vanity URL) will be generated for each affiliate account. In other words, multiple accesses or refreshes to the affiliate account/page will not generate multiple different short links.

# Requirements
1. Your branded domain name (Server B).
2. [YOURLS](https://github.com/YOURLS/YOURLS/releases) URL Shortener Installed (Server B).
3. [_Smarty_ Plugin](https://github.com/our-php-file) (Server A).
4. [ionCube](https://www.ioncube.com/loaders.php) loader (Both Servers).
5. [ionCube](https://www.ioncube.com/) account.


# Implementation

### Server B
Assuming YOURLS is already installed on your server. Create a new user to be used for the API connection. To do so open the _`/user/config.php`_ file, find the variable `$yourls_user_passwords` and create your own credentials like the following:
```php
$yourls_user_passwords = array(
	'apiuser' => 'yourownpassword',
	);
  ```

### Server A
1. [**Download**](https://github.com/MinaHafzalla/Branded-Links-AKA-Vanity-URLs-Auto-Generation/blob/master/function.affyourls.php) :arrow_double_down: our _Smarty_ plugin file.
2. Open file, find and replace the following variables values accordingly with your details.
    * `$Username`, `$password`
    * `$url`
    * `$api_url`
3. Save file as _`function.affyourls.php`_.
4. Upload the file to the _Smarty_ plugins directory _`/whmcs/installation/path/vendor/smarty/smarty/libs/plugins`_.
5. Open the _`affiliates.tpl`_ file in your current active template directory.
6. Find the variable `$referrallink`, and replace it with `{affyourls affiliateid=$affiliateid}`.
7. Save and upload to server.

# Security

### Admin Directory
1. Change admin directory name of YOURLS. To do so, open the file _`/user/config.php`_, find `YOURLS_ADMIN_DIR` and replace its value with your desired custom admin directory name.
```php
define( 'YOURLS_ADMIN_DIR', 'yourcustomname' );
```
2. Restrict access to only IPs of your trusted servers.
3. Setup a password on the admin directory.

### File Encoding
Since the _`function.affyourls.php`_ and _`config.php`_ files contain sensitive information, a good security practice is to encode these files using ionCube to add an extra layer of security.

#### Make sure that:
* You select the correct PHP versions running on servers when you attempt encoding files using ionCube.
* ionCube loader is installed on your servers.

### SSL Connection
An SSL connection is required between the two servers to encrypt the transmitted data.

# Compatibility
* WHMCS Versions 6.x.x, 7.x.x
* YOURLS Version 1.7.x

_**Note:** While this method has been implemented and tested on WHMCS only, it should work on other Smarty-based software if set up correctly._

# Questions
Have a question? Feel free to contact me at mina@netmoly.com
