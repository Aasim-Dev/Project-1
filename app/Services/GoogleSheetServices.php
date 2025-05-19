<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;
use Google\Service\Sheets\ValueRange;
use Google_Service_Sheets_ValueRange;

class GoogleSheetServices
{
    private $client;
    private $service;
    private $spreadsheetId;
    private $sheetName = 'Sheet1';

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(config('sheets.google_sheets.credentials_path'));
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS]);

        $this->service = new Google_Service_Sheets($this->client);
    }

    public function getspreadSheet(){
        $this->spreadsheetId = config('sheets.google_sheets.spreadsheet_id');
        return $this->spreadsheetId;
    }

    public function saveDataToSheet(array $data){
        $this->spreadsheetId = config('sheets.google_sheets.spreadsheet_id');
        $sheetName = 'Sheet1';

        $cleanedData = array_map(function ($row) {
            return array_map(fn ($val) => $val === null ? "" : $val, $row);
        }, $data);

        $body = new \Google\Service\Sheets\ValueRange();
        $body->setValues($cleanedData);

        $params = ['valueInputOption' => 'RAW'];

       
        return $this->service->spreadsheets_values->append(
            $this->spreadsheetId,
            $sheetName,
            $body,
            $params
        );
    }
}   