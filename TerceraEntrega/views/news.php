<a href="/feeds">Agregar Feeds</a>

<form action="/" method="GET">
    <label for="ordenar">Ordenar Por</label>
    <select name="ordenarPor" id="ordenar">
        <option <?= $ordenarPor === "newsTitle" ? "selected" : "" ?> value="newsTitle">Titulo</option>
        <option <?= $ordenarPor === "newsDescription" ? "selected" : "" ?> value="newsDescription">Descripción</option>
        <option <?= $ordenarPor === "newsDate" ? "selected" : "" ?>  value="newsDate">Fecha</option>
    </select>

    <label for="orden">Tipo ordenamiento</label>
    <select name="orden" id="orden">
        <option <?= $orden === "ASC" ? "selected" : "" ?> value="ASC">Ascendente</option>
        <option <?= $orden === "DESC" ? "selected" : "" ?> value="DESC">Descendente</option>
    </select>

    <label for="feeds">Feed:</label>
    <select name="feedId" id="feeds">
    <option value="" default>Todos</option><?php
        foreach ($feeds as $feed):?>
        <option <?= (isset($feedId) && $feedId === $feed["id"]) ? "selected" : "" ?> value="<?= $feed["id"] ?>"> <?= $feed["feedName"] ?> </option>
        <?php
        endforeach;
        ?>
    </select>
    
    <?php 
    if(isset($feedId) && !empty($feedId)):?>
    <label for="categorias">Categorias</label>
    <select name="categoriaId" id="categorias">
    <option value="">Todas</option>
    <?php foreach ($categorias as $categoria):?>
            <option <?= (isset($categoriaId) && $categoriaId == $categoria->id) ? "selected" : "" ?> value="<?= $categoria->id ?>"><?= $categoria->categoryName ?></option>
        <?php endforeach;
    ?></select>

    <?php endif;
    ?>

    <input type="submit" value="Aplicar">
</form>

<div>
    <h1>Feed</h1>
    <ul>
    <?php if ($news !== null) { ?>
        <?php foreach ($news as $new){ ?>
            <li>
            <a href = "<?= $new["newsUrl"]?>"><h2><?= $new["newsTitle"] ?></h2></a>
                <p><?= $new["newsDescription"] ?></p>
                <p><?= $new["newsDate"] ?></p>
                <p><?= "Feed:" . $new["feedName"]?></p>
                <?php if ($new["newsImageUrl"] != null && $new["newsImageUrl"] != "no hay imagen disponible"){ ?>
                <img src="<?= $new["newsImageUrl"] ?>" alt="" width = 200 loading="lazy">
                <?php } ?>
                
            </li>
        <?php
        } ?>
    <?php }else{
        echo "No hay noticias";
    } ?>
</div>
