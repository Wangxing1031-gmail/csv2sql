<?php
    // error_reporting(E_ALL);
    ini_set("display_errors", 1);
    // ini_set('implicit_flush', 1);
    // ob_implicit_flush(true);
    set_time_limit(0);

    // require_once __DIR__ . "/Mysql.php";

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "contact_list";
    
    
    $servername = "localhost";
    $username = "glinks";
    $password = "672416";
    $dbname = "trialpro";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully <br>";
    $header_list = [ 
        'ID', 'Name', 'Full_Address', 'Street_Address', 'City', 
        'State', 'Zip', 'Plus_Code', 'Website', 'Phone', 
        'Email', 'Facebook', 'Twitter', 'Instagram', 'Lat', 
        'Lng', 'Category', 'Rating', 'Reviews', 'Top_Image_URL', 
        'Sub_Title', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 
        'Friday', 'Saturday', 'Sunday', 'URL', 'verified', 
        'hash'];
    $header_list_types = [
        'int(6)', 'varchar(200)', 'varchar(200)', 'varchar(150)', 'varchar(100)', 
        'varchar(20)', 'varchar(20)', 'varchar(250)', 'varchar(250)', 'varchar(50)', 
        'varchar(125)', 'varchar(200)', 'varchar(200)', 'varchar(200)', 'varchar(60)', 
        'varchar(60)', 'varchar(60)', 'varchar(5)', 'varchar(6)', 'varchar(250)', 
        'varchar(50)', 'varchar(50)', 'varchar(50)', 'varchar(50)', 'varchar(50)', 
        'varchar(50)', 'varchar(50)', 'varchar(50)', 'varchar(255)', 'varchar(5)', 
        'varchar(256) NOT NULL'
    ];

    $header_list_raw = [ 
        'ID', 'Keyword', 'Name', 'Full_Address', 'Street_Address', 
        'City', 'State', 'Zip', 'Plus_Code', 'Website', 
        'Phone', 'Email', 'Facebook', 'Twitter', 'Instagram', 
        'Lat', 'Lng', 'Verification_Text', 'Category', 'Rating', 
        'Reviews', 'Top_Image_URL', 'Sub_Title', 'Pricing', 'Amenities', 
        'Description', 'Summary', 'Monday', 'Tuesday', 'Wednesday', 
        'Thursday', 'Friday', 'Saturday', 'Sunday', 'External_Urls', 
        'Photo_Tags', 'URL', 'none', 'hash'
    ];
        
    $header_list_raw_types = [ 
        'int(6)', 'varchar(255)', 'varchar(200)', 'varchar(200)', 'varchar(150)', 
        'varchar(100)', 'varchar(20)', 'varchar(20)', 'varchar(250)', 'varchar(250)', 
        'varchar(50)', 'varchar(125)', 'varchar(200)', 'varchar(200)', 'varchar(200)', 
        'varchar(60)', 'varchar(60)', 'varchar(60)', 'varchar(60)', 'varchar(5)', 
        'varchar(6)', 'varchar(250)', 'varchar(50)', 'varchar(50)', 'varchar(50)', 
        'varchar(50)', 'varchar(50)', 'varchar(50)', 'varchar(50)', 'varchar(50)', 
        'varchar(50)', 'varchar(50)', 'varchar(50)', 'varchar(50)', 'varchar(50)', 
        'varchar(50)', 'varchar(255)', 'varchar(5)', 'varchar(256) NOT NULL'
    ];

    $header_list_kc = [ 
        'Keyword', 'Phone', 'hash'
    ];
        
    $header_list_kc_types = [ 
        'varchar(255)', 'varchar(50)', 'varchar(256) NOT NULL'
    ];
    
    function createTable($tablename){
        global $conn;
        global $header_list;
        global $header_list_types;
        global $header_list_raw;
        global $header_list_raw_types;
        if( $tablename == "Database_garage-door-repair"){
            $header_tmp_list = $header_list;
            $header_tmp_list_type = $header_list_types;
        } else if($table_name == "Database_garage-door-repair_raw"){
            $header_tmp_list = $header_list_raw;
            $header_tmp_list_type = $header_list_raw_types;
        } else if($table_name == "Database_garage-door-kc"){
            $header_tmp_list = $header_list_kc;
            $header_tmp_list_type = $header_list_kc_types;
        }
        $sql = "SHOW TABLES LIKE `%$tablename%`";
        $val = $conn->query($sql);
        if( $val == false){
            $sql = "CREATE TABLE `$tablename` (";
            foreach( $header_tmp_list as $index => $header){
                $type = $header_tmp_list_type[$index];
                $sql .= "`$header` " . $type . ",";
            }
            $sql .= " PRIMARY KEY (`hash`)) ENGINE=MyISAM DEFAULT CHARSET=utf8";
            if( $conn->query($sql)){
                echo "created.";
            } else {
                echo "create failed : " . $conn->error . "<br>";
            }
        }
    }
    createTable("Database_garage-door-repair");
    createTable("Database_garage-door-repair_raw");
    createTable("Database_garage-door-kc");

    function insertRow($tablename, $field_list){
        global $conn;
        global $header_list;
        global $header_list_types;
        global $header_list_raw;
        global $header_list_raw_types;
        global $header_list_kc;
        global $header_list_kc_types;

        if( $tablename == "Database_garage-door-repair"){
            $header_tmp_list = $header_list;
            $header_tmp_list_type = $header_list_types;
            $join = $field_list[2] . ":" . $field_list[3] . ":" . $field_list[9] . ":" . $field_list[10];
        } else if($tablename == "Database_garage-door-repair_raw"){
            $header_tmp_list = $header_list_raw;
            $header_tmp_list_type = $header_list_raw_types;
            $join = $field_list[1] . ":" . $field_list[2] . ":" . $field_list[3] . ":" . $field_list[9] . ":" . $field_list[10];
        } else if( $tablename == "Database_garage-door-kc"){
            $header_tmp_list = $header_list_kc;
            $header_tmp_list_type = $header_list_kc_types;
            $join = $field_list[1] . ":" . $field_list[10];
        }
        $placeholders = array_fill(0, count($header_tmp_list), '?');
        $query = "INSERT INTO `$tablename`(" . implode(",", $header_tmp_list) . ") VALUES(" . implode(",", $placeholders) . ")";
        $stmt = $conn->prepare($query);
        if( !$stmt)return false;
        $fields = 'i' . str_repeat('s', count($header_tmp_list) - 1);
        
        $hash = base64_encode(gzcompress($join, 9));
        $null_string = "";
        if( $tablename == "Database_garage-door-repair"){
            $stmt->bind_param(
                $fields,
                $field_list[0], $field_list[2], $field_list[3], $field_list[4], $field_list[5],
                $field_list[6], $field_list[7], $field_list[8], $field_list[9], $field_list[10],

                $field_list[11], $field_list[12], $field_list[13], $field_list[14], $field_list[15], 
                $field_list[16], $field_list[18], $field_list[19], $field_list[20], $field_list[21], 
                
                $field_list[22], $field_list[27], $field_list[28], $field_list[29], $field_list[30], 
                $field_list[31], $field_list[32], $field_list[33], $field_list[36], $null_string, 
                
                $hash
            );
        } else if($table_name == "Databse_garage-door-repair_raw"){
            $stmt->bind_param(
                $fields,
                $field_list[0], $field_list[1], $field_list[2], $field_list[3], $field_list[4],
                $field_list[5], $field_list[6], $field_list[7], $field_list[8], $field_list[9],
                
                $field_list[10], $field_list[11], $field_list[12], $field_list[13], $field_list[14],
                $field_list[15], $field_list[16], $field_list[17], $field_list[18], $field_list[19],
                
                $field_list[20], $field_list[21], $field_list[22], $field_list[23], $field_list[24],
                $field_list[25], $field_list[26], $field_list[27], $field_list[28], $field_list[29],
                
                $field_list[30], $field_list[31], $field_list[32], $field_list[33], $field_list[34],
                $field_list[35], $field_list[36], $null_string, $hash
            );
        } else if($table_name == "Database_garage-door-kc"){
            $stmt->bind_param(
                $fields, $field_list[1], $field_list[10], $hash
            );
        }
        $retval = $stmt->execute();
        if( $retval) return true;
        print_r( $stmt->error);
        return false;
    }
    function insertRow_List($tablename, $record_list){
        global $conn;
        $sql = "";
        $first_record = true ;
        foreach( $record_list as $record){
            $record_line_sql = "INSERT INTO `$tablename`  VALUES ";
            $record_line_sql .= "(";
            $is_first = true;
            $record_line_sql .= "'" . implode("','", $record) . "'";
            $record_line_sql .= ");";
            $sql .= $record_line_sql;
        }
        if( $conn->multi_query($sql) === TRUE){
            return TRUE;
        }
        echo $conn->error;
        return $conn->error;
    }

?>