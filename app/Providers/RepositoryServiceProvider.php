<?php

namespace App\Providers;

use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use App\Interfaces\DevelopmentRepositoryInterface;
use App\Interfaces\EventParticipantRepositoryInterface;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Interfaces\SosialAssistanceRecipientRepositoryInterface;
use App\Interfaces\SosialAssistanceRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\DevelopmentApplicantRepository;
use App\Repositories\DevelopmentRepository;
use App\Repositories\EventParticipantRepository;
use App\Repositories\EventRepository;
use App\Repositories\FamilyMemberRepository;
use App\Repositories\HeadOfFamilyRepository;
use App\Repositories\SosialAssistanceRecipientRepository;
use App\Repositories\SosialAssistanceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class, 
            UserRepository::class
        );

        $this->app->bind(
            HeadOfFamilyRepositoryInterface::class, 
            HeadOfFamilyRepository::class
        );

        $this->app->bind(
            FamilyMemberRepositoryInterface::class, 
            FamilyMemberRepository::class
        );

        $this->app->bind(
            SosialAssistanceRepositoryInterface::class, 
            SosialAssistanceRepository::class
        );

        $this->app->bind(
            SosialAssistanceRecipientRepositoryInterface::class, 
            SosialAssistanceRecipientRepository::class
        );

        $this->app->bind(
            EventRepositoryInterface::class, 
            EventRepository::class
        );

        $this->app->bind(
            EventParticipantRepositoryInterface::class,
            EventParticipantRepository::class,
        );

        $this->app->bind(
            DevelopmentRepositoryInterface::class,
            DevelopmentRepository::class
        );

        $this->app->bind(
            DevelopmentApplicantRepositoryInterface::class,
            DevelopmentApplicantRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
