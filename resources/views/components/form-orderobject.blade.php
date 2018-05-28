<div id="form-call" class="form-popup">
    <div class="order-call-icon">
        <?php include("svg/call.svg")?>
    </div>
    <div class="page-text">
        <h2>Заявка</h2>
    </div>
    {!! Form::open(["method" =>"POST", "action" => "FormController@handlerForm", "data-success" => "/form/success", "class" => "form form-order-call"]) !!}
        {!! Form::hidden("form_type", "object")!!}
        <div class="form-row form-row--100">
            {!! Form::text("name", null, ["id"=>"name", "placeholder" => "Ваше имя", "data-error"=>"Ваше имя", "aria-required"=>"true", "required", "class"=>"form-item form-item--text"]) !!}
        </div>
        <div class="form-row form-row--100">
            {!! Form::text("mobile", null, ["id"=>"mobile", "placeholder" => "Контактный телефон", "data-error"=>"Укажите телефон", "aria-required"=>"true", "data-pattern"=>"mobileRU", "data-number"=>"+7 (000) 000-00-00", "required", "class"=>"form-item form-item--text"]) !!}
        </div>
        <div class="form-row form-row--100">
            {!! Form::email("email", null, ["id"=>"email", "placeholder" => "Электронная почта", "data-error"=>"Укажите email", "aria-required"=>"true", "required", "class"=>"form-item form-item--text"]) !!}
        </div>
        <div class="form-row form-row--100">
            <div class="order-call-privacy">Нажимая на кнопку "Отправить заявку", вы даете<a href="#" class="link link-white link--opacity">&ensp;согласие на обработку своих персональных данных</a></div>
        </div>
        <div class="form-row form-row--100">
            <button type="submit" class="button button--orange-flood send-order">Отправить заявку</button>
        </div>
    {!! Form::close() !!}
</div>
