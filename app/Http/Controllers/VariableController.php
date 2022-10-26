<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variable;

class VariableController extends Controller
{
    public function updateOla($request)
    {
        Variable::where('variable', $request->variable)
          ->update(['valor' => $request->valor]);

        return View('configuration');
    }
}
