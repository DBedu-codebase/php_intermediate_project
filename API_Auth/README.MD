# API Auth
In this project you are required to develop a REST API for user authentication and authorization using JWT. 
## Goals
The skills you will learn from this project include:

- User authentication
- Schema design and databse
- Restful API design
- JWT (JSON Web Token)
- Create operations with PDO
- Error handling
- form validation

## Requirements
You are required to Rest API for user authentication and authorization using JWT.
- User registration to create a new user
- Login endpoint to authenticate the user and generate a token
- Implementation of Create operations with PDO
- Implementation of error handling and form validation
- Use a database to store the users data (for begginer choose MySQL)
### User Registration
Register a new user account
```json 
POST /api/v1/auth/register
{
    "username": "Jhon Doe",
    "password": "JhonDoe1234"
}
```
### User Login
Authentication users login
```json 
POST /api/v1/auth/login
{
    "username": "Jhon Doe",
    "password": "JhonDoe1234"
}
```
This is will be generated JWT token 
```json 
{
    "message": "Login successfully",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJqb2tvLXBvc3RtYW4iLCJleHAiOjE3MzgyMjk2MDB9.JCdVSt3A-X5aONTkHGFWwM5PWzDPkIXTAh0kzBMmjZc",
        "expiry": "2025-01-30T09:33:20+00:00"
    }
}
```
### Error-Handling and Form-validation
Validating Users Input
```json 
POST /api/v1/auth/login
{
    "username": "Jhon Doe",
    "password": "JhonDoe1234"
}
```
This project will help you understand how to implement REST API with PHP using OOP and JWT. 