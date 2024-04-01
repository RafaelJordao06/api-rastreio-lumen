<?php

namespace App\Http\Controllers\TrackControllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\TrackServices\TrackService;

class TrackController extends BaseController
{
    protected $trackService;

    // Injetar TrackService no construtor do controller
    public function __construct(TrackService $trackService)
    {
        $this->trackService = $trackService;
    }

    public function buscarEncomenda($trackingCode)
    {
        // Chamar o método rastrearEncomenda do serviço injetado
        $dadosDaEncomenda = $this->trackService->rastrearEncomenda($trackingCode);

        // Retornar os dados em formato JSON
        return response()->json([
            'success' => true,
            'data' => $dadosDaEncomenda,
        ]);
    }   
}
