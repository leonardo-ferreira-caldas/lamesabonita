<?php

namespace App\Http\Controllers\Admin\Resources;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class EmailResource extends Controller
{

    public function __construct()
    {
        $this->middleware('guest_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListar()
    {
        return view('admin.emails.listar');
    }

    /**
     * Retorna o corpo do email
     *
     * @param int $id Código do email
     * @return HTML Corpo do html
     */
    public function getCorpoEmail($id) {
        return DB::table('email')->where("id_email", $id)->first()->corpo_email;
    }

    /**
     * Retorna o corpo do email
     *
     * @param int $id Código do email
     * @return HTML Corpo do html
     */
    public function getReenviar($id) {
        DB::table('fila_email')->insert([
            'id_email' => $id
        ]);

        return redirectWithAlertSuccess('O email foi agendando para reenvio.')->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBuscarRegistros()
    {
        return DB::table('email')->orderBy('id_email', 'desc')->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDetalhes($id)
    {
        $dadosEmail = DB::table('email')
            ->where("id_email", $id)
            ->first();

        return view('admin.emails.detalhes', [
            'email' => $dadosEmail
        ]);
    }
}
