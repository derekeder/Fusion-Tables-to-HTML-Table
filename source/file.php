<?php

class FileUploader {
  public static function uploadCSV($ftclient, $csv_filename, $header_map=null) {
    $row = 1;
    $tableid = "";
    $collist = "";
    $results = "";
    if (($handle = fopen($csv_filename, "r")) !== FALSE) {
      while (($data = fgetcsv($handle)) !== FALSE) {
        $num = count($data);
        
        if($row == 1) {
          $columns = "";
          for ($c=0; $c < $num; $c++) {
            if($header_map) {
              $columns.="'".$data[$c]."':".$header_map[$data[$c]];
            } else {
              $columns.="'".$data[$c]."':STRING";
            }
            if($c < $num - 1) $columns.=",";
            $collist.="'".$data[$c]."'";
            if($c < $num - 1) $collist.=",";
          }
          $tableid = $ftclient->query("CREATE TABLE '".$csv_filename."' (".$columns.")");
          $tableid = split("\n", $tableid);
          $tableid = $tableid[1];
        
        } else {
          $values = "";
          for ($c=0; $c < $num; $c++) {
            $values.="'".$data[$c]."'";
            if($c < $num - 1) $values.=",";
          }
          $results .= $ftclient->query("INSERT INTO ".$tableid." (".$collist.") VALUES (".$values.")");
        }
        
        $row++;
      }
      
      fclose($handle);
      return $results;
    }
  }
  
  function importMoreRows($ftclient, $tableid, $csv_filename) {
  	$row = 1;
    $collist = "";
    $results = "";
    if (($handle = fopen($csv_filename, "r")) !== FALSE) {
      while (($data = fgetcsv($handle)) !== FALSE) {
        $num = count($data);
        
        if($row == 1) {
          for ($c=0; $c < $num; $c++) {
            $collist.="'".$data[$c]."'";
            if($c < $num - 1) $collist.=",";
          }
        
        } else {
          $values = "";
          for ($c=0; $c < $num; $c++) {
            $values.="'".$data[$c]."'";
            if($c < $num - 1) $values.=",";
          }
          $results .= $ftclient->query("INSERT INTO ".$tableid." (".$collist.") VALUES (".$values.")");
        }
        
        $row++;
      }
      
      fclose($handle);
      return $results;
    }
  	
  }

}

?>