<?php

return [
    ['email', 'trim'],
    ['email', 'required', 'message' => 'Это обязательное поле'],
    ['email', 'string', 'max' => 255],
    ['email', 'email', 'message' => 'Неверный формат электронной почты'],
];
