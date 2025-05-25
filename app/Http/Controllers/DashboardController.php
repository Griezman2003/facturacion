<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\User;
use App\Models\Perfil;
use App\Models\Folio;
use App\Models\Claves;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;

class DashboardController extends Controller
{
    protected $claves;
    
    public function __construct(Claves $clavesFactura)
    {
        $this->claves = $clavesFactura; 
        $this->middleware('auth');
    }
    
    public function autenticacion()
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * Metodo que pasa la lista de las sucursales activas
     */
    
    public function sucursalUsuario(User $user){
        $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
        $passwordFacturama = $this->autenticacion()->passwordFacturama;
        $url = "https://apisandbox.facturama.mx/BranchOffice";
        $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($url);
        if ($response->failed()) {
            return view('empresa.sucursal', \compact('sucursales'));
        }
        if ($response->successful()) {
            $sucursales = $response->json();
        }
        return view('empresa.sucursal', \compact('sucursales'));
    }
    
    /**
     * Metodo que crea una sucursal
     *
     * @param Request $request
     * @return void
     */
    public function sucursal(Request $request, User $user){
        $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
        $passwordFacturama = $this->autenticacion()->passwordFacturama;
        $dato= $request->all();
        $data = [
            'Name' => $dato['nameSucursal'],
            'Description' => $dato['descriptionSucursal'],
            'Address' => [
                'Street' => $dato['streetSucursal'],
                'ExteriorNumber' => $dato['extNumberSucursal'],
                'InteriorNumber' => $dato['intNumberSucursal'],
                'Neighborhood' => $dato['neighborhoodSucursal'],
                'ZipCode' => $dato['zipCodeSucursal'],
                'Locality' => '',
                'Municipality' => $dato['municipalitySucursal'],
                'State' => $dato['stateSucursal'],
                'Country' => $dato['countrySucursal'],
                ]
            ];
            $url = "https://apisandbox.facturama.mx/BranchOffice";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->post($url, $data);
            if ($response->successful()) {
                return back()->with('mensaje', 'Sucursal creada con éxito.');
            }else{
                $responseData = $response->json();
                $errores = [];
                if (isset($responseData['Message'])) {
                    $errores[] = $responseData['Message'];
                }
                if (isset($responseData['ModelState'])) {
                    foreach ($responseData['ModelState'] as $key => $messages) {
                        if (is_array($messages)) {
                            foreach ($messages as $message) {
                                $errores[] = "$key: $message";
                            }
                        } else {
                            $errores[] = "$key: $messages";
                        }
                    }
                }
                return redirect()->back()->with('mensajeError', implode(' | ', $errores));   
            }
            
            return back()->with('mensajeError', 'Hubo un error al crear la sucursal.');
        }
        
        public function deleteSucursal($id, User $user){
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $url = "https://apisandbox.facturama.mx/BranchOffice/{$id}";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->delete($url);
            if ($response->successful()) {
                return back()->with('mensaje', 'Sucursal eliminada con éxito.');
            }
        }
        
        
        /**
         * Metodo que pasa las sucursales activas
         *
         * @return void
         */
        public function serie(User $user)
        {
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $url = "https://apisandbox.facturama.mx/BranchOffice";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($url);
            $seriesPorSucursal = []; 
            
            if ($response->successful()) {
                $serieSucursales = $response->json();
                
                foreach ($serieSucursales as $sucursal) {
                    $id = $sucursal['Id'];
                    $name = $sucursal['Name']; 
                    $urlSerie = "https://apisandbox.facturama.mx/serie/{$id}";
                    $responseSeries = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($urlSerie);
                    
                    if ($responseSeries->successful()) {
                        $series = $responseSeries->json();
                        foreach ($series as &$serie) {
                            $serie['SucursalId'] = $id;
                            // $serie['SucursalName'] = $name;
                        }
                        $seriesPorSucursal[$name] = $series;
                    }
                }
                // dd($seriesPorSucursal, $serieSucursales);
            }
            
            return view('empresa.serie', compact('serieSucursales', 'seriesPorSucursal'));
        }

