# ManageX CMS

_(Still in development)_

A CMS(Content management system) RESTful API.

## Technologies

-   **Laravel Packages**:
    -   Sanctum
    -   Fortify
    -   Spatie Media
    -   Spatie Permissions
    -   Spatie Query Builder
-   **Database**
    -   MySQL, Postgres
-   **Development Tools**:
    -   Laravel Herd
    -   Postman

## Authentication Features

-   Email/password authentication (register, login with token)
-   Email verification
-   Password recovery
-   Two-step verification

## Features

### Roles

1.  **User**
    -   Can CRUD (Create, Read, Update, Delete) their own posts, profiles, and comments.
2.  **Admin**
    -   Can CRUD all posts, users, comments, and categories.

### Resources

#### **Post**

-   Attributes:
    -   Title, body
    -   Can belong to one user
    -   Can be published or unpublished
-   Relationships:
    -   Belongs to one **category**
    -   Has many **comments**
    -   Has many media files (photos, videos, documents)

#### **Comment**

-   Attributes:
    -   Content
-   Relationships:
    -   Belongs to one **user**

#### **Category**

-   Attributes:
    -   Name
-   Relationships:
    -   Has many **posts**

### API Features

-   Search, filter, sort, include, and paginate resources.
-   Secure media files and routes using middlewares.

## Example Usage

### Filter API Example

**Request**:

```http
http://api-auth.test/api/posts?filter[publish]=1&filter[category.name]=nature&filter[user.id]=10&include=category,user
```

**Explanation**:  
The above API request retrieves all posts that meet the following criteria:

1.  **Publish status** is `1` (published).
2.  **Category name** is `nature`.
3.  **User ID** is `10`.

Additionally, the response will include the details of the related `category` and `user` resources.

## Installation

Follow these steps to set up the project:

1.  Clone the repository:

    ```bash
    git clone https://github.com/aungmoe32/api-auth.git
    ```

2.  Switch to the `develop` branch:

    ```bash
    git checkout develop
    ```

3.  Install dependencies using Composer:

    ```bash
    composer install
    ```

4.  Set up the environment file:

    -   Copy `.env.example` to `.env`:

        ```bash
        cp .env.example .env
        ```

    -   Fill in the **database** and **email** configuration fields in the `.env` file.

5.  Run database migrations:

    ```bash
    php artisan migrate
    ```

6.  Seed the database:

    ```bash
    php artisan db:seed
    ```

7.  Start the development server:

    ```bash
    php artisan serve
    ```

### License

This project is licensed under the MIT License – see the [LICENSE](./LICENSE) file for details.
