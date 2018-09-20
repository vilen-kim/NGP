<?php

return [
    ['email', 'required', 'message' => 'Это обязательное поле'],
    ['email', 'trim'],
    ['email', 'string', 'max' => 255],
    ['email', 'email', 'message' => 'Неверный формат электронной почты'],
];
