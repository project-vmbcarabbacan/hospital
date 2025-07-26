<?php

use App\Domain\Entities\BrandEntity;
use App\Domain\Entities\DistributorEntity;
use App\Domain\Entities\ProductEntity;
use App\Domain\ValueObjects\IdObj;
use App\Models\Brand;
use App\Models\Distributor;
use App\Models\Product;
use App\Infrastructure\Repositories\DistProductServiceRepository;
use App\Application\Utils\ExceptionConstants;
use App\Domain\ValueObjects\PriceObj;
use App\Domain\ValueObjects\SkuObj;
use App\Domain\ValueObjects\StockObj;
use App\Models\Service;

beforeEach(function () {
    $this->repository = app(DistProductServiceRepository::class);
});

it('it retrieves all the distributors', function () {
    Distributor::factory()->count(5)->create();
    $distributor = $this->repository->getAllDistributors();

    expect($distributor)->toHaveCount(5);
    expect($distributor->first())->toBeInstanceOf(Distributor::class);
});

it('find distributor by id', function () {
    $distributor = Distributor::factory()->create([
        'name' => 'Legacy'
    ]);

    $result = $this->repository->getDistributorById(new IdObj($distributor->id));

    expect($result)->toBeInstanceOf(Distributor::class)
        ->and($result->name)->toBe('Legacy');
});

it('distributor id is not present from the query', function () {
    Distributor::factory()->create();

    $result = $this->repository->getDistributorById(new IdObj(999));

    expect($result)->toBeEmpty();
});


it('successfully adds a new distributor', function () {

    $data = new DistributorEntity(
        'Legacy',
        '566368879',
        'v.c@gmail.com',
        '566368879',
        'Deubai, Dubai',
        'default.png',
    );

    $department = $this->repository->addDistributor($data);

    expect($department)->toBeInstanceOf(Distributor::class)
        ->and($department->name)->toBe('Legacy')
        ->and($department->contact)->toBe('566368879');
});


it('throws exception when distributor already exists', function () {
    Distributor::create([
        'name' => 'Legacy',
        'contact' => '566368879'
    ]);


    $data = new DistributorEntity(
        'Legacy',
        '123456789',
        null,
        null,
        null,
        null,
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DISTRIBUTOR_EXIST);

    $this->repository->addDistributor($data);
});


it('successfully update the distributor', function () {

    $data = new DistributorEntity(
        name: 'Legacy',
        contact: '566368879',
        email: 'v.c@gmail.com',
        phone: '566368879',
        address: 'Deubai, Dubai',
        photo: 'default.png',
    );

    $department = $this->repository->addDistributor($data);

    $updated = new DistributorEntity(
        name: 'V Developer',
        contact: '123456789'
    );
    $update = $this->repository->updateDistributor(new IdObj($department->id), $updated);

    expect($update)->toBeInstanceOf(Distributor::class)
        ->and($update->name)->toBe('V Developer')
        ->and($update->contact)->toBe('123456789');
});


it('throws exception when updating non-existent distributor', function () {

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DISTRIBUTOR_NOT_FOUND);

    $data = new DistributorEntity(
        name: 'Ghost',
        contact: '1234123',
    );

    $this->repository->updateDistributor(new IdObj(9999), $data);
});

it('it retrieves all the brands', function () {
    Brand::factory()->count(5)->create();
    $brand = $this->repository->getAllBrands();

    expect($brand)->toHaveCount(5);
    expect($brand->first())->toBeInstanceOf(Brand::class);
});

it('find brand by id', function () {
    $brand = Brand::factory()->create([
        'name' => 'Legacy'
    ]);

    $result = $this->repository->getBrandById(new IdObj($brand->id));

    expect($result)->toBeInstanceOf(Brand::class)
        ->and($result->name)->toBe('Legacy');
});

it('brand id is not present from the query', function () {
    Brand::factory()->create();

    $result = $this->repository->getBrandById(new IdObj(999));

    expect($result)->toBeEmpty();
});


it('successfully adds a new brand', function () {

    $data = new BrandEntity(
        name: 'Legacy',
        photo: 'default.png',
    );

    $brand = $this->repository->addBrand($data);

    expect($brand)->toBeInstanceOf(Brand::class)
        ->and($brand->name)->toBe('Legacy');
});


