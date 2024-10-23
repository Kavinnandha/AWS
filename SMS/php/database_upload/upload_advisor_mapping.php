<?php
    include '../../master/config.php';
    $user_id = $_POST['user_id'];
    $mapping_id = $_POST['mapping_id'];
    $batch_id = $_POST['batch_id'];
    $section_id = $_POST['section_id'];
    $insert_advisor_mapping = 'insert into advisor_mapping(user_id,mapping_id,batch_id,section_id) values("'.$user_id.'","'.$mapping_id.'","'.$batch_id.'","'.$section_id.'")';
    $queryEXE = mysqli_query($connection, $insert_advisor_mapping);
echo "<script>alert('Details have been successfully inserted.');window.location.href='../../master/database_upload/create_advisor_mapping.php'</script>";
?>


