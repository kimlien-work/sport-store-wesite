<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportProducts extends Command
{
    protected $signature = 'import:products {file}';
    protected $description = 'Import products from Excel/CSV file';

    public function handle()
    {
        $file = $this->argument('file');
        
        if (!file_exists($file)) {
            $this->error('File không tồn tại!');
            return;
        }
        
        $this->info('Đang import dữ liệu...');
        
        Excel::import(new ProductsImport, $file);
        
        $this->info('Import hoàn tất!');
    }
}