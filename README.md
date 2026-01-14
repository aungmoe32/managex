
# ManageX - Modern Content Management System API

ManageX is a powerful, feature-rich RESTful API for content management systems built with Laravel. It provides a comprehensive set of tools for managing posts, comments, users, media files, and more, with robust authentication, role-based access control, and advanced filtering capabilities.

##  Live Demo

-   Swagger UI : [https://managex-swagger-ui.vercel.app/](https://managex-swagger-ui.vercel.app/)

-   Postman : https://www.postman.com/lunar-module-physicist-24945643/workspace/managex/collection/39561853-542b1145-7737-48e2-a0b1-37519ffa5c82?action=share&creator=39561853

-   You can explore a live demo of ManageX at: [https://managex-main-lunwyu.laravel.cloud/](https://managex-main-lunwyu.laravel.cloud/)

This demo instance showcases the full functionality of ManageX in a production environment. Feel free to explore the features, API endpoints, and documentation.

##  Table of Contents

-   [Live Demo](#live-demo)
-   [Features](#features)
-   [Tech Stack](#tech-stack)
-   [Technical Implementation](#technical-implementation)
-   [API Endpoints](#api-endpoints)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage Examples](#usage-examples)
-   [Authentication](#authentication)
-   [Testing with Postman](#testing-with-postman)
-   [API Documentation](#api-documentation)
-   [Contributing](#contributing)
-   [License](#license)

##  Features

###  Authentication

-   Email/password authentication (register, login with token)
-   Email verification
-   Password recovery
-   Two-factor authentication (2FA)
-   Password confirmation
-   Social login via OAuth (GitHub, Google, Facebook)

###  Role-Based Access Control

-   **User Role**
    -   Create, read, update, and delete their own posts, profiles, and comments
-   **Admin Role**
    -   Manage all posts, users, comments, and categories
    -   Access to system metrics and analytics

###  Content Management

-   **Posts**
    -   Create, publish, update, and delete posts
    -   Attach media files (images, videos, documents)
    -   Categorize posts
    -   Mark posts as favorites
-   **Comments**
    -   Add comments to posts
    -   Mark comments as "best comment"
    -   Email notifications for best comments
-   **Categories**
    -   Organize posts by categories
    -   User interest tracking by category

###  Advanced API Features

-   Comprehensive filtering, sorting, and pagination
-   Resource inclusion for related data
-   Full-text search capabilities
-   Trending posts based on activity
-   Personalized content based on user interests

###  Security Features

-   API rate limiting and throttling
-   Middleware protection layers
-   Role-based access control
-   Secure media access with signed URLs

###  Performance Optimizations

-   Redis caching for popular content
-   Queued email notifications
-   Efficient media file handling

##  Tech Stack

### Core Framework

-   [Laravel 10.x](https://laravel.com) - PHP Framework

### Laravel Packages

-   [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum) - API authentication
-   [Laravel Fortify](https://laravel.com/docs/10.x/fortify) - Frontend authentication
-   [Spatie Media Library](https://github.com/spatie/laravel-medialibrary) - Media management
-   [Spatie Permissions](https://github.com/spatie/laravel-permission) - Role-based permissions
-   [Spatie Query Builder](https://github.com/spatie/laravel-query-builder) - API filtering
-   [Laravel Socialite](https://laravel.com/docs/10.x/socialite) - OAuth authentication
-   [Laravel Telescope](https://laravel.com/docs/10.x/telescope) - Debugging assistant

### Storage & Caching

-   MySQL/PostgreSQL - Primary database
-   Redis - Caching layer
-   Minio/S3 - Media file storage

### Development Tools

-   Laravel Herd - Local development environment
-   DBngin - Database management
-   Postman - API testing

##  Technical Implementation

For developers who want to understand the technical details of how ManageX is built, we provide a comprehensive implementation guide. This document covers:

-   Architecture overview and design patterns
-   Database schema and relationships
-   Authentication implementation details
-   Content management workflows
-   API request flow and filtering
-   Caching strategies
-   Background processing with queues
-   Security implementations
-   Testing strategies
-   Metrics and monitoring
-   Deployment considerations

For the complete technical documentation, see [IMPLEMENTATION.md](./IMPLEMENTATION.md).

##  API Endpoints

### Authentication

-   `POST /api/auth/register` - Register a new user
-   `POST /api/auth/login` - Login and get token
-   `POST /api/auth/logout` - Logout and invalidate token
-   `POST /api/auth/forgot-password` - Request password reset
-   `GET /api/auth/{provider}` - Redirect to OAuth provider
-   `GET /api/auth/{provider}/callback` - Handle OAuth callback

### Posts

-   `GET /api/posts` - List all posts (with filtering)
-   `GET /api/posts/trending` - Get trending posts
-   `POST /api/posts` - Create a new post
-   `GET /api/posts/{id}` - Get a specific post
-   `PUT /api/posts/{id}` - Replace a post
-   `PATCH /api/posts/{id}` - Update a post
-   `DELETE /api/posts/{id}` - Delete a post

### Comments

-   `GET /api/posts/{post}/comments` - Get comments for a post
-   `POST /api/posts/{post}/comments` - Add a comment to a post
-   `POST /api/comments/{comment}/best` - Mark as best comment
-   `DELETE /api/comments/{comment}/best` - Unmark as best comment

### Favorites

-   `POST /api/favourites/{post}` - Add post to favorites
-   `DELETE /api/favourites/{post}` - Remove post from favorites
-   `GET /api/favourites` - Get user's favorite posts

### Media

-   `POST /api/posts/{post}/medias` - Upload media to a post
-   `DELETE /api/posts/{post}/medias/{media_id}` - Delete media from a post
-   `GET /api/download/{id}/{filename}` - Download media file
-   `GET /api/profile-image/{id}/{filename}` - Get profile image

### User & Profile

-   `GET /api/profile` - Get current user profile
-   `POST /api/profile` - Update user profile
-   `PUT /api/update-password` - Update password
-   `PUT /api/update-email` - Update email

### Admin

-   `GET /api/metrics` - Get system metrics (admin only)

##  Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/aungmoe32/managex.git
    cd managex
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Set up environment variables**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure your database**
   Edit the `.env` file and set your database credentials:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=managex
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Run migrations and seed the database**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. **Configure storage for media files**

    ```bash
    php artisan storage:link
    ```

7. **Start the development server**
    ```bash
    php artisan serve
    ```

##  Configuration

### Email Configuration

Configure your email settings in the `.env` file:

```
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=your_mail_port
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### S3/Minio Configuration

For media file storage, configure S3 or Minio:

```
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=your_region
AWS_BUCKET=your_bucket
AWS_ENDPOINT=your_endpoint
AWS_USE_PATH_STYLE_ENDPOINT=true
```

### Redis Configuration

For caching, configure Redis:

```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### OAuth Configuration

For social login, configure the providers:

```
GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URI=your_redirect_uri

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=your_redirect_uri

FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT_URI=your_redirect_uri
```

##  Usage Examples

### Filtering API Example

**Request**:

```http
GET /api/posts?filter[publish]=1&filter[category.name]=nature&filter[user.id]=10&include=category,user
```

This retrieves all published posts in the "nature" category by user ID 10, and includes the category and user details in the response.

### Create a Post Example

**Request**:

```http
POST /api/posts
Content-Type: application/json
Authorization: Bearer your_token

{
  "title": "My New Post",
  "body": "This is the content of my post",
  "category_id": 1,
  "publish": true
}
```

### Upload Media Example

**Request**:

```http
POST /api/posts/1/medias
Content-Type: multipart/form-data
Authorization: Bearer your_token

file: [binary file data]
```

##  Authentication

### Register a New User

```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secure_password",
  "password_confirmation": "secure_password"
}
```

### Login

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "secure_password"
}
```

The response will include an authentication token to be used in subsequent requests.

##  Testing with Postman

A comprehensive Postman collection is included in this repository to help you test all API endpoints. The collection file `ManageX.postman_collection.json` contains pre-configured requests for all available endpoints.

### Using the Postman Collection

1. **Import the Collection**

    - Open Postman
    - Click "Import" button
    - Select the `ManageX.postman_collection.json` file from the project root

2. **Configure Environment Variables**

    - Create a new environment in Postman
    - Add the following variables:
        - `base_url`: Your API base URL (e.g., `http://localhost:8000/api`)
        - `token`: Your authentication token (will be set automatically after login)

3. **Authentication Flow**

    - Use the "Register" or "Login" request first to get an authentication token
    - The collection includes pre-request scripts that will automatically set the token for subsequent requests

4. **Available Request Groups**
    - Authentication (Register, Login, Logout, Password Reset)
    - Posts (List, Create, Update, Delete)
    - Comments (List, Create, Mark as Best)
    - Categories (List, Create, Update, Delete)
    - Media (Upload, Download)
    - User Profile (View, Update)
    - Admin (Metrics)

The Postman collection is regularly updated to match the latest API endpoints and features.

##  API Documentation

ManageX uses [Laravel Scramble](https://github.com/dedoc/scramble) to automatically generate comprehensive API documentation from your code.

### Features

-   **OpenAPI Specification**: Generates documentation following the OpenAPI 3.0 standard
-   **Interactive UI**: Provides a Swagger UI interface for exploring and testing endpoints
-   **Authentication Support**: Includes authentication methods in the documentation
-   **Request/Response Examples**: Shows example requests and responses for each endpoint
-   **Validation Rules**: Documents validation rules for request parameters

### Accessing the Documentation

Once the application is running, you can access the API documentation at:
http://localhost:8000/docs/api

This interactive documentation allows you to:

1. Browse all available endpoints
2. See required parameters and response formats
3. Test API calls directly from the browser
4. Understand authentication requirements
5. Download the OpenAPI specification for use in other tools

### Customizing Documentation

You can customize the Scramble configuration in the `config/scramble.php` file to:

-   Add additional information about your API
-   Configure security schemes
-   Set up response examples
-   Include or exclude specific routes

The documentation is automatically updated whenever you make changes to your API endpoints, ensuring it always stays in sync with your code.

##  Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

##  License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) file for details.
