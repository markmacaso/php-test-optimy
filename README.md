# PHP test

## 1. Installation

  - create an empty database named "phptest" on your MySQL server
  - (new) copy config/app.php.dev to config/app.php
  - (new) copy config/database.php.dev to config/database.php
  - (new) put your MySQL server credentials in the config/database.php
  - go to your shell and run database initialization: "php index.php --db-init"
  - you can test the demo script in your shell: "php index.php"

## 2. Commands

  - Show all news and comments:
    php index.php
  - Show a  news and comments: 
    php index.php --news news_id=[news_id]
    Example:
    php index.php --news news_id=1
  - Add a news:
    php index.php --news-add title=[title] body=[body]
    Example:
    php index.php --news-add title="This is a news" body="Description of the news"
  - Delete a news:
    php index.php --news-delete news_id=[news_id]
    Example:
    php index.php --news-delete news_id=10
