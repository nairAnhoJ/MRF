<?php

namespace App\Http\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsServices{

    public $client, $service, $documentID, $range;

    public function __construct(){
        $this->client = $this->getClient();
        $this->service = new Sheets($this->client);
        $this->documentId = '1ZekhV3d7vOjnE575bvB4XpVSGlaHyTAJ9BETvnLRsXQ';
        $this->range = 'A:Z';
    }

    public function getClient(){
        $client = new Client();
        $client->setApplicationName('MRF');
        $client->setRedirectUri('http://localhost:8000/googlesheets');
        $client->setScopes(Sheets::SPREADSHEETS);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');

        return $client;
    }

    public function readSheet(){
        $doc = $this->service->spreadsheets_values->get($this->documentId, $this->range);

        return $doc;
    }

    public function writeSheet($values){

        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'RAW'
        ];
        //executing the request
        $result = $this->service->spreadsheets_values->update($this->documentId, 'A4:Z4', $body, $params);
    }

    public function appendSheet($values){

        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];
        //executing the request
        $result = $this->service->spreadsheets_values->append($this->documentId, $this->range, $body, $params);
    }
}