<?php
/**
 * @Author      : xiaxixiang
 * @Email       : xiaxixiang86@gmail.com
 * @Time        : 2020/3/8 6:07 下午
 * @Description :
 */

namespace Samary\HelloApi\Model;

class Hello implements \Samary\HelloApi\Api\HelloInterface
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
    public function name($name)
    {
        return "Hello," . $name;
    }
}