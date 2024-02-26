<?php
/*
Template Name: Главная
*/

$h1 = get_field('t') ?: get_the_title();


get_header(); ?>


<?php $el = get_field('top'); //все поля
if ($el) { ?>


                        <script>
                            let dataElems = []; //пустой массив для эл. видео
                        </script>
                        <?php foreach ($el as $n => $it) {
                            $n++ ?>

                            <div class="swiper-slide slide_image">
                                <div class="hero-slide" data-hero-slide="0">
                                    <div class="hero-slide__info" data-reveal-after-preloader="txt">
                                        <div class="hero-slide__description description--o400"><?= $it['d'] ?></div>
                                        <div class="hero-slide__button">
                                            <?php
                                            if ($it['link']) {
                                                $m_link = $it['link'];
                                                $link_url = $m_link ['url']; ?>
                                                <a href="<?php echo esc_url( $link_url ); ?>" class="button ">

                                                    <span class="button__name"><?= $it['btntxt'] ?: __("Докладніше") ?></span>
                                                    <span class="button__icon">
                                                      <img src="<?= $dir ?>img/svg/icon-button-white.svg" inline-svg alt="">
                                                    </span>
                                                </a>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    <!--                  <picture class="hero-slide__image" >-->
                                    <div class="slide_image-image">
                                        <?php  if ($it['video_photo'] == "photo") { ?>
                                            <img src="<?= $it['foto_product'] ?>" alt="">
                                            <div class="slide_image_mob"><img src="<?= $it['foto_product_mob'] ?>" alt=""></div>
                                        <?php }else{ ?>
                                            <div class="embed-container " >
                                                <?php
                                                if(wp_is_mobile()) {
                                                    $iframe =  $it['video_mob'];
                                                }else {
                                                    $iframe =  $it['video_pr'];
                                                }

                                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $iframe, $video_data); ?>
                                                <div class="youtube-player" id="player<?php echo $n ?>" data-id="<?php echo $video_data[1]; ?>" data-player-id="<?php echo $n ?>"></div>
                                                <script>
                                                    dataElems.push({elemId :'player<?php echo $n ?>', videoId : '<?php echo $video_data[1]; ?>'} )
                                                </script>

                                            </div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <script>
                var tag = document.createElement('script');

                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);


                function onYouTubePlayerAPIReady() {
                    dataElems.forEach(function(elem, index) {
                        var playerName = dataElems[index].elemId;

                        playerName = new YT.Player(dataElems[index].elemId, {
                            videoId: dataElems[index].videoId,
                            suggestedQuality: 'default',
                            // modestbranding: 1,
                            playerVars: {
                                'controls':2,
                                'showinfo': 0,
                                'autoplay': 1,
                                'color': 'white',
                                'rel': 0,
                                'enablejsapi': 1,
                                'ecver': 2,
                                'probably_logged_in' : 0,
                                'modestbranding': 1,
                                'iv_load_policy': 1,
                            },
                            events: {
                                'onReady': onPlayerReady,
                                'onStateChange': onPlayerStateChange,
                            }
                        });
                        playerName.setVolume(10)

                    })

                }
                function onPlayerReady(event) {
                    event.target.playVideo();
                    event.target.setVolume(10);

                }
                var done = false;
                function onPlayerStateChange(event) {
                    if(event.data === 1) {
                        heroColorSlider.autoplay.stop()
                        heroSlider.autoplay.stop()
                        heroTitleSlider.autoplay.stop()
                    }

                    let playerId = event.target.g.dataset.playerId;
                    let targetBtns = document.querySelectorAll(".mx-slider .hero__list .hero__list-item")
                    targetBtns.forEach(function(elem, ind) {
                        elem.addEventListener("click", function(e) {
                            let target = e.target

                            let targetId = +(target.parentElement.dataset.heroButton) + 1
                            if(+playerId !== targetId) {
                                event.target.pauseVideo();
                            }
                        })
                    })
                }

            </script>


<?php } ?>