        /**
         * Metodo para crear la serie de una sucursal
         */
        public function serieSucursal(Request $request, User $user){
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $datos = $request->all();
            $data=[
                'IdBranchOffice' => $datos['Id'],
                'Name' => $datos['nombreSerie'],
                'Description'=> $datos['descripcionSerie'],
                'Folio' => $datos['folioSerie']
            ];
            $url = "https://apisandbox.facturama.mx/serie/{$data['IdBranchOffice']}";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->post($url, $data);
            if ($response->successful()) {
                return redirect()->back()->with('mensaje', 'Serie creada con exito');
            }else{
                $responseData = $response->json();
                $errores = [];
                if (isset($responseData['Message'])) {
                    $errores[] = $responseData['Message'];
                }
                if (isset($responseData['ModelState'])) {
                    foreach ($responseData['ModelState'] as $key => $messages) {
                        if (is_array($messages)) {
                            foreach ($messages as $message) {
                                $errores[] = "$key: $message";
                            }
                        } else {
                            $errores[] = "$key: $messages";
                        }
                    }
                }
                return redirect()->back()->with('mensajeError', implode(' | ', $errores));   
            }
        } 

        /**
         * Metodo para eliminar una serie de la sucursal
         */
        public function serieDelete(Request $request, User $user){
            $datos = $request->all();
            $data = [
            'idBranchOffice' => $datos['sucursal_id'],
            'name'=>$datos['sucursal_name'],
            ];
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $url = "https://apisandbox.facturama.mx/serie/{$data['idBranchOffice']}/{$data['name']}";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->delete($url);
            if ($response->successful()) {
                return back()->with('mensaje', 'Serie eliminada con éxito.');
            }else{
                $responseData = $response->json();
                $errores = [];
                if (isset($responseData['Message'])) {
                    $errores[] = $responseData['Message'];
                }
                if (isset($responseData['ModelState'])) {
                    foreach ($responseData['ModelState'] as $key => $messages) {
                        if (is_array($messages)) {
                            foreach ($messages as $message) {
                                $errores[] = "$key: $message";
                            }
                        } else {
                            $errores[] = "$key: $messages";
                        }
                    }
                }
                return redirect()->back()->with('mensajeError', implode(' | ', $errores));   
            }
        }
        
        /**
         * Metodo que pasa a la vista un registro de los CSD cargados
         *
         * @param [type] $user
         * @return void
         */
        public function csd(User $user){
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $url = "https://apisandbox.facturama.mx/api-lite/csds";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($url);
            if ($response->failed()){
                $csds = $response->json();
                return view('empresa.csd', compact('csds'));
            }
            if ($response->successful()) {
                $csds = $response->json();
            }
            return view('empresa.csd', compact('csds'));
        }
        
        /**
         * Metodo para eliminar los CSD
         *
         * @param [type] $rfc
         * @return void
         */
        public function eliminar($rfc, User $user){
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $url = "https://apisandbox.facturama.mx/api-lite/csds/{$rfc}";
            $response = Http::withBasicAuth($usuarioFacturama,$passwordFacturama)->delete($url);
            if($response->successful()) {
                return redirect()->back()->with('mensaje', 'CSD eliminado correctamente.');
            }else {
                return redirect()->back()->with('mensajeError', 'No se pudo eliminar el CSD.');
            }
        }
        
