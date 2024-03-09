# Bitlis

## Setup

### Project

- Clone the repository
- Run ```composer install``` from the project root directory
- copy .env.example to .env
- run ```php artisan key:generate``` to generate application key

### Database

This project is using sqlite, first you'll need to create a file for storing the data. Run the following from the base 
project directory
```
touch database/database.sqlite
```
Go to .env file and update <b>DB_DATABASE</b> field with absolute path to the file you've just created

Now you can run migrations and seeds. This will create 10 users. You can use those ids for initial testing 
It will also populate the reserved urls table.

```
php artisan migrate --seed
```
### Run the project

Run ```php artisan serve``` from project directory

### Tests
To run tests you can simply run ```php artisan test```
### Calling endpoints

Make sure you include the following in your headers
```
Accept: application/json
```
There are only 3 endpoints so I'm going to document them here. Normally it'd be done through swagger.

#### Create short URL
POST /api/short-url

Request body example (shortUrl and expireInDays are optional fields)
```json
{
    "userId": 1,
    "originalUrl": "https://www.google.com",
    "shortUrl": "trumpasUrl",
    "expireInDays": 3
}
```
Response body
```json
{
	"id": 1,
	"userId": 1,
	"originalUrl": "https:\/\/www.google.com",
	"shortUrl": "http:\/\/localhost\/trumpasUrl",
	"expiryDate": "2024-03-12"
}
```
#### Delete 
DELETE /api/short-url/{id}

#### Redirect
GET /{key}

Redirects you to the assigned url

## Assumptions
- Only registered users can create short urls (not allowing to create fields without user ID)
- Since a database change is a possible thing I gave myself liberty to choose sqlite
- Authentication is not part of the task
- Reserved urls are treated as regular taken urls, meaning I'm not explaining that it's reserved, I just say it's 
already taken

## Not implemented
- Authentication
- DTOs
- CRUD for reserved urls
- Not specified CRUD for short urls

## Possible improvements

- Implement API Resources 
- Database naming can be considered a bit redundant (short_urls.short_url), but I find it clear that way. 
- Authentication of course. Now everyone can delete everything.
- Implement DTOs to pass data in structured way instead of arrays
- Be more flexible with original url format (don't require https://) by implementing custom rules
- Swagger for docs
- Exception handling so opening a link the error message doesn't show the model name
- Not a possible but a must improvement is to adjust random short url generation so that it doesn't fail if random is
  accidentally repeated.
- Short url passed as empty string could be generated randomly instead of being rejected
- Case sensitivity for short urls. Decision needed on how should they be handled and treated.
