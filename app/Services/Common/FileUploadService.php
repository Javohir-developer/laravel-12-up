<?php
namespace App\Services\Common;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($folder, $fileName, 'public');
    }

    public function delete(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    public function update(UploadedFile $newFile, ?string $oldPath, string $folder = 'uploads'): string
    {
        $this->delete($oldPath);
        return $this->upload($newFile, $folder);
    }

    public function url(?string $path): ?string
    {
        if (!$path) return null;
        return Storage::disk('public')->url($path);
    }
}