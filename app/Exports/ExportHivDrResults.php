<?php

namespace App\Exports;

use App\Models\Hivdr\DrResults;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class ExportHivDrResults implements FromCollection, WithHeadings, WithMapping
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
    return DrResults::with('accessionedSamples')->with('drSamples')
    ->whereIn('id', $this->exportIds)->get();
  }
  public function map($results): array
  {
    return [
      $results->drSamples?->formNumber,
      $results->drSamples?->facilityName,
      $results->drSamples?->district?->name,
      $results->drSamples?->facilityHub->name,
      $results->drSamples?->facilityHub?->region?->name,
      $results->drSamples?->patientArtNumber,
      $results->drSamples?->dateCollected,
      $results->drSamples?->testDate,
      $results->drSamples?->created_at,
      $results->accessionedSamples?->locator_id,
      $results->rtSubType,
      $results->genesAnalysed,
      $results->drTestDate,
      $results->amplified === 'false' ? 'Failed amplification' : 'Amplified',
      $results->isReleased === 'Pending realease' ? : 'Released',
      $results->releaseDate
    ];
  }

  public function headings(): array
  {
    return [
      'Form #',
      'Facility Name',
      'District',
      'Hub',
      'Region',
      'Patient Art #',
      'Sample Collection Date',
      'VL Test Date',
      'DR Referral Date',
      'Lab ID',
      'Sub Type',
      'Genes Analyzed',
      'DR Test Date',
      'Amplification Status',
      'Status',
      'DR Result Release Date',
      ];
    }

  }
