# Techat API

A Restfull API for the [Techat](https://github.com/segnbi/techat)'s web application built with [PHP](https://en.wikipedia.org/wiki/PHP).

## Authentication

This API's authtication is __Session__ based authentication.

### Get Session ID

#### Request

`POST /authentication`

__Headers:__

`Content-type: multipart/form-data`

__Body__ (_e.g._)__:__

    {
        "user_name": "username",
        "user_password": "password"
    }

#### Response

`200 ok`

__Headers:__

`N/A`

__Body__ (_e.g._)__:__

    N/A

## Core resources

### Retrieve all comments

#### Request

`GET /comments`

__Headers:__

`N/A`

__Body__ (_e.g._)__:__

    N/A

#### Response

`200 ok`

__Headers:__

`Content-type: application-json`

__Body__ (_e.g._)__:__

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

### Add comment

#### Request

`POST /comments`

__Headers:__

`Content-type: multipart/form-data`

__Body__ (_e.g._)__:__

    {
        "content": "new comment",
    }

#### Response

`200 ok`

__Headers:__

`Content-type: application-json`

__Body__ (_e.g._)__:__

    {
        "id": 35,
        "content": "new comment",
        "created_at": "2023-04-02 17:39:59",
        "score": 0,
        "user_id": 81
    }

### Reply a comment

### Request

`POST /comments?replying-to-comment={id}`

__Headers:__

`Content-type: multipart/form-data`

__Body__ (_e.g._)__:__

    N/A

#### Response

`200 ok`

__Headers:__

`Content-type: application-json`

__Body__ (_e.g._)__:__

    N/A

### Modify a comment

### Request

`PATCH /comments/{id}`

__Headers:__

`Content-type: application/json`

__Body__ (_e.g._)__:__

    N/A

#### Response

`200 ok`

__Headers:__

`Content-type: application/json`

__Body__ (_e.g._)__:__

    N/A

### Modify score

### Request

`PATCH /comments/{id}?score={ +1 | -1 }`

__Headers:__

`N/A`

__Body__ (_e.g._)__:__

    N/A

#### Response

`200 ok`

__Headers:__

`Content-type: application/json`

__Body__ (_e.g._)__:__

    N/A

### Delete a comment

### Request

`DELETE /comments/{id}`

__Headers:__

`N/A`

__Body__ (_e.g._)__:__

    N/A

#### Response

`204 No content`

__Headers:__

`N/A`

__Body__ (_e.g._)__:__

    N/A
