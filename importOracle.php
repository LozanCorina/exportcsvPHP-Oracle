<?php 
$file=$parm['file'];
$fieldseparator = ","; 
$lineseparator = "\n";

if( !file_exists($file) ){
    echo "File not found. Make sure you specified the correct path.";
}
else 
{

    $array = explode(".", $file);
    $extension = end($array);
    $path = explode("\\", $array[0]);
    $table = end($path);
    if($extension == 'sql')
    {
        $conn = oci_connect($parm['username'], $parm['pass'], '//'.$parm['host'].':'.$parm['port'].'/'.$parm['service_name']);
        if (!$conn) {
            $e = oci_error();
        echo trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $output = '';
        $count = 0;
        $file_data = file($file);
        foreach($file_data as $row)
        {
            $start_character = substr(trim($row), 0, 2);
            if($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '')
            {
            $output = $output . $row;
            $end_character = substr(trim($row), -1, 1);
            if($end_character == ';')
            { 
                $stid =oci_parse($conn, $output);
                if(!oci_execute($stid))
                {
                    $count++;
                }
                    $output = '';
                }
            }
        }
        if($count > 0)
        {
            echo 'There is an error in Database Import';
        }
        else
        {
           echo 'Database Successfully Imported';
        }
    }
    else if($extension == 'csv')
    { 
        try {  
            $user=$parm['username'];
            $host=$parm['host'];
            $port=$parm['port'];
            $db=$parm['service_name'];
            $pass=$parm['pass'];
        
            $pdo = new PDO("oci:dbname=//$host:$port/$db", 
                $user, $pass,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (PDOException $e) {
            echo "database connection failed: ".$e->getMessage();
        }
        try { 
            $affectedRows = $pdo->exec("
                LOAD DATA INFILE ".$pdo->quote($file)." INTO TABLE `$table`
                FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
                LINES TERMINATED BY ".$pdo->quote($lineseparator)
            );

            echo "Loaded a total of $affectedRows records from $file\n";
            
        } catch (PDOException $e) {
            echo "failed to insert cvs file: ".$e->getMessage();
        }

    }
    else echo "No csv/sql extension!";
    
}   
?>
