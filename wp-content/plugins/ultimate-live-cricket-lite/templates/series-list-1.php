<?php
    function lcw_load_series_list_1( $series_list,$col  ){
      ob_start();
?>
          <div class="lcw-series-container">
            <h3><?php echo apply_filters('wsl_series_text', 'Tournaments & Series')?></h3>
            
            <div class="row new-deal">
              <div class="col-lg-<?php echo $col; ?> col-md-<?php echo $col; ?> deal deal-block">
                  <div class="item-slide">
                      <div class="box-img">
                          <img src="<?php echo plugins_url( 'images/ICC-Cricket-World-Cup-full.png', dirname(__FILE__)) ?>" alt="World Cup 2019"/>
                        <div class="text-wrap">
                            <h4>World Cup 2019</h4>
                        </div>
                      </div>
                      <div class="slide-hover">
                        <div class="text-wrap">
                             <h4>World Cup 2019 <br> <span class="deal-data"></h4>
                            <div class="date-p">
                               <p>
                                <span class="glyphicon glyphicon-calendar"></span> 
                                30 May 2019
                               </p>
                               <p>
                                  <span class="glyphicon glyphicon-calendar"></span> 
                                  14 Jul 2019
                               </p>
                            </div>

                            <div class="book-now-c"> 
                                 <a href="<?php echo home_url('matches/series/2181/status/upcoming' ) ?>">Matches</a>  
                            </div>
                        </div>
                      </div>
                    </div>   
                </div>
                <?php 
                    if(!empty($series_list)){

                        foreach ($series_list as $single_series) {
                          $series_type_array = explode(' ', $single_series->name);
                          $series_type = end( $series_type_array );
                          $allowed_values = array('Tests','ODIs','T20s','T20','Test');

                ?>
                <?php  
                    $old_start_date = date( $single_series->startDateTime );
                    $old_start_date_timestamp = strtotime($old_start_date);
                    $new_start_date = date('d, F Y', $old_start_date_timestamp);

                    $old_end_date = date( $single_series->endDateTime );
                    $old_end_date_timestamp = strtotime($old_end_date);
                    $new_end_date = date('d, F Y', $old_end_date_timestamp);  
                ?>
                  <div class="col-lg-<?php echo $col; ?> col-md-<?php echo $col; ?> deal deal-block">
                      <div class="item-slide">
                            <div class="box-img">
                            <img src="<?php echo $single_series->shieldImageUrl ?>" alt="<?php echo $single_series->name?>"/>
                              <div class="text-wrap">
                              <h4><?php echo $single_series->name?></h4>
                              
                              </div>
                            </div>
                            <div class="slide-hover">
                              <div class="text-wrap">
                             
                              <h4><?php echo $single_series->name?> <br> <span class="deal-data"></h4>
                              <div class="date-p"><p><span class="glyphicon glyphicon-calendar"></span> <?php echo $new_start_date ?></p><p><span class="glyphicon glyphicon-calendar"></span> <?php echo $new_end_date ?></span></p></div>
                                <?php if( in_array( $series_type, $allowed_values ) ) { ?>
                              
                                  <div class="desc">                  
                                    <span>Type</span>
                                    <h3><?php echo $series_type; ?></h3>
                                  </div>
                                <?php } ?>
                                  
                                  <div class="book-now-c"> 
                                        <a href="<?php echo home_url('matches/series/'.$single_series->id.'/status/'.strtolower( $single_series->status ) ) ?>">
                                            Matches
                                        </a>  
                                  </div>
                                </div>
                            </div>
                        </div>   
                    </div> 

                  <?php 
                      } 
                    } 
                  ?>
                  <div class="col-lg-<?php echo $col; ?> col-md-<?php echo $col; ?> deal deal-block">
                      <div class="item-slide">
                            <div class="box-img">
                                <img src="https://www.cricket.com.au/-/media/Logos/Series/2015/Series-Generic-International-new.ashx" alt="Australia A Tour of India - Men's"/>
                              <div class="text-wrap">
                              <h4>Australia A Tour of India - Men's</h4>
                              
                              </div>
                            </div>
                            <div class="slide-hover">
                              <div class="text-wrap">
                             
                              <h4>Australia A Tour of India - Men's <br></h4>
                              <div class="date-p"><p><span class="glyphicon glyphicon-calendar"></span> 29 August 2018</p><p><span class="glyphicon glyphicon-calendar"></span> 11 September 201</p></div>
                                  <div class="book-now-c"> 
                                        <a href="<?php echo home_url('matches/series/2257/status/current' ) ?>">
                                            Matches
                                        </a>  
                                  </div>
                                </div>
                            </div>
                        </div>   
                    </div>

                  <div class="col-lg-<?php echo $col; ?> col-md-<?php echo $col; ?> deal deal-block">
                      <div class="item-slide">
                            <div class="box-img">
                                <img src="https://www.cricket.com.au/-/media/Logos/Series/2015/Series-Generic-International-new.ashx" alt="'A' One-Day Quad-Series"/>
                              <div class="text-wrap">
                              <h4>'A' One-Day Quad-Series</h4>
                              
                              </div>
                            </div>
                            <div class="slide-hover">
                              <div class="text-wrap">
                             
                              <h4>'A' One-Day Quad-Series<br> </h4>
                              <div class="date-p"><p><span class="glyphicon glyphicon-calendar"></span> 19 August 2018</p><p><span class="glyphicon glyphicon-calendar"></span> 27 August 2018</p></div>
                                  <div class="book-now-c"> 
                                        <a href="<?php echo home_url('matches/series/2232/status/completed' ) ?>">
                                            Matches
                                        </a>  
                                  </div>
                                </div>
                            </div>
                        </div>   
                    </div>
              </div>
            </div> 
    <?php 

      $content = ob_get_clean();
      return $content; 
}