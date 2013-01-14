## Google Fusion Tables to HTML Table

Takes in a Fusion Table and outputs it in to an HTML table that is sortable and searchable with jQuery DataTables. [More details](http://derekeder.com/fusion-tables-to-html-table/)

Demo: http://derekeder.com/fusion-tables-to-html-table/demo/index.php

### Updated to Fusion Tables v1 API
On Jan 14th, 2013 [Google deprecated the SQL API](https://developers.google.com/fusiontables/docs/developers_guide). This script has been updated to use the [Fusion Tables v1 API](https://developers.google.com/fusiontables/docs/v1/getting_started).

An __API key__ is now required and the results are returned as an 2 dimensional array. All the mess with handling blank values is no longer an issue. See index.php for an example of handling the updated format.

### Usage
1. copy source/connectioninfo.php.example to source/connectioninfo.php
2. fill in your Google account info and API key in source/connectioninfo.php. Go to the [Google API Console](https://code.google.com/apis/console/) to get your API Key.
3. customize what table columns you want to show in index.php

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