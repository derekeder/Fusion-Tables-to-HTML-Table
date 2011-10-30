<?php

include('source/clientlogin.php');
include('source/sql.php');
include('source/connectioninfo.php');
include('source/fthelpers.php');

//phpinfo();

//get token
$token = ClientLogin::getAuthToken(ConnectionInfo::$google_username, ConnectionInfo::$google_password);
$ftclient = new FTClientLogin($token);

//select * from table
$result = $ftclient->query(SQLBuilder::select(ConnectionInfo::$fusionTableId));

//echo $result;
$csvArr = fthelpers::str_getcsv($result);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Health Clinics in Chicago - Full List</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<link href='/styles/master.css' media='all' rel='stylesheet' type='text/css' />
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> 
	<script src="/source/analytics_lib.js" type="text/javascript"></script>
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

foreach ($csvArr as $i => $row) {
	if ($i > 0)
	{
		echo "
		<tr>
		<td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[10]</td>
		<td>$row[9]</td>
		<td>$row[2]</td>
		<td>$row[7]</td>
		<td><a href='$row[8]'>Website</a></td>
		</tr>";
	}
}
/*
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

		</div> 
	</body>
</html>