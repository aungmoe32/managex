# ManageX - Implementation Details

This document provides an in-depth look at the technical implementation of the ManageX Content Management System API. It covers the architecture, design patterns, database schema, and key components that make up the system.

### Directory Structure

```
app/
├── Http/
│   ├── Controllers/    # Request handlers
│   ├── Middleware/     # Request filters
│   ├── Requests/       # Form request validation
│   └── Resources/      # API resource transformers
├── Models/             # Eloquent models
├── Services/           # Business logic
├── Repositories/       # Data access layer
├── Events/             # Event classes
├── Listeners/          # Event listeners
├── Jobs/               # Queued jobs
├── Mail/               # Mail templates
├── Providers/          # Service providers
└── Traits/             # Reusable traits
```

## 💾 Database Schema

### Core Tables

1. **users**

    - id, name, email, password, email_verified_at, two_factor_secret, etc.
    - Stores user authentication and profile data

2. **posts**

    - id, title, body, user_id, category_id, publish, created_at, updated_at
    - Stores content created by users

3. **comments**

    - id, body, user_id, post_id, is_best, created_at, updated_at
    - Stores user comments on posts

4. **categories**

    - id, name, description, created_at, updated_at
    - Classifies posts into different topics

5. **media**
    - id, model_type, model_id, collection_name, name, file_name, etc.
    - Stores metadata for uploaded files (using Spatie Media Library)

### Pivot Tables

1. **category_user**

    - category_id, user_id
    - Tracks user interests in categories

2. **favourites**
    - user_id, post_id, created_at
    - Tracks user's favorite posts

### Role and Permission Tables

1. **roles**

    - id, name, guard_name
    - Defines user roles (admin, user, etc.)

2. **permissions**

    - id, name, guard_name
    - Defines granular permissions

3. **model_has_roles**

    - role_id, model_id, model_type
    - Assigns roles to users

4. **model_has_permissions**

    - permission_id, model_id, model_type
    - Assigns permissions to users

5. **role_has_permissions**
    - permission_id, role_id
    - Assigns permissions to roles

## 🔑 Authentication Implementation

ManageX uses a multi-layered authentication system:

### Laravel Fortify

Fortify provides the core authentication features:

-   Registration
-   Login
-   Password Reset
-   Email Verification
-   Two-Factor Authentication
-   Password Confirmation

### Laravel Sanctum

Sanctum provides token-based API authentication:

-   Token generation on login
-   Token validation for protected routes
-   Token revocation on logout

### Social Authentication

Social login is implemented using Laravel Socialite:

1. User initiates OAuth flow via `/api/auth/{provider}`
2. User is redirected to the OAuth provider
3. Provider redirects back with authorization code
4. Backend exchanges code for access token
5. Backend retrieves user information from provider
6. System creates or retrieves local user account
7. System issues authentication token to user

## 📝 Content Management Implementation

### Post Management

Posts are the core content type in ManageX:

1. **Creation Process**:

    - Validate post data (title, body, category)
    - Create post record
    - Handle media uploads (if any)
    - Associate post with user and category
    - Notify interested users (via queue)

2. **Retrieval Process**:

    - Apply filters (publish status, category, user)
    - Apply sorting (latest, trending)
    - Include related resources (user, category, media)
    - Transform using API resources
    - Cache popular posts in Redis

3. **Update Process**:

    - Validate ownership or admin status
    - Update post attributes
    - Handle media changes
    - Clear relevant caches

4. **Deletion Process**:
    - Validate ownership or admin status
    - Delete associated comments
    - Delete associated media
    - Delete post record
    - Clear relevant caches

### Media Management

Media files are managed using Spatie Media Library:

1. **Upload Process**:

    - Validate file type and size
    - Store file in S3/Minio
    - Create media record with metadata
    - Associate media with parent model (post)

2. **Access Control**:

    - Generate signed URLs for protected media
    - Validate URL signature before serving
    - Track download counts in Redis

