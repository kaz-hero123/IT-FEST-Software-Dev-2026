<?php

$files = [
    "resources/views/pages/user/search/user-search-index.blade.php",
    "resources/views/pages/user/home/components/user-home-popular.blade.php",
    "resources/views/pages/user/explore/user-explore-show.blade.php",
    "resources/views/pages/user/explore/components/user-explore-show.blade.php",
    "resources/views/pages/user/explore/components/user-explore-detail.blade.php",
    "resources/views/pages/contributor/home/contributor-home-index.blade.php",
    "resources/views/pages/contributor/form/contributor-edit.blade.php",
    "resources/views/pages/admin/contents/index.blade.php",
    "resources/views/pages/admin/components/moderation/admin-queue.blade.php",
    "resources/views/pages/admin/components/moderation/admin-preview.blade.php",
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Regular expression to replace Storage::url($...->file_path) with $...->resolved_url
    $newContent = preg_replace('/Storage::url\((.*?)\->file_path\)/', '$1->resolved_url', $content);
    
    if ($file === 'resources/views/pages/user/home/components/user-home-popular.blade.php') {
        // Custom replacement for this specific file
        $oldLogic = <<<'EOD'
          @php
            $coverUrl = asset('images/food.png');
            if ($item->primaryPhoto) {
                $path = $item->primaryPhoto->file_path;
                $coverUrl = str_starts_with($path, 'images/') ? asset($path) : Storage::url($path);
            }
          @endphp
EOD;
        $newLogic = <<<'EOD'
          @php
            $coverUrl = $item->primaryPhoto ? $item->primaryPhoto->resolved_url : asset('images/food.png');
          @endphp
EOD;
        $newContent = str_replace($oldLogic, $newLogic, $newContent);
    }
    
    if ($newContent !== $content) {
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
    }
}
