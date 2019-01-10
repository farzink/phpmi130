<?php
require_once './model/ModelFactory.php';
require_once './model/ItemModel.php';


class ItemRepository
{
    private $data;
public function __construct($data)
    {
        $this->data = $data;
    }
    public function getAll()
    {
        $items = array();
        $query = "SELECT * FROM items";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            array_push($items, ModelFactory::rawToItemModel($row));
            }            
        }
        return $items;
    }
    public function getById($id)
    {
        $query = "SELECT * FROM items where id = {$id}";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {            
            return ModelFactory::rawToItemModel($result->fetch_assoc());
        } else {
            return null;
        }
    }
}