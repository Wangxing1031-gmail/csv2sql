<?php

    require_once __DIR__ . '/library/recordInsert.php';
    $file_name = './uploads/'.$_POST['ods'];
    $file_progress_name = $file_name . ".prg";
    $handle = @fopen( $file_name, "r");
    if ($handle) {
        $cur_record = "";
        $is_first = true;
        $total_count = 0;
        $inserted_count = 0;
        $duplicated_count = 0;
        $inserted_count_raw = 0;
        $duplicated_count_raw = 0;
        $inserted_count_kc = 0;
        $duplicated_count_kc = 0;

        $prev_time = time();
        while( ($data = fgetcsv($handle)) != FALSE){
            if( $is_first){
                $is_first = false;
                echo "<hr>header<hr>";
                continue;
            }
            $total_count++;
            if( insertRow('Database_garage-door-repair', $data)){
                $inserted_count ++;
            } else {
                $duplicated_count ++;
            }
            if( insertRow('Database_garage-door-repair_raw', $data)){
                $inserted_count_raw ++;
            } else {
                $duplicated_count_raw ++;
            }
            if( insertRow('Database_garage-door-kc', $data)){
                $inserted_count_kc ++;
            } else {
                $duplicated_count_kc ++;
            }
            if( time() >= $prev_time + 2){
                $prev_time = time();
                $progress_string = ($inserted_count == 0 ? "0" : $inserted_count) . 
                " records inserted / " . ($duplicated_count == 0 ? "0" : $duplicated_count) . " records rejected in Database_garage-door-repair.<br>";
                $progress_string .= ($inserted_count_raw == 0 ? "0" : $inserted_count_raw) . 
                " records inserted / " . ($duplicated_count_raw == 0 ? "0" : $duplicated_count_raw) . " records rejected in Database_garage-door-repair_raw.<br>";
                $progress_string .= ($inserted_count_kc == 0 ? "0" : $inserted_count_kc) . 
                " records inserted / " . ($duplicated_count_kc == 0 ? "0" : $duplicated_count_kc) . " records rejected in Database_garage-door-kc.";
                file_put_contents($file_progress_name, $progress_string);
            }
        }
        $progress_string = "Done : <br>" . ($inserted_count == 0 ? "0" : $inserted_count) . 
        " records inserted / " . ($duplicated_count == 0 ? "0" : $duplicated_count) . " records rejected in Database_garage-door-repair.<br>";
        $progress_string .= ($inserted_count_raw == 0 ? "0" : $inserted_count_raw) . 
        " records inserted / " . ($duplicated_count_raw == 0 ? "0" : $duplicated_count_raw) . " records rejected in Database_garage-door-repair_raw.";
        $progress_string .= ($inserted_count_kc == 0 ? "0" : $inserted_count_kc) . 
        " records inserted / " . ($duplicated_count_kc == 0 ? "0" : $duplicated_count_kc) . " records rejected in Database_garage-door-kc.";
        file_put_contents($file_progress_name, $progress_string);
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