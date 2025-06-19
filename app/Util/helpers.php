<?php

use Illuminate\Support\Carbon;

  if (!function_exists('school_years')) {
    function school_years($pastYears = 1, $range = 5)
    {
      $current_year = date('Y');
      $years        = [];
      for ($i = -$pastYears; $i <= -$pastYears + $range; $i++) {
          $years[] = ($current_year + $i) . '/' . ($current_year + $i + 1);
      }

      return $years;
    }
  }

  if (!function_exists('closed_day_types')) {
    function closed_day_types()
    {
      return [
        'general_holiday' => 'Jours fériés',
        'school_holiday' => 'Vacances scolaires',
        'special_day'    => 'Journée(s) spéciale',
      ];
    }
  }

  if (!function_exists('throw_error')) {
    function throw_error($message)
    {
      throw \Illuminate\Validation\ValidationException::withMessages(['general_error_msg' => $message]);
    }
  }

  if(!function_exists('fotmat_date')){
    function format_date($date){
      return Carbon::parse($date)->format('Y-m-d');
    }
  }

  if (!function_exists('weekdays')) {
    function weekdays()
    {        
      return [
          'monday'    => 'lundi',
          'tuesday'   => 'mardi',
          'wednesday' => 'mercredi',
          'thursday'  => 'jeudi',
          'friday'    => 'vendredi'
      ];
    }
  }

  if (!function_exists('yearth')) {
    function yearth(int $number): string {
      return match($number) {
          1 => '1ère année',
          2 => '2ème année',
          3 => '3ème année',
          4 => '4ème année',
          5 => '5ème année',
          default => $number . 'ème'
      };
    }
  }
?>