# Bitlis

## Setup

### Project

TODO

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

### Calling endpoints

Make sure you include the following in your headers
```
Accept: application/json
```

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

- Implement API Resources to have control of what's returned and how things are formatted (eg. dates)
- Not an improvement, but consideration for variable, table and column namings. Instead of  having
  short_urls.original_url and short_urls.short_url fields it'd be possible to name them urls.original and urls.short
  to avoid redundancy but all of that depends on developer and team preference.
- Authentication of course. Now there is no protection and everyone can delete everything. Saying this user id should 
not be passed in body of request, rather authentication token should be passed and user identified that way.
- Implement DTOs to pass data in structured way instead of arrays
- Be more flexible with original url format (don't require https://) by implementing custom rules
- Swagger for docs
- Store expire in days choice to see how long was it maintained. Now I'm only getting expireInDays int and converting 
it to date straight away
- Exception handling so opening a link the error message doesn't show the model name
- Not a possible but a must improvement is to adjust random short url generation so that it doesn't fail if random is
accidentally repeated. I'd do this in connection with a DTO implementation. I'd leave shortUrl parameter as nullable,
create a generateRandomUrl() method and try to create the record in a loop until it succeeds. Alternatively more 
predictable random password generation would be possible, then there would be less guessing. Saying that it's already
clear that some sort of logging is needed if the DB gets too full, and we start running out of free urls. Then we could
adjust the length of url, take decision on what to do with expired urls (delete, flag, archive).
- Short url passed as empty string could be generated randomly instead of being rejected
- Case sensitivity for short urls. Decision needed on how should they be handled and treated.
