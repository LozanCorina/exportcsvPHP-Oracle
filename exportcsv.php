
 <?php  
    ini_set('display_errors',1);
    //$conn = oci_connect('test', 'test', '//93.115.136.18:4024/clouddev.world');
    
    $contor='';
    for($k=0; $k<$argc; $k++)
    {
        if($argv[$k] == '-h')
        $contor=1;
    }
    if($contor == 1)
    {
        echo 'Usage :
        --username : username for oracle log in. Required
        --pass: password for oracle log in. Required
        --host : host for oracle log in. Required
        --port: port for oracle log in. Required
        ---service_name: service name for oracle log in. Required
        --tables: tables name for exporting csv files from oracle
        --DB_TYPE: [Oracle | MySQL]';
    }
    else{
            $parm = getopt("", array("username:","pass:","host:","port:","service_name:","tables:"));

        $conn = oci_connect($parm['username'], $parm['pass'], '//'.$parm['host'].':'.$parm['port'].'/'.$parm['service_name']);
        if (!$conn) {
            $e = oci_error();
        echo trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        else{
            if($argc>12)
            {   $table='';
            
                for($i=12; $i<$argc; $i++)
                {
                    $tableName=$argv[$i];
            
                    $stid = oci_parse($conn, 'select * from '.$tableName.'');
                    oci_execute($stid);
                    $columns=array();
        
                    $ncols = oci_num_fields($stid);
                    for ($j = 1; $j <= $ncols; $j++) {
                        $columns[]= $column_name  = oci_field_name($stid, $j);    
                    
                    }
            
                    $dir=getcwd();
                    $output = fopen($dir.'\\'.$tableName.'.csv', "w"); 
                //$output = fopen('c:\\xampp\htdocs\\'.$tableName.'.csv', "w"); 
                    fputcsv($output, array_values($columns));  
                
                    while($row = oci_fetch_array($stid,OCI_ASSOC+OCI_RETURN_NULLS))  
                    {  
                        fputcsv($output, $row); 
                    }  
                
                    fclose($output); 
                    echo "CSV file exported successfully for table: $tableName!";
                }  
                
            }
            else echo 'no table entered!';
        }      
    }
    
  
 ?>