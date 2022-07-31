<?php

namespace App\Http\Controllers;

use App\Repositories\CurrencyRateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyRateController extends Controller
{
    /**
     * ProjectController constructor.
     *
     * @param CurrencyRateRepository $projectsRepository
     */
    public function __construct(private CurrencyRateRepository $projectsRepository)
    {
        parent::__construct();
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->response
            ->respond(JsonResource::collection($this->projectsRepository->getAllRates()));
    }
}
