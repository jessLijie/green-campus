<?php
session_start();

include("connectdb.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM newsfeed WHERE id = $id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);

    $sql = "DELETE FROM newsfeed WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        unlink('images/newsImg/' .$row['image_url']);
        echo "News deleted successfully.";
        $_SESSION['deleteNews'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-check2 toast-icon greenColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Success</span>
                                            <span class='message-text text-2'>News deleted successfully</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active greenColor'></div>
                                </div>";
    } else {
        echo "Error deleting user: " . mysqli_error($con);
        $_SESSION['deleteNews'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to delete news</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
    }
    header('Location: adminManage.php');
    exit;
}
mysqli_close($con);
?>