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
    -   Redis for caching
    -   Minio (storing media files)
-   **Development Tools**:
    -   Laravel Herd
    -   DBngin
    -   Postman
    -   Laravel Telescope

## Authentication Features

-   Email/password authentication (register, login with token)
-   Email verification
-   Password recovery
-   Two-step verification
-   Confirm password

## Features

### Roles

1.  **User**
    -   Can CRUD (Create, Read, Update, Delete) their own posts, profiles, and comments.
2.  **Admin**
    -   Can CRUD all posts, users, comments, and categories.
    -   Get metrics of total users, total posts, total posts of categories, total comments, total media files.

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
-   **Update Profile Image**: Allow users to update their profile pictures.
-   **Add Posts to Favorites**: Enable users to bookmark posts for quick access.
-   **Mark Best Comment**: Authors can mark a comment as the best, triggering an email notification to the commenter.
-   **Get Trending Posts**: Retrieve a list of trending posts based on activity.
-   **User Profile with Interests**: Profiles include categories of interest to personalize user experience.
-   **Email Notifications for New Posts**: Notify users about new posts in their categories of interest, with queued emails for faster delivery.
-   **Caching with Redis**: Cache trending posts, favorite post counts, and media download counts for efficient data retrieval.
-   **Media Storage on S3 (Minio)**: Store media files securely on S3-compatible storage.
-   **Video Media Streaming**: Stream video content directly from the platform.
-   **Consistent JSON API Responses**: Ensure all API responses follow a uniform and structured JSON format.

### Security Features

-   **API Route Throttling**: Limit the number of requests to prevent abuse and ensure fair usage.
-   **Middleware Protection**: Secure API endpoints with middleware for authentication, validation, and other safeguards.
-   **Role-Based Access Control**: Enforce access control using roles, permissions, and policies to restrict unauthorized actions.
-   **Protected Media Files**: Secure media access with temporary signed URLs from S3.

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
