<?php
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
?>