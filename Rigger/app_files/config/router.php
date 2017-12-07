<?php

//路由事例
/*
 * [
 *    "URI模式，支持正则"=>[Module,Controller,Action]
 * ]
 */
return[
    '/welcome/'=>['','Welcome','index'],
    '/admin/welcome/'=>['admin','Admin','Welcome'],
    '/admin/getVideoList/(page)/(\d+)/(cate)/(\d+)/'=>['admin','Admin','getVideoList'],
];
