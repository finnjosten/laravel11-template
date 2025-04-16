<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function getTemplate($type)
    {
        // Validate block type
        if (!in_array($type, ['text', 'image', 'video', 'columns'])) {
            return response()->json(['error' => 'Invalid block type'], 400);
        }

        // Return the block template view
        return view('pages.account.pages.blocks.' . $type);
    }
}
