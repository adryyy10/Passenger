# Passenger technical test

This technical test consists of creating a command that inserts all the postcodes into its own database and also creates the following endpoints:
- Search for all postcodes that partially contain a string that is passed as query string
- Search for all nearby postcodes based on provided latitude, longitude and max distance

## Getting Started

Follow these instructions to set up and run the project on your local machine.

### Prerequisites

Before you begin, make sure you have the following prerequisites installed:

- [Composer](https://getcomposer.org/) - Dependency manager for PHP
- [PHP](https://www.php.net/downloads.php) - PHP 8.1 or higher

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/adryyy10/passenger.git
   ```
2. Dependencies:
   ```bash
   cd passenger
   composer install
   ```
3. Run tests:
   ```bash
   bin/console phpunit
   ```
If I had invested more time I would have added cs-fixer to improve the code structure, phpstan to improve the code quality and circleCI to implement continuous integration

### Author
Adria

### Contact
If you have any questions or need assistance, you can contact me at adriafigueresgarciauk@gmail.com.
