<?php declare(strict_types=1);

namespace TestApi\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use TestApi\Domain\Actor\Repository\Database\ActorRepository;
use TestApi\Domain\Address\Repository\Database\AddressRepository;
use TestApi\Domain\Category\Repository\Database\CategoryRepository;
use TestApi\Domain\City\Repository\Database\CityRepository;
use TestApi\Domain\Country\Repository\Database\CountryRepository;
use TestApi\Domain\Customer\Repository\Database\CustomerRepository;
use TestApi\Domain\Film\Repository\Database\FilmRepository;
use TestApi\Domain\Inventory\Repository\Database\InventoryRepository;
use TestApi\Domain\Language\Repository\Database\LanguageRepository;
use TestApi\Domain\Payment\Repository\Database\PaymentRepository;
use TestApi\Domain\Rental\Repository\Database\RentalRepository;
use TestApi\Domain\Staff\Repository\Database\StaffRepository;
use TestApi\Domain\Store\Repository\Database\StoreRepository;
use TestApi\Entity\FactoryInterface;
use TestApi\Entity\IlluminateFactoryAdapter;
use TestApi\Repository\Database\ConnectionInterface;
use TestApi\Repository\Database\Illuminate\Connection;
use TestApi\Repository\Database\Table\NameResolver;
use TestApi\Repository\Database\Table\SimpleNameResolver;
use TestApi\Validators\ActorValidator;
use TestApi\Validators\AddressValidator;
use TestApi\Validators\CategoryValidator;
use TestApi\Validators\CityValidator;
use TestApi\Validators\CountryValidator;
use TestApi\Validators\CustomerValidator;
use TestApi\Validators\FilmValidator;
use TestApi\Validators\InventoryValidator;
use TestApi\Validators\LanguageValidator;
use TestApi\Validators\PaymentValidator;
use TestApi\Validators\RentalValidator;
use TestApi\Validators\StaffValidator;
use TestApi\Validators\StoreValidator;

class TestApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NameResolver::class, SimpleNameResolver::class);
        $this->app->bind(FactoryInterface::class, IlluminateFactoryAdapter::class);
        $this->app->singleton(Manager::class, function () {
            return new Manager();
        });

        $this->registerDatabaseConnection();
        $this->registerRepositories();
        $this->registerValidators();
    }

    /**
     * @return void
     */
    private function registerRepositories()
    {
        $this->app->bind(\TestApi\Domain\Actor\Repository\ActorRepository::class, ActorRepository::class);
        $this->app->bind(\TestApi\Domain\Category\Repository\CategoryRepository::class, CategoryRepository::class);
        $this->app->bind(\TestApi\Domain\Country\Repository\CountryRepository::class, CountryRepository::class);
        $this->app->bind(\TestApi\Domain\Language\Repository\LanguageRepository::class, LanguageRepository::class);
        $this->app->bind(\TestApi\Domain\City\Repository\CityRepository::class, CityRepository::class);
        $this->app->bind(\TestApi\Domain\Address\Repository\AddressRepository::class, AddressRepository::class);
        $this->app->bind(\TestApi\Domain\Store\Repository\StoreRepository::class, StoreRepository::class);
        $this->app->bind(\TestApi\Domain\Staff\Repository\StaffRepository::class, StaffRepository::class);
        $this->app->bind(\TestApi\Domain\Customer\Repository\CustomerRepository::class, CustomerRepository::class);
        $this->app->bind(\TestApi\Domain\Film\Repository\FilmRepository::class, FilmRepository::class);
        $this->app->bind(\TestApi\Domain\Inventory\Repository\InventoryRepository::class, InventoryRepository::class);
        $this->app->bind(\TestApi\Domain\Rental\Repository\RentalRepository::class, RentalRepository::class);
        $this->app->bind(\TestApi\Domain\Payment\Repository\PaymentRepository::class, PaymentRepository::class);
    }

    /**
     * @return void
     */
    private function registerDatabaseConnection()
    {
        $this->app->singleton(ConnectionInterface::class, Connection::class);
    }

    /**
     * @return void
     */
    private function registerValidators()
    {
        $this->app->bind(\TestApi\Domain\Actor\Validator\ActorValidator::class, ActorValidator::class);
        $this->app->bind(\TestApi\Domain\Category\Validator\CategoryValidator::class, CategoryValidator::class);
        $this->app->bind(\TestApi\Domain\Country\Validator\CountryValidator::class, CountryValidator::class);
        $this->app->bind(\TestApi\Domain\Language\Validator\LanguageValidator::class, LanguageValidator::class);
        $this->app->bind(\TestApi\Domain\City\Validator\CityValidator::class, CityValidator::class);
        $this->app->bind(\TestApi\Domain\Address\Validator\AddressValidator::class, AddressValidator::class);
        $this->app->bind(\TestApi\Domain\Store\Validator\StoreValidator::class, StoreValidator::class);
        $this->app->bind(\TestApi\Domain\Staff\Validator\StaffValidator::class, StaffValidator::class);
        $this->app->bind(\TestApi\Domain\Customer\Validator\CustomerValidator::class, CustomerValidator::class);
        $this->app->bind(\TestApi\Domain\Film\Validator\FilmValidator::class, FilmValidator::class);
        $this->app->bind(\TestApi\Domain\Inventory\Validator\InventoryValidator::class, InventoryValidator::class);
        $this->app->bind(\TestApi\Domain\Rental\Validator\RentalValidator::class, RentalValidator::class);
        $this->app->bind(\TestApi\Domain\Payment\Validator\PaymentValidator::class, PaymentValidator::class);
    }
}