        /**
         * Metodo para cargar los CSD a la cuenta
         *
         * @param Request $request
         * @return void
         */
        public function create(Request $request, User $user){
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            
            $datos = $request->all();

            if ($request->hasFile('key_certificado') && $request->hasFile('llave_privada')) {
                $certificadoContenido = file_get_contents($request->file('key_certificado'));
                $llavePrivadaContenido = file_get_contents($request->file('llave_privada'));
                
                $cerBase64 = base64_encode($certificadoContenido);
                $keyBase64 = base64_encode($llavePrivadaContenido);
            } 
            
            $data = [
                'Rfc' => $datos['rfc'],
                'Certificate' => $cerBase64 ?? '',    
                'PrivateKey' => $keyBase64 ?? '', 
                'PrivateKeyPassword' => $datos['key_password'],
            ];

            $url = "https://apisandbox.facturama.mx/api-lite/csds";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->post($url, $data); 
            if ($response->successful()) {
                return redirect()->back()->with('mensaje', 'CSD cargado correctamente.');
            } else {
                $responseData = $response->json();
                
                $errores = [];
                if (isset($responseData['Message'])) {
                    $errores[] = $responseData['Message'];
                }
                if (isset($responseData['ModelState'])) {
                    foreach ($responseData['ModelState'] as $key => $messages) {
                        if (is_array($messages)) {
                            foreach ($messages as $message) {
                                $errores[] = "$key: $message";
                            }
                        } else {
                            $errores[] = "$key: $messages";
                        }
                    }
                }
                
                return redirect()->back()->with('mensajeError', implode(' | ', $errores));   
            }
        }
        
        /**
         * Metodo para cancelar una factura emitida
         *
         * @param Request $request
         * @return void
         */
        public function cancelarFactura(Request $request, User $user)
        {
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $datos= $request->all();
            $data=[
                'id' => $datos['id'],
                'motive'=> $datos['motive'],
                'type' => $datos['type'],
                'uuid' => $datos['uuid']
            ];
            $factura = Factura::where('IdFactura', $data['id'])->first();
            if ($factura && $factura->status === 'canceled') {
                return redirect()->back()->with('mensajeError', 'La factura ya ha sido cancelada anteriormente.');
            }
            $url = "https://apisandbox.facturama.mx/api-lite/cfdis/{$data['id']}?type={$data['type']}&motive={$data['motive']}&uuidReplacement={$data['uuid']}";  
            $response = Http::withBasicAuth($usuarioFacturama,$passwordFacturama)->delete($url);
            if ($response->failed()) {
                $error = $responseData['Message'] ?? 'Error desconocido al cancelar la factura.';
                return redirect()->back()->with('mensajeError', $error);
            } 
            $status = $response->json()['Status'];
            $AcuseStatusDetails = $response->json()['AcuseStatusDetails'];
            if ($response->successful()) { 
                $factura = Factura::where('IdFactura',$data['id'])->first();   
                if (!$factura) {
                    return redirect()->back()->with('mensajeError', 'Factura no encontrada.');
                }
                $factura->status = $status;
                $factura->save();
                return redirect()->back()->with('mensaje', $AcuseStatusDetails);
            } else {
                $error = $response->json()['Message'] ?? 'Error desconocido';
                return redirect()->back()->with('mensajeError', $error);
            }
        }
        
        /**
         * Metodo que retornar acciones a la vista principal del dashboard
         *
         * @param User $user
         * @return void
         */
        public function index(User $user){
            $facturas = $this->autenticacion()->facturas;
            $facturasPorMes = array_fill(1, 12, 0);
            $anioActual = Carbon::now()->year;
            
            foreach ($facturas as $factura) {
                $fecha = Carbon::parse($factura->created_at);
                if ($fecha->year == $anioActual) {
                    $mes = $fecha->month;
                    $facturasPorMes[$mes]++;
                }
            }
            $factura = $this->autenticacion()->facturas;
            return view('page.dashboard', compact('factura', 'facturasPorMes'));
        }
        
        /**
         * Metodo que carga los diferentes tipos de regimenes
         *
         * @param [type] $user
         * @return void
         */
        public function csdEmisor()
        {
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $url = "https://apisandbox.facturama.mx/api-lite/csds";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($url);
            
            if ($response->successful()) {
                return $response->json(); 
            }
            
            return []; 
        }
        
