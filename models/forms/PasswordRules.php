<?php

return [
    [['password', 'passwordRepeat'], 'required', 'message' => 'Это обязательное поле', 'except' => self::SCENARIO_UPDATE],
    ['password', 'string', 'min' => 6],
    ['password', 'match', 'pattern' => '#\d#s', 'message' => 'Пароль должен содержать хотя бы одну цифру.'],
    ['password', 'match', 'pattern' => '#[a-z]#s', 'message' => 'Пароль должен содержать хотя бы одну латинскую строчную букву.'],
    ['password', 'match', 'pattern' => '#[A-Z]#s', 'message' => 'Пароль должен содержать хотя бы одну латинскую прописную букву.'],
    ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
];
