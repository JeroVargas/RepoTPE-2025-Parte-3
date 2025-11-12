<?php
require_once 'app/model/pisos.model.php';
class PisosController
{
    private $model;

    public function __construct()
    {
        $this->model = new PisosModel();
    }

    function getAll($req, $res)
    {
        $pisos = $this->model->getPisos();
        if($pisos){
            return $res->json($pisos, 200);
        }else{
            return $res->json(["message" => "No se econtraron los Pisos"],404);
        }
        
    }

    function get($req, $res)
    {
        $piso = $this->model->getPiso($req->params->id);
        if($piso){
        return $res->json($piso, 200);
        }else{
            return $res->json(["message" => "No se econtro el Piso"],404);
        }
    }

    function create($req, $res,)
    {
        $data = $req->body;
        if (isset($data->id_categoria, $data->tipo_variante, $data->origen, $data->acabados_comunes, $data->uso_recomendado)) {
            $piso = $this->model->insertPiso($data->id_categoria, $data->tipo_variante, $data->origen, $data->acabados_comunes, $data->uso_recomendado);
            return $res->json($piso, 200);
        } else {
            return $res->json(["message" => "Faltan datos obligatorios. Asegúrese de enviar id_categoria, tipo_variante, origen, acabados_comunes y uso_recomendado."], 400);
        }
    }

    function delete($req,$res){
        $piso = $this->model->getPiso($req->params->id);
        if($piso){
            $this->model->deletePisoById($piso->id);
            return $res->json($piso,200);
        }else{
            return $res->json(["message"=> "No se encontro el piso"],404);
        }
    }

    function update($req,$res){
        $piso =$this->model->getPiso($req->params->id);
        if($piso){
            $data = $req->body;
            if(isset($data->id_categoria, $data->tipo_variante, $data->origen, $data->acabados_comunes, $data->uso_recomendado)){
                $pisoAc = $this->model->editPisoById($piso->id,$data->id_categoria, $data->tipo_variante, $data->origen, $data->acabados_comunes, $data->uso_recomendado);
                return $res->json(["message" => "El piso con id ".$piso->id." se actualizo correctamente"],200);
            }else{
                return $res->json(["message" => "Faltan datos"],400);
            }
        }else{
            return $res->json(["message" => "No se encontro el Piso"] , 404);
        }

    }


    
    

}
