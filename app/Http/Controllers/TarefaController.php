<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarefaController extends Controller
{
    public function list()
    {
        // Listando todos
        $list = DB::select('SELECT * FROM tarefas');

        //  Formas de listar apenas o específico
        // $list = DB::select('SELECT * FROM tarefas WHERE resolvido = 1');
        // $list = DB::select('SELECT * FROM tarefas WHERE resolvido = ?', [1]);
        // $list = DB::select('SELECT * FROM tarefas WHERE resolvido = :status', ['status' => 1]);

        return view('tarefas.list', [
            'list' => $list
        ]);
    }

    public function add()
    {
        return view('tarefas.add');
    }

    public function addAction(Request $request)
    {
        
        if ($request->filled('titulo')) {
            $titulo = $request->input('titulo');

            DB::insert('INSERT INTO tarefas (titulo) VALUES (:titulo)', [
                'titulo' => $titulo
            ]);

            return redirect()->route('tarefas.list');
        } else {
            return redirect()->route('tarefas.add')->with('warning', 'Você não preencheu o título');
        }
    }

    public function edit($id)
    {
        $data = DB::select('SELECT * FROM tarefas WHERE id = :id', ['id' => $id]);

        if (count($data) > 0) {
            return view('tarefas.edit', ['data' => $data[0]]);
        } else {
            return redirect()->route('tarefas.list');
        }
        
    }

    public function editAction(Request $request, $id)
    {
        if ($request->filled('titulo')) {
            $titulo = $request->input('titulo');
        
            DB::update('UPDATE tarefas SET titulo = :titulo WHERE id = :id', [
                'id' => $id,
                'titulo' => $titulo
            ]);

            return redirect()->route('tarefas.list');
        } else {
            return redirect()->route('tarefas.edit', ['id' => $id])->with('warning', 'Você não preencheu o título');
        }
    }

    public function del($id)
    {
        DB::delete('DELETE FROM tarefas WHERE id = :id', ['id' => $id]);

        return redirect()->route('tarefas.list');
    }

    public function done($id)
    {
        // Opção 1: select + update
        // Opção2: update matemático

        // Opção 2:
        DB::update('UPDATE tarefas SET resolvido = 1 - resolvido WHERE id = :id', ['id' => $id]);

        return redirect()->route('tarefas.list');
    }
}
