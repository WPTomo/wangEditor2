<?php

namespace Wptomo\WangEditor2;

use Encore\Admin\Form\Field;

class Editor extends Field
{
    protected $view = 'laravel-admin-wang-editor2::editor';
    
    protected static $css = [
        'vendor/laravel-admin-ext/wang-editor2/wangEditor-2.1.23/dist/css/wangEditor.min.css',
    ];
    
    protected static $js = [
        'vendor/laravel-admin-ext/wang-editor2/wangEditor-2.1.23/dist/js/wangEditor.min.js',
    ];

    public function render()
    {
        $token = csrf_token();
        $fileName = config('admin.extensions.wang-editor2.config.uploadImgFileName');
        $api = config('admin.extensions.wang-editor2.config.uploadImgUrl');
        $menus = json_encode(config('admin.extensions.wang-editor2.config.menus'));
        $false = false;
        $this->script = <<<EOT

wangEditor.config.printLog = '{$false}'

var editor = new wangEditor('{$this->id}')
    editor.config.menus = {$menus}
    editor.config.uploadImgFileName = '{$fileName}'
    editor.config.uploadImgUrl = '{$api}'
    editor.config.pasteFilter = '{$false}'
    editor.config.uploadParams = {
        '_token': '$token',
    }
    editor.config.uploadHeaders = {
        'Accept': 'application/json'
    }
    editor.create()

EOT;
        return parent::render();
    }
}
