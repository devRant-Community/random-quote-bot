# random-quote-bot

[![License](https://img.shields.io/github/license/mashape/apistatus.svg)](LICENSE.md)
[![Quotes](http://skayo.lima-city.de/Shields/devRantBot.php?type=quotes)](https://www.devrant.io/users/RandomQuote)
[![Score](http://skayo.lima-city.de/Shields/devRantBot.php?type=score)](https://www.devrant.io/users/RandomQuote)

A devRant bot that posts random quotes every day!

> **Note**
> This project was originally created by @skayo, but he has decided to transfer it to the devRant-Community organization.


## Requirements

- PHP 5.6


## Directory Structure

    .
    ├── DevRant.php             # Little helper class for accessing the devRant API
    ├── index.php               # Executes random quote bot, used by cronjob
    ├── newYear.php             # Executes new year bot, used by cronjob (new year message from @RandomQuote user)
    ├── newYearBot.php          # Class for the new year bot (new year message from @RandomQuote user)
    ├── randomQuoteBot.php      # Class for the random quote bot
    ├── .gitignore
    ├── LICENSE.md
    └── README.md
