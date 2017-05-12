<?php

/**
 * Created by PhpStorm.
 * User: jay
 * Date: 2017/4/8
 * Time: 上午10:07
 */

namespace App;

class Def
{
	const DEF_AVATAR = '/avatar/avatar.png';

    const REDIS_MARKDOWN_KEY = 'markdown_tiki_file_';   //Markdown Redis Prefix

	const TIKI_API_XAUTH = '5DE0CB6960FDD55B9F7C26E6554617B5';		//接口中间件校验 md5(马越)

    //XToken
    const REDIS_XTOKEN_SETS = 'xtoken_sets';    //XToken Redis Prefix
    const MD_SECRET_KEY = 'markdown_secret_key';   //密钥
    const XTOKEN_LIFECYCLE = 60;   //生命周期

    //落盘路径
    const MARKDOWN_ROOT_PATH = 'store';
    const MARKDOWN_TYPE_ORIGIN_PATH = 'origin';
    const MARKDOWN_TYPE_PARSED_PATH = 'parsed';

    //Markdown 生成 HTML
    const GENERATE_AUTH_KEY = '7fUJd46QtlmJkBWn';   //校验key
    const GENERATE_WIKI_URL = 'https://ink.service.tiki.im/parse';

}