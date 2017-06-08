# Group Authentication

## User Login [POST /user/login]
User login

#### Request Attributes
Name | Contrains | Description
---- | --------- | -----------
email  | `email`  `required` | User unique email
password  | `string`  `required` | User secret password

+ Request Sample
    {
        "email": "user@example.com",
        "password": "123456"
    }
