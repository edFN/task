<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");



\Bitrix\Main\UI\Extension::load("ui.forms");
\Bitrix\Main\UI\Extension::load("ui.buttons");

$APPLICATION->SetTitle("Главная страница");

?>



<div class="form-register" xmlns="http://www.w3.org/1999/html">
    <div class="form-register-header">
        <h1>Форма обратной связи</h1>

    </div>
    <div class="form-register-content">
        <form method="post" enctype="multipart/form-data" id="sendData">
        <label for="name">Имя</label>
        <input id="name" type="text" name="name" required>
        <label for="last_name">Фамилия</label>
        <input id="last_name" type="text" name="last_name" required>
        <label for="email">Email</label>
        <input id="email" type="text" name="email" required>
        <label for="date">Дата рождения</label>
        <input id="date" type="date" pattern="[0-9]{2}\.[0-9]{2}\.[0-9]{4}" placeholder="" name="date"
        required>
        <label for="tel">Номер телефона</label>
        <input id="tel" name="phone" type="tel" maxlength="50" minlength="16"
               placeholder="+7(___)___-__-__"
               pattern="\+7\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}"
               required>
        <label for="city">Город</label>
        <input id="city" type="text" name="city" required>

            <div class="file_process">
                <label class="ui-ctl ui-ctl-file-btn">
                    <input type="file" name = "file[]" id="file_in" class="ui-ctl-element" multiple>
                    <div class="ui-ctl-label-text">Добавить файл</div>
                </label>

                <p id="msg"></p>
            </div>

        <input  id="submit_form" type="submit" value="Отправить заявку" onsubmit="return false;">
        </form>

    </div>

</div>

<div class="container">
<div class="popup-window-ok">
    <div class="icon">
        <img src="images/icons/ok.svg"/>
    </div>
    <div class="content">
        <h1>Успешно</h1>
        <p>Ваша заявка успешно принята</p>
    </div>

    <button class="ui-btn" id="popup_button">OK</button>

</div>
<div class="popup-window-bad">
    <div class="icon">
        <img src="images/icons/bad.svg"/>
    </div>
    <div class="content">
        <h1>Ошибка</h1>
        <p>Ваша заявка не была  принята</p>
    </div>

    <button class="ui-btn" id="popup_button">OK</button>



</div>
</div>
<script src="script1.js"></script>


