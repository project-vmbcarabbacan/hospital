<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\BrandEntity;
use App\Domain\Entities\DistributorEntity;
use App\Domain\Entities\ProductEntity;
use App\Models\Brand;
use App\Models\Distributor;
use App\Models\Product;
use App\Domain\Interfaces\Repositories\DistProductServiceRepositoryInterface;
use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\ServiceEntity;
use App\Domain\ValueObjects\IdObj;
use App\Models\Service;
use Exception;

class DistProductServiceRepository implements DistProductServiceRepositoryInterface
{


    public function addDistributor(DistributorEntity $data)
    {
        try {
            $distributor = $this->getDistributorByName($data->name);

            if ($distributor)
                throw new Exception(ExceptionConstants::DISTRIBUTOR_EXIST);

            return Distributor::create([
                'name' => $data->name,
                'email' => $data->email,
                'contact' => $data->contact,
                'phone' => $data->phone,
                'address' => $data->address,
                'photo' => $data->photo,
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateDistributor(IdObj $id, DistributorEntity $data)
    {
        try {
            $exist = $this->getDistributorByName($data->name, $id);
            if ($exist)
                throw new Exception(ExceptionConstants::DISTRIBUTOR_EXIST);

            $distributor = $this->getDistributorById($id);

            if (!$distributor)
                throw new Exception(ExceptionConstants::DISTRIBUTOR_NOT_FOUND);

            $updates = array_filter([
                'name' => $data->name,
                'email' => $data->email,
                'contact' => $data->contact,
                'phone' => $data->phone,
                'address' => $data->address,
                'photo' => $data->photo,
            ], fn($value) => !is_null($value));

            $distributor->update($updates);

            return $distributor->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function addBrand(BrandEntity $data)
    {
        try {
            $brand = $this->getBrandByName($data->name);

            if ($brand)
                throw new Exception(ExceptionConstants::BRAND_EXIST);

            return BRAND::create([
                'name' => $data->name,
                'photo' => $data->photo,
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateBrand(IdObj $id, BrandEntity $data)
    {
        try {
            $exist = $this->getBrandByName($data->name, $id);
            if ($exist)
                throw new Exception(ExceptionConstants::BRAND_EXIST);

            $brand = $this->getBrandById($id);

            if (!$brand)
                throw new Exception(ExceptionConstants::BRAND_NOT_FOUND);

            $updates = array_filter([
                'name' => $data->name,
                'photo' => $data->photo,
            ], fn($value) => !is_null($value));

            $brand->update($updates);

            return $brand->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getProductById(IdObj $id)
    {
        return Product::find($id->value());
    }

    public function getProductByDistributor(IdObj $distributor_id)
    {
        return Product::where('distributor_id', $distributor_id->value())->get();
    }

    public function getProductByBrand(IdObj $brand_id)
    {
        return Product::where('brand_id', $brand_id)->get();
    }

    public function getProductByDistributorAndBrand(IdObj $distributor_id, IdObj $brand_id)
    {
        return Product::where(['distributor_id' => $distributor_id->value(), 'brand_id' => $brand_id->value()])->get();
    }

    public function addProduct(ProductEntity $data)
    {
        try {
            $distributor = $this->getDistributorById($data->distributor_id);

            if (!$distributor)
                throw new Exception(ExceptionConstants::DISTRIBUTOR_NOT_FOUND);

            $brand = $this->getBrandById($data->brand_id);

            if (!$brand)
                throw new Exception(ExceptionConstants::BRAND_NOT_FOUND);

            return Product::create([
                'distributor_id' => $data->distributor_id->value(),
                'brand_id' => $data->brand_id->value(),
                'sku' => $data->sku->value(),
                'name' => $data->name,
                'price' => $data->price->value(),
                'stocks' => $data->stocks->value(),
                'photo' => $data->photo,
                'status' => $data->status,
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateProduct(IdObj $id, ProductEntity $data)
    {
        try {
            $product = $this->getProductById($id);

            if (!$product)
                throw new Exception(ExceptionConstants::PRODUCT_NOT_FOUND);

            $distributor = $this->getDistributorById($data->distributor_id);

            if (!$distributor)
                throw new Exception(ExceptionConstants::DISTRIBUTOR_NOT_FOUND);

            $brand = $this->getBrandById($data->brand_id);

            if (!$brand)
                throw new Exception(ExceptionConstants::BRAND_NOT_FOUND);

            $updates = array_filter([
                'distributor_id' => $data->distributor_id->value(),
                'brand_id'       => $data->brand_id->value(),
                'sku'            => $data->sku->value(),
                'name'           => $data->name,
                'price'          => $data->price->value(),
                'stocks'         => $data->stocks->value(),
                'photo'          => $data->photo,
                'status'         => $data->status,
            ], fn($value) => !is_null($value));

            $product->update($updates);

            return $product->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function addService(ServiceEntity $data)
    {
        try {
            $service = $this->getServiceByName($data->name);

            if ($service)
                throw new Exception(ExceptionConstants::SERVICE_EXIST);

            return Service::create([
                'sku' => $data->sku,
                'name' => $data->name,
                'price' => $data->price,
                'status' => $data->status,
                'photo' => $data->photo,
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateService(IdObj $id, ServiceEntity $data)
    {
        try {
            $exist = $this->getServiceByName($data->name, $id);
            if ($exist)
                throw new Exception(ExceptionConstants::SERVICE_EXIST);

            $service = $this->getServiceById($id);

            if (!$service)
                throw new Exception(ExceptionConstants::SERVICE_NOT_FOUND);

            $updates = array_filter([
                'sku'            => $data->sku,
                'name'           => $data->name,
                'price'          => $data->price,
                'photo'          => $data->photo,
                'status'         => $data->status,
            ], fn($value) => !is_null($value));

            $service->update($updates);

            return $service->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getDistributorById(IdObj $id)
    {
        return Distributor::find($id->value());
    }

    public function getAllDistributors()
    {
        return Distributor::get();
    }

    public function getBrandById(IdObj $id)
    {
        return Brand::find($id->value());
    }

    public function getAllBrands()
    {
        return Brand::get();
    }

    public function getServiceById(IdObj $id)
    {
        return Service::find($id->value());
    }

    protected function getDistributorByName(string $name, ?IdObj $id = null)
    {
        $distributor = Distributor::where('name', $name);

        if (!is_null($id))
            $distributor = $distributor->where('id', '<>', $id->value());

        return $distributor->first();
    }

    protected function getBrandByName(string $name, ?IdObj $id = null)
    {
        $brand = Brand::where('name', $name);

        if (!is_null($id))
            $brand = $brand->where('id', '<>', $id->value());

        return $brand->first();
    }

    protected function getServiceByName(string $name, ?IdObj $id = null)
    {
        $service = Service::where('name', $name);

        if (!is_null($id))
            $service = $service->where('id', '<>', $id->value());

        return $service->first();
    }
}
