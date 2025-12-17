# ManageX API - Postman Collection Guide

## 📋 Overview

ManageX is a modern content management system API built with Laravel 10. This Postman collection provides comprehensive testing capabilities for all API endpoints including authentication, content management, user profiles, and administrative functions.

## 🚀 Quick Start

### 1. Import the Collection
1. Open Postman
2. Click **Import** button
3. Select `ManageX.postman_collection.json`
4. The collection will be imported with all organized endpoints

### 2. Environment Setup
Create a new environment in Postman with these variables:

| Variable | Description | Example Value |
|----------|-------------|---------------|
| `base_url` | Your API base URL | `http://localhost:8000` or `https://your-domain.com` |
| `auth_token` | Bearer token for authentication | (will be set automatically after login) |
| `user_id` | Current user ID | (will be set automatically after login) |

### 3. Authentication Flow
Before testing other endpoints, you must authenticate:
1. Navigate to **Auth > Login**
2. Update the request body with valid credentials
3. Send the request
4. The `auth_token` will be automatically set in your environment

## 📁 Collection Structure

The Postman collection is organized into the following folders:

### 🔐 Authentication
- **Login** - User authentication with email/password
- **Register** - New user registration
- **Logout** - Terminate current session
- **Password Reset** - Forgot password workflow
- **Email Verification** - Email verification endpoints
- **Two Factor Authentication** - 2FA setup and management

### 👤 User Management
- **Profile** - View and update user profile
- **Users** - CRUD operations for users (admin)
- **Roles** - User role management
- **Statistics** - User statistics and metrics

### 📝 Content Management
- **Posts** - Create, read, update, delete posts
- **Comments** - Manage post comments
- **Categories** - Content categorization
- **Favourites** - User favourite posts
- **Best Comments** - Mark/unmark best comments

### 📊 Academic Management
- **Subjects** - Academic subjects
- **Teachers** - Teacher management
- **Semesters** - Academic semesters

### 📎 Media Management
- **Upload Media** - File uploads for posts
- **Download Media** - Media file downloads
- **Profile Images** - User profile image management

### ⚙️ Admin Functions
- **Metrics** - System analytics and metrics (admin only)

## 🔑 Authentication

### Bearer Token Authentication
ManageX uses Laravel Sanctum for API authentication. After successful login, include the bearer token in all subsequent requests:

```
Authorization: Bearer {your_token_here}
```

### Token Lifecycle
- Tokens expire after 1 month
- Use the `/api/auth/logout` endpoint to revoke tokens
- Tokens are automatically included in requests after login via environment variables

## 📋 Common Workflows

### 1. User Registration & Login
```
1. POST /api/auth/register - Create new account
2. POST /api/auth/login - Get authentication token
3. GET /api/profile - Verify authentication
```

### 2. Creating a Post with Media
```
1. POST /api/posts - Create post
2. POST /api/posts/{id}/medias - Upload media files
3. GET /api/posts/{id} - View complete post
```

### 3. Content Interaction
```
1. GET /api/posts - Browse posts
2. POST /api/posts/{id}/comments - Add comment
3. POST /api/favourites/{id} - Add to favourites
4. POST /api/comments/{id}/best - Mark as best comment
```

## 🔧 Request Examples

### User Registration
```json
POST /api/auth/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!"
}
```

### Create Post
```json
POST /api/posts
{
    "title": "My First Post",
    "content": "This is the content of my post.",
    "category_id": 1,
    "publish": true
}
```

### Add Comment
```json
POST /api/posts/{post_id}/comments
{
    "content": "Great post! Very informative."
}
```

## 🎯 Testing Guidelines

### 1. Test Data Setup
- Use the provided seeders to populate test data
- Run: `php artisan db:seed`
- This creates sample users, posts, categories, and other test data

### 2. Permission Testing
The API includes role-based permissions:
- **ADMIN** - Full access to all endpoints
- **USER** - Standard user permissions
- **GUEST** - Limited read access

### 3. Error Handling
Expected error responses:
- `401 Unauthorized` - Missing or invalid token
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource doesn't exist
- `422 Unprocessable Entity` - Validation errors

## 🔍 Query Parameters

Many endpoints support query parameters for filtering and pagination:

### Filtering
```
GET /api/posts?filter[title]=Laravel&filter[publish]=1
GET /api/posts?filter[category.name]=Technology
```

### Sorting
```
GET /api/posts?sort=created_at
GET /api/posts?sort=-title (descending)
```

### Pagination
```
GET /api/posts?page=2
```

### Including Relations
```
GET /api/posts?include=comments,user
GET /api/posts/{id}?include=user
```

## 🚨 Rate Limiting

Be aware of rate limits:
- Login attempts: Limited to prevent brute force
- Email verification: Limited resends
- Media downloads: Throttled downloads
- General API: Standard rate limiting applied

## 📝 Response Format

All API responses follow a consistent format:

### Success Response
```json
{
    "data": { ... },
    "message": "Operation successful",
    "status": 200
}
```

### Error Response
```json
{
    "message": "Error description",
    "status": 400,
    "errors": { ... }
}
```

## 🔧 Environment Configuration

### Local Development
```
base_url = http://localhost:8000
```

### Staging/Production
```
base_url = https://your-api-domain.com
```

### SSL/TLS
Ensure HTTPS is used in production environments for security.

## 🐛 Troubleshooting

### Common Issues

1. **401 Unauthorized**
   - Ensure you're logged in and token is valid
   - Check if token is properly set in environment

2. **403 Forbidden**
   - Verify user has required permissions
   - Check role assignments

3. **422 Validation Error**
   - Review request body format
   - Check required fields are provided
   - Ensure data types match requirements

4. **404 Not Found**
   - Verify endpoint URL is correct
   - Check if resource exists
   - Ensure proper route parameters

### Debug Mode
Enable debug mode in your Laravel `.env` file for detailed error messages:
```
APP_DEBUG=true
```

## 📚 Additional Resources

- **API Documentation**: Available via Laravel Scramble at `/docs/api`
- **Laravel Sanctum**: [Official Documentation](https://laravel.com/docs/sanctum)
- **Spatie Query Builder**: Used for advanced filtering and sorting
- **Laravel Media Library**: Handles file uploads and media management

## 🤝 Contributing

When adding new endpoints to the collection:
1. Follow the existing folder structure
2. Include proper request examples
3. Document expected responses
4. Add environment variable usage where applicable
5. Update this README with new functionality

## 📄 License

This API and collection are part of the ManageX project under MIT License.

---

**Happy Testing! 🚀**

For support or questions, refer to the main project documentation or contact the development team.