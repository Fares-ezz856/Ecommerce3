<?php
namespace App\Interface;
interface ProductInterface{
    public function create(array $data);
    public function getcategory($slug);
}
