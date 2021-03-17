<?php
    // error_reporting(E_ALL);
    ini_set("display_errors", 1);
    // ini_set('implicit_flush', 1);
    // ob_implicit_flush(true);
    set_time_limit(0);

    // require_once __DIR__ . "/Mysql.php";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "contact_list";
    
    
    // $servername = "localhost";
    // $username = "glinks";
    // $password = "672416";
    // $dbname = "trialpro";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully <br>";
    $header_list = ['ID','Keyword','Name','Full_Address','Street_Address','City','State','Zip','Plus_Code','Website','Phone','Email','Facebook','Twitter','Instagram','Lat','Lng','Verification_Text','Category','Rating','Reviews','Top_Image_URL','Sub_Title','Pricing','Amenities','Description','Summary','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','External_Urls','Photo_Tags','URL', 'hash'];
    $header_list_raw = ['ID','Keyword','Name','Full_Address','Street_Address','City','State','Zip','Plus_Code','Website','Phone','Email','Facebook','Twitter','Instagram','Lat','Lng','Verification_Text','Category','Rating','Reviews','Top_Image_URL','Sub_Title','Pricing','Amenities','Description','Summary','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','External_Urls','Photo_Tags','URL', 'hash'];
    function createTable($tablename){
        global $conn;
        $sql = "SHOW TABLES LIKE `%$tablename%`";
        $val = $conn->query($sql);
        if( $val == false){
            $sql = "CREATE TABLE `$tablename` (
              `ID` int(6), `Keyword` varchar(200),
              `Name` varchar(100), `Full_Address` varchar(200),
              `Street_Address` varchar(150), `City` varchar(100),
              `State` varchar(20), `Zip` varchar(20),
              `Plus_Code` varchar(250), `Website` varchar(250),
              `Phone` varchar(50), `Email` varchar(125),
              `Facebook` varchar(200), `Twitter` varchar(200),
              `Instagram` varchar(200), `Lat` varchar(60),
              `Lng` varchar(60), `Verification_Text` varchar(200), `Category` varchar(60),
              `Rating` varchar(10), `Reviews` varchar(20),
              `Top_Image_URL` varchar(250), `Sub_Title` varchar(50), 
              `Pricing` varchar(200), `Amenities` varchar(200), 
              `Description` varchar(200), `Summary` varchar(200), 
              `Monday` varchar(50), `Tuesday` varchar(50),
              `Wednesday` varchar(50), `Thursday` varchar(50),
              `Friday` varchar(50), `Saturday` varchar(50),
              `Sunday` varchar(50), `External_Urls` varchar(255), 
              `Photo_Tags` varchar(255), `URL` varchar(255),
              `hash` varchar(256) NOT NULL,
              PRIMARY KEY (`hash`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
            if( $conn->query($sql)){
                echo "created.";
            } else {
                echo "create failed : " . $conn->error . "<br>";
            }
        }
    }
    function createProgressTable(){
        global $conn;
        $sql = "CREATE TABLE `insert_progress`(
            `ID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT
        )";
    }
    function deleteTable($tablename){
        global $conn;
        $sql = "DROP TABLE `$tablename`";
        $conn->query($sql);
    }
    // deleteTable("Database_garage-door-repair");
    createTable("Database_garage-door-repair");
    createTable("Database_garage-door-repair_raw");

    function isInDB($tablename, $field_value){
        global $conn;

        $sql = "SELECT ID FROM `$tablename` WHERE hash='$field_value'";
        // $sql = "SELECT ID FROM `$tablename` WHERE Keyword='$field_list[1]' AND Name='$field_list[2]' AND Full_Address='$field_list[3]' AND Website='$field_list[9]' AND Phone='$field_list[10]'";
        $result = $conn->query($sql);
        if( !$result){
            return false;
        } else if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    function deleteDuplicateRows($tablename){
        global $conn;
        $sql = "DELETE t1 FROM `$tablename` t1 INNER JOIN `$tablename` t2 WHERE t1.ID < t2.ID AND t1.Keyword = t2.Keyword AND t1.Name = t2.Name AND t1.Full_Address = t2.Full_Address AND t1.WebSite = t2.WebSite AND t1.Phone = t2.Phone;";
        print_r($sql);
        echo "<hr>";
        $conn->query($sql);
    }
    function injectTable2Other($fromTable, $toTable){
        global $conn;
        $sql = "INSERT INTO `$toTable` SELECT * FROM `$fromTable`";
        $conn->query($sql);
        deleteDuplicateRows($toTable);
    }
    function insertRow($tablename, $field_list){
        global $conn;
        global $header_list;
        $placeholders = array_fill(0, count($header_list), '?');
        $query = "INSERT INTO `$tablename`(" . implode(",", $header_list) . ") VALUES(" . implode(",", $placeholders) . ")";
        $stmt = $conn->prepare($query);
        if( !$stmt)return false;
        $fields = 'i' . str_repeat('s', count($field_list));
        $join = $field_list[1] . ":" . $field_list[2] . ":" . $field_list[3] . ":" . $field_list[9] . ":" . $field_list[10];
        $join = base64_encode(gzcompress($join, 9));
        // if( isInDB($tablename, $join)){
        //     return false;
        // }
        // $hash = hash('sha256', $field_list[1] . $field_list[2] . $field_list[3] . $field_list[9] . $field_list[10]);
        $stmt->bind_param(
            $fields,
            $field_list[0], $field_list[1], $field_list[2], $field_list[3], $field_list[4],
            $field_list[5], $field_list[6], $field_list[7], $field_list[8], $field_list[9],
            
            $field_list[10], $field_list[11], $field_list[12], $field_list[13], $field_list[14],
            $field_list[15], $field_list[16], $field_list[17], $field_list[18], $field_list[19],
            
            $field_list[20], $field_list[21], $field_list[22], $field_list[23], $field_list[24],
            $field_list[25], $field_list[26], $field_list[27], $field_list[28], $field_list[29],
            
            $field_list[30], $field_list[31], $field_list[32], $field_list[33], $field_list[34],
            $field_list[35], $field_list[36], $join
        );
        return $stmt->execute();
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