<?php declare(strict_types=1);

namespace TestApi\Providers;

use Illuminate\Support\ServiceProvider;
use TestApi\Command\Bus\CommandBus;
use TestApi\Command\IlluminateCommandBusAdapter;
use TestApi\Domain\Actor\Commands\AddActorCommand;
use TestApi\Domain\Actor\Commands\Handlers\ActorHandler;
use TestApi\Domain\Actor\Commands\UpdateActorCommand;
use TestApi\Domain\Address\Commands\AddAddressCommand;
use TestApi\Domain\Address\Commands\Handlers\AddressHandler;
use TestApi\Domain\Address\Commands\UpdateAddressCommand;
use TestApi\Domain\Category\Commands\AddCategoryCommand;
use TestApi\Domain\Category\Commands\Handlers\CategoryHandler;
use TestApi\Domain\Category\Commands\UpdateCategoryCommand;
use TestApi\Domain\City\Commands\AddCityCommand;
use TestApi\Domain\City\Commands\Handlers\CityHandler;
use TestApi\Domain\City\Commands\UpdateCityCommand;
use TestApi\Domain\Country\Commands\AddCountryCommand;
use TestApi\Domain\Country\Commands\Handlers\CountryHandler;
use TestApi\Domain\Country\Commands\UpdateCountryCommand;
use TestApi\Domain\Customer\Commands\AddCustomerCommand;
use TestApi\Domain\Customer\Commands\Handlers\CustomerHandler;
use TestApi\Domain\Customer\Commands\UpdateCustomerCommand;
use TestApi\Domain\Film\Commands\AddFilmCommand;
use TestApi\Domain\Film\Commands\Handlers\FilmHandler;
use TestApi\Domain\Film\Commands\UpdateFilmCommand;
use TestApi\Domain\Inventory\Commands\AddInventoryCommand;
use TestApi\Domain\Inventory\Commands\Handlers\InventoryHandler;
use TestApi\Domain\Inventory\Commands\UpdateInventoryCommand;
use TestApi\Domain\Language\Commands\AddLanguageCommand;
use TestApi\Domain\Language\Commands\Handlers\LanguageHandler;
use TestApi\Domain\Language\Commands\UpdateLanguageCommand;
use TestApi\Domain\Payment\Commands\AddPaymentCommand;
use TestApi\Domain\Payment\Commands\Handlers\PaymentHandler;
use TestApi\Domain\Payment\Commands\UpdatePaymentCommand;
use TestApi\Domain\Rental\Commands\AddRentalCommand;
use TestApi\Domain\Rental\Commands\Handlers\RentalHandler;
use TestApi\Domain\Rental\Commands\UpdateRentalCommand;
use TestApi\Domain\Staff\Commands\AddStaffCommand;
use TestApi\Domain\Staff\Commands\Handlers\StaffHandler;
use TestApi\Domain\Staff\Commands\UpdateStaffCommand;
use TestApi\Domain\Store\Commands\AddStoreCommand;
use TestApi\Domain\Store\Commands\Handlers\StoreHandler;
use TestApi\Domain\Store\Commands\UpdateStoreCommand;

class CommandBusProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $commandHandlersMap = [
        AddActorCommand::class        => ActorHandler::class,
        UpdateActorCommand::class     => ActorHandler::class,
        AddCategoryCommand::class     => CategoryHandler::class,
        UpdateCategoryCommand::class  => CategoryHandler::class,
        AddCountryCommand::class      => CountryHandler::class,
        UpdateCountryCommand::class   => CountryHandler::class,
        AddLanguageCommand::class     => LanguageHandler::class,
        UpdateLanguageCommand::class  => LanguageHandler::class,
        AddCityCommand::class         => CityHandler::class,
        UpdateCityCommand::class      => CityHandler::class,
        AddAddressCommand::class      => AddressHandler::class,
        UpdateAddressCommand::class   => AddressHandler::class,
        AddStoreCommand::class        => StoreHandler::class,
        UpdateStoreCommand::class     => StoreHandler::class,
        AddStaffCommand::class        => StaffHandler::class,
        UpdateStaffCommand::class     => StaffHandler::class,
        AddCustomerCommand::class     => CustomerHandler::class,
        UpdateCustomerCommand::class  => CustomerHandler::class,
        AddFilmCommand::class         => FilmHandler::class,
        UpdateFilmCommand::class      => FilmHandler::class,
        AddInventoryCommand::class    => InventoryHandler::class,
        UpdateInventoryCommand::class => InventoryHandler::class,
        AddRentalCommand::class       => RentalHandler::class,
        UpdateRentalCommand::class    => RentalHandler::class,
        AddPaymentCommand::class      => PaymentHandler::class,
        UpdatePaymentCommand::class   => PaymentHandler::class,
    ];

    public function boot()
    {
        $this->app->make(CommandBus::class)->map($this->commandHandlersMap);
    }

    public function register()
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBusAdapter::class);
    }
}
