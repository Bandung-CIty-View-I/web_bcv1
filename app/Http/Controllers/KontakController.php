<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontak;
use Illuminate\Support\Facades\Auth;

class KontakController extends Controller
{
    public function getContacts(Request $request)
    {
        $contacts = Kontak::all(); 
        return response()->json($contacts, 200);
    }

    public function addContact(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'nomor' => 'required|string',
            'jenis' => 'required|string',
        ]);

        $contact = new Kontak();
        $contact->nama = $validatedData['nama'];
        $contact->nomor = $validatedData['nomor'];
        $contact->jenis = $validatedData['jenis'];
        $contact->save();

        return response()->json(['message' => 'Contact added successfully'], 201);
    }

    public function deleteContact(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $contact = Kontak::find($id);
        if ($contact) {
            $contact->delete();
            return response()->json(['message' => 'Contact deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Contact not found'], 404);
        }
    }

    public function updateContact(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string',
            'nomor' => 'sometimes|required|string',
            'jenis' => 'sometimes|required|string',
        ]);

        $contact = Kontak::find($id);
        if ($contact) {
            if (isset($validatedData['nama'])) {
                $contact->nama = $validatedData['nama'];
            }
            if (isset($validatedData['nomor'])) {
                $contact->nomor = $validatedData['nomor'];
            }
            if (isset($validatedData['jenis'])) {
                $contact->jenis = $validatedData['jenis'];
            }
            $contact->save();
            return response()->json(['message' => 'Contact updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Contact not found'], 404);
        }
    }

}
