<?php session_start(); ?>
<?php $currentPage = "guide";
include("connectdb.php");
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/guide.css" />
    <title>Greenify | CGuide</title>
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
                <button id="prev">
                    << /button>
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
            next.onclick = function () {
                active = active + 1 <= lengthItems ? active + 1 : 0;
                reloadSlider();
            }
            prev.onclick = function () {
                active = active - 1 >= 0 ? active - 1 : lengthItems;
                reloadSlider();
            }
            let refreshInterval = setInterval(() => { next.click() }, 3000);
            function reloadSlider() {
                slider.style.left = -items[active].offsetLeft + 'px';

                let last_active_dot = document.querySelector('.slider .dots li.active');
                last_active_dot.classList.remove('active');
                dots[active].classList.add('active');

                clearInterval(refreshInterval);
                refreshInterval = setInterval(() => { next.click() }, 3000);

            }

            dots.forEach((li, key) => {
                li.addEventListener('click', () => {
                    active = key;
                    reloadSlider();
                })
            })
            window.onresize = function (event) {
                reloadSlider();
            };
        </script>
        <div class="guideContainer">
            <div class="guideCategoryNav">
                <h4><i class="bi bi-grid-fill" style="margin-right: 10px;"></i>Category</h4>
                <div class="guideCategorylist" id="categoryFilter">
                    <a data-category="All" href="#">
                        <h6>All</h6>
                    </a>
                    <a data-category="<?php echo htmlspecialchars("Environment Protection"); ?>" href="#">
                        <h6><img src="./images/guideImg/envprotectIcon.png" alt="icon" width="18px" height="18px"
                                style="margin-right: 5px;" />Environment Protection</h6>
                    </a>
                    <a data-category="<?php echo htmlspecialchars("Energy and Resource"); ?>" href="#">
                        <h6><img src="./images/guideImg/energyIcon.png" alt="icon" width="18px" height="18px"
                                style="margin-right: 5px;" />Energy and Resource</h6>
                    </a>
                    <a data-category="<?php echo htmlspecialchars("Waste Reduction and Recycling"); ?>" href="#">
                        <h6><img src="./images/guideImg/recycleIcon.png" alt="icon" width="18px" height="18px"
                                style="margin-right: 5px;" />Waste Reduction and Recycling</h6>
                    </a>
                    <a data-category="<?php echo htmlspecialchars("Carbon Footprint"); ?>" href="#">
                        <h6><img src="./images/guideImg/carbonfootprintIcon.png" alt="icon" width="18px" height="18px"
                                style="margin-right: 5px;" />Carbon Footprint</h6>
                    </a>
                    <a data-category="Transportation" href="#">
                        <h6><img src="./images/guideImg/transportIcon.png" alt="icon" width="18px" height="18px"
                                style="margin-right: 5px;" />Transportation</h6>
                    </a>
                    <a data-category="Other" href="#">
                        <h6>Other</h6>
                    </a>
                </div>
            </div>

            <div class="guideListContainer">
                <div class="guideListHeader">
                    <h4><i class="bi bi-list-ul" style="margin-right: 10px;"></i>Guide List</h4>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") { ?>
                        <a href="./guideManage.php" class="manageIcon"><i class="bi bi-gear"></i></a>
                    <?php } ?>
                    <form id="searchguideForm" class="input-group" action="" method="get"
                        style="width: 300px; margin: 0 10px 0 auto;">
                        <input type="text" id="searchVal" name="search" class="form-control"
                            placeholder="Guide Title" />
                        <button class="btn btn-light searchbtn"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                <div class="guideCardList" id="guideCardList">

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            loadFilteredResults("All");
            // Handle category link clicks
            $('#categoryFilter a').click(function (e) {
                e.preventDefault();
                var category = $(this).data('category');
                var clickedCategory = $(this);
                loadFilteredResults(category, clickedCategory);
            });

            function loadFilteredResults(category, clickedCategory = "") {
                $.ajax({
                    type: 'GET',
                    url: 'guide_filter.php',
                    data: { category: category },
                    success: function (data) {
                        $('#guideCardList').html(data);
                        $('#searchVal').val("");
                        $('#categoryFilter a').css("background-color", "white");
                        $(clickedCategory).css("background-color", "#b3ffd6");
                    },
                    error: function () {
                        alert('Error loading filtered results.');
                    }
                });
            }

            $(document).on('submit', '#searchguideForm', function (e) {
                e.preventDefault();
                var searchval = $('#searchVal').val();
                $.ajax({
                    type: 'GET',
                    url: 'guide_filter.php',
                    data: { searchval: searchval },
                    success: function (data) {
                        $('#guideCardList').html(data);
                    },
                    error: function (data) {
                        alert('Error loading searched results.');
                    }
                })
            })

        });

    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

</html>