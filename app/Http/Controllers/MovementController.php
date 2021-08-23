<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Services\MovementService;
use Illuminate\Http\JsonResponse;

/**
 * class MovementController
 * @package App\Http\Controllers
 */
class MovementController extends Controller
{
    /**
     * @var MovementService
     */
    private $movementService;

    /**
     * Constructor
     *
     * @param MovementService $movementService
     */
    public function __construct(MovementService $movementService)
    {
        $this->movementService = $movementService;
    }

    /**
     * @param Movement $movement
     * @return JsonResponse
     */
    public function index(Movement $movement): JsonResponse
    {
        $result = [
            'movement' => $movement->name,
            'ranking' => $this->movementService->getMovementRanking($movement)
        ];

        return response()->json($result);
    }
}
