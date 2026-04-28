<?php

class NaperzClient
{
    private string $baseUrl = 'https://croram.naperz.mx/api/croram';
    private string $apiKey = 'cDkGWH6-VFpg8myZAI.0F3ozzx0B_GLZ2qiUB1hq';

    private function request(string $method, string $path, ?array $body = null, array $query = [])
    {
        if (!function_exists('curl_init')) {
            throw new Exception('La extension cURL de PHP no esta habilitada.');
        }

        $query = array_merge(['key' => $this->apiKey], $query);
        $url = $this->baseUrl . $path . '?' . http_build_query($query);

        $curl = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ];

        if ($body !== null) {
            $options[CURLOPT_POSTFIELDS] = json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $curlError = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($response === false) {
            throw new Exception('Error de comunicacion con Naperz: ' . $curlError);
        }

        $decoded = json_decode($response);
        if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Naperz respondio un JSON invalido: ' . substr($response, 0, 300));
        }

        $status = intval($decoded->status ?? $httpCode);
        if ($httpCode >= 400 || ($status >= 400 && $status !== 0)) {
            $message = $decoded->message ?? ('HTTP ' . $httpCode);
            throw new Exception('Naperz: ' . $message);
        }

        return $decoded;
    }

    public function listClients(int $page = 1, int $pageSize = 1000)
    {
        return $this->request('GET', '/clients', null, ['page' => $page, 'pageSize' => $pageSize]);
    }

    public function getClient(int $clientId)
    {
        return $this->request('GET', '/clients/' . $clientId);
    }

    public function listProducts(int $page = 1, int $pageSize = 1000)
    {
        return $this->request('GET', '/products', null, ['page' => $page, 'pageSize' => $pageSize]);
    }

    public function getProduct(int $productId)
    {
        return $this->request('GET', '/products/' . $productId);
    }

    public function listUsers(int $page = 1, int $pageSize = 1000)
    {
        return $this->request('GET', '/users', null, ['page' => $page, 'pageSize' => $pageSize]);
    }

    public function getUser(int $userId)
    {
        return $this->request('GET', '/users/' . $userId);
    }

    public function createSale(array $payload)
    {
        return $this->request('POST', '/sale', $payload);
    }

    public function updateSale(int $saleId, array $payload)
    {
        return $this->request('PATCH', '/sale/' . $saleId, $payload);
    }

    public function cancelSale(int $saleId)
    {
        return $this->request('PATCH', '/sale/cancel/' . $saleId);
    }

    public function createPayment(array $payload)
    {
        return $this->request('POST', '/payments', $payload);
    }

    public function cancelPayment(int $paymentId)
    {
        return $this->request('PATCH', '/payments/cancel/' . $paymentId);
    }
}
