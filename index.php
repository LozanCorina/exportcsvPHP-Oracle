<?php  
    ini_set('display_errors',1);
      //$conn = oci_connect('test', 'test', '//93.115.136.18:4024/clouddev.world');
    $parm = getopt("", array("db_type:","data_type:","username:","pass:","host:","port:","service_name:","tables:","file:"));
    $contor='';
    for($k=0; $k<$argc; $k++)
    {
        if($argv[$k] == '-h')
        $contor=1;
    }
    if($contor == 1)
    {
        echo 'Usage :
        --username : username for log in. Required
        --pass: password for log in. Required. If no pass write ""
        --host : host for log in. Required
        --port: port for log in. Required
        --service_name: service name for Oracle log in.Database name for MySQL. Required
        --tables: tables name for exporting/importing csv files
        --db_type: [Oracle | MySQL]
        --data_type: [Import | Export ]
        --file: path to the file';
    }
    $db_type='';
    $data_type='';
    for($k=0; $k<$argc; $k++)
    {
        if($argv[$k] == '--db_type')
        { $db = mb_convert_case($argv[$k+1], MB_CASE_UPPER, "UTF-8");
            if($db == 'ORACLE' || $db == 'MYSQL')
            {
                $db_type= $db;
            }
            else 
            {
                echo 'No database matching!';
            }
        }
        if($argv[$k] == '--data_type')
        {
            $data = mb_convert_case($argv[$k+1], MB_CASE_UPPER, "UTF-8");
            if($data == 'IMPORT' || $data == 'EXPORT')
            {
                $data_type= $data;
            }
            else 
            {
                echo 'No data_type matching!';
            }
        }
    }

    if($db_type !='' & $db_type!='')
       {
           if ($db_type == 'ORACLE')
           {
               if ($data_type == 'EXPORT')
               {
                include ('exportcsvOracle.php');//justcsv
               }
               else 
               {
                //echo 'import oracle csv';
                include ('importOracle.php');
               }
               
           }
           else if ($db_type == 'MYSQL')
           {
                if ($data_type == 'EXPORT')
                {        
                    include ('exportcsvMysql.php');
                    
                }
                else 
                {
                    //echo 'import mysql';
                    include ('importSQL.php');
                }
           }
       }

?>