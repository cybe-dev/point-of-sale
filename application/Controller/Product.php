<?php
namespace Controller;

use Model\Product as ProductModel;
use Model\ProductQuery;

class Product
{
    public function insert($param)
    {
        header("Content-Type: application/json");
        $input = $param["getter"];

        $product = new ProductModel;
        $product->setName($input("name"));
        $product->setPrice($input("price"));
        $product->setStock(0);
        $product->save();

        echo json_encode([
            "id" => $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "stock" => $product->getStock(),
        ]);
    }
    public function update($param)
    {
        header("Content-Type: application/json");
        $input = $param["getter"];
        $id = $param["id"];

        $product = ProductQuery::create()->findOneById($id);
        $product->setName($input("name"));
        $product->setPrice($input("price"));
        $product->save();

        echo json_encode([
            "id" => $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "stock" => $product->getStock(),
        ]);
    }
    public function delete($param)
    {
        header("Content-Type: application/json");
        $id = $param["id"];

        $product = ProductQuery::create()->findOneById($id);

        echo json_encode([
            "id" => $product->getId(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "stock" => $product->getStock(),
        ]);

        $product->delete();
    }
}
