# Forum Tech Restful API

This is the RESTful API for the [Forum-Tech](https://exemple.com) web application.  
The API is currently hosted and can be accessed with this url https://api.forum-tech.com.

## Authentication

Some endpoints are private. There is two public endpoints that allows you to signup and login therefore you can access to the private endpoints.  

> Notice: The API Authentication is SESSION based Authenctication

## CORE Resources

### Request

`GET /comments`

### Response

    {
        "current_user": {
            "user_name": "user11",
            "user_image": "http://localhost:8080/public/images/default-image.png"
        },
        "comments": [
            {
                "id": 18,
                "content": "comment comment comment",
                "created_at": "2023-03-24 15:32:16",
                "score": 0,
                "user": {
                    "user_name": "user3",
                    "user_image": "http://localhost:8080/public/images/user3-image.png"
                },
                "replies": [
                    {
                        "id": 20,
                        "content": "replying to comment 18 by user13",
                        "created_at": "2023-03-24 16:24:04",
                        "score": 0,
                        "replying_to": "user3",
                        "user": {
                            "user_name": "user13",
                            "user_image": "http://localhost:8080/public/images/user13-image.png"
                        }
                    }
                ]
            }
        ]
    }

### Request

`POST /comments`

### Response

    {
        "id": 35,
        "content": "new comment",
        "created_at": "2023-04-02 17:39:59",
        "score": 0,
        "user_id": 81
    }