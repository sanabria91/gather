<div class="panel panel-default" id="business-review-form">
    <div class="panel-heading">
        <h3>Write a review about this business here</h3>
    </div>
    <div class="panel-body">
        <form name="customer_reviews" id="submit_form">
            <input name="username" value="<?php echo $_SESSION['LoggedIn']['Username'];?>" id="review-username" hidden>
            <input name="email" value='<?php echo $_SESSION['LoggedIn']['Email'];?>' id="review-email" hidden>
            <input name="businessid" value='<?php echo $_GET['id']; ?>' id="review-businessid" hidden>
            <fieldset name="review">
                <div>
                    <label for="review">Review:</label>
                    <textarea id="review" name="review" rows="4" cols="50"></textarea>
                    <span id="review_text"><?php echo $error_text; ?></span>
                </div>
                <div>
                    <input type="submit" id="submit_review" value="submit" name="submit"/>
                </div>
                <div id="review_response">

                </div>
            </fieldset>
        </form>
    </div>
</div>
