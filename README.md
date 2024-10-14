URL Shortener

## Description
This URL shortener service allows users to shorten long URLs into shorter, more manageable links. It provides a convenient way to share links and track their usage.

## Features
- Shorten long URLs
- Track the number of times a shortened URL is accessed
- Simple user-friendly interface

## Technologies Used
- PHP
- MySQL
- HTML
- CSS

## Getting Started
1. **Clone the Repository**:
   ```sh
   git clone https://github.com/rajeshboda399/URL-Shortener.git


 2. **Navigate to the Project Directory**:
     cd URL-Shortener
 3. **Set Up the Database**:
  
         Create a database named url_shortener_db.
    
        Update the database configuration in index1.php and redirect.php.
    
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "url_shortener_db";

 4.**Run the Project on Your Local Server**:
 
    1. Move the project files to your WampServer www directory (e.g., C:\wamp64\www\URL-Shortener).

    2. Start WampServer.

    3. Access the application in your browser at http://localhost/URL-Shortener.

  **Usage**

    1. Shorten a URL: Visit the homepage and enter the long URL you want to shorten.

    2. Track Usage: Check the list of shortened URLs to see how many times they have been accessed.

  **Files**
  
     1. index1.php: Main file for URL shortening.

    2. redirect.php: Handles redirection from shortened URLs.
