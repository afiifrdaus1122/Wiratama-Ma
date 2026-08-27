<?php
$sub = \App\Models\SubCategory::create(['category_id' => 1, 'name' => 'Vortex Flow Meter', 'slug' => 'vortex-flow-meter']);
\App\Models\Product::where('id', 1)->update(['sub_category_id' => $sub->id]);
echo 'Success';
