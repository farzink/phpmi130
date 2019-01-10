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
        //$query = "SELECT * FROM orders where profileId = {$id}";        
        $query = "select o.id, i.id as itemId, i.price, i.title, i.imageAddress from mi130.items as i join mi130.orders as o 
        on i.id = o.itemId where o.profileId = {$id}";        
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
    public function remove(OrderModel $model)
    {
        try {
            
            $query = "DELETE FROM orders
            where itemId = {$model->itemId}
            and profileID = {$model->profileId} 
            limit 1";         
            
            return $this->data->executeQuery($query);                        
        } catch (Exception $ex) {
            return null;
        }
    }
    public function getLastId(){
        return $this->data->executeCustomCommand("SELECT LAST_INSERT_ID()");
    }
    public function orderCountByProfileId($profileId, $itemId) {
        try {
            
            $query = "SELECT count(id) as count FROM mi130.orders
            where profileId = {$profileId}
        and itemId = {$itemId}"; 
            
            return (int)($this->data->executeQuery($query)->fetch_assoc()["count"]);
        } catch (Exception $ex) {
            return 0;
        }
    }

    public function getGroupedOrderByProfileId($profileId){
        try {
            $orders = array();            
            $query = "SELECT count(orders.id) as count, orders.itemId FROM orders as orders
            where profileId = {$profileId}
            Group By orders.itemId"; 
            $result = $this->data->executeQuery($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($orders, ModelFactory::rawToOrderValidationModel($row));
                }
            }
            return $orders;
        } catch (Exception $ex) {
            return 0;
        }
    }

    public function confirm($profileId){
        try {
            
            $query = "SELECT sum(price) as price, count(id) as count FROM orders
            where profileId = {$profileId}"; 
            
            $result = $this->data->executeQuery($query);
            $price =0;
            $count=0;

            if ($result->num_rows > 0) {
                 $row =  $result->fetch_assoc();                 
                 $price = $row["price"];
                 $count = $row["count"];                
            
            $query = "INSERT INTO orderhistories (profileId, total, items)
            values ({$profileId},
            {$count},
            {$price})";
            
            $result = $this->data->executeQuery($query);                        

            $query = "delete from orders where profileId ={$profileId}";
            $result = $this->data->executeQuery($query);                        
            return $result;
            }
            else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    

    public function getHistory($profileId){
        try {

            $orders = array();
        //$query = "SELECT * FROM orders where profileId = {$id}";        
        $query = "select * from orderhistories";        
        $result = $this->data->executeQuery($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($orders, ModelFactory::rawToHistoryModel($row));
            }
        }
        return $orders;
            
        } catch (Exception $ex) {
            return false;
        }
    }
}
