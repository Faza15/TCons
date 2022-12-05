<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::get();

        return response()->json([
            'success' => true,
            'message' => 'List Semua Tiket',
            'data' => $tickets
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'concert_name' => 'required|string|max:255',
            'concert_date' => 'required|date',
            'concert_category' => 'required|string|max:255',
            'concert_price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validated = $validator->validated();

        $ticket = Ticket::create($validated);

        if ($ticket) {
            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil ditambahkan',
                'data' => $ticket
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tiket gagal ditambahkan',
                'data' => $ticket
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::whereId($id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Detail Tiket',
            'data' => $ticket
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'concert_name' => 'nullable|string|max:255',
            'concert_date' => 'nullable|date',
            'concert_category' => 'nullable|string|max:255',
            'concert_price' => 'nullable|integer',
            'stock' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $validated = $validator->validated();

        $ticket = Ticket::whereId($id)->update($validated);

        if ($ticket) {
            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil diupdate',
                'data' => $ticket
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tiket gagal diupdate',
                'data' => $ticket
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::whereId($id)->delete();

        if($ticket)
        {
            return response()->json([
                'success' => true,
                'message' => 'Tiket Berhasil Dihapus',
                'data' => $ticket
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tiket Gagal Dihapus',
                'data' => $ticket
            ], 409);
        }
    }
}