        public function showFacturaEmpresa(User $user){
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            $regimenFiscal = $this->claves->regimenFiscal();
            $usoCFDI = $this->claves->usoCFDI();
            $ProdServ = $this->claves-> filterProduct();
            $claveUnidad =$this->claves-> claveUnidad();
            $csds = $this->csdEmisor();


            $url = "https://apisandbox.facturama.mx/BranchOffice";
            $response = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($url);
            if ($response->successful()) {
                $sucursal = $response->json(); 
                if (empty($sucursal)) {
                    return redirect()->back()->with('mensajeError', 'No puedes Facturar. ¡Necesitas tener una sucursal activa!');
                }
            }
            $urlSerie = "https://apisandbox.facturama.mx/serie/{$sucursal[0]['Id']}";
            $responseSerie = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($urlSerie);
            if ($responseSerie->successful()) {
                $series = $responseSerie->json(); 
                if (empty($series)) {
                    return redirect()->back()->with('mensajeError', 'No puedes Facturar. ¡Necesitas tener una serie activa!');
                }
            }
            
            return view('empresa.factura', compact('regimenFiscal', 'usoCFDI', 'ProdServ', 'claveUnidad','csds','series'));
        }
        
        /**
         * Metodo que genera la factura
         *
         * @param Request $request
         * @param User $user
         * @return void
         */
        public function generarFactura(Request $request, User $user)
        {
            $productos = json_decode(trim($request->input('productos')), true);
            
            if (empty($productos)) {
                return back()->with('mensajeError', 'No se han agregado productos a la factura');
            }
            $datos = $request->all();
            
            $subtotal = array_sum(array_column($productos, 'importe'));
            $total = $subtotal;
            
            $folio = Folio::firstOrCreate(['serie' => $datos['serie']], ['ultimo_folio' => 0]);
            $folio->increment('ultimo_folio');
            $datos['folio'] = $folio->ultimo_folio;
            
            $url = "https://apisandbox.facturama.mx/api-lite/3/cfdis";
            $usuarioFacturama = $this->autenticacion()->usuarioFacturama;
            $passwordFacturama = $this->autenticacion()->passwordFacturama;
            
            $facturaData = [
                "Serie" => $datos['serie'],
                "Folio" => $datos['folio'],
                "Fecha" => Carbon::now()->format("Y-m-d\TH:i:s"),
                "PaymentForm" => $datos['paymentForm'],
                "PaymentMethod" => $datos['paymentMethod'],
                "SubTotal" => $datos['subtotal'],
                "ExpeditionPlace" => $datos['expeditionPlace'],
                "Moneda" => $datos['moneda'],
                "Total" => $datos['totalFinal'],
                "CfdiType" => $datos['cfdiType'],
                "Issuer" => [
                    "Rfc" => $datos['rfcEmisor'],
                    "Name" => $datos['nombre_emisor'],
                    "FiscalRegime" => $datos['regimenEmisor']
                ],
                "Receiver" => [
                    "Rfc" => $datos['rfcReceptor'],
                    "Name" => $datos['receiver'],
                    "CfdiUse" => $datos['uso_cfdi'],
                    "FiscalRegime" => $datos['regimenFiscal'],
                    "TaxZipCode" => $datos['domicilioReceptor']
                ],
                
                "Items" => []
            ];
            
            foreach ($productos as $producto) {
                $base = $producto['valorUnitario'] * $producto['cantidad'];
                $item = [
                    "Quantity" => $producto['cantidad'],
                    "ProductCode" => $producto['claveProductoServicio'],
                    "UnitCode" => $producto['claveUnidad'],
                    "UnitPrice" => $producto['valorUnitario'],
                    "Subtotal" => $base,
                    "TaxObject" => $producto['objetoImpuesto'],
                    "Description" => $producto['descripcion'],
                    "Total" =>  round($base, 2)
                ];
                if (!empty($producto['noIdentificacion'])) {
                    $item["IdentificationNumber"] = $producto['noIdentificacion'];
                }
                $taxes = [];
                
                // IVA
                if (in_array($producto['objetoImpuesto'], ['02', '03', '04'])) {
                    $iva = round($base * $producto['descuento'], 2);
                    $taxes[] = [
                        "Name" => "IVA",
                        "Base" => ($base),
                        "Rate" => $producto['descuento'],
                        "Total" => $iva,
                        "IsRetention" => false,
                        "IsFederalTax" => true
                    ];
                    $item["Total"] += $iva;
                }
                
                // ISR
                if (!empty($producto['isr'])) {
                    $isr = round($base * $producto['isr'],2);
                    $taxes[] = [
                        "Name" => "ISR",
                        "Base" => $base,
                        "Rate" => $producto['isr'],
                        "Total" => $isr,
                        "IsRetention" => true,
                        "IsFederalTax" => true
                    ];
                    $item["Total"] -= $isr; 
                }
                
                // IVA Retenido
                if (!empty($producto['ivaRetenido'])) {
                    $ivaRetenido = round($base * $producto['ivaRetenido'],2);
                    $taxes[] = [
                        "Name" => "IVA Retenido",
                        "Base" => $base,
                        "Rate" => $producto['ivaRetenido'],
                        "Total" => $ivaRetenido,
                        "IsRetention" => true,
                        "IsFederalTax" => true
                    ];
                    $item["Total"] -= $ivaRetenido;
                }
                
                // IEPS 
                if (!empty($producto['ieps'])) {
                    $ieps = round($base * $producto['ieps'],2);
                    $taxes[] = [
                        "Name" => "IEPS",
                        "Base" => $base,
                        "Rate" => $producto['ieps'],
                        "Total" => $ieps,
                        "IsRetention" => false,
                        "IsFederalTax" => true
                    ];
                    $item["Total"] += $ieps;
                }
                
                if (!empty($taxes)) {
                    $item["Taxes"] = $taxes;
                }
                
                $item["Total"] = round($item["Total"], 2);
                
                $facturaData["Items"][] = $item;
            }
            
            $factura = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->post($url, $facturaData);
            if ($factura->failed()) {
                $response = $factura->json();
                $error = $response['Message'] ?? null;
                $errorRegimen = $response['ModelState']['cfdiToCreate.Receiver.FiscalRegime']['0'] ?? null;
                $errorCfdi = $response['ModelState']['cfdiToCreate.Receiver.CfdiUse']['0'] ?? null;
                $errorEmisor = $response['ModelState']['cfdiToCreate.Issuer.Rfc']['0'] ?? null;
                
                if ($errorRegimen) {
                    return back()->with('mensajeError', $errorRegimen);
                }
                if ($errorCfdi) {
                    return back()->with('mensajeError', $errorCfdi);
                }
                if ($errorEmisor) {
                    return back()->with('mensajeError', $errorEmisor);
                }
                
                if ($error) {
                    return back()->with('mensajeError', $error);
                }
                return back()->with('mensajeError', 'Error desconocido');
            }else{
                $factura->created();
                $Id = $factura->json()['Id'];
                $uuid = $factura->json()['Complement']['TaxStamp']['Uuid'];
                $status = $factura->json()['Status'];
                
                $xml = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get("https://apisandbox.facturama.mx/api/Cfdi/xml/issuedLite/{$Id}");
                Storage::disk('public')->put("facturas/xml/{$uuid}.xml", base64_decode($xml->json()['Content']));
                
                $pdf = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get("https://apisandbox.facturama.mx/api/Cfdi/pdf/issuedLite/{$Id}");
                Storage::disk('public')->put("facturas/pdf/{$uuid}.pdf", base64_decode($pdf->json()['Content']));
                
                Factura::create([
                    'user_id' => $this->autenticacion()->id,
                    'folio' => $datos['folio'],
                    'uuid' => $uuid,
                    'IdFactura' =>$Id,
                    'rfc_emisor' => $datos['rfcEmisor'],
                    'rfc_receptor' => $datos['rfcReceptor'],
                    'subtotal' => $subtotal,
                    'total' => $total,
                    'pdf_path' => "facturas/pdf/{$uuid}.pdf",
                    'xml_path' => "facturas/xml/{$uuid}.xml",
                    'status'=>$status
                ]);
                // $emailResponse = $this->facturaCorreo($datos, $factura, $Id);
                if ($factura->successful()) {
                    return redirect()->route('dashboard.index', $user)->with('mensaje', 'Factura generada correctamente');
                }    
            } 
        }    
    }    
    