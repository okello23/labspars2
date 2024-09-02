<?php

namespace App\Exports;

use \App\Models\Microbiology\MicrobiologySample;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class ExportMicrobiologySamples implements FromCollection, WithHeadings, WithMapping
{
  public $exportIds;
  /**
  * @return \Illuminate\Support\Collection
  */
  public function __construct(array $exportData)
  {
    $this->exportIds = $exportData;
  }
  public function collection()
  {
    return MicrobiologySample::with('accessionedSamples')
    ->whereIn('id', $this->exportIds)->get();
  }
  public function map($sample): array
  {
    return [
      $sample->source,
      $sample->patient_name,
      $sample->age,
      $sample->sex,
      $sample->sample_type,
      $sample->sample_id,
      $sample->organism ,
      $sample->sample_collection_date,
      $sample->ref_lab_name,
      $sample->ref_reason,
      $sample->accessionedSamples?->accession_number
    ];
  }

  public function headings(): array
  {
    return [
      'Sample Origin',
      'Patient Name',
      'Age',
      'Sex',
      'Sample Type',
      'Sample ID',
      'Organism',
      'Sample Collection Date',
      'Referring Lab',
      'Referral Reason',
      'Accession Number'
      ];
    }

  }
