- Доступ к серверу:
	-- 
- Laravel 5.4
	-- composer update (обновить все зависимости и библиотеки)
	-- yourdomain/adminattackplans или в app.blade.php раскомментировать блок <!-- Section for adminpanel--> для доступа к кнопкам логин/регистрация
- SQLite3
	-- yourproject/database/db.sqlite
- Bootstrap3
- API
	-- Twilio (https://www.twilio.com/docs/libraries/php)
		Ключи доступа прописаны в .env
		Реализация отправки смс в контроллере SendMessageController экшн send
	-- Stripe (https://github.com/stripe/stripe-php)
		Ключи доступа прописаны в .env
		Реализация оплаты в контроллере StripeController
	-- PayPal (https://github.com/paypal/PayPal-PHP-SDK)
		Ключи доступа прописаны в .env
		Реализация оплаты в контроллере PayPalController

- Домашняя страница обрабатывается контроллером HomeController экшн index
	-- Основная тема
	 --- в контроллере происходит выборка темы которая указана в БД как selected, это основная тема
	 --- выбор планов атак по соответствующей основной теме
	 --- генерируется вид с учетом темы и планов атак
	-- Доп темы обрабатываются экшеном showPlan($id)
- Поля тел. номер и имя обязательны для заполнения, валидация происходит при отправке формы на контроллер SendMessageController
экшн index
- Зависимо от нажатой кнопки оплаты вызывается соответствующий контроллер StripeController или PayPalController
- Все параметры по оплате и MMS передаются в (Request $request)
- Stripe
	-- Форма ввода информации по карточке, валидация обрабатывается js кодом в файле yourproject/public/js/main.js
	Код с комментрариями. После успешной валидации генерируется токен и передается в контроллер StripeController экшн valid
	При успешной оплате вызывается контроллер SendMessageController экшн send
- PayPal
	-- Форма авторизации вызывается контроллером PayPalController экшн index
	Код с комментрариями. После успешной валидации генерируется токен и передается в контроллер PayPalController экшн valid
	При успешной оплате вызывается контроллер SendMessageController экшн send
- Twilio
	-- Отправка MMS происходит в контроллерe SendMessageController экшн send. 
	Код с комментрариями.