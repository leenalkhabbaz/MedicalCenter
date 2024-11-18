<?php

namespace App\Providers;

use App\Repositories\AssistantRepository;
use App\Repositories\HomeRepositry;
use App\Repositories\Interfaces\AssistantRepositoryInterface;
use App\Repositories\Interfaces\HomeRepositryInterface;
use App\Repositories\Interfaces\MedicineRepositoryInterface;
use App\Repositories\Interfaces\NotificationSettingRepositoryInterface;
use App\Repositories\Interfaces\PatientConditionRepositryInterface;
use App\Repositories\Interfaces\ReelRepositoryInterface;
use App\Repositories\Interfaces\UserAuthRepositoryInterface;
use App\Repositories\MedicineRepository;
use App\Repositories\NotificationSettingRepository;
use App\Repositories\PatientConditionRepository;
use App\Repositories\ReelRepository;
use App\Repositories\UserAuthRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserAuthRepositoryInterface::class, UserAuthRepository::class);
        $this->app->bind(AssistantRepositoryInterface::class, AssistantRepository::class);
        $this->app->bind(PatientConditionRepositryInterface::class, PatientConditionRepository::class);
        $this->app->bind(MedicineRepositoryInterface::class, MedicineRepository::class);
        $this->app->bind(ReelRepositoryInterface::class, ReelRepository::class);
        $this->app->bind(HomeRepositryInterface::class, HomeRepositry::class);
        $this->app->bind(NotificationSettingRepositoryInterface::class, NotificationSettingRepository::class);


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
