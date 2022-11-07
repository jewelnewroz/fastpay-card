<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait HttpCallerTrait
{
    protected array $header = [
        'Accept' => 'application/json'
    ];

    public function setHeader($key, $value): HttpCallerTrait
    {
        $this->header[$key] = $value;

        return $this;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    protected function makeGetRequest($url, $params = [])
    {
        return Http::timeout(120)->withHeaders($this->getHeader())->get($url, $params);
    }

    protected function makePostRequest($url, $params = [], $attachments = [])
    {
        return Http::timeout(120)->withHeaders($this->getHeader())->post($url, $params);
    }
}
