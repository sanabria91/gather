<!-----------------------------------------4. REVIEWS (SIJI)------------------------------------>
<div class="panel panel-default">
    <div class="panel-heading">
        Review<span class="pull-right">
        <?php if(($_SESSION['LoggedIn']['UserRole']== 'business')&&(!isset($_GET['id']))): ?>
            <a href="<?php echo __httpRoot . "Business/ReviewAdmin.php?id=" .$businessId; ?>">Manage Reviews</a>
        <?php endif; ?>
        <?php if(($_SESSION['LoggedIn']['UserRole']== 'normal')): ?>
            <a href="<?php echo __httpRoot . "Business/addReviews.php?id=" .$businessId; ?>">Add Review</a>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <!-----------4.1 USER REVIEW ------>
        <div class="row">
            <?php 
                foreach ($reviews as $r) :
                    if (($r->status == 'approved') || ($r->status == 'Approved')): 
            ?>
            <div class="col-md-12">
                <ul id="display">
                    <li id="name"><b> Review By: <?php echo $r->fname; ?></b></li>
                    <li id="name"><?php echo $r->date; ?> </li>
                    <li id="list3"><em><?php echo $r->review; ?></em></li>
                </ul>
                <form action=" " method="POST">
                    <input type="hidden" value="<?php echo $r->post_id; ?>" name="post_id">
                    <input class="btn btn-default" type="submit" id="like" value="like" name="like"/>
                    <span id="num_likes">
                        <?php 
                            $row = $reviewController->displayalldata($r->post_id);
                            echo " " . $row->likes . " people liked"; 
                        ?>
                    </span>
                </form>
            </div>
            <?php 
                    endif;
                endforeach;
            ?>
        </div>
        <!----4.2 Rating -------->
        <?php if(($_SESSION['LoggedIn']['UserRole']== 'normal')): ?>
        <form action="" name="ratings" id="ratings">
                <input type="text" name="businessId" value='<?php echo $businessId; ?>' hidden id="rating-id">
            <div class="rating_container">
                <div class="rating_stars" style="padding: 10px"  style="margin-left: 35px">
                    <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png" id="1_star" style="margin-right: 10px " />
                    <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png" id="2_star"/>
                    <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png" id="3_star"/>
                    <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png" id="4_star"/>
                    <img src="<?php echo __httpRoot . "assest/"?>images/blankn.png" id="5_star"/>
                </div>
            </div>
            <div>
                <input type="hidden" id="rating" name="rating" value="<?php echo (isset($_POST['clicked_val'])) ? $_POST['clicked_val'  ] : 0; ?>"/>
                <input type="button" value="submit rating" id="submit_rating" name="ratingvalue"/>
            </div>
            <div id="response">

            </div>
        </form>
        <?php endif; ?>
    </div>
</div>