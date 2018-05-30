<div style="background:#009ecc" class="page-inner page-inner--max">
    <div class="page-inner page-inner--w1">
        <div class="order-call">
            <div class="page-text">
                <h2>Закажите профессиональный подбор сейчас</h2>
            </div>
            {!! Form::open(["method" =>"POST", "action" => "FormController@handlerForm", "data-success" => "/form/success", "class" => "form form-order-call"]) !!}
                {!! Form::hidden("form_type", "special")!!}
                <div class="form-row form-row--100">
                    {!! Form::text("name", null, ["id"=>"name", "placeholder" => "Ваше имя", "data-error"=>"Ваше имя", "aria-required"=>"true", "required", "class"=>"form-item form-item--text"]) !!}
                </div>
                <div class="form-row form-row--100">
                    {!! Form::text("mobile", null, ["id"=>"mobile", "placeholder" => "Контактный телефон", "data-error"=>"Укажите телефон", "aria-required"=>"true", "data-pattern"=>"mobileRU", "data-number"=>"+7 (000) 000-00-00", "required", "class"=>"form-item form-item--text"]) !!}
                </div>
                <div class="form-row form-row--100">
                    <div class="order-call-privacy">Нажимая на кнопку "Отправить заявку", вы даете<a href="#" class="link link-white link--opacity">&ensp;согласие на обработку своих персональных данных</a></div>
                </div>
                <div class="form-row form-row--100">
                    <button type="submit" class="button button--orange-flood send-order">Отправить заявку</button>
                </div>
            {!! Form::close() !!}
            <div class="order-call-hotline">
                <span class="order-call-hotline-text">Бесплатная горячая линия</span>
                <a href="tel:+78007075523" class="link link-white link--opacity order-call-hotline-mobile">8-800-707-55-23</a>
                <span class="order-call-hotline-text">операторы доступны</span>
                <span class="order-call-hotline-text">с 8:00 до 22:00 МСК</span>
            </div>
            <div class="order-call-icon">
                <?php include("svg/call.svg")?>
            </div>
        </div>
    </div>
</div>
