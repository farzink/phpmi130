<?php
require_once './model/ModelFactory.php';
require_once './model/OrderModel.php';

class OrderRepository
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function getAll()
    {
        $orders = array();
        $query = "SELECT * FROM orders";
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($orders, ModelFactory::rawToOrderModel($row));
            }
        }
        return $orders;
    }
    public function getOrderByProfileId($id)
    {
        $orders = array();
        $query = "SELECT * FROM orders where profileId = {$id}";        
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($orders, ModelFactory::rawToOrderModel($row));
            }
        }
        return $orders;
    }
    public function add(OrderModel $model)
    {
        try {
            $query = "INSERT INTO orders (profileId, itemId, price) VALUES ({$model->profileId}, {$model->itemId}, {$model->price})";            
            return $this->data->executeQuery($query);                        
        } catch (Exception $ex) {
            return null;
        }
    }
    public function getLastId(){
        return $this->data->executeCustomCommand("SELECT LAST_INSERT_ID()");
    }
}
