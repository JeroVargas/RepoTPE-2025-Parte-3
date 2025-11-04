<?php

class PisosController
{
    private $model;

    public function __construct()
    {
        $this->model = new PisosModel();
    }

    function get($req, $res)
    {
        $pisos = $this->model->getPisos();
        return $res->json($pisos, 200);
    }
}
