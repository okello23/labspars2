<?php

namespace App\Services;

use App\Models\Hivdr\DrRun;
use App\Models\Hivdr\DrAccessionIdCounter;
use App\Models\Microbiology\MicrobiologyAccessionIdCounter;
use Illuminate\Support\Str;

class GeneratorService
{
  public static function password($length = 2)
  {
    $numbers = '0123456789';
    $symbols = '!@#$%^&*()';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomNumber = '';
    $randomSymbol = '';
    $randomUppercase = '';
    $randomLowercase = '';
    for ($i = 0; $i < $length; $i++) {
      $randomNumber .= $numbers[rand(0, strlen($numbers) - 1)];
      $randomSymbol .= $symbols[rand(0, strlen($symbols) - 1)];
      $randomUppercase .= $uppercase[rand(0, strlen($uppercase) - 1)];
      $randomLowercase .= $lowercase[rand(0, strlen($lowercase) - 1)];
    }

    return str_shuffle($randomNumber.$randomSymbol.$randomUppercase.$randomLowercase);
  }

  //Generate microbiology accession numbers
  public static function MicrobiologyAcessionNumberGenerator()
  {
    $last_id = MicrobiologyAccessionIdCounter::orderBy('id', 'DESC')->limit(1)->get(['id']);
    $id = sizeof($last_id) == 0 ? 1 : $last_id[0]->id+1;
    $accession_number =
    (strlen($id) < 4 ) ? ((strlen($id) == 3) ? '0'.$id : ((strlen($id) == 2) ? '00'.$id : '000'.$id)) : ((strlen($id) == 4) ? $id :$id);

    return 'NGRL-'.date('ym-W/').$accession_number;
  }

  //Generate HIVDR accession numbers
  public static function HivDrAcessionNumberGenerator()
  {
    $last_id = DrAccessionIdCounter::orderBy('id', 'DESC')->limit(1)->get(['id']);
    $id = sizeof($last_id) == 0 ? 1 : $last_id[0]->id+1;
    $accession_number =
    (strlen($id) < 4 ) ? ((strlen($id) == 3) ? '0'.$id : ((strlen($id) == 2) ? '00'.$id : '000'.$id)) : ((strlen($id) == 4) ? $id :$id);

    return 'HIVDR-'.$accession_number;
  }

  //Generate DR Extraction worksheet Run Number
  public static function runNumber()
  {
    $reference = '';
    $yearStart = date('y');
    $latestReference = DrRun::select('id')->orderBy('id', 'desc')->first();

    if ($latestReference) {
      $referenceNumberSplit = explode('-', $latestReference->reference_number);
      $referenceYear = (int) filter_var($referenceNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

      if ($referenceYear == $yearStart) {
        $reference = $referenceNumberSplit[0].'-'.str_pad(((int) filter_var($referenceNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).'TR';
      } else {
        $reference = '#NIMS'.$yearStart.'-001TR';
      }
    } else {
      $reference = '#NIMS'.$yearStart.'-001TR';
    }

    return $reference;
  }
}
