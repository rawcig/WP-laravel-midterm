<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all organizers
        $organizers = Organizer::all();

        // If no organizers exist, create some first
        if ($organizers->isEmpty()) {
            $organizers = collect([
                Organizer::create([
                    'name' => 'Rawh Events',
                    'email' => 'rawh.game@gmail.com',
                    'phone' => '0974862241',
                    'description' => 'Professional event management company',
                    'website' => 'https://rawhevents.com',
                ]),
                Organizer::create([
                    'name' => 'Phnom Penh Events',
                    'email' => 'info@ppevents.com',
                    'phone' => '012345678',
                    'description' => 'Leading event organizer in Cambodia',
                    'website' => 'https://ppevents.com',
                ]),
                Organizer::create([
                    'name' => 'Asia Pacific Conferences',
                    'email' => 'contact@apc-events.com',
                    'phone' => '023456789',
                    'description' => 'International conference organizer',
                    'website' => 'https://apc-events.com',
                ]),
                Organizer::create([
                    'name' => 'Music & Entertainment Co.',
                    'email' => 'bookings@musicent.com',
                    'phone' => '034567890',
                    'description' => 'Concert and music event specialist',
                    'website' => 'https://musicent.com',
                ]),
                Organizer::create([
                    'name' => 'Tech Summit Organization',
                    'email' => 'hello@techsummit.com',
                    'phone' => '045678901',
                    'description' => 'Technology conferences and workshops',
                    'website' => 'https://techsummit.com',
                ]),
            ]);
        }

        // Event titles templates
        $eventTemplates = [
            ['Tech Conference 2026', 'technology'],
            ['Music Festival Summer', 'music'],
            ['Business Summit', 'business'],
            ['Food & Wine Expo', 'food'],
            ['Art Exhibition Opening', 'art'],
            ['Charity Gala Dinner', 'charity'],
            ['Startup Pitch Competition', 'business'],
            ['Digital Marketing Workshop', 'technology'],
            ['Wedding Fair 2026', 'lifestyle'],
            ['Sports Championship', 'sports'],
            ['Film Festival Premiere', 'entertainment'],
            ['Health & Wellness Expo', 'health'],
            ['Education Conference', 'education'],
            ['Fashion Show Spring', 'fashion'],
            ['Gaming Tournament', 'entertainment'],
            ['Real Estate Forum', 'business'],
            ['Photography Exhibition', 'art'],
            ['Cooking Competition', 'food'],
            ['Science Fair', 'education'],
            ['Jazz Night Concert', 'music'],
        ];

        // Create 30 events
        for ($i = 0; $i < 30; $i++) {
            $template = $eventTemplates[array_rand($eventTemplates)];
            $organizer = $organizers->random();

            Event::create([
                'title' => $template[0] . ($i > 19 ? " - Edition " . ($i - 19) : ""),
                'organizer_id' => $organizer->id,
                'description' => $faker->paragraph(3),
                'date' => $faker->dateTimeBetween('+1 week', '+6 months'),
                'location' => $faker->randomElement([
                    'Phnom Penh, Cambodia',
                    'Siem Reap, Cambodia',
                    'Sihanoukville, Cambodia',
                    'Battambang, Cambodia',
                    'Koh Kong, Cambodia',
                    'NagaWorld Convention Center',
                    'Koh Pich Exhibition Center',
                    'Sokha Phnom Penh Hotel',
                    'Rosewood Phnom Penh',
                    'Fairmont Sampeah',
                ]),
                'status' => $faker->randomElement(['draft', 'published', 'cancelled', 'completed']),
            ]);
        }

        $this->command->info('30 events seeded successfully!');
    }
}
