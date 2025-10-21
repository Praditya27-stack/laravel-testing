@echo off
echo ========================================
echo Publishing Package Configurations
echo ========================================
echo.

echo [1/9] Publishing Livewire config...
call php artisan livewire:publish --config

echo.
echo [2/9] Publishing Spatie Permission config and migrations...
call php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

echo.
echo [3/9] Publishing Spatie Media Library config and migrations...
call php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-config"
call php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

echo.
echo [4/9] Publishing Spatie Activity Log config and migrations...
call php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
call php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"

echo.
echo [5/9] Publishing Laravel Excel config...
call php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config

echo.
echo [6/9] Publishing DomPDF config...
call php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"

echo.
echo [7/9] Publishing Laravel Scout config...
call php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"

echo.
echo [8/9] Publishing Laravel Horizon assets and config...
call php artisan horizon:install

echo.
echo [9/9] Publishing Filament assets (if installed)...
call php artisan filament:install --panels

echo.
echo ========================================
echo All configurations published!
echo ========================================
echo.
echo Next: Run migrations for new package tables
echo Command: php artisan migrate
echo.
pause
