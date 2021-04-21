# PurchAPI
Laravel API with Oauth2 

**PRODUCT-PURCHASE API**

The API was developed using PHP laravel in docker and we can find the source code on Github:  https://github.com/nzajos/PurchAPI/tree/master 


**1.Requests (All)**
Content-type: application/json

**2.Oauth2 REGISTRATION **

#2.1 Request sample    POST:  http://localhost/api/user/signup

{ "name": "josue",
"email": "nzajos3@gmail.com",
"password": "Josue@123!!",
"password_confirmation": "Josue@123!!" }



#2.2 Successfully created user
{
    "message": "Successfully created user!"
}


#2.3 User duplication

{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}


#3. Login
#3.1 POST:  http://localhost/api/user/login

#3.2 Request sample
{ "email": "nzajos3@gmail.com",
"password": "Josue@123!!",
"remember_me": "true", }


#3.3  Response sample
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMWRmNmExZTRkNTFiY2ZmMjJjM2Q4NzQzZTNiMzM4MDM0NGU2YTJkNWFmYzdkZmFlZDdjZjFkYWVhZjFlOWMzNGE5ZDQ2OTA1ODNhMzA1MzQiLCJpYXQiOiIxNjE1Mzc3MzMzLjM1MzUxOCIsIm5iZiI6IjE2MTUzNzczMzMuMzUzNTI4IiwiZXhwIjoiMTY0NjkxMzMzMi44OTczMjciLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.4hWDik6amkv79N7JqKRmzCCDdi2nCbhlkKDQQ79eQLEklRUtrgWcOZ_jV3kcseTNwagImIvS6EmpFhALzlwSq-hl1xUUa1GjDxVGJxy01ji9FMb9CZF4ztm0shF_Z8_Evrl8vViBMVxJvilkJalpwaWh3qsrBlsLeCTVQqwH3xZimH-fRIlBoE8uRtZW0x1dnRELod3d5w23tUZ_iurue_FcGtOGoPRfUoqLyysOtIMSwYp_M66vPJM7am56_zzgQ98RvM7VNOz8DfyNyci7FMemTn2EZOEgw21l81o06H39h_ZQJcBzWJvsCmYD_EmN6BGuUXGze6Xqxfx2Do7_pmP3Kh5G2lW6M-UW5XtgF-63c6JRkkHkOzixQewan-wjCZGp5n8abNjv2OHye3jCszyL4rqHAh6PIm4jbkBih5X-SpT3A8z7_7BrV7r6WHR5ivgcqhRoawh7Ninb7NSnk0z41CkM-Cmx3roU1L8pYowxaniR4vBoMcH3uXUGc-l1p5IdG4mVit9mZqbXjQRPpQt67NtvRvQjwY0rl7HltdaqFYlpD_7ls05Ai2Mtc8jfPBWzT01yVBj8uVaJr8fXhl0jrksdXutUPSLkqi0HondBCo0eyvy7IHERGubT730hV9_7JR239yn25JqYJvMJmz2PJ7Bwy5RPSt2PsALIDZc",
    "token_type": "Bearer",
    "expires_at": "2022-03-10 11:55:32"
}


#4.  Product registration
#4.1  Request sample POST:  http://localhost/api/product/store

{"name": "Fish"}



#4.2 When Token is not available:
{"message": "Unauthenticated."}



#4.3 Product already registered
{
    "status": "error",
    "status_code": 500,
    "message": [
        "Product already registered."
    ]
}



#4.4 Get product list    (order by product name)
GET:    http://localhost/api/product/productlist
[
    {
        "id": 3,
        "name": "Tea",
        "created_at": "2021-03-10T16:31:42.000000Z",
        "updated_at": "2021-03-10T16:31:42.000000Z"
    },
    {
        "id": 4,
        "name": "Fish",
        "created_at": "2021-03-10T17:36:42.000000Z",
        "updated_at": "2021-03-10T17:36:42.000000Z"
    }
]

#5. PURCHASER 
#5.1 Purchaser registration   POST:  http://localhost/api/purchaser/store
{"name": "Nzajyayo"}



#5.1 List of purchasers
GET:  http://localhost/api/purchaser/purchaserlist
[
    {
        "id": 2,
        "name": "josue",
        "created_at": "2021-03-11T10:46:10.000000Z",
        "updated_at": "2021-03-11T10:46:10.000000Z"
    },
    {
        "id": 1,
        "name": "Nzajyayo",
        "created_at": "2021-03-11T09:27:55.000000Z",
        "updated_at": "2021-03-11T09:27:55.000000Z"
    }
]


#6.Purchase Product
#6.1 Request POST: http://localhost/api/purchaser_product/store
{ "purchase_id": 1,
"product_id": 2,
"purchase_timestamp": 1566265701 }

#6.2 Response sample
{"message": "Successfully created purchase record!"}


#6.3 List of purchase-product
Request sample   GET:http://localhost/api/purchaser_product/purchaserlist
[{
        "id": 6,
        "product_id": 2,
        "purchase_id": 1,
        "purchase_timestamp": "2019-08-20 01:48:21",
        "created_at": "2021-03-13T01:51:12.000000Z",
        "updated_at": "2021-03-13T01:51:12.000000Z"
    }]


#7.  Purchase product without start and end date

GET:  http://localhost/api/purchaser/1/product    (1 is the purchaser id)
{
    "purchases": {
        "2021-03-11 00:00:00": [
            {
                "name": "Birthday cake",
                "purchase_timestamp": "2021-03-11 00:00:00"
            },
            {
                "name": "Birthday cake",
                "purchase_timestamp": "2021-03-11 00:00:00"
            },
            {
                "name": "Birthday cake",
                "purchase_timestamp": "2021-03-11 00:00:00"
            },
            {
                "name": "Tomato",
                "purchase_timestamp": "2021-03-11 00:00:00"
            }
        ],
        "2019-08-20 01:48:21": [
            {
                "name": "Tomato",
                "purchase_timestamp": "2019-08-20 01:48:21"
            },
            {
                "name": "Tomato",
                "purchase_timestamp": "2019-08-20 01:48:21"
            }
        ]
    }
}



#7.1  Purchase product with start and end date
GET: http://localhost/api/purchaser/1/product?start_date=1566265601&end_date=1566265702

{
    "purchases": {
        "2019-08-20 01:48:21": [
            {
                "name": "Tomato",
                "purchase_timestamp": "2019-08-20 01:48:21"
            },
            {
                "name": "Tomato",
                "purchase_timestamp": "2019-08-20 01:48:21"
            }
        ]
    }
}

