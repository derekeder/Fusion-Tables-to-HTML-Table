<?php

/*!
 * Google Fusion Tables to HTML Table
 * http://derekeder.com/fusion-tables-to-html-table/
 *
 * Copyright 2012, Derek Eder
 * Licensed under the MIT license.
 * https://github.com/derekeder/Fusion-Tables-to-HTML-Table/wiki/License
 *
 * Date: 5/2/2012
 * 
 */

include('source/clientlogin.php');
include('source/sql.php');
include('source/connectioninfo.php');
include('source/fthelpers.php');

function format_address($street, $city, $state, $zip) {
	
	$result = str_replace(" ", "&nbsp;", $street);
	$result = $result . "<br />$city, $state $zip";
	return $result;
}

//phpinfo();

//get token
$token = ClientLogin::getAuthToken(ConnectionInfo::$google_username, ConnectionInfo::$google_password);
$ftclient = new FTClientLogin($token);

//select * from table
$result = $ftclient->query(SQLBuilder::select(ConnectionInfo::$fusionTableId));

?>

<!DOCTYPE html>
<html>
<head>
	<title>Health Clinics in Chicago - Full List</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<link href='styles/master.css' media='all' rel='stylesheet' type='text/css' />
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> 
	<!--<script src="/source/analytics_lib.js" type="text/javascript"></script>-->
	<script src="source/jquery.dataTables.min.js" type="text/javascript"></script>
	
	<script type="text/javascript">
	    $(function(){
	      $(".data").dataTable({
	        "aaSorting": [[0, "asc"]],
	        "aoColumns": [
	          null,
	          null,
	          null,
	          null,
	          null,
	          null,
	          { "bSearchable": false, "bSortable": false }
	        ],
	        "bFilter": true,
	        "bInfo": false,
	        "bPaginate": false
	      });
	    });
  </script>
</head>
<body>
	<div id="page">
		<h1>Health Clinics in Chicago - List</h1>
		
		<p class='tagline'>List of Neighborhood, Mental Health and Women, Infants & Children (WIC) clinics in Chicago. <a href='/maps/chicago-clinics/'>Find them on the map &raquo;</a></p>
		
		<table class='data'>
			<thead>
				<tr>
					<th>Clinic</th>
					<th>Address</th>
					<th>Type</th>
					<th>Services</th>
					<th>Hours</th>
					<th>Phone</th>
					<th>Website</th>
				</tr>
			</thead>
			<tbody>
<?php

foreach ($result as $i => $row) {
	if ($i > 0)
	{
		echo "
		<tr>
		<td>$row[0]</td>
		<td>" . format_address($row[3], $row[4], $row[5], $row[6]) . "</td>
		<td>$row[10]</td>
		<td>$row[9]</td>
		<td>$row[2]</td>
		<td>$row[7]</td>
		<td><a href='$row[8]'>Website</a></td>
		</tr>";
	}
}
/*
//use this to print out all columns and rows
//print table head
echo "<thead><tr>\n";
foreach ($csvArr[0] as $i => $col) {
	echo "<th>$col</th>\n";
}
echo "</tr></thead>\n";

//print table body
echo "<tbody>\n";
foreach ($csvArr as $i => $row) {
	if ($i > 0)
	{
		echo "<tr>\n";
		foreach ($row as $j => $col) {
			echo "<td>$col</td>\n";
		}
		echo "</tr>\n";
	}
}

echo "</tbody></table>\n";
*/

?>

			</tbody>
		</table>
		<hr />
		<p>A project by <a href='http://derekeder.com'>Derek Eder</a>.</p>
		</div> 
	</body>
</html>