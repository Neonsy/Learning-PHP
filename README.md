# PHP MVC-Space

![PHP](https://img.shields.io/badge/php-031321?style=for-the-badge&logo=php)
![MariaDB](https://img.shields.io/badge/mariadb-031321?style=for-the-badge&logo=mariadb)
![Tailwind](https://img.shields.io/badge/tailwind-031321?style=for-the-badge&logo=tailwindcss)

This repository showcases my initial journey into web development using PHP.
While I have always been fond of JavaScript, I found that understanding the construction of a custom MVC framework and routing could be more effectively learned through PHP.
Thus, I taught myself PHP version **8.3+**, incorporating OOP principles and strict mode for type safety.

For database interactions, I used PDO with a database hosted on XAMPP.
During development, I've made use of XDebug as well.

> [!NOTE]
> This project served as my final practical exam/project, but with an **imaginary situation and customer**.

> [!WARNING]
> It is important to use PHP **V8.3+** for the project, otherwise there will be errors.

## Situation

In this scenario, the customer, "DigitalMakerFairs GmbH" operates in the educational sector with a course website similar to something like Udemy.
They offer official courses and allow community members to create their own courses under certain quality guidelines.

DigitalMakerFairs GmbH aimed to launch a new course series and combined community suggestions alongside their ideas.
After evaluating the feedback, they decided on a course series focused on MVC, titled _PHPioneers MVC Forge_.

The first course would be _Introduction to the MVCSpace_.
The code in this repository was intended as an example of a self-made MVC framework in PHP, featuring all essential components except for a fully-fledged service container, because time was limited.

> [!NOTE]
> The entire project, which includes the MVC framework, as well as a 12-15 pages documentation, plus a customer documentation, was created within two weeks (80 hours), with 95% of the "IHK" evaluation, focused on the documentation.
> Therefore the framework is rushed, but it taught me a lot and is for educational purposes after all.

## Framework Features

-   **Index.php**: Acts as the front controller
-   **App class**: Serves as the bootstrapper
-   **Request class**: Manages request logic
-   **Response class**: Handles response logic
-   **Router class**: Manages route logic including path parameters
-   **Middleware**: Ensures public resources like images and CSS are protected by the front controller
-   **DB class**: A PDO wrapper for database interactions
-   **Models**
-   **Views**
-   **Render function**: Renders views
-   **Controller classes**: Facilitate communication between models (DB) and views

## CRUD-Demo-App

The repository includes a CRUD-Demo-App, a simple note manager.
Users can register an account, log in, view all notes, read full notes (as notes are partially displayed on the app page), edit and delete notes, change their email and password, log out, or delete their account along with their notes.

> [!NOTE]
> The only reason I have HTMX is here, is because I wanted to test it out.

### Images

![HomePage](https://github.com/user-attachments/assets/3388cc3e-c5f3-4e83-b120-3d431a3c827d)
You can only access the HomePage if you're logged out.

![Register](https://github.com/user-attachments/assets/2dad4b48-8777-423c-aa14-3e07399a2075)
![Login](https://github.com/user-attachments/assets/f44804ac-8319-4fd1-b9e5-3aa2ec30683f)

![App](https://github.com/user-attachments/assets/e7d245a2-cf7d-483e-99d9-b4bc1e30f595)
You can only access the NoteApp if you're logged in.

![Creating a Note](https://github.com/user-attachments/assets/b0dfdbcb-53f8-440b-9194-58988e8133fc)
![Note on AppPage](https://github.com/user-attachments/assets/d9b9234b-80e5-4566-a86f-178792fc874f)
![Several notes on AppPage](https://github.com/user-attachments/assets/f569aa68-4062-4d4c-ad70-7daf04bbd80f)

![Editing a Note](https://github.com/user-attachments/assets/49c59871-a7ef-48ca-8423-5baf5e5b75fe)
![Edited Note](https://github.com/user-attachments/assets/10e676a1-b094-4cc6-b85d-bc4b95239cc9)

![Deleting a Note](https://github.com/user-attachments/assets/1c1fd9b1-3a5e-4587-b20e-49de1dc1966f)
![Note deleted](https://github.com/user-attachments/assets/6e465198-af87-43e5-82af-ea1ee5cbf943)

![Account Page](https://github.com/user-attachments/assets/6d356107-3013-4a3d-b02f-c26777bda8e8)
You can update either the E-Mail or the password or both (It does not require both to allow for updates).

![DB Account](https://github.com/user-attachments/assets/46a75989-3758-4fb3-be2f-0d82a6131bf1)
![DB Notes](https://github.com/user-attachments/assets/6b6b6a09-679b-4f85-b41e-dae6bfc81a14)