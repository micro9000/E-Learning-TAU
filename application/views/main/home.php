
    <div class="wrapper">
        <div class="content">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        
                        <div class="content-panel" style="margin-bottom: 0;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="carouselExampleIndicators" class="lessons_cover carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="8"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="9"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="10"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="11"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="12"></li>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="13"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <div class="carousel-item active cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/1.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/2.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/3.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/4.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/5.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/6.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/7.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/8.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/9.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/10.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/11.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/12.jpg") ?>" alt="First slide">
                                            </div>
                                            <div class="carousel-item cover_img">
                                              <img class="d-block w-100" src="<?php echo base_url("assets/imgs/slide/13.jpg") ?>" alt="First slide">
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        
                        <div class="content-panel">
                            <p class="agri_quote_of_the_day">
                                “Agriculture is our wisest pursuit, because it will in the end contribute most to real wealth, good morals, and happiness.” - Thomas Jefferson
                            </p>
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                        <?php

                            for($i=0; $i<$latest_lessons_with_cover_len; $i++){

                                echo "<div class='content-panel'>";
                                    echo "<div class='row'>";
                                        echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";

                                            $orientation = $latest_lessons_with_cover[$i]['coverOrientation'];
                                            $isWithCover =$latest_lessons_with_cover[$i]['isWithCoverPhoto'];

                                            if ($orientation == "L" && $isWithCover == "1"){

                                                echo "<div class='post_cover'>";
                                                    echo "<img src=".base_url("uploads/lessons/cover/".$latest_lessons_with_cover[$i]['coverPhoto']).">"; 
                                                echo "</div>";

                                                echo "<div class='post_wrapper'>";
                                                    
                                                    echo "<div class='post_date'>";
                                                        echo $latest_lessons_with_cover[$i]['dateAddedFormated'] ." / ". $latest_lessons_with_cover[$i]['principle'] ." / ".$latest_lessons_with_cover[$i]['topic'];
                                                    echo "</div>";

                                                    echo "<div class='post_title'>";
                                                        echo $latest_lessons_with_cover[$i]['title'];
                                                    echo "</div>";

                                                    echo "<div class='post_by'> By ";
                                                        echo $latest_lessons_with_cover[$i]['AddedByUser'];
                                                    echo "</div>";

                                                    echo "<div class='post_description'><p>";
                                                        echo get_content_summary_helper($latest_lessons_with_cover[$i]['content']) . "...<br/><a href='". base_url("view_lesson/".$latest_lessons_with_cover[$i]['id']."/".$latest_lessons_with_cover[$i]['slug']) ."' class='link-read-more'>Read more</a>";
                                                    echo "</p></div>";

                                                echo "</div>";

                                            }else if ($orientation == "P" && $isWithCover == "1"){

                                                echo "<div class='post_wrapper'>";
                                                    echo "<div class='row'>";

                                                        echo "<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6' style='padding: 0 !important;'>";
                                                            echo "<div class='post_cover cover_portrait'>";
                                                                echo "<img src=".base_url("uploads/lessons/cover/".$latest_lessons_with_cover[$i]['coverPhoto']).">"; 
                                                            echo "</div>";
                                                        echo "</div>";

                                                        echo "<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";

                                                            echo "<div class='post_date'>";
                                                                echo $latest_lessons_with_cover[$i]['dateAddedFormated'] ." / ". $latest_lessons_with_cover[$i]['principle'] ." / ".$latest_lessons_with_cover[$i]['topic'];
                                                            echo "</div>";

                                                            echo "<div class='post_title'>";
                                                                echo $latest_lessons_with_cover[$i]['title'];
                                                            echo "</div>";

                                                            echo "<div class='post_by'> By ";
                                                                echo $latest_lessons_with_cover[$i]['AddedByUser'];
                                                            echo "</div>";

                                                            echo "<div class='post_description'><p>";
                                                                echo get_content_summary_helper($latest_lessons_with_cover[$i]['content']) . "...<br/><a href='". base_url("view_lesson/".$latest_lessons_with_cover[$i]['id']."/".$latest_lessons_with_cover[$i]['slug']) ."' class='link-read-more'>Read more</a>";
                                                            echo "</p></div>";

                                                        echo "</div>";

                                                    echo "</div>";
                                                echo "</div>";
                                            }else{
                                                // nothing
                                            }

                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                        <?php
                            for($i=0; $i<$latest_lessons_without_cover_len; $i++){
                                echo "<div class='content-panel lessons-without-cover'>";
                                    echo "<div class='post_wrapper'>";

                                        echo "<div class='post_date'>";
                                            echo $latest_lessons_without_cover[$i]['dateAddedFormated'] ." / ". $latest_lessons_without_cover[$i]['principle'] ." / ".$latest_lessons_without_cover[$i]['topic'];
                                        echo "</div>";

                                        echo "<div class='post_title'>";
                                            echo $latest_lessons_without_cover[$i]['title'];
                                        echo "</div>";

                                        echo "<div class='post_by'> By ";
                                            echo $latest_lessons_without_cover[$i]['AddedByUser'];
                                        echo "</div>";

                                        echo "<div class='post_description'><p>";
                                            echo get_content_summary_helper($latest_lessons_without_cover[$i]['content']) . "...<br/><a href='". base_url("view_lesson/".$latest_lessons_without_cover[$i]['id']."/".$latest_lessons_without_cover[$i]['slug']) ."' class='link-read-more'>Read more</a>";
                                        echo "</p></div>";

                                    echo "</div>";
                                echo "</div>";
                            }
                        ?>

                    </div>

            
                </div>
            </div>
            
        </div>
    </div>


    <!-- <div class="overlay"></div> -->
