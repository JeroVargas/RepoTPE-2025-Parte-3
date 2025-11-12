<?php

class CategoriasModel
{

    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=pisostpe;charset=utf8', 'root', '');
    }

    public function getAllCategorias($sort = null, $order = null)
    {
        $sql = "SELECT * FROM categorias";

        if (isset($sort)) {
            $allowedColumns = ['id', 'nombre'];
            if (in_array($sort, $allowedColumns)) {
                $sql .= ' ORDER BY ' . $sort;
                if (isset($order)) {
                    $allowedOrders = ['ASC', 'DESC'];
                    $order = strtoupper($order);
                    if (in_array($order, $allowedOrders)) {
                        $sql .= ' ' . $order;
                    }
                }
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias;
    }

    public function getCategoria($id)
    {
        $query = $this->db->prepare('SELECT * FROM categorias WHERE id=?');
        $query->execute([$id]);
        $categorias = $query->fetch(PDO::FETCH_OBJ);
        return $categorias;
    }

    public function insertCategoria($nombre)
    {
        $query = $this->db->prepare('INSERT INTO categorias(nombre) VALUES(?)');
        $query->execute([$nombre]);
        return $this->db->lastInsertId();
    }

    public function editCategoriaById($id, $nombre)
    {
        $query = $this->db->prepare('UPDATE categorias SET nombre = ? WHERE id = ?');
        $query->execute([$nombre, $id]);
        $actualizado = $query->fetch(PDO::FETCH_OBJ);
        return $actualizado;
    }

    public function deleteCategoriaById($id)
    {
        $query = $this->db->prepare('DELETE FROM categorias WHERE id = ?');
        $query->execute([$id]);
    }
}
