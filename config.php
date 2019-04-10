<?php
/*
 * MIT License
 *
 * Copyright (c) 2019 cactus-io
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
return array(
    /*
     * Debug mode
     */
    'debug' => true,
    /*
     * Working encoding
     */
    'encoding' => 'UTF-8',
    /*
     * DB of the mime-types. In some OS there is no default 
     * mime-type DB, so you have to set a file.
     */
    'mimetypes_db' =>  __DIR__ . '/storage/etc/mime.types',
    /*
     * Supported languages by the server
     */
    'languages' => array(
        'fa',
        'en'
    ),
    /*
     * tmp_folder is used to generate temprory files
     */
    'tmp_folder' =>  __DIR__ . '/storage/tmp',
    
    
    
    /*********************************************************
     * Modules
     *********************************************************/
    'installed_apps' => array(
        'Pluf',
        'Cactus'
    ),
    'middleware_classes' => array(
        'Pluf_Middleware_Translation',
    ),
    
    /*********************************************************
     * Templates
     *********************************************************/
    'template_folders' => array(
        __DIR__ . '/storage/templates',
    ),
    'template_tags' => array(
        'now' => 'Pluf_Template_Tag_Now',
        'cfg' => 'Pluf_Template_Tag_Cfg',
        'tenant' => 'Pluf_Template_Tag_Tenant',
    ),
    
    /*********************************************************
     * Logger
     *********************************************************/
    'log_delayed' => true,
    'log_level' => Pluf_Log::ERROR,
    'log_handler' => 'Pluf_Log_File',
    //----------------
    // Pluf file log handler configuration
    //----------------
    /*
     * Pluf file log use a file to log all events. The main configuration
     * of this module is log file path. Set a path to the log file with
     * the following key
     */
    'pluf_log_file' => __DIR__ . '/storage/logs/pluf.log',
    
    
    
    /*********************************************************
     * Cactus
     *********************************************************/
    // 'cactus_storage' => __DIR__ . '/storage/cactus',
    
);

