<?php

namespace Database\Seeders;

use App\Models\SubUnit;
use Illuminate\Database\Seeder;

class SubUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'name' => 'Proyección Social y Extensión Cultural',
                'description' => 'Coordinación de actividades comunitarias y extensión de la universidad.',
                'href' => '/proyeccion-social',
                'is_external' => false,
                'logo_path' => 'https://scontent.flim20-1.fna.fbcdn.net/v/t39.30808-6/272960757_4628681473926778_6629600432458897605_n.jpg?stp=dst-jpg_tt6&cstp=mx2017x2017&ctp=s2017x2017&_nc_cat=105&ccb=1-7&_nc_sid=6ee11a&oh=00_AQAIEfjqOqi6lNXRJGchTrJDiR7lgLTCn1Tsr0u-PBGCMQ&oe=6A55939C',
                'fb_url' => 'https://www.facebook.com/p/Direcci%C3%B3n-de-Proyecci%C3%B3n-Social-y-Extensi%C3%B3n-Cultural-UNA-Puno-100071137256988/',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Gestión Ambiental',
                'description' => 'Oficina encargada de la sostenibilidad y ecoeficiencia de la UNA Puno.',
                'href' => 'https://gestionambiental.unap.edu.pe',
                'is_external' => true,
                'logo_path' => 'https://scontent.flim26-1.fna.fbcdn.net/v/t39.30808-6/398995862_10222830756230066_520338572561505771_n.jpg?stp=dst-jpg_tt6&cstp=mx2026x2048&ctp=s2026x2048&_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&oh=00_AQBqcxqtRryOxfdDWVSMKxKwEz3Q3nom4XDNa6jobUDa4A&oe=6A55BE72',
                'fb_url' => 'https://www.facebook.com/p/Gesti%C3%B3n-Ambiental-UNA-PUNO-Oficial-61552848737780/',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Seguimiento al Graduado',
                'description' => 'Servicios de bolsa de trabajo y vinculación con egresados.',
                'href' => '/seguimiento-graduado',
                'is_external' => false,
                'logo_path' => 'https://scontent.flim20-1.fna.fbcdn.net/v/t39.30808-6/359734308_147671118342738_5430089938518897443_n.jpg?stp=dst-jpg_tt6&cstp=mx272x272&ctp=s272x272&_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&oh=00_AQCqEmTof-9bhusJcgLFU17KNI21K1cUYUZz039qp3XTZg&oe=6A55B461',
                'fb_url' => 'https://www.facebook.com/p/Egresados-y-Graduados-UNA-Puno-100092995523250/',
                'sort_order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($units as $unit) {
            SubUnit::create($unit);
        }
    }
}
