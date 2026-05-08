<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OdooService
{
    protected $url;
    protected $db;
    protected $user;
    protected $apiKey;

    public function __construct()
    {
        $this->url = env('ODOO_URL') . '/jsonrpc';
        $this->db = env('ODOO_DB');
        $this->user = env('ODOO_USER');
        $this->apiKey = env('ODOO_API_KEY');
    }

    /**
     * Obtiene el UID de autenticación. Lo guarda en caché por 24 horas para no saturar Odoo.
     */
    public function authenticate()
    {
        return Cache::remember('odoo_uid', 86400, function () {
            $response = Http::post($this->url, [
                'jsonrpc' => '2.0',
                'method' => 'call',
                'params' => [
                    'service' => 'common',
                    'method' => 'authenticate',
                    'args' => [
                        $this->db,
                        $this->user,
                        $this->apiKey,
                        []
                    ]
                ],
                'id' => 1
            ]);

            $result = $response->json('result');

            if (!$result) {
                throw new \Exception('Error de autenticación con Odoo. Revisa tus credenciales.');
            }

            return $result; // Retornará el 2 que vimos en Postman
        });
    }

    /**
     * Método genérico para ejecutar acciones en Odoo
     */
    public function executeKw($model, $method, $args = [], $kwargs = [])
    {
        $uid = $this->authenticate();

        $response = Http::post($this->url, [
            'jsonrpc' => '2.0',
            'method' => 'call',
            'params' => [
                'service' => 'object',
                'method' => 'execute_kw',
                'args' => [
                    $this->db,
                    $uid,
                    $this->apiKey,
                    $model,
                    $method,
                    $args,
                    $kwargs
                ]
            ],
            'id' => random_int(10, 1000)
        ]);

        $data = $response->json();

        // 🚨 AQUÍ ATRAPAMOS EL ERROR SILENCIOSO DE ODOO 🚨
        if (isset($data['error'])) {
            // Odoo suele mandar el motivo exacto en error -> data -> message
            $mensajeOdoo = $data['error']['data']['message'] ?? json_encode($data['error']);
            throw new \Exception('Rechazo del ERP: ' . $mensajeOdoo);
        }

        return $data['result'] ?? null;
    }
}