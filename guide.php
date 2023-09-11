<?php session_start(); ?>
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
    <link rel="stylesheet" href="css/guide.css" />
    <title>Greenify UTM</title>
</head>
<body>
    <?php include("header.php"); ?>
    <?php 
        if(isset($_GET['category'])){
            $guideCategory = $_GET['category'];
            if($guideCategory=="All"){
                $guideSql = "SELECT * FROM guides";
            }else{
              $guideSql = "SELECT * FROM guides WHERE guideCategory='$guideCategory'";  
            }
        } else {
            $guideSql = "SELECT * FROM guides";
        }
    ?>
    <?php
        function makeLinksClickable($text) {
            // Regular expression to find URLs in the text
            $pattern = '/(https?:\/\/[^\s]+)/';
            $replacement = '<a href="$1" target="_blank">$1</a>';
            $text = preg_replace($pattern, $replacement, $text);
            return $text;
        }
    ?>
    <div class="guidePageContainer">
        <div class="slider">
            <div class="slideList">
                <div class="item">
                    <div class="slideContent">
                        <img src="./images/guideImg/earthday.jpg" alt="environment-protection" height="100%" />
                    </div>
                </div>
                <div class="item">
                    <div class="slideContent">
                        <img src="./images/guideImg/transport.png" alt="transportation" height="100%" />
                    </div>
                </div>
                <div class="item">
                    <div class="slideContent">
                        <img src="./images/guideImg/recycle.png" alt="recycle" height="100%" />
                    </div>
                </div>
                <div class="item">
                    <div class="slideContent">
                        <img src="./images/guideImg/energy.jpg" alt="energy" height="100%" />
                    </div>
                </div>
                <div class="item">
                    <div class="slideContent">
                        <img src="./images/guideImg/carbonfootprint.jpg" alt="energy" height="100%" />
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button id="prev"><</button>
                <button id="next">></button>
            </div>
            <ul class="dots">
                <li class="active"></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <script>
            let slider = document.querySelector('.slider .slideList');
            let items = document.querySelectorAll('.slider .slideList .item');
            let next = document.getElementById('next');
            let prev = document.getElementById('prev');
            let dots = document.querySelectorAll('.slider .dots li');

            let lengthItems = items.length - 1;
            let active = 0;
            next.onclick = function(){
                active = active + 1 <= lengthItems ? active + 1 : 0;
                reloadSlider();
            }
            prev.onclick = function(){
                active = active - 1 >= 0 ? active - 1 : lengthItems;
                reloadSlider();
            }
            let refreshInterval = setInterval(()=> {next.click()}, 3000);
            function reloadSlider(){
                slider.style.left = -items[active].offsetLeft + 'px';
                
                let last_active_dot = document.querySelector('.slider .dots li.active');
                last_active_dot.classList.remove('active');
                dots[active].classList.add('active');

                clearInterval(refreshInterval);
                refreshInterval = setInterval(()=> {next.click()}, 3000);
 
            }

            dots.forEach((li, key) => {
                li.addEventListener('click', ()=>{
                    active = key;
                    reloadSlider();
                })
            })
            window.onresize = function(event) {
                reloadSlider();
            };
        </script>
        <div class="guideContainer">
            <div class="guideCategoryNav">
                <h4><i class="bi bi-grid-fill" style="margin-right: 10px;"></i>Category</h4>
                <div class="guideCategorylist" id="categoryFilter">
                    <a data-category="All" href="#"><h6>All</h6></a>
                    <a data-category="<?php echo htmlspecialchars("Environment Protection"); ?>" href="#"><h6><img src="./images/guideImg/envprotectIcon.png" alt="icon" width="18px" height="18px" style="margin-right: 5px;"/>Environment Protection</h6></a>
                    <a data-category="<?php echo htmlspecialchars("Energy and Resource"); ?>" href="#"><h6><img src="./images/guideImg/energyIcon.png" alt="icon" width="18px" height="18px" style="margin-right: 5px;"/>Energy and Resource</h6></a>
                    <a data-category="<?php echo htmlspecialchars("Waste Reduction and Recycling"); ?>" href="#"><h6><img src="./images/guideImg/recycleIcon.png" alt="icon" width="18px" height="18px" style="margin-right: 5px;"/>Waste Reduction and Recycling</h6></a>
                    <a data-category="<?php echo htmlspecialchars("Carbon Footprint"); ?>" href="#"><h6><img src="./images/guideImg/carbonfootprintIcon.png" alt="icon" width="18px" height="18px" style="margin-right: 5px;"/>Carbon Footprint</h6></a>
                    <a data-category="Transportation" href="#"><h6><img src="./images/guideImg/transportIcon.png" alt="icon" width="18px" height="18px" style="margin-right: 5px;"/>Transportation</h6></a>
                    <a data-category="Other" href="#"><h6>Other</h6></a>
                </div>
            </div>
            
            <div class="guideListContainer">
                <div class="guideListHeader">
                    <h4><i class="bi bi-list-ul" style="margin-right: 10px;"></i>Guide List</h4>
                    <a href="./guideManage.php" class="manageIcon"><i class="bi bi-gear"></i></a>
                </div>
                
                <div class="guideCardList" id="guideCardList">
                    <?php 
                        $resguide = mysqli_query($con, $guideSql);
                        $count = mysqli_num_rows($resguide);
                        if($count>0){
                            while($row=mysqli_fetch_assoc($resguide)){
                                $guideID = $row['guideID'];
                                $guideTitle = $row['guideTitle'];
                                $guideContent = nl2br($row['guideContent']);
                                $guideImg = $row['guideImg'];
                                $guideCategory = $row["guideCategory"];

                                $modalContent[$row['guideID']] = array(
                                    "guideTitle" => $row["guideTitle"],
                                    "guideContent" => nl2br($row["guideContent"]),
                                    "guideImg" => $row["guideImg"],
                                    "guideCategory" => $row["guideCategory"]
                                );?>

                        <a style="text-decoration: none; color: black;" href="#" type="button" data-bs-toggle="modal" data-bs-target="#guideDetailsContainer<?php echo $row["guideID"]; ?>" >    
                            <div class="guideCard">
                                <?php if($guideImg){ ?>
                                    <img src="images/guideImg/<?php echo $guideImg; ?>" class="guideImg" />
                                <?php } else { ?>
                                        <img src="images/guideImg/default.jpg" class="guideImg" style="object-fit: cover;"/>
                                <?php } ?>
                                <div class="guideCategory">
                                    <?php echo $guideCategory; ?>
                                </div>
                                <div class="guideTitle">
                                    <?php echo $guideTitle; ?>
                                </div>
                                <div class="guideDescription">
                                <?php echo $guideContent; ?>
                                </div>
                                <div class="learnmore">
                                    <span>Learn more</span> <i class="bi bi-arrow-right-short"></i>
                                </div>
                            </div>
                        </a>

                        <div class="modal fade .modal-dialog-centered" id="guideDetailsContainer<?php echo $row["guideID"]; ?>" tabindex="-1" aria-labelledby="guideDetailsContainerLabel" aria-hidden="true" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="guideDetailsContainerLabel"></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div style="padding: 5px 15px;">
                                        <?php if($guideImg){ ?>
                                            <img src="images/guideImg/<?php echo $guideImg; ?>" alt="guideImg-<?php echo $guideID; ?>" style="width: 100%; height: 300px; border-radius: 10px;"/>
                                        <?php } else { ?>
                                            <img src="images/guideImg/default.jpg" alt="guideImg" style="width: 100%; height: 300px; border-radius: 10px; object-fit: cover;"/>
                                        <?php } ?>
                                        <div class="guideCategory" style="margin: 15px 0;"><?php echo $guideCategory; ?></div>
                                        <h3 style="font-size: 20px;"><?php echo $guideTitle; ?></h3>
                                        <?php $guideContent=makeLinksClickable($guideContent); ?>
                                        <div><?php echo $guideContent; ?></div>
                                    </div>
                                </div>
                                <!--<div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>-->
                                </div>
                            </div>
                        </div>
                        <?php 
                            }
                        } else {
                            echo "<div style='font-size: 20px; margin: auto;'>No result found.</div>";
                        } ?>
                        
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
    // Handle category link clicks
    $('#categoryFilter a').click(function(e) {
        e.preventDefault();
        var category = $(this).data('category');
        loadFilteredResults(category);
    });

    function loadFilteredResults(category) {
        $.ajax({
            type: 'GET',
            url: 'guide_filter.php', // Replace with the actual endpoint
            data: { category: category },
            success: function(data) {
                console.log(data);
                $('#guideCardList').html(data);
            },
            error: function() {
                alert('Error loading filtered results.');
            }
        });
    }
});

</script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</html>