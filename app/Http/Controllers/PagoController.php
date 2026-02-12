<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Matricula;
use App\Models\Establecimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pago::with(['estudiante', 'matricula.grupo']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('concepto')) {
            $query->where('concepto', $request->concepto);
        }

        if ($request->filled('mes')) {
            $query->whereMonth('fecha_pago', $request->mes);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%");
            });
        }

        $pagos = $query->latest('fecha_pago')->paginate(20)->withQueryString();

        return view('pagos.index', compact('pagos'));
    }

    public function create(Request $request)
    {
        $matricula = null;
        if ($request->filled('matricula_id')) {
            $matricula = Matricula::with(['estudiante', 'grupo'])->find($request->matricula_id);
        }

        $matriculas = Matricula::with(['estudiante', 'grupo'])
            ->where('estado', 'activa')
            ->get();

        return view('pagos.create', compact('matriculas', 'matricula'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matricula_id' => 'required|exists:matriculas,id',
            'concepto' => 'required|in:matricula,pension,material,otro',
            'valor' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'required|string',
        ]);

        $matricula = Matricula::findOrFail($request->matricula_id);

        $descuento = $request->descuento ?? 0;
        $recargo = $request->recargo ?? 0;
        $total = $request->valor - $descuento + $recargo;

        $pago = Pago::create([
            'recibo' => Pago::generarRecibo(),
            'matricula_id' => $matricula->id,
            'estudiante_id' => $matricula->estudiante_id,
            'concepto' => $request->concepto,
            'mes' => $request->mes,
            'valor' => $request->valor,
            'descuento' => $descuento,
            'recargo' => $recargo,
            'total' => $total,
            'metodo_pago' => $request->metodo_pago,
            'referencia_pago' => $request->referencia_pago,
            'fecha_pago' => $request->fecha_pago,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'estado' => 'pagado',
            'observaciones' => $request->observaciones,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('matriculas.show', $matricula)
            ->with('success', "Pago registrado. Recibo: {$pago->recibo}");
    }

    public function show(Pago $pago)
    {
        $pago->load(['estudiante', 'matricula.grupo']);

        return view('pagos.show', compact('pago'));
    }

    public function recibo(Pago $pago)
    {
        $pago->load(['estudiante', 'matricula.grupo', 'matricula.acudiente']);
        $establecimiento = Establecimiento::datos();

        return view('pagos.recibo', compact('pago', 'establecimiento'));
    }

    public function destroy(Pago $pago)
    {
        $pago->update(['estado' => 'anulado']);

        return redirect()->route('pagos.show', $pago)
            ->with('success', 'Pago anulado.');
    }
}
