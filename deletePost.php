<?php
if(isset($_POST['action']) && $_POST['action']=="delete"){
    $delpostid = $_POST['delpostID'];
    $delpostImg = $_POST['delpostImg'];
    if($delpostImg != ""){
        $path = "./images/postImg/$delpostImg";
        $remove = unlink($path);

        if($remove==false){
            $_SESSION['deletePost'] = "<div class='statusMessageBox1'>
                                            <div class='toast-content'>
                                            <i class='bi bi-x toast-icon redColor'></i>
                                            <div class='message'>
                                                <span class='message-text text-1'>Failed</span>
                                                <span class='message-text text-2'>Failed to remove post image</span>
                                            </div>
                                            </div>
                                            <i class='bi bi-x toast-close'></i>
                                            <div class='progressbar active redColor'></div>
                                    </div>";
            header("location: forum.php");
            die();
        }
    }
    $sqlDelpost = "DELETE FROM post WHERE postID=$delpostid";
    $resdelpost = mysqli_query($con, $sqlDelpost);
    if($resdelpost){
        $_SESSION['deletePost'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-check2 toast-icon greenColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Success</span>
                                            <span class='message-text text-2'>Post deleted successfully</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active greenColor'></div>
                                </div>";
        header("location: forum.php");
    } else{
        $_SESSION['deletePost'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Post failed to delete</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
        header("location: forum.php");
    }
}
?>