<?php

namespace App\Http\Controllers;

use App\Models\Guzzler;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GuzzlerController extends Controller
{

    public function index()
    {
        return view('guzzler');
    }

    public function fetchPosts()
    {
        $client = new Client();
        $request = $client->get('https://jsonplaceholder.typicode.com/posts');
        //dd($response);

        return response()->json(json_decode($request->getBody()));
    }


    public function createPost(Request $request)
    {
        $client = new Client();
        $response = $client->post('https://jsonplaceholder.typicode.com/posts', $request->all());

        return response()->json($response);

    }

    public function updatePost(Request $request)
    {
        $client = new Client();
        $response = $client->put('https://jsonplaceholder.typicode.com/posts/'.$request->id, $request
            ->only(['userId','title','body']));

        return response()->json($response);
    }


    public function deletePost($id)
    {
        $client = new Client();
        $response = $client->delete('https://jsonplaceholder.typicode.com/posts/'.$id );

        return response()->json($response );
    }

}
