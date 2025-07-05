<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'pays' => 'Cameroun',
                'ville' => 'Douala',
                'description' => 'La capitale économique du Cameroun avec son port actif',
                'image_url' => 'destinations/douala.jpg',
                'statut' => 'active',
                'populaire' => true,
                'note' => 4.8
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Yaoundé',
                'description' => 'La capitale politique du Cameroun avec ses monuments emblématiques',
                'image_url' => 'destinations/yaounde.jpg',
                'statut' => 'active',
                'populaire' => true,
                'note' => 4.8
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Garoua',
                'description' => 'La ville de la Bénoué avec son patrimoine culturel',
                'image_url' => 'destinations/garoua.jpg',
                'statut' => 'active',
                'populaire' => false,
                'note' => 4.5
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Bamenda',
                'description' => 'La ville des montagnes avec son marché artisanal',
                'image_url' => 'destinations/bamenda.jpg',
                'statut' => 'active',
                'populaire' => true,
                'note' => 4.6
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Maroua',
                'description' => 'La ville de la Bénoué avec son patrimoine culturel',
                'image_url' => 'destinations/maroua.jpg',
                'statut' => 'active',
                'populaire' => false,
                'note' => 4.5
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Bafoussam',
                'description' => 'La ville de la Bénoué avec son patrimoine culturel',
                'image_url' => 'destinations/bafoussam.jpg',
                'statut' => 'active',
                'populaire' => false,
                'note' => 4.5
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Ngaoundéré',
                'description' => 'La ville de la Bénoué avec son patrimoine culturel',
                'image_url' => 'destinations/ngaoundere.jpg',
                'statut' => 'active',
                'populaire' => false,
                'note' => 4.5
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Bertoua',
                'description' => 'La ville de la Bénoué avec son patrimoine culturel',
                'image_url' => 'destinations/bertoua.jpg',
                'statut' => 'active',
                'populaire' => false,
                'note' => 4.5
            ],
            [
                'pays' => 'Cameroun',
                'ville' => 'Loum',
                'description' => 'La ville de la Bénoué avec son patrimoine culturel',
                'image_url' => 'destinations/loum.jpg',
                'statut' => 'active',
                'populaire' => false,
                'note' => 4.5
            ],

        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
