<?php
class HttpClient {
    public function getJson(string $url, int $timeout): array {
        $curl = curl_init($url);
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => min(3, $timeout),
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
            CURLOPT_USERAGENT => 'IronForgeGym/3.0 (course project)',
        ];
        $caFile = getenv('CURL_CA_BUNDLE') ?: getenv('SSL_CERT_FILE');
        if ($caFile) { $options[CURLOPT_CAINFO] = $caFile; }
        curl_setopt_array($curl, $options);
        try {
            $body = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
            if ($body === false || $status !== 200) {
                throw new RuntimeException('Weather HTTP request failed (status ' . $status . ', curl ' . curl_errno($curl) . ').');
            }
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($data)) { throw new RuntimeException('Weather response is not a JSON object.'); }
            return $data;
        } finally { curl_close($curl); }
    }
}
