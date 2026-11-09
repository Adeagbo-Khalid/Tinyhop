<?php

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('home');
});

Route::post('/', function (Request $request) {
    $validated = $request->validate([
        'original_url' => ['required', 'url:http,https', 'max:2048'],
    ]);

    do {
        $code = Str::random(6);
    } while (Link::where('short_code', $code)->exists());

    $link = Link::create([
        'original_url' => $validated['original_url'],
        'short_code' => $code,
    ]);

    return back()->with('short_url', url('/' . $link->short_code));
});

Route::get('/{code}', function (string $code) {
    $link = Link::where('short_code', $code)->firstOrFail();

    $link->increment('clicks');

    return redirect()->away($link->original_url);
});