<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

$imageUrls = [
    'laptops' => 'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=800',
    'cameras' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800',
    'gaming-consoles' => 'https://images.unsplash.com/photo-1486401899868-0e435ed85128?w=800',
    'drones' => 'https://images.unsplash.com/photo-1473968512647-3e447244af8f?w=800',
    'audio-equipment' => 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=800',
];

$client = new Client();
$outputDir = __DIR__ . '/../public/images/categories';

if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

foreach ($imageUrls as $category => $url) {
    try {
        $response = $client->get($url);
        if ($response->getStatusCode() === 200) {
            $imageContent = $response->getBody()->getContents();
            $outputPath = $outputDir . '/' . $category . '.jpg';
            file_put_contents($outputPath, $imageContent);
            echo "Downloaded image for {$category}\n";
        }
    } catch (GuzzleException $e) {
        echo "Failed to download image for {$category}: " . $e->getMessage() . "\n";
    }
}

echo "Image download complete!\n"; 