3. **Media Conversions**:
    - Generate thumbnails for images
    - Create optimized versions for different devices
    - Convert videos to streamable format

## 🚦 API Request Flow

1. **Request Lifecycle**:

    - Request hits API endpoint
    - Middleware processes request (auth, throttling)
    - Controller receives request
    - Request is validated
    - Service layer processes business logic
    - Repository layer handles data operations
    - Response is transformed via API resources
    - Response is returned to client

2. **Filtering Implementation**:

    - Uses Spatie Query Builder
    - Defines allowable filters per endpoint
    - Handles relationship filtering
    - Applies scopes for complex filters

3. **Pagination**:

    - Default page size of 15 items
    - Customizable via query parameters
    - Includes metadata (total, pages, links)

4. **Includes (Eager Loading)**:
    - Defined allowable includes per endpoint
    - Optimizes database queries
    - Transforms included resources

## 🔄 Caching Strategy

ManageX uses Redis for caching frequently accessed data:

1. **Cache Keys**:

    - `post:{id}` - Individual post data
    - `posts:trending` - Trending posts list
    - `user:{id}:stats` - User activity statistics
    - `category:{id}:posts` - Posts in a category

2. **Cache Invalidation**:

    - Tag-based invalidation for related items
    - Time-based expiration for volatile data
    - Event-driven invalidation on updates

3. **User Statistics**:
    - Track post views in Redis
    - Track download counts in Redis
    - Calculate trending posts based on activity
    - Periodically sync Redis data to database

## 📨 Queued Jobs and Background Processing

1. **Email Notifications**:

    - New post notifications to interested users
    - Comment notifications to post authors
    - Best comment notifications

2. **Media Processing**:

    - File conversions and optimization
    - Thumbnail generation
    - Video processing

3. **System Maintenance**:
    - Cache warming
    - Statistics calculation
    - Database cleanup

## 🛡️ Security Implementations

1. **Rate Limiting**:

    - API-wide rate limits to prevent abuse
    - Stricter limits on authentication endpoints
    - Custom throttling for media downloads

2. **Input Validation**:

    - Form request validation for all endpoints
    - Sanitization of user input
    - Type checking and constraint validation

3. **Authorization**:

    - Policy-based authorization for resources
    - Role-based access control via Spatie Permissions
    - Gate definitions for complex authorization rules

4. **Media Protection**:
    - Signed URLs for media access
    - Temporary URLs with expiration
    - Download tracking to detect abuse

## 🧪 Testing Strategy

1. **Unit Tests**:

    - Test individual components in isolation
    - Mock dependencies
    - Focus on business logic

2. **Feature Tests**:

    - Test API endpoints
    - Test authentication flows
    - Test authorization rules

3. **Integration Tests**:
    - Test component interactions
    - Test database operations
    - Test cache operations

## 📊 Metrics and Monitoring

1. **System Metrics**:

    - User registration counts
    - Post creation counts
    - Media storage usage
    - API endpoint usage

2. **Performance Monitoring**:

    - Response times
    - Database query performance
    - Cache hit/miss rates
    - Queue processing times

3. **Error Tracking**:
    - Exception logging
    - Failed job tracking
    - Authentication failures
    - Rate limit breaches

## 🚀 Deployment Considerations

1. **Environment Setup**:

    - PHP 8.1+ environment
    - Composer for dependency management
    - MySQL/PostgreSQL database
    - Redis server
    - S3-compatible storage

2. **Queue Worker**:

    - Supervisor configuration for queue workers
    - Multiple queue workers for high-traffic systems
    - Dedicated queues for different job types

3. **Caching**:

    - Redis configuration for optimal performance
    - Cache warming on deployment
    - Cache tag management

4. **Storage**:

    - S3 bucket configuration
    - CORS settings for direct uploads
    - Lifecycle policies for temporary files

5. **Scaling Strategies**:
    - Horizontal scaling for API servers
    - Database read replicas
    - Redis clustering
    - CDN for media delivery
