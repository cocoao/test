<meta charset='utf-8'>
<?php
    $design_num = $_GET['num'];
    $design_title = nl2br($_REQUEST['design_title']);
    $design_title = addslashes($design_title); //addcslashes 문자로 인식하게 슬래쉬 추가
    $design_serial = $_REQUEST['design_serial'];
    $design_client = $_REQUEST['design_client'];
    $design_desc = nl2br($_REQUEST['design_desc']); //nl2br 엔터치면 <br>로
    $design_desc = addslashes($design_desc);
    $regist_day = date("Y-m-d");

    $img_upload_dir = $_SERVER['DOCUMENT_ROOT'].'/gold/data/design_page/';  
    $thumb_upload_dir = $_SERVER['DOCUMENT_ROOT'].'/gold/data/design_page/thumb/';

    //main image
    $main_name = $_FILES['main']['name'];
    $main_tmp_name = $_FILES['main']['tmp_name']; // 인코딩된 이름
    $main_error = $_FILES['main']['error']; //에러

    //sub image
    $sub_name = $_FILES['sub']['name'];
    $sub_tmp_name = $_FILES['sub']['tmp_name']; // 인코딩된 이름
    $sub_error = $_FILES['sub']['error']; //에러

    //thumbnail image
    $thumbnail_name = $_FILES['thumbnail']['name'];
    $thumbnail_tmp_name = $_FILES['thumbnail']['tmp_name']; // 인코딩된 이름
    $thumbnail_error = $_FILES['thumbnail']['error']; //에러

    //main image upload
    if($main_name && !$main_error){
        $uploaded_main_file = $img_upload_dir.$main_name;
        if(!move_uploaded_file($main_tmp_name,$uploaded_main_file)){
            echo "
            <script>
                alert('사진이 업로드 되지 않았습니다');
            </script>
            ";
            exit; 
            }
        } else {
            $main_name = '';
        }
   
    //sub image upload
    if($sub_name && !$sub_error){
        $uploaded_sub_file = $img_upload_dir.$sub_name;
        if(!move_uploaded_file($sub_tmp_name,$uploaded_sub_file)){
            echo "
            <script>
                alert('사진이 업로드 되지 않았습니다');
            </script>
            ";
            exit;
            }
        } else {
            $sub_name = '';
        }
    
    //thumbnail image upload
    if($thumbnail_name && !$thumbnail_error){
        $uploaded_thumbnail_file = $thumb_upload_dir.$thumbnail_name;
        if(!move_uploaded_file($thumbnail_tmp_name,$uploaded_thumbnail_file)){
            echo "
            <script>
                alert('사진이 업로드 되지 않았습니다');
            </script>
            ";
            exit;
            }
        } else{
            $thumbnail_name='';
        }
    
    // database connect
    include $_SERVER['DOCUMENT_ROOT'].'/gold/php_process/connect/db_connect.php';

    $sql = "UPDATE gold_de SET GOLD_DE_tit='$design_title',GOLD_DE_ser='$design_serial',GOLD_DE_des='$design_desc',GOLD_DE_img1='$main_name',GOLD_DE_img2='$sub_name',GOLD_DE_thumb='$thumbnail_name',GOLD_DE_cli='$design_client',GOLD_DE_reg='$regist_day' WHERE GOLD_DE_num='$design_num'";


    // $sql = "UPDATE into gold_de(GOLD_DE_tit,GOLD_DE_ser,GOLD_DE_des,GOLD_DE_img1,GOLD_DE_img2,GOLD_DE_thumb,GOLD_DE_cli,GOLD_DE_reg) values('$design_title','$design_serial','$design_desc','$main_name','$sub_name','$thumbnail_name','$design_client','$regist_day')";

    mysqli_query($dbConn,$sql);

    echo "
    <script>
    alert('수정이 완료되었습니다')
        location.href='/gold/pages/design/design.php';
    </script>
    "
?>
