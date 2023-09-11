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
        <?php include("header.php"); 
        if(isset($_SESSION['editguide'])){
            echo $_SESSION['editguide'];
            unset($_SESSION['editguide']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['addguide'])){
            echo $_SESSION['addguide'];
            unset($_SESSION['addguide']);
        }
        if(isset($_SESSION['deleteGuide'])){
            echo $_SESSION['deleteGuide'];
            unset($_SESSION['deleteGuide']);
        }
        if(isset($_SESSION['remove-failed'])){
            echo $_SESSION['remove-failed'];
            unset($_SESSION['remove-failed']);
        }
        ?>
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
            include("addguideModal.php");
            include("deleteGuide.php");
        ?>

        <div class="guideManageContainer">
            <a class="goback" href="guide.php">
                <i class="bi bi-arrow-left-short"></i>
                <span>Back</span>
            </a>
            <h1 style="font-size: 30px; text-align: center; margin: 15px 0 30px 0;">Guide List</h1>
            <div style="margin: 20px 0; text-align: right;">
                <button type="button" class="addGuideBtn" data-bs-toggle="modal" data-bs-target="#addGuideFormContainer">
                        <i class="bi bi-plus-circle"></i> Add Guide
                </button>
            </div>
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
            </div>
            
            <div class="guideMTable">
                <table class="table table-hover">
                    <thead class="table">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 30%;">Title</th>
                            <th style="width: 20%;">Image</th>
                            <th style="width: 25%;">Category</th>
                            <th colspan="2" style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <?php 
                        $result = mysqli_query($con, $sql);
                        $count = mysqli_num_rows($result);
                        $numcount = 1;
                        if($count>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $guideID = $row['guideID'];
                                $guideTitle = $row['guideTitle'];
                                $guideContent = nl2br($row['guideContent']);
                                $guideImg = $row['guideImg'];
                                $guideCategory = $row["guideCategory"];
                    ?>
                            <tr class="tableRow">
                                <td><?php echo $numcount; ?></td>
                                <td><?php echo $guideTitle; ?></td>
                                <td>
                                    <?php 
                                        if($guideImg!=""){ ?>
                                            <img src="./images/guideImg/<?php echo $guideImg;?>" alt="guideImg-<?php echo $guideID; ?>" style="width: 130px; height: 100px;" />
                                    <?php } else{
                                            echo "No Image";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $guideCategory; ?></td>
                                <td style="padding-right: 0;">
                                    <button class='editguide' data-bs-toggle="modal" data-bs-target="#editGuideFormContainer<?php echo $guideID; ?>" > 
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                                <td style="padding-left: 0;">
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
                                include("editguideModal.php");
                                $numcount++;
                            }
                        } else {
                            echo "<tr><td colspan='6'>No guide yet</td></tr>";
                        }
                        ?>

                </table>
                
            </div>
        </div>
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

            document.addEventListener('DOMContentLoaded', function(){
                var statusMessageBox = document.querySelector('.statusMessageBox1');
                if(statusMessageBox){
                    setTimeout(function() {
                        statusMessageBox.classList.add("slideOut");
                    }, 4000);
                }
                var progressbar = document.querySelector('.progressbar.active');
                if (progressbar) {
                    setTimeout(function() {
                        progressbar.classList.remove("active");
                        statusMessageBox.remove();
                    }, 4500);
                }

                var toastCloseButtons = document.querySelectorAll('.toast-close');
                toastCloseButtons.forEach(function(button) {
                    button.addEventListener("click", function() {
                        var statusMessageBox = document.querySelector('.statusMessageBox1');
                        statusMessageBox.classList.add("slideOut");

                        setTimeout(function() {
                            progressbar.classList.remove("active");
                            statusMessageBox.remove();
                        }, 300);
                    });
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>