# Group Order

## Order Pizza [POST /order]
Order pizza

#### Request Attributes
Name | Contrains | Description
---- | --------- | -----------
pizza_id  | `number`  `required` | Pizza ID
pizza_option_id  | `number`  `required` | Pizza Option ID
address  | `string`  `required` | Customer Address

+ Request Sample
    {
       "pizza_id" : "1",
       "pizza_option_id" : "1",
       "address" : "Hanoi"
    }
