# Techat API

_API Server:_  https://api.techat.com.

## Authentication

The API's authentication is based on __Session__. You can create an account here [Techat web application](https://github.com/serignebidev/tech-chat-web-application).

### Get Session ID

#### Request

`POST /authentication`

__Headers:__

`Accept: form-data`

__Body__ (_e.g._)__:__

    {
        "id": 1,
        "user_name": "username",
        "user_image": ""
    }

#### Response

`200 ok`

__Headers:__

`Content-type: Text`

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

Add comment
Request
POST /comments
Request headers
Accept: form-data

Response
200 ok
Response headers
Content-type: application-json
Exemples
{
"id": 35,
"content": "new comment",
"created_at": "2023-04-02 17:39:59",
"score": 0,
"user_id": 81
}

Reply a comment
Request
POST /comments?replying-to-comment={id}
Request headers
Accept: form-data

Response
200 ok
Response headers
Content-type: application-json
Exemples
{
"id": 35,
"content": "new comment",
"created_at": "2023-04-02 17:39:59",
"score": 0,
"user_id": 81
}

Modify a comment
Request
PATCH /comments/{id}
Request headers
Accept: application/json

Response
200 ok
Response headers
Content-type: application-json
Exemples
{
"id": 35,
"content": "new comment",
"created_at": "2023-04-02 17:39:59",
"score": 0,
"user_id": 81
}

Add/ remove score
Request
PATCH /comments/{id}?score={operation}
Request headers
Accept: application/json

Response
200 ok
Response headers
Content-type: application-json
Exemples
{
"id": 35,
"content": "new comment",
"created_at": "2023-04-02 17:39:59",
"score": 0,
"user_id": 81
}

Delete a comment
Request
DELETE /comments/{id}
Request headers
Accept: application/json

Response
200 ok
Response headers
Content-type: application-json
Exemples
no content