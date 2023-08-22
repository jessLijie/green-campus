<?php session_start(); ?>
<?php $currentPage = "guide"; ?>
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
                        <h1>Green Campus Transportation</h1>
                        <p class="slideContentDescription">
                            - Walking and Biking
                            - Public Transportation
                            - Carpooling and Ride-Sharing
                            - Electric and Hybrid Vehicles
                        </p>
                        <iframe width="600" height="355" src="https://www.youtube.com/embed/2M8FZiKQ798?si=Mvsgbvga5Od3VY4w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        
                    </div>
                </div>
                <div class="item">
                    <div class="slideContent">
                    <img src="./images/guideImg/recycle.png" alt="environment-protection" height="100%" />
                    </div>
                </div>
                <div class="item">
                    <div class="slideContent">
                        Item 4
                    </div>
                </div>
                <div class="item">
                    <div class="slideContent">
                        Item 5
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
        <div class="category-nav">

        </div>
        <div class="">

        </div>

    </div>
</body>
</html>