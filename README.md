##Description
A little Plugin to import and export pages from WordPress.

## Installation
cd to Docker composer file.

Start docker via:
```
docker-compose up -d 
```

Import SQL-Dump to Database.

## Usage
Go to Plugins and install BooksPlugin.
On the left hand side there will be displayed a new Category Books.
There you can import and export Json-Files. 
Make sure using following syntax:
````
{
  "books": [{
      "post_author_id": ...,
      "post_author": ...,
      "post_type": "books",
      "post_content": ...,
      "post_title": ...,
      "post_name": ...,
      "post_status": ...,
    },
...
..
.}
````

## Testing:
This is under development-status so feel free to contribute.
For testing prupposes there is a books.json file to test this plugin.

## License
[GNU/GPLv3.0](https://choosealicense.com/licenses/gpl-3.0/#)