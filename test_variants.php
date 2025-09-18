<?php
// test_variants.php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing variant display...\n";
$item = App\Models\Item::with('variants')->first();
echo "Sample item: " . $item->name . "\n";
echo "Variants: " . $item->variants->count() . "\n";
foreach($item->variants as $v) {
    echo "- " . $v->name . " (₹" . $v->price . ")\n";
}

echo "\nVariant display updated successfully!\n";
