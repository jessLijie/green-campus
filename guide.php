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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                                $guideTitle = $row['guideTitle'];
                                $guideContent = $row['guideContent'];
                                $guideImg = $row['guideImg'];
                                $guideCategory = $row['guideCategory']; ?>
                            
                        <div class="guideCard">
                            <img src="images/guideImg/<?php echo $guideImg; ?>" class="guideImg" />
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
                        <?php 
                            }
                        } ?>
                </div>
            </div>
        </div>
        
        

    </div>
</body>
</html>