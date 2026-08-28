<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        CompanyProfile::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'PT Wiratama Mitra Abadi',
                'hero_title' => 'Excellent Quality, Innovative Solution, Trusted Partner',
                'hero_subtitle' => 'With over 15 years of industrial experience, we provide reliable products and solutions for your business.',
                'about_page_title' => 'We Believe In Hard Work & Dedication',
                'about_page_subtitle' => 'We Can Do It Together!',
                'about_summary' => 'Wiratama Mitra Abadi is a trusted provider of industrial equipment and technical solutions in Indonesia.',
                'about_us' => '<p>Choosing Wiratama to be a provider of industrial equipment is the right choice. With our products, customers can save expenses and get the best consultation for the products they need.</p><p>We provide the best solutions according to customer needs for automotive, agricultural, power plant, petrochemical, water treatment plant, mining, health and care, and food and beverages industries.</p>',
                'vision' => '<p>We help customers determine product specifications and provide products to meet customer needs.</p>',
                'mission' => '<p>We provide repair and setting services with experienced technicians for after-sales products as well as products beyond responsibility.</p>',
                'company_values' => '<p>We provide calibration services for some of the products we offer, such as flow measurement and level measurement.</p>',
                'company_history' => '<h3>Our Services</h3><ul><li><strong>Consultation:</strong> Helping customers determine product specifications and providing products to meet their needs.</li><li><strong>Repair &amp; Setting:</strong> Repair and setting services with experienced technicians.</li><li><strong>Calibration:</strong> Calibration services for flow measurement and level measurement products.</li><li><strong>Installation &amp; Commissioning:</strong> Helping customers operate products properly.</li><li><strong>Product Customization:</strong> Customization according to customer requirements.</li><li><strong>Technical Supplier:</strong> Supplying quality technical products for customer satisfaction.</li></ul><h3>Exhibitions</h3><ul><li>Manufacturing Indonesia</li><li>Indowater Expo &amp; Forum</li><li>Cikarang Industrial Expo</li></ul>',
                'stats' => [
                    ['number' => '5,674+', 'label' => 'Customers'],
                    ['number' => '76', 'label' => 'Business Partners'],
                    ['number' => '17', 'label' => 'Brands'],
                ],
                'features' => [
                    ['title' => 'Consultation', 'desc' => 'Product specification consultation for industrial needs.'],
                    ['title' => 'Repair & Setting', 'desc' => 'Experienced technical support for after-sales service.'],
                    ['title' => 'Calibration', 'desc' => 'Calibration for flow and level measurement products.'],
                    ['title' => 'Installation & Commissioning', 'desc' => 'Support to operate products correctly.'],
                    ['title' => 'Product Customization', 'desc' => 'Solutions customized to customer requirements.'],
                    ['title' => 'Technical Supplier', 'desc' => 'Quality technical products from trusted brands.'],
                ],
                'address' => 'Jl. Satria Raya Blok IV No. 7, South Bekasi, West Java, Indonesia',
                'email' => 'sales@wma.co.id',
                'phone' => '(021) 8949 1561',
                'whatsapp' => '6281189491561',
                'linkedin' => 'https://www.linkedin.com/company/pt-wiratama-mitra-abadi/',
                'facebook' => 'https://www.facebook.com/wiratamamitraabadiupdate/',
                'instagram' => 'https://www.instagram.com/wiratamamitraabadi/',
                'youtube' => null,
            ]
        );
    }
}