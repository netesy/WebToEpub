# PHP Web Scraper for Dynamic Novel Websites

This directory contains a PHP-based web scraper designed to extract information from novel websites that rely heavily on JavaScript for dynamic content loading.

## Architecture

Due to the limitations of traditional PHP scraping methods on JavaScript-driven sites, this solution uses a hybrid approach:

*   **PHP:** The main parsers and business logic are written in PHP.
*   **Node.js Helper:** A Node.js script (`get_rendered_html.js`) is used to control a headless browser (Puppeteer). This script is called from the PHP code via `shell_exec`.

The workflow is as follows:
1.  The PHP parser calls the Node.js script, passing the target URL.
2.  The Node.js script launches a headless browser, navigates to the page, and performs necessary interactions (e.g., clicking tabs, expanding accordions) to reveal all dynamic content.
3.  The script returns the fully-rendered HTML to the PHP parser.
4.  The PHP parser then uses `DOMDocument` and `DOMXPath` to extract the required information from the complete HTML.

## Setup

To run this project, you need both PHP and Node.js environments set up.

### PHP Dependencies

This project uses Composer to manage PHP dependencies. (While no dependencies are currently required, a `composer.json` is included for future use).

### Node.js Dependencies

The headless browser is powered by Puppeteer. To install it and other necessary packages, run the following command in the root directory:

```bash
npm install
```

This will download the required `node_modules`.

## Running the Parser

The `test.php` script provides an example of how to use the parsers. You can run it from the command line:

```bash
php php_parsers/test.php
```
