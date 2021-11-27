<?php

namespace App\Http\Controllers;


use App\Http\Requests\AppealPostRequest;
use App\Models\Appeal;
use App\Sanitizers\PhoneSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function create(Request $request)
    {
        $showMessage = false;
        if ($request->get('accepted', false)) {
            $showMessage = $request->session()->get('show_message', false);
            $request->session()->put('show_message', false);
        }
        return view('appeal', ['showMessage' => $showMessage]);
    }

    public function save(AppealPostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $appeal = new Appeal();
        $appeal->name = $validated['name'];
        $appeal->surname = $validated['surname'];
        $appeal->patronymic = $validated['patronymic'];
        $appeal->age = $validated['age'];
        $appeal->gender = $validated['gender'];
        $appeal->phone = PhoneSanitizer::sanitize($validated['phone']);
        $appeal->email = $validated['email'];
        $appeal->message = $validated['message'];
        $appeal->save();
        $request->session()->put('appeal', true);

        return redirect()
            ->route('appeal')
            ->with('success', 'Appeal created');
    }
}
