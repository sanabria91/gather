$(document).ready(function(){
        var businessId = $('#rating-id').val();
        var clicked_val=0;
        var path = "/php_gather";
        var review_username = $('#review-username').val();
        var review_email = $('#review-email').val();
        var review_businessid = $('#review-businessid').val();

        $('#1_star').hover(function () {
            $('#1_star').attr('src', ' http://' + location.host + path +'/assest/images/starn.png');
            $('#2_star').attr('src', ' http://' + location.host + path +'/assest/images/blankn.png');
            $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');

        })  ;

        $('#1_star').click(function () {
            clicked_val=1;
        });

        $('#2_star').hover(function () {
            $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');

        })  ;

        $('#2_star').click(function () {
            clicked_val=2;
        });

        $('#3_star').hover(function () {
            $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
        })  ;

        $('#3_star').click(function () {

            clicked_val=3;
        });

        $('#4_star').hover(function () {
            $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
        })  ;

        $('#4_star').click(function () {
            clicked_val=4;
        });

        $('#5_star').hover(function () {
            $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
        })  ;

        $('#5_star').click(function () {
            clicked_val=5;
        });

        $('.rating_stars').mouseout(function(){

            if(clicked_val=== 0 || clicked_val > 5)
            {

                $('#1_star').attr('src', ' http://' + location.host + path +'/assest/images/blankn.png');
                $('#2_star').attr('src', ' http://' + location.host + path +'/assest/images/blankn.png');
                $('#3_star').attr('src', ' http://' + location.host + path +'/assest/images/blankn.png');
                $('#4_star').attr('src', ' http://' + location.host + path +'/assest/images/blankn.png');
                $('#5_star').attr('src', ' http://' + location.host + path +'/assest/images/blankn.png');
            }

            else if(clicked_val==1)
            {
                $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
                $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
                $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
                $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            }
            else if(clicked_val==2)
            {
                $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
                $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
                $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            }
            else if(clicked_val==3)
            {
                $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
                $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            }
            else if(clicked_val==4)
            {
                $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/blankn.png');
            }
            else if(clicked_val==5)
            {
                $('#1_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#2_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#3_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#4_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
                $('#5_star').attr('src',' http://' + location.host + path +'/assest/images/starn.png');
            }
        });

        $('#submit_rating').click(function () {
            console.log(businessId);
            if(clicked_val === 0 || clicked_val > 5)
            {
                $('#response').html('Please give a rating');
            }
            else
            {
                $.ajax({

                    type:'POST',
                    cache:false,
                    url:'rating_response.php',
                    data:
                        {
                            'clicked_val':clicked_val, 
                            'BId': businessId
                        },

                    success:function (response) {

                        $('#response').html("Your rating will be " + response);
                        $('#rating').val(response);
                    }
                });
            }
        });

        $('#submit_review').click(function(e)
        {
            e.preventDefault();
            $.ajax({
                url: 'review_response.php',
                type:'POST',
                data:
                    {
                        'fname': review_username,
                        'email': review_email,
                        'review':$('#review').val(),
                        'BID': review_businessid
                    },
                success: function(res)
                {
                    if (res.code == 200) {
                        $('#review_response').html("Your review is submitted.Thank You!");
                    } else {
                        $('#review_response').html("Invalid Input");
                    }
                }
            });
        });
    }
);