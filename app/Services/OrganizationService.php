<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

class OrganizationService
{
    /**
     * Get organizations by building ID
     */
    public function getByBuilding(int $buildingId): Collection
    {
        // TODO: Implement logic to get organizations by building ID
        return Organization::with(['phoneNumbers', 'activities'])->where('building_id', $buildingId)->get();
    }

    /**
     * Get organizations by activity ID (including child activities)
     */
    public function getByActivity(int $activityId): Collection
    {
        // TODO: Implement logic to get organizations by activity ID including child activities
        $activity = \App\Models\Activity::find($activityId);
        if (!$activity) {
            return new Collection();
        }
        
        // Get all child activity IDs recursively
        $childActivityIds = $this->getChildActivityIds($activityId);
        $allActivityIds = array_merge([$activityId], $childActivityIds);
        
        return Organization::whereHas('activities', function ($query) use ($allActivityIds) {
            $query->whereIn('activities.id', $allActivityIds);
        })->get();
    }
    
    /**
     * Get all child activity IDs recursively
     */
    private function getChildActivityIds(int $parentId): array
    {
        $childIds = [];
        $children = \App\Models\Activity::where('parent_id', $parentId)->get();
        
        foreach ($children as $child) {
            $childIds[] = $child->id;
            $childIds = array_merge($childIds, $this->getChildActivityIds($child->id));
        }
        
        return $childIds;
    }

    /**
     * Get organizations within radius
     */
    public function getByRadius(float $latitude, float $longitude, float $radius): Collection
    {
        // TODO: Implement logic to get organizations within radius using Haversine formula
        $haversine = "(6371 * acos(cos(radians($latitude)) * cos(radians(buildings.latitude)) * cos(radians(buildings.longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(buildings.latitude))))";
        
        return Organization::join('buildings', 'organizations.building_id', '=', 'buildings.id')
            ->select('organizations.*')
            ->selectRaw("$haversine AS distance")
            ->having('distance', '<=', $radius / 1000) // Convert meters to kilometers
            ->orderBy('distance')
            ->get();
    }

    /**
     * Get organization by ID
     */
    public function getById(int $id): ?Organization
    {
        // TODO: Implement logic to get organization by ID
        return Organization::with(['building', 'phoneNumbers', 'activities'])->find($id);
    }

    /**
     * Search organizations by name
     */
    public function searchByName(string $name): Collection
    {
        // TODO: Implement logic to search organizations by name
        return Organization::with(['building', 'phoneNumbers', 'activities'])
            ->where('name', 'like', "%{$name}%")
            ->get();
    }

    /**
     * Get all buildings
     */
    public function getBuildings(): Collection
    {
        // TODO: Implement logic to get all buildings
        return \App\Models\Building::with('organizations')->get();
    }

    /**
     * Get all buildings with coordinates for testing
     */
    public function getBuildingsWithCoordinates(): Collection
    {
        return \App\Models\Building::select('id', 'address', 'latitude', 'longitude')->get();
    }
} 