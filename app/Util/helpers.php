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
          'monday'    => 'Lundi',
          'tuesday'   => 'Mardi',
          'wednesday' => 'Mercredi',
          'thursday'  => 'Jeudi',
          'friday'    => 'Vendredi'
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

  if(!function_exists('normaliserChaine')){
    function normaliserChaine($chaine) {
      // Tableau de correspondance des caractères spéciaux
      $caracteresSpeciaux = array(
          'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
          'ç' => 'c',
          'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
          'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
          'ñ' => 'n',
          'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
          'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
          'ý' => 'y', 'ÿ' => 'y',
          'œ' => 'oe', 'æ' => 'ae',
          // Majuscules
          'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
          'Ç' => 'C',
          'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
          'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
          'Ñ' => 'N',
          'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
          'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
          'Ý' => 'Y',
          'Œ' => 'OE', 'Æ' => 'AE'
      );
      
      // Remplacer les caractères spéciaux
      $chaine = strtr($chaine, $caracteresSpeciaux);
      
      // Supprimer les espaces et autres caractères non désirés
      $chaine = preg_replace('/[^A-Za-z0-9]/', '', $chaine);
      
      return $chaine;
    }
  }
?>