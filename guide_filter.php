<?php
require_once 'connectdb.php';

if (isset($_GET['category'])) {
    $category = mysqli_real_escape_string($con, $_GET['category']);

    if ($category === "All") {
        $guideSql = "SELECT * FROM guides";
    } else {
        $guideSql = "SELECT * FROM guides WHERE guideCategory='$category'";
    }

    $resguide = mysqli_query($con, $guideSql);
    $count = mysqli_num_rows($resguide);
} else if(isset($_GET['searchval'])){
    $searchval = mysqli_real_escape_string($con, $_GET['searchval']);
    $guideSql = "SELECT * FROM guides WHERE guideTitle LIKE '%$searchval%'";
    $resguide = mysqli_query($con, $guideSql);
    $count = mysqli_num_rows($resguide);
} else{
    $guideSql = "SELECT * FROM guides";
    $resguide = mysqli_query($con, $guideSql);
    $count = mysqli_num_rows($resguide);
}

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($resguide)) {
            $guideID = $row['guideID'];
            $guideTitle = $row['guideTitle'];
            $guideContent = nl2br($row['guideContent']);
            $guideImg = $row['guideImg'];
            $guideCategory = $row["guideCategory"];

            ?>
            <a style="text-decoration: none; color: black; width: fit-content;" href="#" type="button" data-bs-toggle="modal" data-bs-target="#guideDetailsContainer<?php echo $row["guideID"]; ?>" >    
            <div class="guideCard">
                <?php if($guideImg){ ?>
                    <img src="images/guideImg/<?php echo $guideImg; ?>" class="guideImg" />
                <?php } else { ?>
                        <img src="images/guideImg/default.jpg" class="guideImg" style="object-fit: cover;"/>
                <?php } ?>
                <div class="guideCategory" style="background-color:<?php echo categoryColor($guideCategory); ?> ">
                    <?php echo $guideCategory; ?>
                </div>
                <div class="guideTitle">
                    <?php echo $guideTitle; ?>
                </div>
                <div class="guideDescription">
                <?php echo $guideContent; ?>
                </div>
                <div class="learnmore">
                    <span>Read more</span>
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
                        <div class="guideCategory" style="margin: 15px 0; background-color: <?php echo categoryColor($guideCategory); ?>"><?php echo $guideCategory; ?></div>
                        <h3 style="font-size: 20px;"><?php echo $guideTitle; ?></h3>
                        <?php $guideContent=makeLinksClickable($guideContent); ?>
                        <div><?php echo $guideContent; ?></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <?php 
            }
        }else{
            if(isset($_GET['category'])){
                echo "<div style='font-size: 20px; margin: auto; grid-column: 1 / -1;'>No guide for category \"$category\".</div>";
            }else if(isset($_GET['searchval'])){
                echo "<div style='font-size: 20px; margin: auto; grid-column: 1 / -1;'>No matching guide title \"$searchval\".</div>";
            }
        }

    function makeLinksClickable($text) {
        // Regular expression to find URLs in the text
        $pattern = '/(https?:\/\/[^\s]+)/';
        $replacement = '<a href="$1" target="_blank">$1</a>';
        $text = preg_replace($pattern, $replacement, $text);
        return $text;
    }

    function categoryColor($cat){
        switch($cat){
            case 'Environment Protection':
                return '#b2f7ff';
            case 'Energy and Resource':
                return '#ffff76';
            case 'Waste Reduction and Recycling':
                return '#ffdb70';
            case 'Carbon Footprint':
                return '#acffac';
            case 'Transportation':
                return '#f1c2c2';
            case 'Other':
                return '#dbdbdb';
        }
    }
?>
