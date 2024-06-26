<?php

namespace Classes;

class Paginacion
{
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;
    public $feedId;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0, $feedId = null)
    {
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
        $this->pagina_actual = (int) $pagina_actual;
        $this->feedId = $feedId;
    }
    public function offset()
    {
        return $this->registros_por_pagina * ($this->pagina_actual - 1);
    }

    public function total_paginas()
    {
        return (int) ceil($this->total_registros / $this->registros_por_pagina);
    }

    public function pagina_anterior()
    {
        return ($this->pagina_actual - 1) > 0 ? $this->pagina_actual - 1 : false;
    }

    public function pagina_siguiente()
    {
        return ($this->pagina_actual + 1) <= $this->total_paginas() ? $this->pagina_actual + 1 : false;
    }

    public function enlace_anterior()
    {
        $html = '';
        if ($this->pagina_anterior()){
            if (!empty($this->feedId)) {
            $html .= "<a class='paginacion__enlace paginacion__enlace--texto' href='?page={$this->pagina_anterior()}&feedId={$this->feedId}'>&laquo; Anterior</a>";
        }else{
            $html .= "<a class='paginacion__enlace paginacion__enlace--texto' href='?page={$this->pagina_anterior()}'>&laquo; Anterior</a>";
        }
        return $html;
    }
}

    public function enlace_siguiente()
    {
        $html = '';
        if ($this->pagina_siguiente()) {
            if(!empty($this->feedId)) {
            $html .= "<a class='paginacion__enlace paginacion__enlace--texto' href='?page={$this->pagina_siguiente()}&feedId={$this->feedId}'>Siguiente &raquo;</a>";
        }else{
            $html .= "<a class='paginacion__enlace paginacion__enlace--texto' href='?page={$this->pagina_siguiente()}'>Siguiente &raquo;</a>";
        }
        return $html;
    }
}

    public function numeros_paginas()
    {
        $html = '';

        for ($i = 1; $i <= $this->total_paginas(); $i++) {
            if ($i === $this->pagina_actual) {
                $html .= "<span class='paginacion__enlace paginacion__enlace--actual' >$i</span>";
            } else if (!empty($this->feedId)) {
                $html .= "<a class='paginacion__enlace paginacion__enlace--numero ' href='?page=$i&feedId={$this->feedId}'>$i</a>";
            } else {
                $html .= "<a class='paginacion__enlace paginacion__enlace--numero ' href='?page=$i'>$i</a>";
            }
        }
        return $html;
    }

    public function paginacion()
    {
        $html = '';

        if ($this->total_registros > $this->registros_por_pagina) {
            $html .= "<div class='paginacion'>";
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();
            $html .= "</div>";
        }
        return $html;
    }
}
