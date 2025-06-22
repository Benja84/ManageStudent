<?php

namespace App\Providers;

use App\Models\CloseDay;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\QueryException;

class CarbonServiceProvider extends ServiceProvider
{

    protected static $generalHolidays = [];

    protected static $schoolHoliDays = [];
    protected static $specialDays = [];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadExtensions();
    }

    protected function loadExtensions()
    {
        try {
            if (Schema::hasTable('close_days')) {
                if (empty(self::$generalHolidays)) {
                    self::$generalHolidays = app(CloseDay::class)->where('type', 'general_holiday')->pluck('date')->toArray();
                }
                if (empty(self::$schoolHoliDays)) {
                    self::$schoolHoliDays = app(CloseDay::class)->where('type', 'school_holiday')->pluck('date')->toArray();
                }
                if (empty(self::$specialDays)) {
                    self::$specialDays = app(CloseDay::class)->where('type', 'special_day')->pluck('date')->toArray();
                }
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            Log::error($e->getSql());
            Log::error($e->getTraceAsString());
        }
        $generalHolidays = self::$generalHolidays;
        $schoolHoliDays = self::$schoolHoliDays;
        $specialDays    = self::$specialDays;

        Carbon::macro('isGeneralHoliday', function ($date) use ($generalHolidays) {
            return in_array($date->format('Y-m-d'), $generalHolidays);
        });

        Carbon::macro('getGeneralHolidays', function () use ($generalHolidays) {
            foreach ($generalHolidays as $key => $generalHoliday) {
                try {
                    $generalHolidays[$key] = Carbon::createFromFormat('d/m/Y', $generalHoliday)->format('Y-m-d');
                } catch (\Exception $e) {
                    $generalHolidays[$key] = Carbon::parse($generalHoliday)->format('Y-m-d');
                }
            }

            return $generalHolidays;
        });

        Carbon::macro('isSchoolHoliday', function ($date) use ($schoolHoliDays) {
            return in_array($date->format('Y-m-d'), $schoolHoliDays);
        });

        Carbon::macro('getSchoolHolidays', function () use ($schoolHoliDays) {
            foreach ($schoolHoliDays as $key => $schoolHoliDay) {
                try {
                    $schoolHoliDays[$key] = Carbon::createFromFormat('d/m/Y', $schoolHoliDay)->format('Y-m-d');
                } catch (\Exception $e) {
                    $schoolHoliDays[$key] = Carbon::parse($schoolHoliDay)->format('Y-m-d');
                }
            }

            return $schoolHoliDays;
        });

        Carbon::macro('isSpecialDay', function ($date) use ($specialDays) {
            return in_array($date->format('Y-m-d'), $specialDays);
        });

        Carbon::macro('getSpecialDays', function () use ($specialDays) {
            foreach ($specialDays as $key => $specialDay) {
                try {
                    $specialDays[$key] = Carbon::createFromFormat('d/m/Y', $specialDay)->format('Y-m-d');
                } catch (\Exception $e) {
                    $specialDays[$key] = Carbon::parse($specialDay)->format('Y-m-d');
                }
            }

            return $specialDays;
        });
    }
}
