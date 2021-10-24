<?php 
require_once '../../../config/db/database.php';
require_once '../../model/Admin/admin.php';

$db = new Database();
$db = $db->get_connection();

$admin = new Admin();
$result = $admin->get_all_merchant($db);

if($result)
{
while($row = mysqli_fetch_array($result))
{
    
    echo $row['name']." ". $row['email']." ".$row['password'].'<br>';
}
}
else
{
  $response = array(
      'message'=> 'Table is empty',
      'status_code'=>'406'
  );
  http_response_code(406);
  echo json_encode($response);
}
?>