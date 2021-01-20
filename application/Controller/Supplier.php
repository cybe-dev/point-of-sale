<?php
namespace Controller;

use Model\Supplier as SupplierModel;

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
}
