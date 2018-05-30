<div class="order-sub">
    <div class="page-text">
        <h2>Быть в курсе – просто. <br>Подпишитесь!</h2>
    </div>
    {!! Form::open(["method" =>"POST", "action" => "FormController@handlerForm", "data-success" => "/form/success", "class" => "form form-order-sub"]) !!}
        {!! Form::hidden("form_type", "sub")!!}
        <div class="form-row form-row--100">
            {!! Form::email("email", null, ["id"=>"email", "placeholder" => "Укажите Ваш e-mail", "data-error"=>"Укажите email", "aria-required"=>"true", "required", "class"=>"form-item form-item--text"]) !!}
        </div>
        <div class="form-row form-row--100">
            <div class="order-call-privacy">Нажимая на кнопку "Отправить заявку", вы даете<a href="#" class="link link-white link--opacity">&ensp;согласие на обработку своих персональных данных</a></div>
        </div>
        <div class="form-row form-row--100">
            <button type="submit" class="button button--orange-flood send-order">Подписаться на блог</button>
        </div>
    {!! Form::close() !!}
</div>
