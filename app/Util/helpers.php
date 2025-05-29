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
?>