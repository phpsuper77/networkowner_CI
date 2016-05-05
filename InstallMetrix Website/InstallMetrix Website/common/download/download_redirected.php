<?

include 'config.php'; 

//make randome short paramenter    
$param2_name = RandomeStringName(rand(3, 5));
$param2_value = RandomeUpperStringValue(rand(7, 10));                                                  
$url = DOMAIN_URL . "/download_final.php?{$_SERVER['QUERY_STRING']}&{$param2_name}={$param2_value}";
header("Location: {$url}");
exit;
?>