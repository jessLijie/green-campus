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
            $guideSql = "SELECT * FROM guides WHERE guideCategory=$guideCategory";
        } else {
            $guideSql = "SELECT * FROM guides";
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
                <h4>Category</h4>
                <div class="guideCategorylist">
                    <a href="guide.php"><h6>All</h6></a>
                    <a href="guide.php?category='<?php echo htmlspecialchars("Environment Protection"); ?>'"><h6>Environment Protection</h6></a>
                    <a href="guide.php?category='<?php echo htmlspecialchars("Energy and Resource"); ?>'"><h6>Energy and Resource</h6></a>
                    <a href="guide.php?category='<?php echo htmlspecialchars("Waste Reduction and Recycling"); ?>'"><h6>Waste Reduction and Recycling</h6></a>
                    <a href="guide.php?category='<?php echo htmlspecialchars("Carbon Footprint"); ?>'"><h6>Carbon Footprint</h6></a>
                    <a href="guide.php?category='Transportation'"><h6>Transportation</h6></a>
                    <a href="guide.php?category='Other'"><h6>Other</h6></a>
                </div>
            </div>
            
            <div class="guideListContainer">
                <div class="guideListHeader">
                    <h4>Guide List</h4>
                    <a href="./guideManage.php" class="manageIcon"><i class="bi bi-gear"></i></a>
                </div>
                
                <div class="guideCardList" id="guideCardList">
                    <?php 
                        $resguide = mysqli_query($con, $guideSql);
                        $count = mysqli_num_rows($resguide);
                        if($count>0){
                            while($row=mysqli_fetch_assoc($resguide)){
                                $modalContent[$row['guideID']] = array(
                                    "guideTitle" => $row["guideTitle"],
                                    "guideContent" => $row["guideContent"],
                                    "guideImg" => $row["guideImg"],
                                    "guideCategory" => $row["guideCategory"]
                                )?>

                        <a style="text-decoration: none; color: black;" href="#" type="button" data-bs-toggle="modal" data-bs-target="#guideDetailsContainer<?php echo $row["guideID"]; ?>" >    
                            <div class="guideCard">    
                                <img src="images/guideImg/<?php echo $modalContent[$row["guideID"]]["guideImg"]; ?>" class="guideImg" />
                                <div class="guideCategory">
                                    <?php echo $modalContent[$row["guideID"]]["guideCategory"]; ?>
                                </div>
                                <div class="guideTitle">
                                    <?php echo $modalContent[$row["guideID"]]["guideTitle"]; ?>
                                </div>
                                <div class="guideDescription">
                                <?php echo $modalContent[$row["guideID"]]["guideContent"]; ?>
                                </div>
                                <div class="learnmore">
                                    <span>Learn more</span> <i class="bi bi-arrow-right-short"></i>
                                </div>
                            </div>
                        </a>
                        <?php 
                            }
                        } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- display modal -->
    
    <?php 
    mysqli_data_seek($resguide, 0);
    while($row=mysqli_fetch_assoc($resguide)){ ?>
    <div class="modal fade .modal-dialog-centered" id="guideDetailsContainer<?php echo $row["guideID"]; ?>" tabindex="-1" aria-labelledby="guideDetailsContainerLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="guideDetailsContainerLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="padding: 5px 15px;">
                    <img src="images/guideImg/<?php echo $modalContent[$row['guideID']]['guideImg'] ?>" alt="<?php $modalContent[$row['guideID']]['guideImg'] ?>" style="width: 100%; height: 300px; border-radius: 10px;"/>
                    <div class="guideCategory" style="margin: 15px 0;"><?php echo $modalContent[$row['guideID']]['guideCategory']; ?></div>
                    <h3 style="font-size: 20px;"><?php echo $modalContent[$row["guideID"]]["guideTitle"]; ?></h3>
                    <div><?php echo $modalContent[$row['guideID']]['guideContent']; ?></div>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>-->
            </div>
        </div>
    </div>
    <?php } ?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const scrollLinks = document.querySelectorAll('.scroll-link');
    
    // Store scroll position when a link is clicked
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
    });
    
    // Restore scroll position on page load
    const storedScrollPosition = sessionStorage.getItem('scrollPosition');
    if (storedScrollPosition) {
        window.scrollTo(0, storedScrollPosition);
        sessionStorage.removeItem('scrollPosition'); // Clear stored position
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</html>