<?php session_start(); ob_start();?>
<?php $currentPage = "guide"; 
include("connectdb.php");
if(isset($_SESSION['urole'])){
    $role = $_SESSION['urole'];
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="./css/guideManage.css" />
        <title>Greenify UTM</title>
    </head>
    <body>
        <?php include("header.php"); ?>
        <?php

            if(isset($_GET["filter"]) && isset($_GET["search"])){
                $filter=$_GET['filter'];
                $search_val = $_GET['search'];
                $sql = "SELECT * FROM guides WHERE guideCategory='$filter' AND guideTitle LIKE '%$search_val%'";
            }
            else if(isset($_GET["filter"])){
                $filter=$_GET['filter'];
                $sql = "SELECT * FROM guides WHERE guideCategory='$filter'";
            } else if(isset($_GET["search"])){
                $search_val = $_GET['search'];
                $sql = "SELECT * FROM guides WHERE guideTitle LIKE '%$search_val%'";
            } else {
                $sql = "SELECT * FROM guides";
            }

        ?>
        <?php
            //delete guide
            if(isset($_POST['action']) && $_POST['action']=="delete"){
                $delguideid = $_POST['delguideID'];
                $delguideImg = $_POST['delguideImg'];
                if($delguideImg != ""){
                    $path = "./images/guideImg/$delguideImg";
                    $remove = unlink($path);
            
                    if($remove==false){
                        $_SESSION['deleteGuide'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon' />Failed to remove picture.</div>";
                        header("location: guideManage.php");
                        die();
                    }
                }
                $sqlDelguide = "DELETE FROM guides WHERE guideID=$delguideid";
                $resdelguide = mysqli_query($con, $sqlDelguide);
                if($resdelguide){
                    $_SESSION['deleteGuide'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='cross icon' />Guide deleted successfully.</div>";
                    header("location: guideManage.php");
                } else{
                    $_SESSION['deleteGuide'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon' />Failed to delete guide.</div>";
                    header("location: guideManage.php");
                }
            }
            ?>
        ?>

        <div class="guideManageContainer">
            <a class="goback" href="guide.php">
                <i class="bi bi-arrow-left-short"></i>
                <span>Back</span>
            </a>
            <h1 style="font-size: 30px; text-align: center; margin: 15px 0 30px 0;">Guide List</h1>
            <div class="guideMTool">
                <div class="guidefilter">
                    <span><i class="bi bi-funnel" style="font-size:15px; margin-right: 5px;"></i></span>
                    <span style="margin-right: 5px;  white-space: nowrap;">Filter by:</span>
                    <select id="guideFilterOption" name="filter" class="form-select">
                        <option value="" selected >All</option>
                        <option value="<?php echo htmlspecialchars("Environment Protection"); ?>" <?php if(isset($_GET['filter'])&&$filter==htmlspecialchars('Environment Protection')){ echo "selected"; } ?> >Environment Protection</option>
                        <option value="<?php echo htmlspecialchars("Energy and Resource"); ?>" <?php if(isset($_GET['filter'])&&$filter==htmlspecialchars('Energy and Resource')){ echo "selected"; } ?> >Energy and Resource</option>
                        <option value="<?php echo htmlspecialchars("Waste Reduction and Recycling"); ?>" <?php if(isset($_GET['filter'])&&$filter==htmlspecialchars('Waste Reduction and Recycling')){ echo "selected"; } ?> >Waste Reduction and Recycling</option>
                        <option value="<?php echo htmlspecialchars("Carbon Footprint"); ?>" <?php if(isset($_GET['filter'])&&$filter==htmlspecialchars('Carbon Footprint')){ echo "selected"; } ?> >Carbon Footprint</option>
                        <option value="<?php echo htmlspecialchars("Transportation"); ?>" <?php if(isset($_GET['filter'])&&$filter==htmlspecialchars('Transportation')){ echo "selected"; } ?> >Transportation</option>
                        <option value="Other" <?php if(isset($_GET['filter'])&&$filter=="Other"){ echo "selected"; } ?>>Other</option>
                    </select>
                </div>
                <div class="input-group searchBar">
                    <input type="text" name="search" class="form-control" value="<?php if(isset($_GET['search'])){ echo $search_val; } ?>" placeholder="Guide Title" />
                    <button name="searchbtn" id="guideSearch" class="btn btn-light searchbtn"><i class="bi bi-search"></i></button>
                </div>
                <button type="button" class="addGuideBtn" data-bs-toggle="modal" data-bs-target="#addGuideFormContainer">
                    Add Guide
                </button>
            </div>
            
            <div class="guideMTable">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th colspan="2">Action</th>
                    </tr>
                
                    <?php 
                        $result = mysqli_query($con, $sql);
                        $count = mysqli_num_rows($result);
                        if($count>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $guideID = $row['guideID'];
                                $guideTitle = $row['guideTitle'];
                                $guideContent = $row['guideContent'];
                                $guideImg = $row['guideImg'];
                                $guideCategory = $row["guideCategory"];
                    ?>
                            <tr>
                                <td><?php echo $guideID; ?></td>
                                <td><?php echo $guideTitle; ?></td>
                                <td><?php echo $guideContent; ?></td>
                                <td>
                                    <?php 
                                        if($guideImg!=""){ ?>
                                            <img src="./images/guideImg/<?php echo $guideImg;?>" alt="guideImg-<?php echo $guideID; ?>" style="width: 130px; height: 100px;" />
                                    <?php    } else{
                                            echo "No Image";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $guideCategory; ?></td>
                                <td>
                                    <form method="post" action="" >
                                        <input type='hidden' name='action' value='edit' />
                                        <input type='hidden' name='editguideID' value="<?php echo $row['guideID']; ?>" />
                                        <button type="submit" class='editguide'>
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="">
                                        <input type='hidden' name='delguideID' value="<?php echo $guideID; ?>" />
                                        <input type='hidden' name='delguideImg' value="<?php echo $guideImg; ?>" />
                                        <input type='hidden' name='action' value='delete' />
                                        <button type="submit" class='delguide' onClick="javascript: return confirm('Please confirm deletion.');">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>No guide yet</td></tr>";
                        }
                        ?>

                </table>
                
            </div>
        </div>
        <?php include("addguideModal.php"); ?>
        <?php include("editguideModal.php"); ?>
        <script>
            var filter = document.getElementById("guideFilterOption");
            filter.addEventListener("change", function (){
                var searchValue = encodeURIComponent(document.querySelector("[name='search']").value);
                var filterValue = encodeURIComponent(document.querySelector("[name='filter']").value);
                console.log(searchValue);
                if(searchValue != "" && filterValue !=""){
                    window.location.href = "guideManage.php?search=" + searchValue + "&filter=" + filterValue;
                } else if(searchValue == "" && filterValue != ""){
                    window.location.href = "guideManage.php?filter=" + filterValue;
                } else if(searchValue != "" && filterValue == ""){
                    window.location.href = "guideManage.php?search=" + searchValue;
                } else {
                    window.location.href = "guideManage.php";
                }
            }); 

            document.getElementById("guideSearch").addEventListener("click", function () {
                var searchValue = encodeURIComponent(document.querySelector("[name='search']").value);
                var filterValue = encodeURIComponent(document.querySelector("[name='filter']").value);
                console.log(searchValue);
                if(searchValue != "" && filterValue !=""){
                    window.location.href = "guideManage.php?search=" + searchValue + "&filter=" + filterValue;
                } else if(searchValue == "" && filterValue != ""){
                    window.location.href = "guideManage.php?filter=" + filterValue;
                } else if(searchValue != "" && filterValue == ""){
                    window.location.href = "guideManage.php?search=" + searchValue;
                } else {
                    window.location.href = "guideManage.php";
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>