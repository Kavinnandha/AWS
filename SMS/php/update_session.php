<?php
$session_count = $_POST['session_id']+1;
echo json_encode(['new_value' => $session_count]);
?>
