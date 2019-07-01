<?php

/**
 * 登录
 * @param  integer $aid 用户id
 * @author @janpun
 */
function login($aid){
  //写入登录session
  session('aid', $aid);
}