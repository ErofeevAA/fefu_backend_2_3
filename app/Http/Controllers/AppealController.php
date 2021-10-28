<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appeal;

class AppealController extends Controller
{
    public function __invoke(Request $request)
    {
        $errors = [];
        $success = $request->session()->get('success', false);

        if ($request->isMethod('post')) {
            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $message = $request->input('message');

            if ($name === null) {
                $errors['name'] = 'Поле имени пустое';
            }
            if ($phone === null && $email === null) {
                $errors['contacts'] = 'Одно из полей номера телефона или e-mail должно быть заполнено';
            }
            if ($message === null) {
                $errors['message'] = 'Поле сообщения пустое';
            }

            if (strlen($name) > 20) {
                $errors['name'] = 'Поле имени содержит больше 20 символов';
            }

            if (strlen($phone) != 11) {
                $errors['phone'] = 'Поле телефона должно содержать 11 цифр';
            }

            if (strlen($email) > 100) {
                $errors['email'] = 'Поле e-mail содержит больше 100 символов';
            }

            if (strlen($message) > 100) {
                $errors['message'] = 'Поле сообщения содержит более 100 символов';
            }

            if (count($errors) > 0) {
                $request->flash();
            }

            else {
                $appeal = new Appeal();
                $appeal->name = $name;
                $appeal->phone = $phone;
                $appeal->email = $email;
                $appeal->message = $message;
                $appeal->save();
                $success = true;

                return redirect()
                    ->route('appeal')
                    ->with('success', $success);
            }
        }

        return view('appeal', ['errors' => $errors, 'success' => $success]);
    }
}
