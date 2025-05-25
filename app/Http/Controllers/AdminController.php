<?php

namespace App\Http\Controllers;
use App\Models\Factura;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function marcarNotificacionComoLeida($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back()->with('mensaje', 'Notificación marcada como leída.');
    }

    /**
     * Metodo que administra la vista principal del administrador
     *
     * @return void
     */
    public function admin()
    {
        $facturas = Factura::whereYear('created_at', Carbon::now()->year)->get();
        $facturasPorMes = array_fill(1, 12, 0);

        foreach ($facturas as $factura) {
            $mes = $factura->created_at->month;
            $facturasPorMes[$mes]++;
        }
        $totalFacturado = $facturas->sum('total');
    
        $admin = Auth::user();
        $notifications = $admin->notifications;

        return view('admin.admin', compact('facturas', 'totalFacturado', 'facturasPorMes','notifications'));
    }
    
    public function usuarios(){
        $usuarios = User::all();
        return view ('admin.usuarios', \compact('usuarios'));
    }

    public function facturas()
    {
        $facturas = Factura::all();
        $montoTotalPorDia = Factura::whereDate('created_at', today())->sum('total');
        $facturasHoy = Factura::whereDate('created_at', today())->count();
    
        $montoPorUsuarioPorDia = Factura::selectRaw('user_id, rfc_emisor, DATE(created_at) as fecha, SUM(total) as monto_total')
            ->groupBy('user_id', 'rfc_emisor', 'fecha')
            ->orderBy('fecha', 'asc')
            ->get();
  
        $montoPorMes = Factura::selectRaw('YEAR(created_at) as año, MONTH(created_at) as mes, SUM(total) as monto_total')
            ->groupBy('año', 'mes')
            ->orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->get();
    
        return view('admin.facturas', compact('facturas', 'montoTotalPorDia', 'facturasHoy', 'montoPorUsuarioPorDia', 'montoPorMes'));
    }

    public function delete($id){
        $usuario = User::findOrFail($id);
        $usuario->delete();
        return redirect()->route('admin')->with('mensaje', 'Usuario eliminado correctamente.');
    }

    public function facturama(Request $request, $id){
        $request->validate([
            'usuarioFacturama' => 'required|string|max:255',
            'passwordFacturama' => 'required|string|min:8',
        ]);
        $user = User::findOrFail($id);
        $user->usuarioFacturama = $request->usuarioFacturama;
        $user->passwordFacturama = $request->passwordFacturama;
        $user->save();
        return redirect()->back()->with('mensaje', 'Cuenta de Facturama asignada correctamente.');
    }
    
}
