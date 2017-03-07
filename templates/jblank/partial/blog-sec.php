<section class="blog-sec <?=$class?>">

    <div class="container container_blog-sec" data-category-id="<?=$category_id?>">

        <h2 class="title title_blog-sec">
            <span class="sub-title__top"><?=$title_top?></span> <?=$title?><span class="point">.</span>
        </h2>

        <div class="news__box">
            <?php
            $listElements = $tpl -> getMaterialsOfCategory($category_id);
            if (is_array($listElements))
                if (count($listElements)) {
                    foreach ($listElements as $element) {
                        $images = json_decode($element->images);
                        $currentImage = "";
                        if (is_object($images)) $currentImage = $images -> image_intro ? "/".$images -> image_intro : "";
                        $dateCreated = $element -> created;
                        $dateCreated = $dateCreated ? array_shift(explode(" ", $dateCreated)) : "";
                        ?>
                        <article class="news">
                            <div class="news__image">
                                <a href="<?= $tpl->getUrlPage($element->id) ?>">
                                    <?if($currentImage):?>
                                        <img class="images__item" src="<?=$currentImage?>"
                                             alt="CHI Nourish Intense system"/>
                                    <?endif?>
                                </a>
                            </div>
                            <div class="news__text">
                                <a href="<?= $tpl->getUrlPage($element->id) ?>">
                                    <h3 class="news__title"><?=$element -> title?>
                                        <time pubdate datetime="<?=$dateCreated?>"><?=$dateCreated?></time>
                                    </h3>
                                </a>
                                <div id="news__item1" class="news__item dot-ellipsis dot-height-80">
                                    <p><?=$element -> introtext?></p>
                                </div>
                                <a href="<?= $tpl->getUrlPage($element->id) ?>">
                                    <span class="news__details">Читать блог</span>
                                    <span class="news__details_full">Читать полностью</span>
                                    <i class="fi flaticon-long-right-arrow"></i>
                                </a>
                                <div class="socmedia">
                                    <ul class="socmedia__list">
                                        <li class="socmedia__item">
                                            <a href="#" class="item__link">
                                                <i class="fi flaticon-social"></i>
                                            </a>
                                        </li>
                                        <li class="socmedia__item">
                                            <a href="#" class="item__link">
                                                <i class="fi flaticon-instagram-symbol"></i>
                                            </a>
                                        </li>
                                        <li class="socmedia__item">
                                            <a href="#" class="item__link">
                                                <i class="fi flaticon-pinterest"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                        <?
                    }
                }
            ?>
        </div>
        <div class="more"><a href="#">Еще</a></div>
    </div>
</section>