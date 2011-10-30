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

//$result = explode("\n", $result);

//foreach ($result as $i => $value) {
//	//echo "exploding row $i<br />";
//    $result[$i] = explode(",", $value);
//}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Health Clinics in Chicago - Full List</title>
	<link href='/styles/master.css' media='all' rel='stylesheet' type='text/css' />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> 
	<script src="/source/analytics_lib.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<div id="page">
		<h1>Health Clinics in Chicago - Full List</h1>
<?php

echo "<table class='data'>\n";

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

?>

		</div> 
	</body>
</html>