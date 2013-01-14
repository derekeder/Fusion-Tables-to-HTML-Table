## Google Fusion Tables to HTML Table

Takes in a Fusion Table and outputs it in to an HTML table that is sortable and searchable with jQuery DataTables. [More details](http://derekeder.com/fusion-tables-to-html-table/)

Demo: http://derekeder.com/fusion-tables-to-html-table/demo/index.php

### NOTE on Fusion Tables SQL API deprecation
On Jan 14th, 2013 [Google deprecated the SQL API](https://developers.google.com/fusiontables/docs/developers_guide). This script has been updated to use the [Fusion Tables v1 API](https://developers.google.com/fusiontables/docs/v1/getting_started).

### Usage
1. copy source/connectioninfo.php.example to source/connectioninfo.php
2. fill in your Google account info in source/connectioninfo.php
3. customize what table columns you want to show in index.php (lines 39 and 63) or uncomment the block starting at line 93 to just dump the entire table

Note: This is currently using a custom string to csv function to convert the cURL response from Fusion Tables to an array. If you have PHP 5.3+, you should use str_getcsv instead.

## Dependencies

* [Google Fusion Tables](http://www.google.com/fusiontables/Home)
* [jQuery](http://jquery.org)
* [Datatables](http://datatables.net/)
* PHP
* [PHP Fusion Tables Client Library](http://code.google.com/p/fusion-tables-client-php/)

## Contributors 

* [Derek Eder](http://derekeder.com) - primary contributor

## Note on Patches/Pull Requests
 
* Fork the project.
* Make your feature addition or bug fix.
* Commit and send me a pull request.

## Copyright

Copyright (c) 2013 Derek Eder. Released under the MIT License.

See [LICENSE](https://github.com/derekeder/Fusion-Tables-to-HTML-Table/wiki/License) for details 