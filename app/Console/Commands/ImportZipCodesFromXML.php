<?php

namespace App\Console\Commands;

use App\Models\Settlement;
use App\Models\ZipCode;
use App\Repositories\ZipCodeRepository;
use Illuminate\Console\Command;

class ImportZipCodesFromXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:zipcodes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Import Zip Codes Command');
        $startTime = microtime(true);

        $xmlFile = file_get_contents('./CPdescarga.xml');
        $xmlData = collect(json_decode(json_encode(@simplexml_load_string($xmlFile)), true));
        $priorZipCode = '';
        $zipCodeId = '';

        foreach ($xmlData as $data) {
            foreach ($data as $dat) {
                if ($priorZipCode !== $dat['d_codigo']) {
                    $this->info('Processing Zip Code('.$dat['d_estado'].'): ' . $dat['d_codigo']);
                    $this->newLine();

                    $zipCode = (new ZipCodeRepository)->store($dat);

                    $priorZipCode = $dat['d_codigo'];
                    $zipCodeId = $zipCode->id;
                }

                $this->info('Processing Settlement ('.$dat['d_codigo'].'): ' . $dat['d_asenta']);
                $settlementType = [
                    'name' => $dat['d_tipo_asenta']
                ];

                Settlement::insert([
                    'zip_code_id' => $zipCodeId,
                    'key' => (int)$dat['id_asenta_cpcons'],
                    'name' => $dat['d_asenta'],
                    'zone_type' => $dat['d_zona'],
                    'settlement_type' => json_encode($settlementType),
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $this->info('Zip Code has been processed: ' . $dat['d_codigo']);
                $this->newLine();
            }
        }

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime)/60;

        $this->info('Total Execution Time: ' . number_format((float) $executionTime, 10) . ' mins.');
    }
}
