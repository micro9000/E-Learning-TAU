
    <div class="wrapper">
        <div class="content">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        
                        <div class="content-panel" style="margin-bottom: 0;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="lessons_cover" class="carousel slide" data-ride="carousel">

                                      <!-- Indicators -->
                                      <ul class="carousel-indicators">
                                        <?php
                                            $coverLen = sizeof($latest_lessons_cover_img);

                                            if ($coverLen > 0){

                                                echo "<li data-target='#lessons_cover' data-slide-to='0' class='active'></li>";
                                                for($i=1; $i<$coverLen; $i++){
                                                    echo "<li data-target='#lessons_cover' data-slide-to='". $i ."'></li>";
                                                }
                                            }
                                        ?>
                                      </ul>
                                      
                                      <!-- The slideshow -->
                                      <div class="carousel-inner">

                                        <?php
                                            $coverLen = sizeof($latest_lessons_cover_img);

                                            if ($coverLen > 0){

                                                echo "<div class='carousel-item active cover_img'>";
                                                echo "<img src=" . base_url("uploads/lessons/cover/". $latest_lessons_cover_img[0]['coverPhoto']) .">";
                                                echo "</div>";

                                                for($i=1; $i<$coverLen; $i++){
                                                    echo "<div class='carousel-item cover_img'>";
                                                    echo "<img src=" . base_url("uploads/lessons/cover/". $latest_lessons_cover_img[$i]['coverPhoto']) .">";
                                                    echo "</div>";
                                                }
                                            }
                                        ?>
                                      </div>
                                      
                                      <!-- Left and right controls -->
                                      <a class="carousel-control-prev" href="#lessons_cover" data-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                      </a>
                                      <a class="carousel-control-next" href="#lessons_cover" data-slide="next">
                                        <span class="carousel-control-next-icon"></span>
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

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        
                        <div class="row">
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <h5>Economics And Agricultural Marketing</h5>
                            </div> 
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <h5>Economics And Agricultural Marketing</h5>
                            </div>  
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <h5>Economics And Agricultural Marketing</h5>
                            </div>  
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <h5>Economics And Agricultural Marketing</h5>
                            </div>  
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <h5>Economics And Agricultural Marketing</h5>
                            </div>  
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <h5>Economics And Agricultural Marketing</h5>
                            </div>  
                              
                        </div>

                    </div>
                </div>
            </div>
            	
        </div>
    </div>

    <!-- <div class="overlay"></div> -->
