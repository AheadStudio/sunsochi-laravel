<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use App\FormSubscription;

class FormController extends Controller
{
    // view form order call
    public function formOrderCall(Request $request) {
        return view("order-call");
    }

    // view form order object
    public function formOrderObject(Request $request) {
        return view("order-object");
    }

    // view form success
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
                    Mail::to("PorstLogin@yandex.ru")->send(new SendEmail($request));

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

                    Mail::to("PorstLogin@yandex.ru")->send(new SendEmail($request));

                    return response()->json($request);
                    break;

                case "special":

                    $request = [
                        "name" => $request->name,
                        "mobile" => $request->mobile,
                        "type" => "special",
                    ];

                    Mail::to("PorstLogin@yandex.ru")->send(new SendEmail($request));

                    return response()->json($request);
                    break;

                case "sub":

                    $request = [
                        "email" => $request->email,
                        "type" => "sub",
                    ];

                    $sub = FormSubscription::firstOrCreate(
                        ["user_email" => $request["email"]]
                    );

                    Mail::to($request["email"])->send(new SendEmail($request));

                    return response()->json($sub);
                    break;

            }
        }
    }
}
