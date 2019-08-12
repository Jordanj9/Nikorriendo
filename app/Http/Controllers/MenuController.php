<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller {

    /**
     * Show the view menu usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function usuarios() {
        return view('menu.usuarios')->with('location', 'usuarios');
    }

    /**
     * Show the view menu estructura.
     *
     * @return \Illuminate\Http\Response
     */
    public function estructura() {
        return view('menu.estructura')->with('location', 'estructura');
    }

}
