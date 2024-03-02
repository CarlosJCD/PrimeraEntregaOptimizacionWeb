
<a href="/feeds">Agregar Feeds</a>

<div>
    <h1>Feed</h1>
    <ul>
    <?php if ($news != null) { ?>
        <?php foreach ($news as $new){ ?>
            <li>
            <a href = "<?= $new->newsUrl?>"><h2><?= $new->newsTitle ?></h2></a>
                <p><?= $new->newsDescription ?></p>
                <p><?= $new->newsDate ?></p>
                <?php if ($new->newsImageUrl != null && $new->newsImageUrl != "no hay imagen disponible"){ ?>
                <img src="<?= $new->newsImageUrl ?>" alt="" width = 200>
                <?php } ?>
                
            </li>
        <?php
        } ?>
    <?php }else{
        echo "No hay noticias";
    } ?>
</div>