<?php
require_once 'app/model/pisos.model.php';
class PisosController
{
    private $model;

    public function __construct()
    {
        $this->model = new PisosModel();
    }

    function getPisos($req, $res)
    {
        $pisos = $this->model->getPisos();
        return $res->json($pisos, 200);
    }

    function addPiso($req,$res,){
        $data = $req->body;
        if(isset($data->id_categoria,$data->tipo_variante,$data->origen,$data->acabados_comunes,$data->uso_recomendado)){
            $piso = $this->model->insertPiso($data->id_categoria,$data->tipo_variante,$data->origen,$data->acabados_comunes,$data->uso_recomendado);
             return $res->json($piso , 200);
        }
    }

    /*public function create($req, $res) {
        $data = $req->body;
        if (isset($data->nombre_ingrediente, $data->descripcion)) {
            $id = $this->model->addIngrediente($data->nombre_ingrediente, $data->descripcion);
            http_response_code(201);
            echo json_encode(["message" => "Ingrediente creado", "id_ingrediente" => $id]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Faltan datos obligatorios"]);
        }
    }*/

}
