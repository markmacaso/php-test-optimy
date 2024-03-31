# PHP test

## 1. Installation

  - create an empty database named "phptest" on your MySQL server
  - (new) copy config/app.php.dev to config/app.php
  - (new) copy config/database.php.dev to config/database.php
  - (new) put your MySQL server credentials in the config/database.php
  - go to your shell and run database initialization: "php index.php --db-init"
  - you can test the demo script in your shell: "php index.php"

## 2. Commands

  - Show all news and comments: <br>
    php index.php<br>
  - Show a  news and comments: <br>
    php index.php --news news_id=[news_id]<br>
    Example:<br>
    php index.php --news news_id=1<br>
  - Add a news:<br>
    php index.php --news-add title=[title] body=[body]<br>
    Example:<br>
    php index.php --news-add title="This is a news" body="Description of the news"<br>
  - Delete a news:<br>
    php index.php --news-delete news_id=[news_id]<br>
    Example:<br>
    php index.php --news-delete news_id=10<br>
  - Show comments of a news: <br>
    php index.php --comments news_id=[news_id]<br>
    Example:<br>
    php index.php --comments news_id=1<br>
  - Show a comment: <br>
    php index.php --comment comment_id=[comment_id]<br>
    Example:<br>
    php index.php --comment comment_id=1<br>
  - Add a comment:<br>
    php index.php --comment-add news_id=[news_id] body=[body]<br>
    Example:<br>
    php index.php --comment-add news_id=1 body="new comment"<br>
  - Delete a comment:<br>
    php index.php --comment-delete comment_id=[comment_id]<br>
    Example:<br>
    php index.php --comment-delete comment_id=1

## 3. Architecture

  - index.php <br>
    Entry point of the application.
  - composer.json <br>
    Contain project properties and package dependencies
  - config (directory) <br>
    Config files  <br>
    app.php: Application configurations  <br>
    database.php: Database connection configurations
  - database (directory) <br>
    Contain sql files
  - routes (directory) <br>
    Contain definition of routes
  - src (directory) <br>
    Contain the application logic
  - src/Controllers (directory) <br>
    Contain the controller classes that handle the requests
  - 
