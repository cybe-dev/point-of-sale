<?php
namespace Controller;

use Model\Supplier as SupplierModel;
use Model\SupplierQuery;

class Supplier
{
    public function insert($param)
    {
        header("Content-Type: application/json");
        $input = $param["getter"];

        $supplier = new SupplierModel;
        $supplier->setName($input("name"));
        $supplier->setAddress($input("address"));
        $supplier->setPhone($input("phone"));
        $supplier->save();

        echo json_encode([
            "id" => $supplier->getId(),
            "name" => $supplier->getName(),
            "address" => $supplier->getAddress(),
            "phone" => $supplier->getPhone(),
        ]);
    }
    public function update($param)
    {
        header("Content-Type: application/json");
        $input = $param["getter"];
        $id = $param["id"];

        $supplier = SupplierQuery::create()->findOneById($id);
        $supplier->setName($input("name"));
        $supplier->setAddress($input("address"));
        $supplier->setPhone($input("phone"));
        $supplier->save();

        echo json_encode([
            "id" => $supplier->getId(),
            "name" => $supplier->getName(),
            "address" => $supplier->getAddress(),
            "phone" => $supplier->getPhone(),
        ]);
    }

    public function delete($param)
    {
        header("Content-Type: application/json");
        $id = $param["id"];

        $supplier = SupplierQuery::create()->findOneById($id);

        echo json_encode([
            "id" => $supplier->getId(),
            "name" => $supplier->getName(),
            "address" => $supplier->getAddress(),
            "phone" => $supplier->getPhone(),
        ]);

        $supplier->delete();
    }
}
