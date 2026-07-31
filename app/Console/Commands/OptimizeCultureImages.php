<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('image:optimize-culture')]
#[Description('Optimize large images in public/images/culture')]
class OptimizeCultureImages extends Command
{
    public function handle()
    {
        $dir = public_path('images/culture');
        $backupDir = storage_path('app/image-backup');
        
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $files = File::files($dir);
        $totalBefore = 0;
        $totalAfter = 0;

        foreach ($files as $file) {
            $size = $file->getSize();
            if ($size > 500 * 1024) { // > 500KB
                $totalBefore += $size;
                $this->info("Processing: " . $file->getFilename() . " (" . round($size / 1024, 2) . " KB)");
                
                // Backup
                File::copy($file->getPathname(), $backupDir . '/' . $file->getFilename());

                // Process with GD
                $imagePath = $file->getPathname();
                $ext = strtolower($file->getExtension());

                $image = null;
                if ($ext === 'jpg' || $ext === 'jpeg') {
                    $image = @imagecreatefromjpeg($imagePath);
                } elseif ($ext === 'png') {
                    $image = @imagecreatefrompng($imagePath);
                }

                if (!$image) {
                    $this->error("Failed to load image: " . $file->getFilename());
                    $totalAfter += $size;
                    continue;
                }

                $width = imagesx($image);
                $height = imagesy($image);

                $newWidth = $width;
                $newHeight = $height;

                if ($width > 1600) {
                    $newWidth = 1600;
                    $newHeight = floor($height * (1600 / $width));
                }

                $newImage = imagecreatetruecolor($newWidth, $newHeight);
                
                if ($ext === 'png') {
                    $bg = imagecolorallocate($newImage, 255, 255, 255);
                    imagefill($newImage, 0, 0, $bg);
                }

                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                imagejpeg($newImage, $imagePath, 80);

                imagedestroy($image);
                imagedestroy($newImage);

                clearstatcache();
                $newSize = filesize($imagePath);
                $totalAfter += $newSize;
                
                $this->info("Done: " . $file->getFilename() . " (" . round($newSize / 1024, 2) . " KB)");
            }
        }

        $this->info("Total Size Before: " . round($totalBefore / 1024 / 1024, 2) . " MB");
        $this->info("Total Size After: " . round($totalAfter / 1024 / 1024, 2) . " MB");
    }
}
