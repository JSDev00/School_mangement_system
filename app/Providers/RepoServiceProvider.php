<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repository\TeacherRepositoryInterface','App\Repository\TeacherRepository');
        $this->app->bind('App\Repository\StudentsRepositoryInterface','App\Repository\StudentsRepository');
        $this->app->bind('App\Repository\StudentsRepositoryPromotionsInterface','App\Repository\StudentsRepositoryPromotions');
        $this->app->bind('App\Repository\StudentGraduatedRepositoryInterface','App\Repository\StudentGraduatedRepository');
        $this->app->bind('App\Repository\FeesRepositoryInterface','App\Repository\FeesRepository');
        $this->app->bind('App\Repository\FeeInvoicesRepositoryInterface','App\Repository\FeeInvoicesRepository');
        $this->app->bind('App\Repository\ReceiptStudentsRepositoryInterface','App\Repository\ReceiptStudentsRepository');
        $this->app->bind('App\Repository\ProcessingFeesRepositoryInterface','App\Repository\ProcessingFeesRepository');
        $this->app->bind('App\Repository\PaymentRepositoryInterface','App\Repository\PaymentRepository');
        $this->app->bind('App\Repository\AttendanceRepositoryInterface','App\Repository\AttendanceRepository');
        $this->app->bind('App\Repository\ExamRepositoryInterface','App\Repository\ExamRepository');
        $this->app->bind('App\Repository\SubjectRepositoryInterface','App\Repository\SubjectRepository');
        $this->app->bind('App\Repository\QuizzesRepositoryInterface','App\Repository\QuizzesRepository');
        $this->app->bind('App\Repository\LibraryRepositoryInterface','App\Repository\LibraryRepository');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
