<?php

class Function_helper
{
    static function makeToken()
    {
        return bcrypt(time().uniqid());
    }
}
