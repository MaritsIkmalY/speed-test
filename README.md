# Speed-Test Installation and Setup Guide

## Prerequisites
1. **XAMPP**
2. **PHPMyAdmin**

## Steps:

### 1. Download and Extract Folder
1. **Download** the zip file containing the `speed-test` folder from the provided source.
2. **Extract** the zip file into the `htdocs` folder located in your XAMPP installation directory. The default path is usually `C:\xampp\htdocs`.

### 2. Running XAMPP
3. **Open** the XAMPP application.
4. **Start** the Apache and MySQL services by clicking the `Start` button for each service.

### 3. Setting Up the Database in PHPMyAdmin
5. **Open** PHPMyAdmin in your browser by navigating to: [http://localhost/phpmyadmin/index.php](http://localhost/phpmyadmin/index.php).
6. **Create** a new database named `speed_test`:
   - Click on the `Databases` tab.
   - Enter the database name `speed_test` in the `Create database` field.
   - Click the `Create` button.

### 4. Importing the Database
7. **Import** the `speed_test.sql` database file from the extracted `speed-test` folder:
   - Click on the `speed_test` database you just created.
   - Select the `Import` tab.
   - Click the `Choose File` button and select the `speed_test.sql` file from the `speed-test` folder.
   - Click the `Go` button.

8. After the import process is complete, the database will have two new tables: `users` and `speedtest_users`.

### 5. Running the Application
9. **Access** the application in your browser by navigating to: [http://localhost/speed-test/login.php](http://localhost/speed-test/login.php).

### 6. Logging into the Application
10. **Log in** using the following credentials:
    - **Email:** `tes@gmail.com`
    - **Password:** `tes`
11. After a successful login, you will be redirected to the home page.

### 7. Done
12. **Voila!** The Speed-Test application is now up and running with all functionalities available.

Enjoy using the application! If you encounter any issues or need further assistance, feel free to seek additional support.
