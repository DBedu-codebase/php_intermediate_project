# Todo List API
- In this project you are required to develop a REST API for user authentication and authorization using JWT and CRUD Todo operations using PDO. 
## Goals
The skills you will learn from this project include:

- User authentication
- Schema design and databse
- Restful API design
- JWT (JSON Web Token)
- CRUD operations with PDO
- Error handling
- Security

## Requirements
You are required to develop a REST API for user authentication and authorization using JWT and CRUD Todo operations using PDO. 
- User registration to create a new user
- Login endpoint to authenticate the user and generate a token
- Implementation of Create, Read, Update, Delete operations Todo with PDO
- Implementation of error handling and form validation
- Use a database to store the users and to-do-list data (for begginer choose MySQL)
- Implementation pagination and filtering for the to-do-list data based on status to-do-list.
- Implementation of ordering for the to-do-list data based on ASC or DESC, based on task_id.
### User Registration
Register a new user account
```json 
POST /api/v1/auth/register
{
    "name": "text",
    "email": "text@gmail.com",
    "password": "text1@gmail.com"
}
```
### User Login
Authentication users login
```json 
POST /api/v1/auth/login
{
    "email": "text@gmail.com",
    "password": "text1@gmail.com"
}
```
This is will be generated JWT token 
```json 
{
    "message": "Login successfully",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwiZW1haWwiOiJqaG9uLmRvZUBnbWFpbC5jb20iLCJleHAiOjE3Mzg2Mzc1NjN9.Tc8Z2-OgrhZypD7ZYi1UP1CSBezAV-PtpuLcEuytJbw",
        "expiry": "2025-02-04T02:52:43+00:00"
    }
}
```
### CRUD Todo operations
Read all Todo list
```json 
GET /api/v1/todos?orderBy=ASC&page=1&limit=11&status=1   
Bearer Token: 
eyJ0eXAiOiJK.eyJpZCI6MTA.Pq4spR_q_sS5I
Response:
{
    "message": "Successfully Get All Todo",
    "data": {
        "todo": [
            {
                "task_id": 2,
                "title": "Update Todos",
                "description": "This is the update data from todos",
                "author_id": 1,
                "created_at": "2025-02-03 11:24:49",
                "updated_at": "2025-02-03 12:39:18",
                "status": 1
            },
            {
                "task_id": 12,
                "title": "Update Todos",
                "description": "This is the update data from todos",
                "author_id": 1,
                "created_at": "2025-02-03 19:44:38",
                "updated_at": "2025-02-03 12:44:54",
                "status": 1
            }
        ],
        "page": 1,
        "limit": 11,
        "total": 2
    }
}
```
Read Todo list based on ID
```json 
GET /api/v1/todos/2 
Bearer Token: 
eyJ0eXAiOiJK.eyJpZCI6MTA.Pq4spR_q_sS5I
Response:
{
    "message": "Successfully Get Blog Based Id",
    "data": {
        "blog": {
            "task_id": 2,
            "title": "Update Todos",
            "description": "This is the update data from todos",
            "author_id": 1,
            "created_at": "2025-02-03 11:24:49",
            "updated_at": "2025-02-03 12:39:18",
            "status": 1
        }
    }
}
```
Create a new Todo list
```json 
POST /api/v1/todos
Bearer Token: 
eyJ0eXAiOiJK.eyJpZCI6MTA.Pq4spR_q_sS5I
Input:
{
  "title": "Add new data todos",
  "description": "description about data todos"
}
Response:
{
    "message": "Successfully Create Todo",
    "data": {
        "todo": {
            "id": "13",
            "title": "Add new data todos",
            "description": "description about data todos",
            "author_id": 1
        }
    }   
}
```
Update a Todo list based on id
```json 
PUT /api/v1/todos/13
Bearer Token: 
eyJ0eXAiOiJK.eyJpZCI6MTA.Pq4spR_q_sS5I
Input:
{
  "title": "Update Todos on id 13",
  "description": "This is the update data from todos",
  "status": 1
}
Response:
{
    "message": "Successfully Update TodoList",
    "data": {
        "todo": {
            "id": 13,
            "title": "Update Todos on id 13",
            "description": "This is the update data from todos",
            "status": 1,
            "author_id": 1,
            "updated_at": "2025-02-04 02:48:54"
        }
    }
}
```
Delete a Todo list based on id
```json 
DELETE /api/v1/todos/13 
Bearer Token: 
eyJ0eXAiOiJK.eyJpZCI6MTA.Pq4spR_q_sS5I
Response:
{
    "message": "Deleted successfully"
}
```
### Error-Handling and Form-validation
Validating Users Input
```json 
POST /api/v1/auth/register
{
    "errors": {
        "email": "email is required",
        "username": "max:50 is required",
        "password_hash": "max:255 is required"
    }
}
```
```json 
POST /api/v1/todos
{
    "errors": {
        "title": "max:50 is required",
        "description": "max:255 is required"
    }
}
```
```json 
PUT /api/v1/todo/2
{
    "errors": {
        "title": "max:50 is required",
        "description": "max:255 is required",
        "status": "maxNumber:1 is required"
    }
}
```
This project will help you understand how to implement REST API with PHP using OOP and JWT. You will also learn about database, handle errors and security. 
