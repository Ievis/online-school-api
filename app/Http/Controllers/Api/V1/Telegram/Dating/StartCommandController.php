<?php

namespace App\Http\Controllers\Api\V1\Telegram\Dating;

use Illuminate\Support\Facades\Cache;

class StartCommandController extends CommandController
{
    public function __invoke()
    {
        $username = $this->data->getUsername();

        $this->telegram_request_service
            ->setMethodName('sendMessage')
            ->setParams([
                'chat_id' => $this->data->getChatId(),
                'text' => 'Привет, это бот для знакомств учеников!' . PHP_EOL . '<strong>Для начала нам нужно узнать твоё имя, предмет и категорию...</strong>',
                'parse_mode' => 'html',
            ])
            ->make();

        $user_data = [
            'name' => [
                'is_completed' => false,
                'is_pending' => false,
                'type' => 'text',
                'value' => null,
                'method' => 'name'
            ],
            'subject' => [
                'is_completed' => false,
                'is_pending' => false,
                'type' => 'callback',
                'value' => null,
                'method' => 'subject'
            ],
            'category' => [
                'is_completed' => false,
                'is_pending' => false,
                'type' => 'callback',
                'value' => null,
                'method' => 'category'
            ],
            'about' => [
                'is_completed' => false,
                'is_pending' => false,
                'type' => 'text',
                'value' => null,
                'method' => 'about'
            ],
        ];

        Cache::forget($username . ':' . 'reset-bot-message-id');
        Cache::forget($username . ':' . 'summary-message-id');
        Cache::set($username . ':' . 'register-data', $user_data, 60 * 60);

        $register_service = new RegisterService();
        $register_service->setTelegramUserData($this->data);
        $register_service->setCallbackArgs($this->callback_query_args);

        $register_service->setUserData($user_data);
        $register_service->proceed();

    }
}