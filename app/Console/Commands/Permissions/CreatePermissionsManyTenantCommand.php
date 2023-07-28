<?php

namespace App\Console\Commands\Permissions;

use App\Http\Modules\Tenants\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreatePermissionsManyTenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-permissions-tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created all permissions';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {

        $this->line('Creating permissions for all tenants...');

        try {
            Tenant::all()->runForEach(function () {
                Artisan::call('create-permissions');
            });
            $this->line('Permissions created successfully.');
        } catch (\Throwable $th) {
            $this->error($th->getMessage());

            $this->line('Permissions not created.');
        }
    }
}
