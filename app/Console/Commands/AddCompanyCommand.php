<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Company;
class AddCompanyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contact:company {name} {phone=N/A}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'adds a new company';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            $company = Company::create([
            'name' => $this->argument('name'),
            'phone' => $this->argument('phone'),
        ]);

        $this->info('Added: ' . $company->name);
    }
}
