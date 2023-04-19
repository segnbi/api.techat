# Tech Chat Restful API

This is the RESTful API for the [Forum-Tech](https://exemple.com) web application.  
The API is currently hosted and can be accessed with this url https://api.forum-tech.com.

## Authentication

The API authentication is based on **SESSION**. These two public endpoints allows you to create an account and login therefor you can access to the privates endpoints.

### Sign up

`POST /users` _with ***form-data*** content type_

### Login

`POST /authentication` _with ***form-data*** content type_

#### Response

    {
        "id": 1,
        "user_name": "username",
        "user_image": ""
    }

## CORE Resources

### Retrive comments

##### Endpoint

`GET /comments`

##### Response

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

### Post new comment

#### Endpoint

`POST /comments`

#### Response

    {
        "id": 35,
        "content": "new comment",
        "created_at": "2023-04-02 17:39:59",
        "score": 0,
        "user_id": 81
    }

### Post a reply

#### Endpoint

`POST /comments?replying-to-comment={id}` _with ***form-data*** content type_

#### Response

    {
        "id": 35,
        "content": "new comment",
        "created_at": "2023-04-02 17:39:59",
        "score": 0,
        "user_id": 81
    }

### modify a comment

#### Endpoint

`PATCH /comments/{id}` _with ***application/json*** content type_

#### Response

    {
        "id": 35,
        "content": "new comment",
        "created_at": "2023-04-02 17:39:59",
        "score": 0,
        "user_id": 81
    }

### give a score

#### Endpoint

`PATCH /comments/{id}?score={operation}` \*with **\*operation = +1 or -1\*\***

#### Response

    {
        "id": 35,
        "content": "new comment",
        "created_at": "2023-04-02 17:39:59",
        "score": 0,
        "user_id": 81
    }

### delete a comment

#### Endpoint

`DELETE /comments/{id}`

#### Response

    no-content
