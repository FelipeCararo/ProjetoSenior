<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PainelController extends Controller {

    public function __construct() {
        /**
         * @description Autenticar usuário logado.
         */
//        $this->middleware('auth');
    }

    public function index() {
        return 'Home Page do Site';
    }
}
