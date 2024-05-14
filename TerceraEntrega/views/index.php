<div class="contenido__titulo">

    <h1 class="contenido__titulo-texto"><?= isset($selectedFeed) ? $selectedFeed->feedName : "Noticias" ?></h1>

    <div class="contenido__titulo-iconobuscar" id="botonBusqueda">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
    </div>

</div>

<h5 class="contenido__subtitulo">FILTROS POR NOTICIA</h5>

<form class="contenido__filtros" method="GET">

    <div class="contenido__filtros-contenedor">
        <label for="ordenar-por" class="contenido__filtros-label">Ordenar por:</label>

        <select id="ordenar-por" class="contenido__filtros-select" name="ordenarPor">
            <option value="">(Seleccionar)</option>
            <option <?= $ordenarPor === "newsTitle" ? "selected" : "" ?> value="newsTitle">Titulo</option>
            <option <?= $ordenarPor === "newsDescription" ? "selected" : "" ?> value="newsDescription">Descripción</option>
            <option <?= $ordenarPor === "newsDate" ? "selected" : "" ?>  value="newsDate">Fecha</option>
        </select>
    </div>
    
    <div class="contenido__filtros-contenedor">
        <label for="orden" class="contenido__filtros-label" >Orden:</label>

        <select id="orden" class="contenido__filtros-select" name="orden">
        <option <?= $orden === "ASC" ? "selected" : "" ?> value="ASC">Ascendente</option>
        <option <?= $orden === "DESC" ? "selected" : "" ?> value="DESC">Descendente</option>
        </select>
    </div>
    
    <?php if(!empty($feedId) && !empty($categorias)):?>
    <div class="contenido__filtros-contenedor">
        <label for="categoria" class="contenido__filtros-label">Categoría:</label>

        <select id="categoria" class="contenido__filtros-select" name="categoriaId" >
            <option value="">Todas</option>
            <?php foreach ($categorias as $categoria):?>
            <option <?= (isset($categoriaId) && $categoriaId == $categoria->id) ? "selected" : "" ?> value="<?= $categoria->id ?>"><?= $categoria->categoryName ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="hidden" name="feedId" value="<?= $feedId ?>">
    <?php endif ?>
    <input type="submit" class="contenido__filtros-aceptar" value="Aplicar">
</form>

<?php 

foreach ($news as $noticia): ?>
  <div class="noticias">
    <div class="noticias__imagen">
        <img src="<?= $noticia["newsImageUrl"] ?>" alt="Imagen Noticia <?= $noticia["newsTitle"] ?>">
    </div>

    <div class="noticias__contenido">
        <a href="<?= $noticia["newsUrl"] ?>" target="_blank"><p class="noticias__titulo"><?= $noticia["newsTitle"] ?></p></a>

        <div class="noticias__info">
            <p class="noticias__feed"><a href="<?= $noticia["feedUrl"] ?>" target="_blank"><?= $noticia["feedName"] ?></a></p>
            <p class="noticias__info-texto">•</p>
            <p class="noticias__info-texto"><?= $noticia["newsDate"] ?></p>
        </div>

        <p class="noticias__texto">
        <?= strip_tags($noticia["newsDescription"]) ?>
        </p>

        <p class="noticias__categorias">Categorias: <span><?= $noticia["categories"] ?? "---" ?></span></p>
    </div>
</div>
<?php endforeach; ?>


<?= $paginacion ?>
<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>