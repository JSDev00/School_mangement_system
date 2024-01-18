<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeesRequest;
use Illuminate\Http\Request;
use App\Repository\FeesRepositoryInterface;

class FeesController extends Controller
{
   protected $fee;
   public function __construct(FeesRepositoryInterface $fee){
    $this->fee = $fee;
   }
    public function index()
    {
        return $this->fee->index();
    }


    public function create()
    {
        return $this->fee->add();
        //
    }
    public function edit($id)
    {
        return $this->fee->edit($id);
        //
    }


    public function store(Request $request)
    {
        return $this->fee->saveFees($request);
    }


    public function show($id)
    {
        //
    }




    public function update(Request $request)
    {
        return $this->fee->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->fee->delete($request);
    }
}
