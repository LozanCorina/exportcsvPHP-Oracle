<?php
 ini_set('display_errors',1);
 include ('dumper.php');
$conn = mysqli_connect($parm['host'].':'.$parm['port'], $parm['username'], $parm['pass'], $parm['service_name']);
if (!$conn) {
  echo  mysqli_error();

}
else{
    if($argc>16)
    { 
        $tables=array();
        for($i=16; $i<$argc; $i++)
        {
            $tableName=$argv[$i];
            $tables[]=$tableName;
            $stid = mysqli_query($conn, 'select * from '.$tableName.'');
            $columns=array();

            $fieldinfo = $stid -> fetch_fields();
            foreach ($fieldinfo as $val) {
                $columns[]= $val -> name;
                
              }

            $dir=getcwd();
            $output = fopen($dir.'\\'.$tableName.'.csv', "w"); 
        //$output = fopen('c:\\xampp\htdocs\\'.$tableName.'.csv', "w"); 
            fputcsv($output, array_values($columns));  
        
            while($row = mysqli_fetch_array($stid,MYSQLI_ASSOC))  
            {  
                fputcsv($output, $row); 
            }  
        
            fclose($output); 
            echo "CSV file exported successfully for table: $tableName!";
        }         
        try {
            $dumper = Shuttle_Dumper::create(array(
                'host' => $parm['host'],
                'username' => $parm['username'],
                'password' => $parm['pass'],
                'db_name' => $parm['service_name'],
                'include_tables' => array_values($tables), // only include those tables
            ));
            $dumper->dump($parm['service_name'].'.sql');

        } catch(Shuttle_Exception $e) {
            echo "Couldn't dump database: " . $e->getMessage();
        }
                
    }
    else echo 'no table entered!';
}      
?>