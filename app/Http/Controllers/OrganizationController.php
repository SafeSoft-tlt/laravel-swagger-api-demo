<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetOrganizationsByActivityRequest;
use App\Http\Requests\GetOrganizationsByBuildingRequest;
use App\Http\Requests\GetOrganizationsByRadiusRequest;
use App\Http\Requests\GetOrganizationByIdRequest;
use App\Http\Requests\SearchOrganizationsByNameRequest;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Laravel Swagger API Demo",
 *     version="1.0.0",
 *     description="Laravel REST API demo with API key authentication and Swagger documentation"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     name="X-API-KEY",
 *     in="header"
 * )
 */
class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationService $organizationService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/building/{buildingId}",
     *     summary="Get organizations by building",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="buildingId",
     *         in="path",
     *         required=true,
     *         description="Building ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of organizations in building",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - API key required"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function getByBuilding(GetOrganizationsByBuildingRequest $request): JsonResponse
    {
        $organizations = $this->organizationService->getByBuilding((int) $request->buildingId);
        
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activity/{activityId}",
     *     summary="Get organizations by activity",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="activityId",
     *         in="path",
     *         required=true,
     *         description="Activity ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of organizations by activity (including child activities)",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - API key required"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function getByActivity(GetOrganizationsByActivityRequest $request): JsonResponse
    {
        $organizations = $this->organizationService->getByActivity((int) $request->activityId);
        
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/radius",
     *     summary="Get organizations within radius",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="latitude",
     *         in="query",
     *         required=true,
     *         description="Latitude",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="longitude",
     *         in="query",
     *         required=true,
     *         description="Longitude",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="radius",
     *         in="query",
     *         required=true,
     *         description="Radius in meters",
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of organizations within radius",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - API key required"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function getByRadius(GetOrganizationsByRadiusRequest $request): JsonResponse
    {
        $organizations = $this->organizationService->getByRadius(
            $request->latitude,
            $request->longitude,
            $request->radius
        );
        
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     summary="Get organization by ID",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Organization ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization details",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - API key required"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function getById(GetOrganizationByIdRequest $request): JsonResponse
    {
        $organization = $this->organizationService->getById((int) $request->id);
        
        return response()->json($organization);
    }
    
    public function getByIdSimple(Request $request): JsonResponse
    {
        $id = (int) $request->route('id');
        $organization = $this->organizationService->getById($id);
        
        return response()->json($organization);
    }
    
    public function searchByNameSimple(Request $request): JsonResponse
    {
        $name = $request->query('name');
        if (!$name) {
            return response()->json(['error' => 'Name parameter is required'], 422);
        }
        
        $organizations = $this->organizationService->searchByName($name);
        
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/search",
     *     summary="Search organizations by name",
     *     tags={"Organizations"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Organization name",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of organizations matching search",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - API key required"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function searchByName(Request $request): JsonResponse
    {
        $name = $request->query('name');
        if (!$name) {
            return response()->json(['error' => 'Name parameter is required'], 422);
        }
        
        $organizations = $this->organizationService->searchByName($name);
        
        return response()->json($organizations);
    }

    /**
     * @OA\Get(
     *     path="/api/buildings",
     *     summary="Get all buildings",
     *     tags={"Buildings"},
     *     security={{"api_key":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all buildings",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Building"))
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - API key required"
     *     )
     * )
     */
    public function getBuildings(): JsonResponse
    {
        $buildings = $this->organizationService->getBuildings();
        
        return response()->json($buildings);
    }
} 