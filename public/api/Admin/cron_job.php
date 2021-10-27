<?php 
require_once '../../../config/db/database.php';
require_once '../../model/Admin/admin.php';

$db = new Database();
$db = $db->get_connection();

$admin = new Admin();
$result = $admin->cron_job($db);



?>