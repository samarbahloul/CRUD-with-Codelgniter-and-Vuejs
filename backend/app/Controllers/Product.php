<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $model = new ProductModel();
        $data = $model->findAll();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Empty Data');
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new ProductModel();
        $data = $model->find(['id' => $id]);
        if (!$data) return $this->failNotFound('Empty Data');
        return $this->respond($data[0]);
    }



    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $json = $this->request->getJSON();
        $data = [
            'title' => $json->title,
            'price' => $json->price
        ];
        $model = new ProductModel();
        $product = $model->insert($data);
        if (!$product) return $this->fail('erreur', 400);
        return $this->respondCreated($product);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $json = $this->request->getJSON();
        $data = [
            'title' => $json->title,
            'price' => $json->price
        ];
        $model = new ProductModel();
        $chekId = $model->find(['id' => $id]);
        if (!$chekId) return $this->fail('id inexistant', 404);
        $product = $model->update($id, $data);
        if (!$product) return $this->fail('erreur', 400);
        return $this->respond($product);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new ProductModel();
        $chekId = $model->find(['id' => $id]);
        if (!$chekId) return $this->fail('id inexistant', 404);
        $product = $model->delete($id);
        if (!$product) return $this->fail('erreur', 400);
        return $this->respondDeleted('Data supprime');
    }
}