it('throws exception when brand already exists', function () {
    Brand::create([
        'name' => 'Legacy',
    ]);


    $data = new BrandEntity(
        name: 'Legacy'
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::BRAND_EXIST);

    $this->repository->addBrand($data);
});


it('successfully update the brand', function () {

    $data = new BrandEntity(
        name: 'Legacy',
        photo: 'default.png',
    );

    $brand = $this->repository->addBrand($data);

    $update = $this->repository->updateBrand(new IdObj($brand->id), new BrandEntity(name: 'Uniliver'));

    expect($update)->toBeInstanceOf(Brand::class)
        ->and($update->name)->toBe('Uniliver');
});


it('throws exception when updating non-existent brand', function () {

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::BRAND_NOT_FOUND);

    $this->repository->updateBrand(new IdObj(9999), new BrandEntity(name: 'Ghost'));
});

it('find product by id', function () {
    $distributor = Distributor::factory()->create();
    $brand = Brand::factory()->create();

    $product = Product::factory()->create([
        'distributor_id' => $distributor->id,
        'brand_id' => $brand->id,
        'name' => 'Citirizine'
    ]);

    $result = $this->repository->getProductById(new IdObj($product->id));

    expect($result)->toBeInstanceOf(Product::class)
        ->and($result->name)->toBe('Citirizine');
});

it('find product by distributor id', function () {
    $distributor = Distributor::factory()->create();
    $brand = Brand::factory()->create();

    Product::factory()->create([
        'distributor_id' => $distributor->id,
        'brand_id' => $brand->id,
        'name' => 'Citirizine'
    ]);

    $result = $this->repository->getProductByDistributor(new IdObj($distributor->id));

    expect($result->first())->toBeInstanceOf(Product::class)
        ->and($result->first()->name)->toBe('Citirizine');
});

it('find product by brand id', function () {
    $distributor = Distributor::factory()->create();
    $brand = Brand::factory()->create();

    Product::factory()->create([
        'distributor_id' => $distributor->id,
        'brand_id' => $brand->id,
        'name' => 'Citirizine'
    ]);

    $result = $this->repository->getProductByBrand(new IdObj($brand->id));

    expect($result->first())->toBeInstanceOf(Product::class)
        ->and($result->first()->name)->toBe('Citirizine');
});

it('find product by distributor id and brand id', function () {
    $distributor = Distributor::factory()->create();
    $brand = Brand::factory()->create();

    Product::factory()->create([
        'distributor_id' => $distributor->id,
        'brand_id' => $brand->id,
        'name' => 'Citirizine'
    ]);

    $result = $this->repository->getProductByDistributorAndBrand(new IdObj($distributor->id), new IdObj($brand->id));

    expect($result->first())->toBeInstanceOf(Product::class)
        ->and($result->first()->name)->toBe('Citirizine');
});

it('successfully adds new product', function () {
    $distributor = Distributor::factory()->create();
    $brand = Brand::factory()->create();

    $data = new ProductEntity(
        new IdObj($distributor->id),
        new IdObj($brand->id),
        new SkuObj('ABC-123'),
        'Citirizine',
        new PriceObj(125.25),
        new StockObj(100),
        true,
        null
    );

    $result = $this->repository->addProduct($data);

    expect($result)->toBeInstanceOf(Product::class)
        ->and($result->name)->toBe('Citirizine');
});

it('throw exception when adding a non-existent distributor', function () {
    $distributor = Distributor::factory()->create();
    $brand = Brand::factory()->create();

    $data = new ProductEntity(
        new IdObj(150),
        new IdObj($brand->id),
        new SkuObj('ABC-123'),
        'Citirizine',
        new PriceObj(125.25),
        new StockObj(100),
        true,
        null
    );

    $this->expectException(Exception::class);
    $this->expectExceptionMessage(ExceptionConstants::DISTRIBUTOR_NOT_FOUND);

    $this->repository->addProduct($data);
});


it('find service by id', function () {

    $service = Service::factory()->create([
        "name" => "Therapy"
    ]);

    $result = $this->repository->getServiceById(new IdObj($service->id));

    expect($result->first())->toBeInstanceOf(Service::class)
        ->and($result->first()->name)->toBe('Therapy');
});
