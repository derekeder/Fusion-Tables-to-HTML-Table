<?php

class SQLBuilder {
  //Builds SQL statements. Helper class.

  public static function showTables() {
    //Return show tables statement
    return "SHOW TABLES";
  }
  
  public static function describeTable($table_id) {
    //Return describe table statement
    return "DESCRIBE $table_id";
  }
  
  public static function delete($table_id, $row_id) {
    //Return delete statement
    return "DELETE FROM $table_id WHERE ROWID = '$row_id'";
  }
  
  public static function deleteAll($table_id) {
    //Return delete all rows statement
    return "DELETE FROM $table_id";
  }
  
  public static function dropTable($table_id) {
    //Return drop table statement
    return "DROP TABLE $table_id";
  }

  public static function createTable($table) {
    //Return create table statement
    $keys = array_keys($table);
    $table_name = $keys[0];
    $cols_and_datatypes = "";
    $length = count($table[$table_name]);
    $count = 0;
    foreach($table[$table_name] as $key => $value) {
      $cols_and_datatypes .= "'$key': $value";
      if($count < $length-1) { $cols_and_datatypes .= ", "; }
      $count++;
    }
    return "CREATE TABLE '$table_name' ($cols_and_datatypes)";
  }
  
  public static function select($table_id, $cols="", $condition="", $orderby="", $limit="") {
    //Return select statement
    if ($cols == "") $cols = "*";
    if ($condition != "") $condition = "WHERE $condition";
    if ($orderby != "") $orderby = "ORDER BY $orderby";
    if ($limit != "") $limit = "LIMIT $limit";
    
    $select = "SELECT $cols FROM $table_id $condition $orderby $limit";
    
    //echo $select;
    return $select;
  }

  public static function update($table_id, $col_values, $row_id) {
    //Return update statement
    $updateStatement = "";
    $count = 0;
    foreach($col_values as $key => $value) {
      $updateStatement .= "'$key' = ";
      if(gettype($value) == 'integer' || gettype($value) == 'double' || gettype($value) == 'float') {
        $updateStatement .= "$value";
      } else {
        $updateStatement .= "'$value'";
      }

      if($count < count($col_values)-1) $updateStatement .= ",";
      $count++;
    }

    return "UPDATE $table_id SET $updateStatement WHERE ROWID = '$row_id'";
  }
  
  public static function insert($table_id, $col_values) {
    //Return insert statement
    $stringValues = "";
    $count = 0;
    foreach($col_values as $col => $value) {
      if(gettype($value) == 'integer' || gettype($value) == 'double' || gettype($value) == 'float') {
        $stringValues .= "$value";
      } else {
        $stringValues .= "'$value'";
      }
      if($count < count($col_values)-1) { $stringValues .= ","; }
      $count++;
    }

    $cols = "'" . implode("','", array_keys($col_values)) . "'";
    
    $insertSql = "INSERT INTO $table_id ($cols) VALUES ($stringValues)";
    //echo "\n" . $insertSql . "\n";
    return $insertSql;
  }
  
  //added by Derek Eder
  //converts text to number based on the presence of a string. unknown fields are given a value of 2
  public function convertToFlag($value, $stringCompare) {
    	$value = strtolower(trim($value));
    	
    	if (is_null($value) || $value == "" || strpos($value, "unknown") !== false)
    		return 2; //2 = unknown
    	else if (strpos($value, $stringCompare) !== false)
    		return 1; //1 = yes
    	else
    		return 0; //0 = no	
  }
    
  //added by Derek Eder
  //sets empty number fields to 0
  public function setEmptyToZero($value) {
    	$value = strtolower(trim($value));
    	
    	if (is_null($value) || $value == "")
    		return 0;
    	else
    		return 1;
  }
}


?>