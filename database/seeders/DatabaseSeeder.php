<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\OrganizationPhoneNumber;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create buildings
        $building1 = Building::create([
            'address' => 'ул. Ленина, 1',
            'latitude' => '55.755800',
            'longitude' => '37.617600',
        ]);

        $building2 = Building::create([
            'address' => 'ул. Пушкина, 10',
            'latitude' => '55.750000',
            'longitude' => '37.620000',
        ]);

        // Create activities with hierarchy
        $foodActivity = Activity::create([
            'name' => 'Еда',
            'parent_id' => null,
        ]);

        $meatActivity = Activity::create([
            'name' => 'Мясная продукция',
            'parent_id' => $foodActivity->id,
        ]);

        $dairyActivity = Activity::create([
            'name' => 'Молочная продукция',
            'parent_id' => $foodActivity->id,
        ]);

        // Create organizations
        $organization1 = Organization::create([
            'name' => 'Мясной магазин "Свежее"',
            'building_id' => $building1->id,
        ]);

        $organization2 = Organization::create([
            'name' => 'Молочный магазин "Молоко"',
            'building_id' => $building2->id,
        ]);

        // Create phone numbers
        OrganizationPhoneNumber::create([
            'organization_id' => $organization1->id,
            'phone_number' => '+7 (495) 123-45-67',
        ]);

        OrganizationPhoneNumber::create([
            'organization_id' => $organization1->id,
            'phone_number' => '+7 (495) 123-45-68',
        ]);

        OrganizationPhoneNumber::create([
            'organization_id' => $organization2->id,
            'phone_number' => '+7 (495) 987-65-43',
        ]);

        // Create activity_organization relationships
        $organization1->activities()->attach($meatActivity->id);
        $organization2->activities()->attach($dairyActivity->id);
    }
}
