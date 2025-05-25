<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Email extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'email';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Comandos para enviar correos';
    
    /**
    * Execute the console command.
    */
    public function handle()
    {
        $username = "CHARLIEMART";
        $password = "FACTURACION98";

        $CfdiId= 'VHYH5vKyEjLsQnf9IMxP4w2';
        $email = 'garciagomezgamaliel@gmail.com';
        $cfidType = 'I';
        $subject = 'Factura Electrónica';
        $comments = 'Adjunto su factura electrónica.';
        $issuerEmail = 'despachojmr2@hotmail.com';
        $IncludePayBtn = 'true';

        $emailUrl = "https://apisandbox.facturama.mx/Cfdi?CfdiType={$cfidType}&CfdiId={$CfdiId}&Email={$email}&Subject={$subject}&Comments={$comments}&IssuerEmail={$issuerEmail}&IncludePayBtn={$IncludePayBtn}";
        $emailResponse = Http::withBasicAuth($username, $password)
        ->post($emailUrl);

        dd($emailResponse->json());            
    }
}
