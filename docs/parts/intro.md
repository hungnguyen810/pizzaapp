## Authorization

Every request should always looking for json in response, so you have to set up your `HTTP HEADER` like this:

```http
Content-Type: application/json
Accept: application/json
```

For authorize your request, you have to add `Authorization` with your `token` to your `HTTP HEADER` like this:

```http
Authorization: Bearer <token-key>
Content-Type: application/json
Accept: application/json
```

## HTTP Status Codes

Code | Text | Description
--:| ---- | -----------
 200 | OK  | Success!
 400 | Bad Request | The request was invalid or cannot be otherwise served.
 401 | Unauthorized | Authentication credentials were missing or incorrect.
 403 | Forbidden | The request is understood, but it has been refused or access is not allowed.
 404 | Not Found | The URI requested is invalid or the resource requested, such as a user, does not exists.
 406 | Not Acceptable | Returned by the Search API when an invalid format is specified in the request.
 422 | Unprocessable Entity | Returned when request is invalid or unable to be validated
 500 | Internal Server Error | Something is broken. Please contact to us.
 502 | Bad Gateway | System is down or being upgraded.
 503 | Service Unavailable | System is still up, but overloaded with requests. Try again later.
 504 | Gateway timeout | System is still up, but the request couldn’t be serviced due to some failure within our stack. Try again later.

## Response

**Success**

HTTP/1.1 200
```json
{
    "message": "Your request has been proceed successfully!",
    "data": [
        {
            "id": 1,
            "object": "Entity name"
        },
    ],
}
```

**Success with Data & Meta like Pagination**

HTTP/1.1 200
```json
{
    "message": "Message that telling you about your data",
    "data": [
        {
            "id": 1,
            "object": "Entity name"
        },
        {
            "id": 2,
            "object": "Entity name"
        },
    ],
    "meta" : {
        "pagination": {
            "total": 1000,
            "last_page": 20,
            "per_page": 50,
            "current_page": 1
        }
    }
}
```

**Error**

HTTP/1.1 4xx 5xx
```json
{
    "message": "A message about this error",
    "error": {
        "status": true,
    }
}
```

**Validation error**

HTTP/1.1 422
```json
{
    "message": "A message about this error",
    "error": {
        "status": true,
        "messages": {
            "field_1": [
                "Error 1 of field 1",
                "Error 2 of field 1"
            ],
            "field_2": [
                "Error 1 of field 2"
            ]
        }
    }
}
```