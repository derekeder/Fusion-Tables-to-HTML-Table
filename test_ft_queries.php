<?php

include('clientlogin.php');
include('sql.php');
include('file.php');
include('source/connectioninfo.php');

//get token
$token = ClientLogin::getAuthToken(ConnectionInfo::$google_username, ConnectionInfo::$google_password);
$ftclient = new FTClientLogin($token);

//show all tables
//echo $ftclient->query(SQLBuilder::showTables());
//echo "<br />";
//describe a table
//echo $ftclient->query(SQLBuilder::describeTable(358077));
//echo "<br />";
//select * from table
//echo $ftclient->query(SQLBuilder::select(358077));
//echo "<br />";
//select * from table where test=1
//echo $ftclient->query(SQLBuilder::select(358077, null, "'test'=1"));
//echo "<br />";
//select test from table where test = 1

//$ftclient->query(SQLBuilder::select(564620, array('rowid'), "'ANY PEOPLE USING PROPERTY? (HOMELESS, CHILDEN, GANGS)'=''"));

//foreach ($ftclient as $key => $value) {
//    echo "RowId: $value<br />\n";
//    }
//echo "<br />";
//select rowid from table
//echo $ftclient->query(SQLBuilder::select(358077, array('rowid')));
//echo "<br />";
//delete row 401
//echo $ftclient->query(SQLBuilder::delete(358077, '401'));
//echo "<br />";
//drop table
//echo $ftclient->query(SQLBuilder::dropTable(358731));
//echo "<br />";
//update table test=1 where rowid=1
//echo $ftclient->query("UPDATE 564620 SET 'ANY PEOPLE USING PROPERTY? (HOMELESS, CHILDEN, GANGS)' = 2 WHERE ROWID = ''");
//echo "<br />";
//insert into table (test, test2, 'another test') values (12, 3.3333, 'bob')
//echo $ftclient->query(SQLBuilder::insert(358077, array('test'=>12, 'test2' => 3.33333, 'another test' => 'bob')));

?>