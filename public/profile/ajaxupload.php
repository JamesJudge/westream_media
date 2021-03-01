<?php
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // valid extensions
$path = dirname(dirname(__FILE__)).'/assets/profile/'; // upload directory
if(!empty($_POST['nickname']) && $_FILES['image'])
{
    $nickname = $_POST['nickname'];
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    // can upload same image using rand function
    $final_image = rand(1000,1000000).$img;
    // check's valid format
    if(in_array($ext, $valid_extensions))
    {
        $final_image = strtolower($final_image);
        $path = $path.strtolower($final_image);



        if(move_uploaded_file($tmp,$path))
        {
            echo "<h3>Image Uploaded Successfully.</h3> <p><a href='/profile/$nickname'>Click here to go back to profile page</a></p> <img src='/assets/profile/$final_image' />";

//include database configuration file
            include_once 'db.php';
//insert form data in the database
            $insert = $conn->query("update user set profile_image = '$final_image' where nickname='nickname';");
//echo $insert?'ok':'err';
        }else{
            echo('<p style="color:red">Upload Error<br/>Path: '.$path.'<br/>Temp: '.$tmp.'</p>');
        }
    }
    else
    {
        echo 'invalid';
    }
}else{
    echo("Form Error");
}
?>