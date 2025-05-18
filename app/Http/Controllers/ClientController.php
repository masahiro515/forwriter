<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    private $client;

    public function __construct(Client $client){
        $this->client = $client;
    }

    public function create(){
        $all_clients = $this->client->paginate(9);

        return view('projects.client-create')
                ->with('all_clients', $all_clients);
    }

    public function store(Request $request){
        $request->validate([
            'name'    => 'required|min:1|max:50|unique:clients,name',
            'description'        => 'nullable|string|min:1|max:1000'
        ]);

        $this->client->name = $request->name;
        $this->client->description = $request->description;
        $this->client->save();

        return redirect()->back();
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'    => 'required|min:1|max:50|unique:clients,name',
            'description'        => 'nullable|string|min:1|max:1000',
        ]);

        $client = $this->client->findOrFail($id);
        $client->name = $request->name;
        $client->description = $request->description;
        $client->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->client->destroy($id);

        return redirect()->back();
    }
}
