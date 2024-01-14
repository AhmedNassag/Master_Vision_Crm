<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContactExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    public $contacts;
    public function __construct($contacts){
        $this->contacts = $contacts;
    }
    public function collection()
    {
        // Replace this with the code to retrieve your contacts
        $contacts = $this->contacts;

        // Map the data to the desired format
        return $contacts->map(function ($contact) {
            return [
                'Employee' => $contact->employee->name ?? null,
                'Gender' => $contact->gender,
                'Customer ID' => $contact->customer_id ?? null,
                'Name' => $contact->name,
                'Mobile' => $contact->mobile,
                'Activity' => $contact->activity->name ?? '',
                'Interest' => $contact->sub_activity->name ?? '',
                'National ID' => $contact->national_id,
                'Birth Date' => $contact->birth_date,
                'Another mobile' => $contact->mobile2,
                'Email' => $contact->email,
                'Company Name' => $contact->company_name,
                'Job Title' => $contact->jobTitle->name ?? '',
                'Contact Category' => $contact->contactCategory->name ?? '',
                'Contact Source ID' => $contact->contactSource->name,
                'City' => $contact->city->name ?? '',
                'Area' => $contact->area->name ?? '',
                'Industry' => $contact->industry->name ?? '',
                'Major' => $contact->major->name ?? '',
            ];
        });
    }

    public function headings(): array
    {
        // Define the column headers
        return [
            trans('admin.Employee'),
            trans('admin.Gender'),
            trans('admin.Customer ID'),
            trans('admin.Name'),
            trans('admin.Mobile'),
            trans('admin.Activity'),
            trans('admin.Interest'),
            trans('admin.National ID'),
            trans('admin.Birth Date'),
            trans('admin.Another mobile'),
            trans('admin.Email'),
            trans('admin.Company Name'),
            trans('admin.Job Title'),
            trans('admin.Contact Category'),
            trans('admin.Contact Source ID'),
            trans('admin.City'),
            trans('admin.Area'),
            trans('admin.Industry'),
            trans('admin.Major'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => '000000'], 'size' => 14],
                'fill' => ['color' => ['rgb' => 'FFFF00']],
                'alignment' => ['horizontal' => 'center'],
                'borders' => ['allBorders' => ['style' => 'thin', 'color' => ['rgb' => '000000']]],
            ],
            2 => [
                'fill' => ['color' => ['rgb' => 'FFCC99']], // Background color for rows other than the header
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => 'General',
            'B' => 'General',
            'C' => 'General',
            'D' => 'General',
            'E' => 'General',
            'F' => 'General',
            'G' => 'General',
            'H' => 'General',
            'I' => 'General',
            'J' => 'General',
            'K' => 'General',
            'L' => 'General',
            'M' => 'General',
            'N' => 'General',
            'O' => 'General',
            'P' => 'General',
        ];
    }
}
