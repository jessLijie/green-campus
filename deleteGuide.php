<?php
session_start(); ob_start();
include("connectdb.php");
if(isset($_POST['action']) && $_POST['action']=="delete"){
    $delguideid = $_POST['delguideID'];
    $delguideImg = $_POST['delguideImg'];
    if($delguideImg != ""){
        $path = "./images/guideImg/$delguideImg";
        $remove = unlink($path);

        if($remove==false){
            $_SESSION['remove-failed'] = "<div class='statusMessageBox1'>
                                                <div class='toast-content'>
                                                <i class='bi bi-x toast-icon redColor'></i>
                                                <div class='message'>
                                                    <span class='message-text text-1'>Failed</span>
                                                    <span class='message-text text-2'>Failed to remove guide image</span>
                                                </div>
                                                </div>
                                                <i class='bi bi-x toast-close'></i>
                                                <div class='progressbar active redColor'></div>
                                        </div>";
            header("location: guideManage.php");
            die();
        }
    }
    $sqlDelguide = "DELETE FROM guides WHERE guideID=$delguideid";
    $resdelguide = mysqli_query($con, $sqlDelguide);
    if($resdelguide){
        $_SESSION['deleteGuide'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-check2 toast-icon greenColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Success</span>
                                            <span class='message-text text-2'>Guide deleted successfully</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active greenColor'></div>
                                </div>";
        header("location: guideManage.php");
    } else{
        $_SESSION['deleteGuide'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to delete guide</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
        header("location: guideManage.php");
    }
}
?>