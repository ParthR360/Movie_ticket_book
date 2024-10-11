<?php 
session_start();
// if(isset($_POST['admin_key_submit'])){
    $adminkey = $_POST['admin_key'];
    

    include('connection.php');
    $sql = "SELECT * FROM admin_info";
    $result = mysqli_query($conn,$sql);

    $dbkey = mysqli_fetch_array($result);
    
    if($adminkey == $dbkey['adminkey']){
        $_SESSION['admin'] = true;
        header('location:index.php');

    }else{
        $admin_flag = false;
    
    }
// }

?>