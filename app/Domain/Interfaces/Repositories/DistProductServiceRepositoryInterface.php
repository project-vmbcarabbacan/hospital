<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\BrandEntity;
use App\Domain\Entities\DistributorEntity;
use App\Domain\Entities\ProductEntity;
use App\Domain\Entities\ServiceEntity;
use App\Domain\ValueObjects\IdObj;

interface DistProductServiceRepositoryInterface
{

    public function getDistributorById(IdObj $id);
    public function getAllDistributors();
    public function addDistributor(DistributorEntity $data);
    public function updateDistributor(IdObj $id, DistributorEntity $data);
    public function getBrandById(IdObj $id);
    public function getAllBrands();
    public function addBrand(BrandEntity $data);
    public function updateBrand(IdObj $id, BrandEntity $data);

    public function getProductById(IdObj $id);
    public function getProductByDistributor(IdObj $distributor_id);
    public function getProductByBrand(IdObj $brand_id);
    public function getProductByDistributorAndBrand(IdObj $distributor_id, IdObj $brand_id);
    public function addProduct(ProductEntity $data);
    public function updateProduct(IdObj $id, ProductEntity $data);
    public function getServiceById(IdObj $id);
    public function addService(ServiceEntity $data);
    public function updateService(IdObj $id, ServiceEntity $data);
}
