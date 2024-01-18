<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\ReceiptStudentsRepositoryInterface;
use Illuminate\Http\Request;

class ReceiptStudentsController extends Controller
{
    protected  $Receipt;
    public function __construct(ReceiptStudentsRepositoryInterface $Receipt){
        $this->Receipt =  $Receipt;
    }
    public function index()
    {
        return $this->Receipt->index();
    }


    public function create()
    {
        // return $this->Receipt->store();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->Receipt->store($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Receipt->show($id);
    }
    public function edit($id)
    {
        return $this->Receipt->edit($id);
    }

    public function update(Request $request)
    {
        return $this->Receipt->update($request);
    }

    public function destroy($request)
    {
        return $this->Receipt->destroy($request);
    }
}
