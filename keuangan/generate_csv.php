<title>generate csv</title>
<?php
 
// Mini-Config
$data_separator = '|~|';
 
// Handle Generate CSV Action
if (isset($_POST['action'])   && $_POST['action'] == 'generate' &&
    isset($_POST['csv_type']) && !empty($_POST['csv_type'])     &&
    isset($_POST['csv_data']) && !empty($_POST['csv_data']))
{
    // Delete Temp CSV Files - Older Than 1 Day
    $temp_csv_files = glob('*.csv');
    if (is_array($temp_csv_files) && sizeof($temp_csv_files)) {
        foreach ($temp_csv_files as $temp_csv_file) {
            if (is_file($temp_csv_file) && time() - filemtime($temp_csv_file) >= 24*60*60) { // 1 Day Old
                unlink($temp_csv_file);
            }
        }
    }
 
    // Write CSV To Disk
    $csv_data = explode("\r\n", $_POST['csv_data']);
    $csv_file_name =  uniqid($_POST['csv_type'] .'_', true) .'.csv';
    $h = @fopen($csv_file_name, 'w');
    if (false !== $h) {
        if (sizeof($csv_data)) {
            foreach ($csv_data as $csv_row) {
                $csv_row = explode($data_separator, $csv_row);
                array_walk_recursive($csv_row, function($item) {
                    $item = preg_replace('/\s+/', ' ', preg_replace('/[\r\n\t]*/', '', $item));
                    $item = trim(strip_tags($item));
                });
                fputcsv($h, $csv_row, ',', '"');
            }  
        }
        fclose($h);
    }
    echo file_exists($csv_file_name) ? $csv_file_name : '';
}
 
// End
exit();
 
?>