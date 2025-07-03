# Libretto API Documentation

## Authentication with Daily Expiring Tokens

This API uses Laravel Sanctum for authentication with daily expiring tokens. The token system works as follows:

- Tokens expire after 24 hours
- When a user logs in, the system checks if they have a valid (non-expired) token
- If a valid token exists, it returns the existing token
- If no valid token exists, it creates a new one
- Only one token per user is active at a time

## Base URL
```
http://localhost:8000/api
```

## Authentication Endpoints

### 1. Register User
```http
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:**
```json
{
    "message": "Registration successful",
    "token": "1|abc123def456...",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "expires_at": "2025-07-03T10:30:00.000000Z",
    "token_created": true
}
```

### 2. Login User
```http
POST /api/login
Content-Type: application/json

{
    "username": "testuser",
    "password": "password"
}
```

**Response (New Token):**
```json
{
    "message": "Login successful",
    "token": "2|xyz789abc123...",
    "user": {
        "id": 1,
        "name": "Test User",
        "email": "test@example.com"
    },
    "expires_at": "2025-07-03T10:30:00.000000Z",
    "token_created": true
}
```

**Response (Existing Valid Token):**
```json
{
    "message": "Login successful",
    "token": "existing-token",
    "user": {
        "id": 1,
        "name": "Test User",
        "email": "test@example.com"
    },
    "expires_at": "2025-07-03T10:30:00.000000Z",
    "token_created": false
}
```

### 3. Get User Info
```http
GET /api/user
Authorization: Bearer YOUR_TOKEN_HERE
```

### 4. Refresh Token
```http
POST /api/refresh-token
Authorization: Bearer YOUR_TOKEN_HERE
```

### 5. Logout
```http
POST /api/logout
Authorization: Bearer YOUR_TOKEN_HERE
```

## CRUD Endpoints (Protected)

All CRUD operations require authentication. Include the token in the Authorization header:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

### Books
- `GET /api/books` - List all books
- `POST /api/books` - Create a book
- `GET /api/books/{id}` - Get a specific book
- `PUT /api/books/{id}` - Update a book
- `DELETE /api/books/{id}` - Delete a book
- `GET /api/authors/{id}/books` - Get books by author
- `GET /api/genres/{id}/books` - Get books by genre

### Authors
- `GET /api/authors` - List all authors
- `POST /api/authors` - Create an author
- `GET /api/authors/{id}` - Get a specific author
- `PUT /api/authors/{id}` - Update an author
- `DELETE /api/authors/{id}` - Delete an author

### Genres
- `GET /api/genres` - List all genres
- `POST /api/genres` - Create a genre
- `GET /api/genres/{id}` - Get a specific genre
- `PUT /api/genres/{id}` - Update a genre
- `DELETE /api/genres/{id}` - Delete a genre

### Reviews
- `GET /api/reviews` - List all reviews
- `POST /api/reviews` - Create a review
- `GET /api/reviews/{id}` - Get a specific review
- `PUT /api/reviews/{id}` - Update a review
- `DELETE /api/reviews/{id}` - Delete a review
- `GET /api/books/{id}/reviews` - Get reviews for a book

## Public Endpoints (No Authentication Required)

These endpoints are available without authentication for browsing:

- `GET /api/public/books` - Browse books
- `GET /api/public/books/{id}` - View a book
- `GET /api/public/authors` - Browse authors
- `GET /api/public/authors/{id}` - View an author
- `GET /api/public/genres` - Browse genres
- `GET /api/public/genres/{id}` - View a genre
- `GET /api/public/reviews` - Browse reviews
- `GET /api/public/books/{id}/reviews` - View book reviews

## Example: Creating a Book

```http
POST /api/books
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json

{
    "title": "Horus Rising",
    "author_id": 1,
    "genre_ids": [1, 2, 3]
}
```

## Test Users Available

After running the seeder, these test users are available:

- **Username:** testuser **Password:** password
- **Username:** admin **Password:** password

## Token Expiry Behavior

1. **Login with valid token:** Returns existing token info
2. **Login with expired token:** Creates new token and deletes old one
3. **API requests with expired token:** Returns 401 Unauthorized
4. **Refresh token endpoint:** Checks expiry and creates new token if needed

## Testing with curl

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"testuser","password":"password"}'

# Use the token from login response
curl -X GET http://localhost:8000/api/books \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```
