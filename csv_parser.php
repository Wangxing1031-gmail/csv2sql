<?php

    require_once __DIR__ . '/library/recordInsert.php';
    $file_name = './uploads/'.$_POST['ods'];
    $handle = @fopen( $file_name, "r");
    if ($handle) {
        $cur_record = "";
        $is_first = true;
        while( ($data = fgetcsv($handle)) != FALSE){
            if( $is_first){
                $is_first = false;
                echo "<hr>header<hr>";
                continue;
            }
            insertRow('Database_garage-door-repair', $data);
            insertRow('Database_garage-door-repair_raw', $data);
        }
        fclose($handle);
    }
    unlink($file_name);

    function parseOneLine($one_line){
        global $header_count;
        
        $field_value = "";
        $field_list = [];
        $quot_detected = false;
        for( $index = 0; $index < strlen($one_line); $index++){
            $cur_char = substr( $one_line, $index, 1);
            switch( $cur_char){
                case '"':
                    if( $quot_detected){
                        $quot_detected = false;
                    } else {
                        $quot_detected = true;
                    }
                    break;
                case ',':
                    if( $quot_detected){
                    } else {
                        $field_list[] = $field_value;
                        $field_value = "";
                    }
                    break;
                default:
                    $field_value .= $cur_char;
                    break;
            }
        }
        $field_list[] = $field_value;
        if( count($field_list) != $header_count){
            return array();
        } else {
            return $field_list;
        }
    }
    mysqli_close($conn);
?>