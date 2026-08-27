<?php
use App\Models\Category;
use Illuminate\Support\Str;

$categories = [
    [
        'name' => 'Flow Measurement',
        'description' => 'Our expertise in measurement is supported by flow and level measuring components'
    ],
    [
        'name' => 'Level Measurement',
        'description' => 'Accurate and reliable level measurement instruments for various industrial applications'
    ],
    [
        'name' => 'Display Indicator & Control',
        'description' => 'Good measuring components also assisted with Hi-tech monitoring devices'
    ],
    [
        'name' => 'Electrical Parts',
        'description' => 'We also provide you with great electrical components such as connectors and plugs'
    ],
    [
        'name' => 'Mechanical Part',
        'description' => 'Brand new Mechanical Technology has been help us to boost our customers satisfaction'
    ],
    [
        'name' => 'Sensor',
        'description' => 'High-precision industrial sensors for accurate data acquisition and process automation'
    ]
];

foreach ($categories as $catData) {
    $slug = Str::slug($catData['name']);
    
    // Check if category already exists by slug or name
    $existingCat = Category::where('slug', $slug)->orWhere('name', $catData['name'])->first();
    
    if (!$existingCat) {
        Category::create([
            'name' => $catData['name'],
            'slug' => $slug,
            'description' => $catData['description']
        ]);
        echo "Created: {$catData['name']}\n";
    } else {
        // Update description if it's empty
        if (empty($existingCat->description)) {
            $existingCat->description = $catData['description'];
            $existingCat->save();
        }
        echo "Already exists: {$catData['name']}\n";
    }
}
echo "Seeding completed.\n";
