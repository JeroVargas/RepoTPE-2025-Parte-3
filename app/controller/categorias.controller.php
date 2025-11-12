<?php
require_once 'app/model/categorias.model.php';
class CategoriasController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoriasModel();
    }

    function getAll($req, $res)
    {
        $sort = isset($req->query->sort) ? $req->query->sort : null;
        $order = isset($req->query->order) ? $req->query->order : null;

        $categorias = $this->model->getAllCategorias($sort, $order);
        if ($categorias) {
            return $res->json($categorias, 200);
        } else {
            return $res->json([], 200); // Devuelve 200 OK con un array vacío para colecciones sin resultados
        }
    }

    function get($req, $res)
    {
        $categoria = $this->model->getCategoria($req->params->id);
        if ($categoria) {
            return $res->json($categoria, 200);
        } else {
            return $res->json(["message" => "No se econtro la Categoria"], 404);
        }
    }

    function create($req, $res,)
    {
        $data = $req->body;
        if (isset($data->nombre)) {
            $categoria = $this->model->insertCategoria($data->nombre);
            return $res->json(["message" => "Se agrego el piso " . $categoria . " a la lista"], 201); // 201 Created
        } else {
            return $res->json(["message" => "Faltan datos obligatorios. Asegúrese de enviar el Nombre"], 400);
        }
    }

    function delete($req, $res)
    {
        $categoria = $this->model->getCategoria($req->params->id);
        if ($categoria) {
            $this->model->deleteCategoriaById($categoria->id);
            return $res->json(["message" => "Se elimino la categoria de id " . $categoria], 200);
        } else {
            return $res->json(["message" => "No se encontro la Categoria"], 404);
        }
    }

    function update($req, $res)
    {
        $categoria = $this->model->getCategoria($req->params->id);
        if ($categoria) {
            $data = $req->body;
            if (isset($data->nombre)) {
                $categoriaAc = $this->model->editCategoriaById($categoria->id, $data->nombre);
                return $res->json(["message" => "La categoria con id " . $categoria->id . " se actualizo correctamente"], 200);
            } else {
                return $res->json(["message" => "Faltan datos"], 400);
            }
        } else {
            return $res->json(["message" => "No se encontro La categoria"], 404);
        }
    }
}
