<?php

namespace App\Exports;

use \App\Models\Hivdr\DrugResistantSamples;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Facades\Excel;

class ExportHivDrSamples implements FromCollection, WithHeadings, WithMapping
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
    return DrugResistantSamples::with('accessionedSamples')
    ->whereIn('id', $this->exportIds)->get();
  }
  public function map($sample): array
  {
    return [
      $sample->formNumber,
      $sample->facilityName,
      $sample->district?->name,
      $sample->facilityHub->name,
      $sample->facilityHub?->region?->name,
      $sample->patientArtNumber,
      $sample->dateCollected,
      $sample->testDate,
      $sample->created_at,
      $sample->accessionedSamples?->locator_id,
      // $sample->rtSubType,
      // $sample->genesAnalysed,
      // $sample->drTestDate,
      // $sample->amplified === 'false' ? 'Failed amplification' : 'Amplified',
      // $sample->isReleased === 'Pending realease' ? : 'Released',
      // $sample->releaseDate
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
      'Lab / Accession ID',
      // 'Sub Type',
      // 'Genes Analyzed',
      // 'DR Test Date',
      // 'Amplification Status',
      // 'Status',
      // 'DR Result Release Date',
      ];
    }

  }
