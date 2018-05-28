<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;


class FormController extends Controller
{
    public function formOrderCall(Request $request) {
        return view("order-call");
    }
    public function formOrderObject(Request $request) {
        return view("order-object");
    }
    public function formSuccess() {
        return view("success");
    }

    public function handlerForm(Request $request) {
        if (isset($request->_token) && !empty($request->_token)) {
            switch ($request->form_type) {
                case "call":

                    $request = [
                        "name" => $request->name,
                        "mobile" => $request->mobile,
                        "type" => "call",
                    ];
                    Mail::to("GORPONFFFFFF@yandex.ru")->send(new SendEmail($request));
                    return response()->json($request);
                    break;

                case "object":

                    $request = [
                        "name" => $request->name,
                        "mobile" => $request->mobile,
                        "email" => $request->email,
                        "element_id" => $request->element_id,
                        "type" => "object",
                    ];
                    Mail::to("GORPONFFFFFF@yandex.ru")->send(new SendEmail($request));
                    return response()->json($request);
                    break;
            }
        }
    }
}
