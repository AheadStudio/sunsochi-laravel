<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $fields = [];


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->fields = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /*$to = 'Gorponffffff@yandex.ru';
        $subject = 'Тестовое письмо с HTML';

        $message = '
        <html>
            <head>
                <title>Тестовое письмо с HTML</title>
                <meta charset="utf8">
            </head>
            <body>
                <p>Пример таблицы</p>
                <table>
                    <tr>
                        <th>Колонка 1</th><th>Колонка 2</th><th>Колонка 3</th><th>Колонка 4</th>
                    </tr>
                    <tr>
                        <td>Ячейка 1</td><td>Ячейка 2</td><td>Ячейка 3</td><td>Ячейка 4</td>
                    </tr>
                    <tr>
                        <td>Ячейка 5</td><td>Ячейка 6</td><td>Ячейка 7</td><td>Ячейка 8</td>
                    </tr>
                </table>
            </body>
        </html>
        ';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf8';
        $headers[] = 'To: Receiver <receiver@test.com>';
        $headers[] = 'From: Sender <sender@test.com>';
        $headers[] = 'Cc: copy@test.com';

        $result = mail($to, $subject, $message, implode("\r\n", $headers));
        echo $result ? 'OK' : 'Error';*/

        if ($this->fields["type"] == "call") {
            return $this->view("emails/call-email")
                        ->with($this->fields)
                        ->subject("Звонок");
        }

        if ($this->fields["type"] == "special") {
            return $this->view("emails/special-email")
                        ->with($this->fields)
                        ->subject("Проффесиональный подбор");
        }

        if ($this->fields["type"] == "object") {
            return $this->view("emails/object-email")
                        ->with($this->fields)
                        ->subject("Заявка на объект");
        }

        if ($this->fields["type"] == "sub") {
            return $this->view("emails/sub-email")
                        ->with($this->fields)
                        ->subject("Заявка на объект");
        }
    }
}
